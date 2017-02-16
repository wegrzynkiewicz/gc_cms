<?php

/** Plik zawiera definicje najważniejszych stałych i ustawień dla aplikacji */

/******************************************************************************/
/*    ____  ____      _     _____   ____  _____  _   _  _____  _____  ____    */
/*   / ___||  _ \    / \   |  ___| / ___|| ____|| \ | ||_   _|| ____||  _ \   */
/*  | |  _ | |_) |  / _ \  | |_   | |    |  _|  |  \| |  | |  |  _|  | |_) |  */
/*  | |_| ||  _ <  / ___ \ |  _|  | |___ | |___ | |\  |  | |  | |___ |  _ <   */
/*   \____||_| \_\/_/   \_\|_|     \____||_____||_| \_|  |_|  |_____||_| \_\  */
/*                                                                            */
/*    GrafCenterCMF 1.0.0 made with <3 by @wegrzynkiewicz for @grafcenter     */
/*                                                                            */
/******************************************************************************/

# początkowy czas uruchomienia aplikacji
define('START_TIME', $_SERVER["REQUEST_TIME_FLOAT"]);

# nazwa używanego szablonu
define('TEMPLATE', 'bootstrap-example');

# adres do katalogu z zasobami
define('ASSETS_URL', '/assets');

# ścieżka do katalogu głównego serwera www
define('ROOT_PATH', realpath(__DIR__.'/../../'));

# ścieżka do katalogu an który jest nakierowana domena
define('WEB_PATH', ROOT_PATH.'/web');

# ścieżka do katalogu z plikami kontrolerów i szablonów
define('ACTIONS_PATH', ROOT_PATH.'/actions');

# ścieżka do katalogu z szablonem
define('TEMPLATE_PATH', ROOT_PATH.'/templates/'.TEMPLATE);

# adres do zasobów w katalogu z szablonem
define('TEMPLATE_ASSETS_URL', '/templates/'.TEMPLATE);

# zmienia bieżący katalog na root
chdir(ROOT_PATH);

# zabrania tworzenia zmiennych z danych wysyłanych przez żądanie
ini_set('register_globals', 0);

# raportuje napotkane błędy
ini_set('error_reporting', E_ALL);

# włącza wyświetlanie błędów
ini_set('display_errors', 1);

# włącza wyświetlanie startowych błędów
ini_set('display_startup_errors', 1);

# zmienia ścieżkę logowania błędów
ini_set('error_log', ROOT_PATH.'/tmp/logs/'.date('Y-m-d').'.error.log');

# określa maksymalny czas trwania skryptu
ini_set('max_execution_time', 300);

# ustawienie domyślnej strefy czasowej
ini_set('date.timezone', 'Europe/Warsaw');

# zmiana nazwy ciastka sesyjnego
ini_set('session.name', 'PSV');

# częstotliwość z jaką następuje czyszczenie sesji
ini_set('session.gc_probability', 10);

ini_set('session.use_trans_sid', 0);

ini_set('session.use_strict_mode', 1);

# ustawia ciastko tylko do odczytu, nie jest możliwe odczyt document.cookie w js
ini_set('session.cookie_httponly', 1);

# do przechowywania sesji ma użyć ciastka
ini_set('session.use_cookies', 1);

# do przechowywania sesji ma używać tylko ciastka!
ini_set('session.use_only_cookies', 1);

# użycie bardziej złożonej funkcji do hashowania ciastka sesyjnego
ini_set('session.hash_function', 1);

# ścieżka w której będą przechowywane pliki sesji
// ini_set('session.save_path', ROOT_PATH.'/app/storage/sessions');

# poziom kompresji wyjścia skryptu
ini_set('zlib.output_compression_level', 1);

# ustawienie domyślego mimetype i kodowanie
header("Content-Type: text/html; charset=utf-8");

# nie pozwala przeglądarce na zgadywanie typu mime nieznanego pliku
header('X-Content-Type-Options: nosniff');

# ustawienie ochrony przeciw XSS, przeglądarka sama wykrywa XSSa
header('X-XSS-Protection: 1; mode=block');

# usuwa informacje o wykorzystywanej wersji php
header_remove('X-Powered-By');

return [

    # opcje związane z wyświetlaniem błędów
    'debug' => [

        # zezwala na nietypowe akcje (np: zmiana hasła admina)
        'enabled' => true,

        # wyświetla komunikat "strona w budowie" za każdym żądaniem
        'inConstruction' => false,
    ],

    # związane z nazwą adresu url witryny
    'seo' => [

        # wartość logiczna, nakazuje przekierowywanie na adres z lub bez https,
        # null jeżeli możliwość wejścia z każdego protokolu
        'forceHTTPS' => false,

        # wartość logiczna, nakazuje przekierowywanie na adres z lub bez www,
        # null jeżeli możliwość wejścia z każdego www.
        'forceWWW' => false,

        # nakazuje przekierowywanie na zadaną domenę,
        # null jeżeli możliwość wejścia z każdej domeny.
        'forceDomain' => null,

        # nakazuje przekierowywanie na zadany port,
        # null jeżeli możliwość wejścia z każdego portu.
        'forcePort' => null,
    ],

    # wyświetlana w prawym gornym rogu panelu admina
    'adminNavbarTitle' => 'Panel Administracyjny',

    # nazwa doklejana do <title> strony w panelu admina
    'adminHeadTitleBase' => 'Acme Panel Administracyjny',

    # ścieżka do obrazka w przypadku braku obrazka
    'noImageUrl' => '/admin/images/no-image.jpg',

    # zawiera ustawienia dotyczące polityki haseł
    'password' => [
        # minimalna długość hasła
        'minLength' => 8,
    ],

    # ustawienia sesji
    'session' => [

        # ustawienia sesji dla pracownika
        'staff' => [

            # czas jaki musi upłynąć po zalogowaniu, aby sesja pracownika przedawniła się; w sekundach
            'lifetime' => 1800,

            # ustawienia ciastka sesyjnego
            'cookie' => [

                # nazwa ciastka sesyjnego dla pracownika
                'name' => 'PSS',

                # czas jaki musi upłynąć, aby ciastko wygasło; w sekundach
                'lifetime' => 3600,
            ],
        ],

        # ustawienia sesji dla odwiedzającego
        'visitor' => [

            # czas jaki musi upłynąć po zalogowaniu, aby sesja odwiedzającego przedawniła się; w sekundach
            'lifetime' => 1800,

            # ustawienia ciastka sesyjnego
            'cookie' => [

                # nazwa ciastka sesyjnego dla odwiedzającego
                'name' => 'PSV',

                # czas jaki musi upłynąć po zalogowaniu, aby ciastko przestało być ważne; w sekundach
                'lifetime' => 3600,
            ],
        ],
    ],

    'avatar' => [

        # ściezka do domyślnego obrazka avatara
        'noAvatarUrl' => '/admin/images/no-avatar.jpg',
    ],

    # zawiera parametry połączeniowe do bazy danych
    'database' => [
        'dns' => 'mysql:host=localhost;dbname=_gc_cms;charset=utf8',
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'name' => '_gc_cms',
        'prefix' => 'gc_'
    ],

    # ustawienia dla rejestrowania logów
    'logger' => [

        # uruchamia rejestrowanie logów
        'enabled' => true,

        # katalog do ktorego są zapisywane logi
        'folder' => ROOT_PATH.'/tmp/logs',
    ],

    # ustawienia translatora
    'translator' => [

        # czy włączyć tłumaczenie komunikatów
        'enabled' => true,

        # katalog do ktorego są zapisywane tłumaczenia
        'folder' => ROOT_PATH.'/app/storage/locales',

        # klucz do api translatora w serwisie Yandex
        'key' => 'trnsl.1.1.20161215T151949Z.587eb49efd9a9be2.a1eb760e6bf78076ea004f12eeb22b37902aadc2',
    ],

    # ustawienia serwera pocztowego do rozsyłania emaili
    'mailer' => [

        # czy użwać mailera smtp?
        'smtp' => true,

        # host serwera pocztowego
        'host' => 'smtp.emaillabs.net.pl',

        # post hosta
        'port' => 587,

        # nazwa konta pocztowego
        'username' => '1.wegrzynkiewicz.smtp',

        # hasło konta pocztowego
        'password' => '9pf1SdUuZxZzagJN6235ShyTXGLCWCiHbI4Lh6pd',

        # szyfrowanie wiadomości email
        'SMTPsecure' => 'tls',

        # adres email w nagłówku from, zostaw puste, aby wygenerować z nazwą domeny
        'fromEmail' => 'from@localhost',

        # nazwa użytkownika w nagłówku from
        'fromName' => null,

        # nazwa użytkownika w nagłówku reply
        'replyEmail' => 'noreply@localhost',

        # nazwa użytkownika w nagłówku reply
        'replyName' => null,

        # ile może się wysłać wiadomości na raz za jednym żądaniem
        'limitPerOnce' => 10,

        # wykorzystywane do wyświetlania w panelowych mailach
        'headerTitle' => "Panel administracyjny GrafCenter CMS",
    ],

    # zawiera konfiguracje dla recaptchy od googla
    'reCaptcha' => [

        # publiczny klucz
        'public' => '6Le88g4UAAAAAJ_VW4XML20c2tWSWFSv29lkGeVp',

        # prywatny klucz
        'secret' => '6Le88g4UAAAAAIOFZyOilvhdWRP3IIOWdkdQ7gAf',
    ],

    # dotyczą pluginu DataTables
    'dataTable' => [

        # ilość rekordów domyślnie wyświetlanych na jedną strone
        'iDisplayLength' => 50,
    ],

    # zainstalowane języki w aplikacji
    'langs' => [
        'pl' => [
            'name' => 'Polski',
            'flag' => 'pl',
        ],
        'en' => [
            'name' => 'English',
            'flag' => 'gb',
        ],
        'de' => [
            'name' => 'Deutsch',
            'flag' => 'de',
        ],
    ],

    # ustawienia języków
    'lang' => [

        # domyśly język gdy nie wiadomo jakiego języka oczekuje odwiedzający
        'visitorDefault' => 'pl',

        # domyślny język edytowania w panelu admina
        'editorDefault' => 'pl',
    ],

    # rodzaje zainstalowanych modułów
    'modules' => [
        'html-editor' => [
            'name' => 'Moduł tekstowy',
            'description' => 'Wyświelta treść HTML poprzez edytor WYSIWYG.',
            'themes' => [],
        ],
        'gallery' => [
            'name' => 'Moduł galerii zdjęć',
            'description' => 'Wyświetla wiele zdjęć z możliwością podglądu.',
            'themes' => [
                'default' => 'Standardowa galeria',
                'simple' => 'Zwykłe zdjęcia bez obramowań (z podglądem)'
            ],
        ],
        'photo' => [
            'name' => 'Moduł pojedyńczego zdjęcia',
            'description' => 'Wyświetla jedno zdjęcie z możliwością podglądu.',
            'themes' => [
                'default' => 'Zdjęcie z poglądem',
                'no-clickable' => 'Nieklikalne zdjęcie',
            ],
        ],
        'image-slider' => [
            'name' => 'Moduł slajdów ze zdjęciami',
            'description' => 'Wyświetla animowane slajdy zawierające tylko zdjęcia.',
            'themes' => [
                'default' => 'Standardowy slajder',
            ],
        ],
        'form' => [
            'name' => 'Moduł formularza',
            'description' => 'Wyświetla jeden z przygotowanych formularzy.',
            'themes' => [
                'default' => 'Budowany automatycznie',
                'custom' => 'Specjalnie przygotowany (jeżeli istnieje, wtedy automatyczny)',
            ],
        ],
        'tabs' => [
            'name' => 'Moduł zakładek',
            'description' => 'Rozdziela treść pomiędzy klikalne zakładki.',
            'themes' => [],
        ],
    ],

    # rodzaje węzłów nawigacji
    'nodeTypes' => [
        'empty' => 'Nieklikalny węzeł',
        'external' => 'Kieruj na adres',
        'homepage' => 'Kieruj na stronę główną',
        'page' => 'Kieruj na istniejącą stronę',
    ],

    # rodzaje zainstalowanych pól formularzy
    'formFieldTypes' => [
        'editbox' => 'Zwykłe pole tekstowe',
        'selectbox' => 'Pole jednokrotnego wyboru',
    ],

    # statusy jakie nadesłany formularz może otrzymać
    'formStatuses' => [
        'unread' => [
            'name' => 'Nieprzeczytana',
            'class' => 'font-bold',
        ],
        'readed' => [
            'name' => 'Przeczytana',
            'class' => 'text-muted',
        ],
        'processed' => [
            'name' => 'W trakcie realizacji',
            'class' => 'text-warning warning',
        ],
        'completed' => [
            'name' => 'Zrealizowano',
            'class' => 'text-success success',
        ],
        'rejected' => [
            'name' => 'Odrzucono',
            'class' => 'text-danger danger',
        ],
    ],

    # typy widżetów
    'widgetTypes' => [
        'plain' => 'Zwykły tekst',
        'html-editor' => 'Formatowany tekst HTML',
        'image' => 'Zdjęcie',
    ],

    # zawiera uprawnienia dostępne dla pracownikow
    'permissions' => [
        'manage_staff' => 'Zarządzanie pracownikami',
        'manage_staff_groups' => 'Zarządzanie grupami pracowników',
    ],

    # ustawienia generatora miniaturek
    'thumb' => [

        # czy generować miniaturki?
        'enabled' => true,

        # ścieżka do katalogu z miniaturkami, należy do tego dodać thumbsUrl
        'thumbsPath' => ROOT_PATH.'/web',

        # adres do katalogu z miniaturkami
        'thumbsUrl' => '/thumbs',

        # ustawienia dla generatora miniaturek
        'options' => [
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

    # dostępne atrybuty target dla węzłów nawigacji
    'navNodeTargets' => [
        '_self'     => 'Załaduj w tym samym oknie',
        '_blank' => 'Załaduj w nowym oknie',
    ],

    # zawiera niestandardowe przekierowania $regex => $destination
    'rewrites' => [
        '~^/old-service/index\.php\?id=(\d+)\&theme=([a-z]+?)$~'
            => '/old-service/$1/$2',
    ],

    # zawiera informacje dla eksportera bazy danych
    'dump' => [

        # ścieżka do katalogu z rzutami bazy danych
        'path' => ROOT_PATH.'/app/storage/dumps/'.date('Y-m'),

        # ścieżka tymczasowa dla eksportera
        'tmpPath' => ROOT_PATH.'/tmp',

        # ustawienia dla MySQLDump
        'settings' => [
            'include-tables' => [],
            'exclude-tables' => [
                '/checksums$/',
                '/dumps$/',
                '/form_sent$/',
                '/mail_to_send$/',
                '/mail_sent$/',
                '/staff$/',
                '/staff_groups$/',
                '/staff_membership$/',
                '/staff_permissions$/',
            ],
            'compress' => 'Gzip',
            'no-data' => false,
            'add-drop-table' => true,
            'single-transaction' => true,
            'lock-tables' => false,
            'add-locks' => true,
            'extended-insert' => false,
            'complete-insert' => false,
            'disable-keys' => true,
            'where' => '',
            'no-create-info' => false,
            'skip-triggers' => false,
            'add-drop-trigger' => true,
            'routines' => false,
            'hex-blob' => true,
            'databases' => false,
            'add-drop-database' => false,
            'skip-tz-utc' => false,
            'no-autocommit' => true,
            'default-character-set' => 'utf8',
            'skip-comments' => true,
            'skip-dump-date' => false,
        ],
    ],
];
