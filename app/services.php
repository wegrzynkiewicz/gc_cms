<?php

# załadowanie pliku konfiguracyjnego
$config = require __DIR__.'/config/config.php';
GC\Container::set('config', $config);

# serwis logowania do pliku, jeżeli logowanie wyłączone wtedy utwórz atrapę
$logger = $config['logger']['enabled']
    ? new GC\Debug\FileLogger($config['logger']['folder'].'/'.date('Y-m-d').'.log')
    : new GC\Debug\NullLogger();
GC\Container::set('logger', $logger);

# serwis do łatwego tłumaczenia tekstu: $trans('text')
$trans = function ($text, array $params = []) {
    return GC\Container::get('translator')->translate($text, $params);
};
GC\Container::set('trans', $trans);

# serwis translacji tekstu, jeżeli translacja wyłączona wtedy utwórz atrapę
GC\Container::registerLazyService('translator', function () use ($config) {
    return $config['translator']['enabled']
        ? new GC\Translation\FileTranslator($config['translator']['folder'].'/'.GC\Auth\Client::getLang().'.json')
        : new GC\Translation\NullTranslator();
});

# serwis bazodanowy, łączy się z bazą tylko jeżeli jest to potrzebne
GC\Container::registerLazyService('database', function () use (&$config) {
    $dbConfig = &$config['database'];
    $pdo = new \PDO(
        $dbConfig['dns'],
        $dbConfig['username'],
        $dbConfig['password']
    );
    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    $database = new GC\Storage\Database($pdo);
    $database->prefix = $dbConfig['prefix'];

    GC\Container::get('logger')->database($dbConfig['dns']);

    return $database;
});

# serwis reprezentujący żądanie
$request = new GC\Request();
GC\Container::set('request', $request);
