<?php

/** Plik zawiera inicjalizacje wszystkich globalnych serwisów w aplikacji */

# załadowanie wartości wygenerowanych
$generated = @include __DIR__.'/storage/generated.php';
if (!$generated) {
    $generated = [
        'password.salt' => GC\Auth\Password::random(40),
        'csrf.cookieName' => GC\Auth\Password::random(40),
        'session.staff.cookie.name' => GC\Auth\Password::random(40),
        'session.visitor.cookie.name' => GC\Auth\Password::random(40),
    ];
    exportDataToPHPFile($generated, __DIR__.'/storage/generated.php');
}

# załadowanie pliku konfiguracyjnego
$config = require __DIR__.'/config/config.php';

# serwis logowania do pliku lub atrapa
$logger =
    $config['logger']['enabled']
        ? new GC\Debug\FileLogger($config['logger']['folder'].'/'.date('Y-m-d').'.log')
        : new GC\Debug\NullLogger();

# serwis służy do zapisywania wyrzuconych wyjątków do loggera
$logException = function (Exception $exception) use (&$logException, &$logger) {
    $previous = $exception->getPrevious();
    if ($previous) {
        $logException($previous);
    }
    $logger->info(sprintf("[EXCEPTION] %s: %s [%s]\n%s",
        get_class($exception),
        $exception->getMessage(),
        $exception->getCode(),
        $exception->getTraceAsString()
    ));
};

# niestandardowy łapacz błędów, na każdym rodzaju błędu przerywa działanie
$errorHandler = function ($severity, $msg, $file, $line, array $context) use (&$logger) {
    $logger->info("[ERROR] {$msg}", [$file, $line]);
    if (error_reporting() === 0) {
        return false;
    }
    if ($severity & error_reporting()) {
        throw new ErrorException ($msg, 0, $severity, $file, $line);
    }

    return false;
};
set_error_handler($errorHandler);

# niestandardowy łapacz wyjątków, zapisuje tylko wyjątki do loggera
$exceptionHandler = function (Exception $exception) use (&$logException) {
    $logException($exception);
    throw $exception;
};
set_exception_handler($exceptionHandler);

# serwis translacji tekstu, jeżeli translacja wyłączona wtedy utwórz atrapę
$translator =
    $config['translator']['enabled']
        ? new GC\Translation\FileTranslator($config['translator']['folder'].'/'.GC\Auth\Visitor::getLang().'.php')
        : new GC\Translation\NullTranslator();

# serwis do łatwego tłumaczenia tekstu: $trans('text')
$trans = function ($text, array $params = []) use ($translator) {
    return $translator->translate($text, $params);
};

# serwis reprezentujący żądanie
$request = new GC\Request(
    $_SERVER['REQUEST_METHOD'],
    $_SERVER['REQUEST_URI'],
    $_SERVER['SCRIPT_NAME']
);

# serwis uri jest tym samym żądaniem, tylko o krótszej nazwie
$uri = $request;
