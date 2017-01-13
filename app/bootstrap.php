<?php

/* Bootstapuje aplikację */

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/config/config.php';

# serwis logowania do pliku, jeżeli logowanie wyłączone wtedy utwórz atrapę
GC\Container::set('logger',
    $config['logger']['enabled']
        ? new GC\Debug\FileLogger($config['logger']['folder'].date('Y-m-d').'.log')
        : new GC\Debug\NullLogger()
);

# serwis translacji tekstu, jeżeli translacja wyłączona wtedy utwórz atrapę
GC\Container::registerLazyService('translator', function () use ($config) {
    return $config['translator']['enabled']
        ? new GC\Translation\FileTranslator($config['translator']['folder'].getClientLang().'.json')
        : new GC\Translation\NullTranslator();
});

# serwis bazodanowy, łączy się z bazą tylko jeżeli jest to potrzebne
GC\Container::registerLazyService('database', function () use ($config) {
    $config = $config['database'];
    $pdo = new \PDO(
        $config['dns'],
        $config['username'],
        $config['password']
    );
    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    $database = new GC\Storage\Database($pdo);
    $database->prefix = $config['prefix'];

    GC\Container::get('logger')->database($config['dns']);

    return $database;
});

$trans = function ($text, array $params = []) {
    return GC\Container::get('translator')->translate($text, $params);
};

//require __DIR__.'/error-handler.php';
require __DIR__.'/functions.php';
require __DIR__.'/redirects.php';

session_start();

if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = [];
}

$request = new GC\Request(); # tworzy obiekt reprezentujący żądanie

GC\Container::set('config', $config);
GC\Container::set('request', $request);

# sprawdzana jest weryfikacja csrf tokenu, chroni przed spreparowanymi żądaniami
// if (!$request->isMethod('GET') and isset($_SESSION['csrf_token'])) {
//     if (isset($_SERVER['HTTP_X_CSRFTOKEN']) && $_SERVER['HTTP_X_CSRFTOKEN'] === $_SESSION['csrf_token']) {
//         GC\Container::get('logger')->csrf("Token verified via header");
//     } elseif (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
//         GC\Container::get('logger')->csrf("Token verified via request");
//     } else {
//         GC\Container::get('logger')->csrf("Invalid token");
//         return http_response_code(403);
//     }
// }

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = GC\Auth\Password::random(80);
}

GC\Render::$extract = [
    'trans' => $trans,
];

GC\Render::$shortcuts = [
    'action' => ROOT_PATH.'/actions',
    'adminPart' => ROOT_PATH.'/actions/admin/_parts',
    'template' => ROOT_PATH.'/templates/'.TEMPLATE,
    'templatePart' => ROOT_PATH.'/templates/'.TEMPLATE.'/_parts',
];

require __DIR__.'/routing.php';

GC\Container::get('logger')->response(sprintf('%s :: ExecutionTime: %s',
    http_response_code(),
    (microtime(true))
));
