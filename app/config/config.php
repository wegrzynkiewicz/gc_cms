<?php

/** Plik zawiera definicje najważniejszych stałych i właściwości dla aplikacji */

define('TEMPLATE', 'bootstrap-example'); # nazwa używanego szablonu
define('ASSETS_URL', '/assets'); # adres do katalogu z zasobami
define('ROOT_PATH', realpath(__DIR__.'/../../')); # ścieżka do katalogu głównego serwera www
define('WEB_PATH', ROOT_PATH.'/web'); # ścieżka do katalogu z www rootem
define('ACTIONS_PATH', ROOT_PATH.'/actions'); # ścieżka do katalogu z plikami kontrolerów i szablonów
define('TEMPLATE_PATH', ROOT_PATH.'/templates/'.TEMPLATE); # ścieżka do plików szablonu
define('TEMPLATE_ASSETS_URL', '/templates/'.TEMPLATE); # adres do zasobów w katalogu z szablonem

$config = [
    'debug' => [ # opcje związane z wyświetlaniem błędów
        'enabled' => true,
        'inConstruction' => false, # wyświetla komunikat "strona w budowie" za każdym żądaniem
    ],
    'adminNavbarTitle' => 'Panel Administracyjny', # wyświetlana w prawym gornym rogu panelu admina
    'adminHeadTitleBase' => 'Acme Panel Administracyjny', # nazwa doklejana do <title> strony w panelu admina
    'noImageUrl' => '/admin/images/no-image.jpg', # ścieżka do obrazka w przypadku braku obrazka
    'timezone' => 'Europe/Warsaw', # domyślna strefa czasowa
    'password' => [
        'minLength' => 8, # minimalna długość hasła
        'staticSalt' => '81qU6GlSusOZNxrWQF0x5xNaWT0odCfM4x4im4p3', # unikalna, sól dla wszystkich użytkowników, nie zmieniać nigdy
        'options' => [ # opcje dla generatora haseł
            'cost' => 11,
        ]
    ],
    'session' => [
        'cookieName' => 'TOLmEeE4ouK9lWuFigwvPqVhxLgtfj7k5kVqhIWL', # nazwa ciastka sesyjnego
        'staffTimeout' => 1800, # czas jaki musi upłynąć po zalogowaniu, aby wylogowało pracownika z automatu, w sekundach
    ],
    'avatar' => [
        'noAvatarUrl' => '/admin/images/no-avatar.jpg', # ściezka do domyślnego obrazka avatara
    ],
    'lang' => [
        'clientDefault' => 'pl', # wykorzystywany gdy wszystkie inne sposoby określenia języka klienta zawiodą
        'editorDefault' => 'pl', # domyślny język edytowania w panelu admina
    ],
    'translator' => [ # ustawienia translatora
        'enabled' => true, # czy włączyć tłumaczenie komunikatów
        'folder' => ROOT_PATH.'/app/storage/locales', # katalog do ktorego są zapisywane tłumaczenia
        'key' => 'trnsl.1.1.20161215T151949Z.587eb49efd9a9be2.a1eb760e6bf78076ea004f12eeb22b37902aadc2', # klucz do api translatora w serwisie Yandex
    ],
    'logger' => [ # ustawienia dla rejestrowania logów
        'enabled' => true, # uruchamia rejestrowanie logów
        'folder' => ROOT_PATH.'/tmp/logs', # katalog do ktorego są zapisywane logi
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
    'reCaptcha' => [ # zawiera konfiguracje dla recaptchy od googla
        'public' => '6Le88g4UAAAAAJ_VW4XML20c2tWSWFSv29lkGeVp', # publiczny klucz
        'secret' => '6Le88g4UAAAAAIOFZyOilvhdWRP3IIOWdkdQ7gAf', # prywatny klucz
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
    'modules' => [ # rodzaje zainstalowanych modułów
        'html-editor' => [
            'name' => 'Moduł tekstowy',
            'description' => 'Wyświelta treść HTML poprzez edytor WYSIWYG.',
        ],
        'gallery' => [
            'name' => 'Moduł galerii zdjęć',
            'description' => 'Wyświetla wiele zdjęć z możliwością podglądu.',
        ],
        'photo' => [
            'name' => 'Moduł pojedyńczego zdjęcia',
            'description' => 'Wyświetla jedno zdjęcie z możliwością podglądu.',
        ],
        'image-slider' => [
            'name' => 'Moduł slajdów ze zdjęciami',
            'description' => 'Wyświetla animowane slajdy zawierające tylko zdjęcia.',
        ],
        'form' => [
            'name' => 'Moduł formularza',
            'description' => 'Wyświetla jeden z przygotowanych formularzy.',
        ],
        'tabs' => [
            'name' => 'Moduł zakładek',
            'description' => 'Rozdziela treść pomiędzy klikalne zakładki.',
        ],
    ],
    'moduleThemes' => [ # rodzaje zainstalowanych szablonów dla modułów
        'gallery' => [
            'default' => 'Standardowa galeria',
            'simple' => 'Zwykłe zdjęcia bez obramowań (z podglądem)'
        ],
        'photo' => [
            'default' => 'Zdjęcie z poglądem',
            'no-clickable' => 'Nieklikalne zdjęcie',
        ],
        'image-slider' => [
            'default' => 'Standardowy slajder',
        ],
        'form' => [
            'default' => 'Budowany automatycznie',
            'custom' => 'Specjalnie przygotowany (jeżeli nie istnieje, wtedy automatyczny)',
        ],
    ],
    'nodeTypes' => [ # rodzaje węzłów nawigacji
        'empty' => 'Nieklikalny węzeł',
        'external' => 'Kieruj na adres',
        'homepage' => 'Kieruj na stronę główną',
        'page' => 'Kieruj na istniejącą stronę',
    ],
    'formFieldTypes' => [
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
            'name' => 'Odrzucona',
            'class' => 'text-danger danger',
        ],
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
        'thumbsPath' => ROOT_PATH.'/web', # ścieżka do katalogu z miniaturkami, należy do tego dodać thumbsUrl
        'thumbsUrl' => '/thumbs', # adres do katalogu z miniaturkami
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
    'navNodeTargets' => [ # dostępne atrybuty target dla węzłów nawigacji
        '_self'	 => 'Załaduj w tym samym oknie',
        '_blank' => 'Załaduj w nowym oknie',
    ],
    'rewrites' => [ # zawiera niestandardowe przekierowania $regex => $destination
        '~^/old-service/index\.php\?id=(\d+)\&theme=([a-z]+?)$~' => '/old-service/$1/$2',
    ],
    'dump' => [ # zawiera informacje dla eksportera bazy danych
        'path' => ROOT_PATH.'/app/storage/dumps', # ścieżka do katalogu z rzutami bazy danych
        'tmpPath' => ROOT_PATH.'/tmp', # ścieżka tymczasowa dla eksportera
        'settings' => [
            'include-tables' => [],
            'exclude-tables' => [
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
