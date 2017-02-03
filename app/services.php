<?php

/** Plik zawiera inicjalizacje wszystkich globalnych serwisów w aplikacji */

# zarejestrowanie niestandardowego autoloadera klas, aby przyśpieszyć ładowanie
spl_autoload_register(function ($classNameWithNamespace) {

    # jeżeli nazwa klasy zaczyna się od GC\
    if (strpos($classNameWithNamespace, 'GC\\') === 0) {

        # utwórz ścieżkę składającą się z nazwy klasy bez "GC\"
        $pathToFile = '/classes/'.substr($classNameWithNamespace, 3).'.php';

        # załaduj plik z klasą i wyjdź z funkcji
        return require __DIR__.$pathToFile;
    }

    # utwórz zmienną, która raz zainicjowana nie zmieni wartości podczas
    # kolejnej inicjalizacji, celem sprawdzenia czy composer zostałzaładowany
    static $composerLoaded = false;

    if ($composerLoaded === false) {

        # załaduj composera dopiero, wtedy jeżeli nasz autoloading zawiedzie
        $composerLoader = require_once __DIR__.'/../vendor/autoload.php';
        $composerLoader->loadClass($classNameWithNamespace);

        # zmień wartość, aby zapobiec ponownemu załadowaniu composera
        $composerLoaded = true;
    }

}, true, true);

# załadowanie wartości wygenerowanych
$generated = @include __DIR__.'/storage/generated.php';

# jeżeli wygenerowane wartości nie istnieją
if (!$generated) {

    # wygeneruj losowe kryptograficznie bezpieczne wartości
    $generated = [

        # używana do solenia wszystkich haseł w aplikacji
        'password.salt' => GC\Auth\Password::random(40),

        # nazwa ciastka, w którym jest zapisany token CSRF
        'csrf.cookieName' => GC\Auth\Password::random(40),

        # nazwa ciastka sesyjnego dla pracownika
        'session.staff.cookie.name' => GC\Auth\Password::random(40),

        # nazwa ciastka sesyjnego dla odwiedzającego
        'session.visitor.cookie.name' => GC\Auth\Password::random(40),
    ];

    # zapisz do łatwego w odczytaniu pliku PHP
    exportDataToPHPFile($generated, __DIR__.'/storage/generated.php');
}

# załadowanie pliku konfiguracyjnego
$config = require __DIR__.'/config/config.php';

# serwis logowania do pliku lub atrapa kiedy logowanie jest wyłączone
$logger =
    $config['logger']['enabled']
        ? new GC\Debug\FileLogger(
            $config['logger']['folder'].'/'.date('Y-m-d').'.log')
        : new GC\Debug\NullLogger();

# serwis służy do zapisywania wyrzuconych wyjątków do loggera
$logException = function ($exception) use (&$logException) {
    $previous = $exception->getPrevious();
    if ($previous) {
        $logException($previous);
    }
    $GLOBALS['logger']->info(sprintf("[EXCEPTION] %s: %s [%s]\n%s",
        get_class($exception),
        $exception->getMessage(),
        $exception->getCode(),
        $exception->getTraceAsString()
    ));
};

# niestandardowy łapacz błędów, na każdym rodzaju błędu rzuca wyjątek
set_error_handler(function ($severity, $msg, $file, $line, array $context) {
    $GLOBALS['logger']->info("[ERROR] {$msg}", [$file, $line]);
    if (error_reporting() === 0) {
        return false;
    }
    if ($severity & error_reporting()) {
        throw new ErrorException($msg, 0, $severity, $file, $line);
    }

    return false;
});

# niestandardowy łapacz wyjątków, zapisuje tylko wyjątki do loggera
set_exception_handler(function ($exception) use (&$logException) {
    $logException($exception);
    throw $exception;
});

# serwis translacji tekstu, jeżeli translacja wyłączona wtedy utwórz atrapę
$translator =
    $config['translator']['enabled']
        ? new GC\Translation\FileTranslator($config['translator']['folder'].'/'.GC\Auth\Visitor::getLang().'.php')
        : new GC\Translation\NullTranslator();

# serwis do łatwego tłumaczenia tekstu: $trans('text')
$trans = function ($text, array $params = []) use ($translator) {
    return $translator->translate($text, $params);
};

# serwis reprezentujący żądanie, serwis uri jest tym samym żądaniem, tylko o krótszej nazwie
$uri = $request = new GC\Request(
    $_SERVER['REQUEST_METHOD'],
    $_SERVER['REQUEST_URI'],
    $_SERVER['SCRIPT_NAME']
);
