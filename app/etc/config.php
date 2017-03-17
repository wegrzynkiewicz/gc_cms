<?php

/** Plik zawiera definicje najważniejszych stałych i ustawień dla aplikacji */

/******************************************************************************/
/*    ____  ____      _     _____   ____  _____  _   _  _____  _____  ____    */
/*   / ___||  _ \    / \   |  ___| / ___|| ____|| \ | ||_   _|| ____||  _ \   */
/*  | |  _ | |_) |  / _ \  | |_   | |    |  _|  |  \| |  | |  |  _|  | |_) |  */
/*  | |_| ||  _ <  / ___ \ |  _|  | |___ | |___ | |\  |  | |  | |___ |  _ <   */
/*   \____||_| \_\/_/   \_\|_|     \____||_____||_| \_|  |_|  |_____||_| \_\  */
/*                                                                            */
/*       GrafCenterCMF made with <3 by @wegrzynkiewicz for @grafcenter        */
/*                                                                            */
/******************************************************************************/

define('START_TIME', $_SERVER["REQUEST_TIME_FLOAT"]); # początkowy czas uruchomienia aplikacji
define('GCCMF_VERSION', '1.0.0'); # wersja systemu
define('TEMPLATE', 'bootstrap-example'); # nazwa używanego szablonu
define('ASSETS_URL', '/assets'); # adres do katalogu z zasobami
define('ROOT_PATH', realpath(__DIR__.'/../../')); # ścieżka do katalogu głównego serwera www
define('WEB_PATH', ROOT_PATH.'/web'); # ścieżka do katalogu an który jest nakierowana domena
define('TEMP_PATH', ROOT_PATH.'/cache'); # ścieżka do katalogu tymczasowego
define('ROUTES_PATH', ROOT_PATH.'/routes'); # ścieżka do katalogu z plikami kontrolerów i szablonów
define('STORAGE_PATH', ROOT_PATH.'/storage'); # ścieżka do katalogu magazynu
define('TEMPLATE_PATH', ROOT_PATH.'/templates/'.TEMPLATE); # ścieżka do katalogu z szablonem
define('TEMPLATE_ASSETS_URL', '/assets/'.TEMPLATE); # adres do zasobów w katalogu z szablonem

chdir(ROOT_PATH); # zmienia bieżący katalog na root

ini_set('register_globals', 0); # zabrania tworzenia zmiennych z danych wysyłanych przez żądanie
ini_set('error_reporting', E_ALL); # raportuje napotkane błędy
ini_set('display_errors', 1); # włącza wyświetlanie błędów
ini_set('display_startup_errors', 1); # włącza wyświetlanie startowych błędów
ini_set('error_log', TEMP_PATH.'/logs/'.date('Y-m-d').'.error.log'); # zmienia ścieżkę logowania błędów
ini_set('max_execution_time', 300); # określa maksymalny czas trwania skryptu
ini_set('memory_limit', '256M'); # określa maksymalny rozmiar zaalokowanej pamięci
ini_set('date.timezone', 'Europe/Warsaw'); # ustawienie domyślnej strefy czasowej
ini_set('session.gc_maxlifetime', 3600); # ustaw, aby usuwać sesje starsze niż (w sekundach)
ini_set('session.gc_probability', 20); # częstotliwość z jaką następuje czyszczenie sesji
ini_set('session.use_trans_sid', 0);
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_httponly', 1); # ustawia ciastko tylko do odczytu, nie jest możliwe odczyt document.cookie w js
ini_set('session.use_cookies', 1); # do przechowywania sesji ma użyć ciastka
ini_set('session.use_only_cookies', 1); # do przechowywania sesji ma używać tylko ciastka!
ini_set('session.save_path', STORAGE_PATH.'/sessions'); # ścieżka w której będą przechowywane pliki sesji
ini_set('zlib.output_compression_level', 1); # poziom kompresji wyjścia skryptu

header('X-Content-Type-Options: nosniff'); # nie pozwala przeglądarce na zgadywanie typu mime nieznanego pliku
header('X-XSS-Protection: 1; mode=block'); # ustawienie ochrony przeciw XSS, przeglądarka sama wykrywa XSSa
header_remove('X-Powered-By'); # usuwa informacje o wykorzystywanej wersji php

$config = [
    'debug' => [ # opcje związane z wyświetlaniem błędów
        'enabled' => true, # zezwala na nietypowe akcje (np: zmiana hasła admina)
        'construction' => false, # wyświetla komunikat "strona w budowie" za każdym żądaniem
    ],
    'template' => [ # ustwienia szablonu
        # powinny być puste i zaktualizowane poprzez pliki szablonu
    ],
    'seo' => [ # związane z nazwą adresu url witryny

        # kod odpowiedzi podczas przekierowywania seo, przydatne, aby przeglądarki nie cachowany przekierowań
        'responseCode' => 303,

        # null jeżeli możliwość wejścia z każdego protokolu, wartość logiczna,
        # boolean, nakazuje przekierowywanie na adres z lub bez https,
        'forceHTTPS' => false,

        # null jeżeli możliwość wejścia z każdego www, wartość logiczna,
        # boolean, nakazuje przekierowywanie na adres z lub bez www,
        'forceWWW' => false,

        # null jeżeli możliwość wejścia z każdej domeny,
        # string, nakazuje przekierowywanie na zadaną domenę,
        'forceDomain' => null,

        # null jeżeli możliwość wejścia z i bez front controllera,
        # boolean, nakazuje przekierowywanie front controller
        'forceIndexPhp' => null,

        # null jeżeli możliwość wejścia z każdego portu,
        # int, nakazuje przekierowywanie na zadany port,
        'forcePort' => null,

        # null jeżeli możliwość wejścia bez rozszerzenia
        # string, nakazuje przekierowywanie na zadane rozszerzenie, jeżeli nie jest ono podane
        'forceDefaultExtension' => null,
    ],
    'adminNavbarTitle' => 'Panel Administracyjny', # wyświetlana w prawym gornym rogu panelu admina
    'adminHeadTitleBase' => 'Acme Panel Administracyjny', # nazwa doklejana do <title> strony w panelu admina
    'noImageUri' => ASSETS_URL.'/admin/images/no-image.jpg', # ścieżka do obrazka w przypadku braku obrazka
    'password' => [ # zawiera ustawienia dotyczące polityki haseł
        'minLength' => 8, # minimalna długość hasła
    ],
    'session' => [ # ustawienia sesji
        'staff' => [ # ustawienia sesji dla pracownika
            'lifetime' => 1800, # czas jaki musi upłynąć, aby sesja wygasło; w sekundach
        ],
    ],
    'avatar' => [
        'noAvatarUrl' => '/admin/images/no-avatar.jpg', # ściezka do domyślnego obrazka avatara
    ],
    'database' => [ # zawiera parametry połączeniowe do bazy danych
        'dns' => 'mysql:host=localhost;dbname=_gc_cms;charset=utf8',
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'name' => '_gc_cms',
        'prefix' => 'gc_'
    ],
    'logger' => [ # ustawienia dla rejestrowania logów
        'enabled' => true, # uruchamia rejestrowanie logów
        'folder' => TEMP_PATH.'/logs', # katalog do ktorego są zapisywane logi
    ],
    'translator' => [ # ustawienia translatora
        'enabled' => true, # czy włączyć tłumaczenie komunikatów
        'folder' => STORAGE_PATH.'/locales', # katalog do ktorego są zapisywane tłumaczenia
        'key' => 'trnsl.1.1.20161215T151949Z.587eb49efd9a9be2.a1eb760e6bf78076ea004f12eeb22b37902aadc2', # klucz do api translatora w serwisie Yandex
    ],
    'mailer' => [ # ustawienia serwera pocztowego do rozsyłania emaili
        'smtp' => true, # czy używać mailera smtp?
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
        'headerTitle' => "Panel administracyjny GrafCenter CMS", # wykorzystywane do wyświetlania w panelowych mailach
    ],
    'reCaptcha' => [ # zawiera konfiguracje dla recaptchy od googla
        'public' => '6Le88g4UAAAAAJ_VW4XML20c2tWSWFSv29lkGeVp', # publiczny klucz
        'secret' => '6Le88g4UAAAAAIOFZyOilvhdWRP3IIOWdkdQ7gAf', # prywatny klucz
    ],
    'thumbnail' => [ # ustawienia generatora miniaturek
        'enabled' => true, # czy generować miniaturki?
        'path' => WEB_PATH, # ścieżka do katalogu z miniaturkami, należy do tego dodać 'uri'
        'uri' => '/thumbnails', # adres do katalogu z miniaturkami
        'options' => [ # ustawienia zapisu dla miniaturek
            'jpeg_quality' => 90, # stopień kompresji dla JPG 0-100
            'png_compression_level' => 9, # stopień kompresji dla PNG 0-9
        ],
    ],
    'dataTable' => [ # dotyczą pluginu DataTables
        'iDisplayLength' => 50, # ilość rekordów domyślnie wyświetlanych na jedną strone
    ],
    'langs' => [ # zainstalowane języki w aplikacji
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
    'lang' => [ # ustawienia języków
        'main' => 'pl', # główny język strony, który nie jest wyświetlany w slugu
        'visitorDefault' => 'pl', # domyśly język gdy nie wiadomo jakiego języka oczekuje odwiedzający
        'editorDefault' => 'pl', # domyślny język edytowania w panelu admina
    ],
    'frames' => [ # ustawienia i rodzaje rusztowań
        'page' => [
            'name' => 'Strona',
        ],
        'post' => [
            'name' => 'Wpis',
        ],
        'post-node' => [ # węzeł podziału wpisu, czyli np. Aktualności
            'name' => 'Węzeł wpisu',
        ],
        'post-taxonomy' => [ # podział wpisu, czyli np. Kategoria wpisu
            'name' => 'Podział wpisu',
        ],
        'product' => [
            'name' => 'Produkt',
        ],
        'product-node' => [ # węzeł podziału produktu, czyli np. Procesory
            'name' => 'Węzeł produktu',
        ],
        'product-taxonomy' => [ # węzeł podziału produktu, czyli np. Kategoria produktu
            'name' => 'Podział produktu',
        ],
    ],
    'modules' => [ # rodzaje zainstalowanych modułów
        'html-editor' => [
            'name' => 'Moduł tekstowy',
            'description' => 'Wyświelta treść HTML poprzez edytor WYSIWYG.',
            'themes' => [
                'default' => 'Standardowa treść',
            ],
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
        'youtube' => [
            'name' => 'Moduł YouTube',
            'description' => 'Wyświetla film z serwisu YouTube.',
            'themes' => [],
        ],
        'see-also' => [
            'name' => 'Moduł: Zobacz także',
            'description' => 'Wyświetla wybrane treści z możliwością przekierowania',
            'themes' => [
                'default' => 'Boksy z miniaturkami',
                'links' => 'Zwykłe linki',
            ],
        ],
    ],
    'navigation' => [ # ustawienia dla nawigacji
        'nodeTypes' => [ # rodzaje węzłów nawigacji
            'empty' => 'Nieklikalny węzeł',
            'external' => 'Kieruj na adres',
            'homepage' => 'Kieruj na stronę główną',
            'frame' => 'Kieruj na stronę w serwisie',
        ],
        'nodeThemes' => [ # dostępne wyróżnienia węzłów
            'default' => 'Domyślny węzeł',
        ],
        'nodeTargets' => [ # dostępne atrybuty target dla węzłów nawigacji
            '_self' => 'Załaduj w tym samym oknie',
            '_blank' => 'Załaduj w nowym oknie',
        ],
    ],
    'formFieldTypes' => [ # rodzaje zainstalowanych pól formularzy
        'editbox' => 'Zwykłe pole tekstowe',
        'selectbox' => 'Pole jednokrotnego wyboru',
    ],
    'formStatuses' => [ # statusy jakie nadesłany formularz może otrzymać
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
    'widgetTypes' => [ # typy widżetów
        'plain' => 'Zwykły tekst',
        'html-editor' => 'Formatowany tekst HTML',
        'image' => 'Zdjęcie',
    ],
    'popupTypes' => [ # typy wyskakujących okienek
        'html-editor' => 'Formatowany tekst HTML',
        'fullsize-image' => 'Zdjęcie na całą szerokość',
        'custom' => 'Specjalnie przygotowany przez programistę',
    ],
    'permissions' => [ # zawiera uprawnienia dostępne dla pracownikow
        'manage_staff' => 'Zarządzanie pracownikami',
        'manage_staff_groups' => 'Zarządzanie grupami pracowników',
    ],
    'frameVisibility' => [ # dostępne atrybuty visibility dla rusztowań
        'all' => 'Widoczna dla wszystkich',
        'hidden' => 'Ukryta',
    ],
    'rewrites' => [ # zawiera niestandardowe przekierowania $regex => $destination
        '~^/old-service/index\.php\?id=(\d+)\&theme=([a-z]+?)$~' => '/old-service/$1/$2',
    ],
    'elfinder' => [ # ustwienia dotyczące elfindera
        'uri' => '/admin/elfinder/connector.json', # adres relatywny connectora
    ],
    'dump' => [ # zawiera informacje dla eksportera bazy danych
        'path' => STORAGE_PATH.'/dumps/'.date('Y-m'), # ścieżka do katalogu z rzutami bazy danych
        'tmpPath' => TEMP_PATH, # ścieżka tymczasowa dla eksportera
        'settings' => [ # ustawienia dla MySQLDump
            'include-tables' => [],
            'exclude-tables' => [
                '/checksums$/',
                '/dumps$/',
                '/form_sent$/',
                '/mail_to_send$/',
                '/mail_sent$/',
                '/staff$/',
                '/staff_meta$/',
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
