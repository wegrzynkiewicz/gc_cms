<?php

/** Plik zawiera definicje najważniejszych stałych i właściwości dla aplikacji */

define('TEMPLATE', 'bootstrap-example'); # nazwa używanego szablonu
define('ASSETS_URL', '/assets'); # adres do katalogu z zasobami
define('ROOT_PATH', realpath(__DIR__.'/../../')); # ścieżka do katalogu głównego serwera www
define('ACTIONS_PATH', ROOT_PATH.'/actions'); # ścieżka do katalogu z plikami kontrolerów i szablonów
define('APP_PATH', ROOT_PATH.'/app'); # ścieżka do katalogu z najważniejszy plikami aplikacji
define('TMP_PATH', ROOT_PATH.'/tmp'); # ścieżka do folderu z plikami tymczasowymi
define('TEMPLATE_PATH', ACTIONS_PATH.'/templates/'.TEMPLATE); # ścieżka do plików szablonu
define('TEMPLATE_ASSETS_URL', ASSETS_URL.'/templates/'.TEMPLATE); # adres do zasobów w katalogu z szablonem

$config = [
    'debug' => true, # tryb developerski i wyświetlanie błędów
    'adminNavbarTitle' => 'Panel Administracyjny', # wyświetlana w prawym gornym rogu panelu admina
    'adminHeadTitleBase' => 'Acme Panel Administracyjny', # nazwa doklejana do <title> strony w panelu admina
    'noImageUrl' => '/admin/images/no-image.jpg', # ścieżka do obrazka w przypadku braku obrazka
    'timezone' => 'Europe/Warsaw', # domyślna strefa czasowa
    'avatar' => [
        #'useGravatarForStaff' => true, # czy wyświetlać avatary dla pracowników z gravatara?
        #'useGravatarForClient' => true, # czy wyświetlać avatary dla klientów gravatara?
        'noAvatarUrl' => '/admin/images/no-avatar.jpg', # ściezka do domyślnego obrazka avatara
    ],
    'lang' => [
        'client' => 'pl', # język klienta używany w systemie
        'clientDefault' => 'pl', # wykorzystywany gdy wszystkie inne sposoby określenia języka klienta zawiodą
        'editor' => 'pl', # język używany podczas edycji w panelu admina
        'editorDefault' => 'pl', # domyślny język edytowania w panelu admina
    ],
    'logger' => [ # ustawienia dla rejestrowania logów
        'enabled' => true, # uruchamia rejestrowanie logów
        'folder' => TMP_PATH.'/logs', # katalog do ktorego są zapisywane logi
    ],
    'db' => [ # zawiera parametry połączeniowe do bazy danych
        'dns' => 'mysql:host=localhost;dbname=_gc_cms;charset=utf8',
        'user' => 'root',
        'password' => '',
        'prefix' => 'gc_'
    ],
    'langs' => [ # zainstalowane wersje językowe
        'pl' => 'Polski',
        'en' => 'English',
        'de' => 'Deutsch',
    ],
    'frames' => [ # zainstalowane typy stron
        'page' => 'Zwykła strona', # zwykła strona z modułami
        'product' => 'Strona produktu', # strona ze szczegółami produktu i modułami
    ],
    'modules' => [ # rodzaje zainstalowanych modułow
        'text' => 'Moduł tekstowy',
        'gallery' => 'Galeria zdjęć'
    ],
    'nodeTypes' => [ # rodzaje węzłów nawigacji
        'empty' => 'Nieklikalny węzeł',
        'external' => 'Kieruj na adres',
        'homepage' => 'Kieruj na stronę główną',
        'page' => 'Kieruj na istniejącą stronę',
    ],
    'navNodeTargets' => [ # dostępne atrybuty target dla węzłów nawigacji
        '_self'	 => 'Załaduj w tym samym oknie',
        '_blank' => 'Załaduj w nowym oknie',
    ],
    'thumb' => [ # ustawienia generatora miniaturek
        'enabled' => true, # czy generować miniaturki?
        'thumbsUrl' => '/tmp/thumbs', # adres do katalogu z miniaturkami
        'thumbsPath' => TMP_PATH.'/thumbs', # adres do katalogu z miniaturkami
        'options' => [ # ustawienia dla generatora miniaturek
            'jpg' => [
                'loader' => 'imagecreatefromjpeg',
                'saver' => 'imagejpeg',
                'mime' => 'image/jpeg',
                'transparent' => false,
                'quality' => 90,
            ],
            'png' => [
                'loader' => 'imagecreatefrompng',
                'saver' => 'imagepng',
                'mime' => 'image/png',
                'transparent' => true,
                'quality' => 9,
            ],
        ],
    ],
    'rewrites' => [ # zawiera niestandardowe przekierowania $regex => $destination
        '~^/old-service/index\.php\?id=(\d+)\&theme=([a-z]+?)$~' => '/old-service/$1/$2',
    ]
];

/**
 * Generuje przednie części adresu dla plików w katalogu głównym
 */
function rootUrl($path)
{
    return ROOT_URL.$path; # generowane przez routing
}

/**
 * Generuje przednie części adresu dla plików nieźródłowych
 */
function assetsUrl($path)
{
    return rootUrl(ASSETS_URL.$path);
}

/**
 * Generuje przednie części adresu dla plików nieźródłowych w szablonie
 */
function templateAssetsUrl($path)
{
    return rootUrl(TEMPLATE_ASSETS_URL.$path);
}

/**
 * Generuje przednie części adresu, nie używać przed rutingiem
 */
function url($path)
{
    global $config;

    $url = rootUrl(FRONT_CONTROLLER_URL); # generowane przez routing

    if ($config['lang']['client'] !== $config['lang']['clientDefault']) {
        $url .= '/'.$config['lang']['client'];
    }

    return $url.$path;
}

/**
 * Usuwa przednie części adresu, aby nie zawierały domeny lub rootUrl
 */
function uploadUrl($path)
{
    if ($path and strpos($path, ROOT_URL) === 0) {
        $path = substr($path, strlen(ROOT_URL));
    }

    return $path;
}
