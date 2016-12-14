<?php

/** Plik zawiera definicje najważniejszych stałych i właściwości dla aplikacji */

define('TEMPLATE', 'bootstrap-example'); # nazwa używanego szablonu
define('ASSETS_URL', '/assets'); # adres do katalogu z zasobami
define('ROOT_PATH', realpath(__DIR__.'/../../')); # ścieżka do katalogu głównego serwera www
define('ACTIONS_PATH', ROOT_PATH.'/actions'); # ścieżka do katalogu z plikami kontrolerów i szablonów
define('APP_PATH', ROOT_PATH.'/app'); # ścieżka do katalogu z najważniejszy plikami aplikacji
define('TMP_PATH', ROOT_PATH.'/tmp'); # ścieżka do folderu z plikami tymczasowymi
define('TEMPLATE_PATH', ROOT_PATH.'/templates/'.TEMPLATE); # ścieżka do plików szablonu
define('TEMPLATE_ASSETS_URL', '/templates/'.TEMPLATE); # adres do zasobów w katalogu z szablonem

$config = [
    'debug' => true, # tryb developerski i wyświetlanie błędów
    'adminNavbarTitle' => 'Panel Administracyjny', # wyświetlana w prawym gornym rogu panelu admina
    'adminHeadTitleBase' => 'Acme Panel Administracyjny', # nazwa doklejana do <title> strony w panelu admina
    'noImageUrl' => '/admin/images/no-image.jpg', # ścieżka do obrazka w przypadku braku obrazka
    'timezone' => 'Europe/Warsaw', # domyślna strefa czasowa
    'minPasswordLength' => 8, # minimalna długość hasła
    'sessionTimeout' => 1800, # czas jaki musi upłynąć po zalogowaniu, aby wylogowało kogoś z automatu, w sekundach
    'avatar' => [
        'noAvatarUrl' => '/admin/images/no-avatar.jpg', # ściezka do domyślnego obrazka avatara
    ],
    'lang' => [
        'clientDefault' => 'pl', # wykorzystywany gdy wszystkie inne sposoby określenia języka klienta zawiodą
        'editorDefault' => 'pl', # domyślny język edytowania w panelu admina
    ],
    'translator' => [ # ustawienia translatora
        'enabled' => true, # czy włączyć tłumaczenie komunikatów
        'folder' => ROOT_PATH.'/data/locales', # katalog do ktorego są zapisywane tłumaczenia
    ],
    'logger' => [ # ustawienia dla rejestrowania logów
        'enabled' => true, # uruchamia rejestrowanie logów
        'folder' => TMP_PATH.'/logs', # katalog do ktorego są zapisywane logi
    ],
    'db' => [ # zawiera parametry połączeniowe do bazy danych
        'dns' => 'mysql:host=localhost;dbname=_gc_cms;charset=utf8',
        'username' => 'root',
        'password' => '',
        'prefix' => 'gc_'
    ],
    'email' => [ # ustawienia serwera pocztowego do rozsyłania emaili
        'smtp' => true, # czy użwać mailera smtp?
        'host' => 'smtp.emaillabs.net.pl', # host serwera pocztowego
        'port' => 587, # post hosta
        'username' => '1.wegrzynkiewicz.smtp', # nazwa konta pocztowego
        'password' => '9pf1SdUuZxZzagJN6235ShyTXGLCWCiHbI4Lh6pd', # hasło konta pocztowego
        'SMTPsecure' => 'tls', # szyfrowanie wiadomości email
        'fromEmail' => 'from@localhost', # adres email w nagłówku from, zostaw puste, aby wygenerować z nazwą domeny
        'fromName' => null, # nazwa użytkownika w nagłówku from
        'replyEmail' => 'noreply@localhost', # nazwa użytkownika w nagłówku reply
        'replyName' => null, # nazwa użytkownika w nagłówku reply
        'limitPerOnce' => 10, # ile może się wysłać wiadomości na raz za jednym żądaniem
        'headerTitle' => "Panel administracyjny GrafCenter CMS", # wykorzystywane do wyświetlania w panelowych mailaich
    ],
    'langs' => [ # zainstalowane wersje językowe
        'pl' => 'Polski',
        'en' => 'English',
        'de' => 'Deutsch',
    ],
    'flags' => [ # mapowanie języków na krajowe flagi
        'pl' => 'pl',
        'en' => 'gb',
        'de' => 'de',
    ],
    'frames' => [ # zainstalowane typy stron
        'page' => 'Zwykła strona',
        'post' => 'Strona wpisu bloga',
        'product' => 'Strona produktu',
    ],
    'modules' => [ # rodzaje zainstalowanych modułow
        'html-editor' => 'Moduł tekstowy',
        'gallery' => 'Moduł galerii zdjęć',
        'photo' => 'Moduł pojedyńczego zdjęcia',
    ],
    'moduleThemes' => [ # rodzaje zainstalowanych szablonów dla modułów
        'gallery' => [
            'default' => 'Standardowa galeria',
            'fancybox' => 'Fancybox'
        ],
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
    'widgetTypes' => [ # typy widżetów
        'plain' => 'Zwykły tekst',
        'html-editor' => 'Formatowany tekst HTML',
        'image' => 'Zdjęcie',
    ],
    'permissions' => [ # zawiera uprawnienia dostępne dla pracownikow
        'manage_staff' => 'Zarządzanie pracownikami',
        'manage_staff_groups' => 'Zarządzanie grupami pracowników',
    ],
    'thumb' => [ # ustawienia generatora miniaturek
        'enabled' => true, # czy generować miniaturki?
        'thumbsUrl' => '/tmp/thumbs', # adres do katalogu z miniaturkami
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

    if ($path === "#") {
        return $path;
    }

    $url = rootUrl(FRONT_CONTROLLER_URL); # generowane przez routing

    return $url.$path;
}

/**
 * Usuwa przednie części adresu, aby nie zawierały domeny lub rootUrl
 */
function uploadUrl($path)
{
    if (strlen(ROOT_URL) <= 0) {
        return $path;
    }

    if ($path and strpos($path, ROOT_URL) === 0) {
        $path = substr($path, strlen(ROOT_URL));
    }

    return $path;
}
