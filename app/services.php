<?php

/** Plik zawiera inicjalizacje wszystkich globalnych serwisów w aplikacji */

# załadowanie wartości wygenerowanych
$generated = require __DIR__.'/config/generated.php';
if (empty($generated)) {
    $generated = [
        'datetime' => date('Y-m-d H:i:s'),
        'password.salt' => GC\Auth\Password::random(40),
        'csrf.secretKey' => GC\Auth\Password::random(40),
        'csrf.cookieName' => GC\Auth\Password::random(40),
        'session.staff.cookieName' => GC\Auth\Password::random(40),
        'session.visitor.cookieName' => GC\Auth\Password::random(40),
    ];
    GC\Disc::exportDataToPHPFile($generated, __DIR__.'/config/generated.php');
}

# załadowanie pliku konfiguracyjnego
$config = require __DIR__.'/config/config.php';
GC\Data::set('config', $config);

# serwis logowania do pliku, jeżeli logowanie wyłączone wtedy utwórz atrapę
$logger = $config['logger']['enabled']
    ? new GC\Debug\FileLogger($config['logger']['folder'].'/'.date('Y-m-d').'.log')
    : new GC\Debug\NullLogger();
GC\Data::set('logger', $logger);

# serwis służy do zapisywania wyrzuconych wyjątków do loggera
$logException = function (Exception $exception) use (&$logException, &$logger) {
    $previous = $exception->getPrevious();
    if ($previous) {
        $logException($previous);
    }
    $logger->exception(sprintf("%s: %s [%s]\n%s",
        get_class($exception),
        $exception->getMessage(),
        $exception->getCode(),
        $exception->getTraceAsString()
    ));
};
GC\Data::set('logException', $logException);

# niestandardowy łapacz błędów, na każdym rodzaju błędu przerywa działanie
$errorHandler = function ($severity, $msg, $file, $line, array $context) use (&$logger) {
    $logger->error($msg, [$file, $line]);
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

# serwis do łatwego tłumaczenia tekstu: $trans('text')
$trans = function ($text, array $params = []) {
    return GC\Data::get('translator')->translate($text, $params);
};
GC\Data::set('trans', $trans);

# serwis translacji tekstu, jeżeli translacja wyłączona wtedy utwórz atrapę
GC\Data::registerLazyService('translator', function () use (&$config) {
    return $config['translator']['enabled']
        ? new GC\Translation\FileTranslator($config['translator']['folder'].'/'.GC\Auth\Visitor::getLang().'.json')
        : new GC\Translation\NullTranslator();
});

# serwis bazodanowy, łączy się z bazą tylko jeżeli jest to potrzebne
GC\Data::registerLazyService('database', function () use (&$config, &$logger) {
    $dbConfig = &$config['database'];
    $pdo = new \PDO(
        $dbConfig['dns'],
        $dbConfig['username'],
        $dbConfig['password']
    );
    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    $database = new GC\Storage\Database($pdo);
    $database->prefix = $dbConfig['prefix'];

    $logger->database($dbConfig['dns']);

    return $database;
});

# serwis reprezentujący żądanie
$request = new GC\Request();
GC\Data::set('request', $request);
