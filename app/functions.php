<?php

/** Zawiera definicje wszyskich funkcji */

/**
 * Zabezpiecza wyjście przed XSS zamieniając znaki specjalne na encje
 */
function e(string $string): string
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Służy do debugowania, exportuje wynik print_r() do pliku logu
 */
function dd($mixed = null): void
{
    # pobiera informacje o pliku w którym wywoływana jest funkcja dd()
    $backtrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT);
    $execution = array_shift($backtrace);

    logger(sprintf('[DUMP] %s:%s - %s %s',
        $execution['file'],
        $execution['line'],
        gettype($mixed),
        print_r($mixed, true)
    ));
}

function purifyHtml(string $dirtyHtml): string
{
    $config = HTMLPurifier_Config::createDefault();
    $purifier = new HTMLPurifier($config);
    $cleanHtml = $purifier->purify($dirtyHtml);

    return $cleanHtml;
}

/**
 * Kompresuje kod HTMLa
 */
function compressHtml(string $html): string
{
    return \zz\Html\HTMLMinify::minify($html, [
        'optimizationLevel' => \zz\Html\HTMLMinify::OPTIMIZATION_ADVANCED
    ]);
}

/**
 * Służy do prostrzego drukowania warunku
 */
function selected(bool $condition): string
{
    return $condition ? ' selected="selected" ' : '';
}

/**
 * Służy do prostrzego drukowania warunku
 */
function checked(bool $condition): string
{
    return $condition ? ' checked="checked" ' : '';
}

/**
 * Pobiera element z tablicy $array po kluczach $keys, zwraca $default jeżeli nie znajdzie elementu
 * getValueByKeys($_POST, ['sample', 'example']) === $_POST['sample']['example'];
 */
function getValueByKeys(array $array, array $keys, $default = null)
{
    if (count($keys) == 0) {
        return $default;
    }

    foreach ($keys as $key) {
        if (!isset($array[$key])) {
            return $default;
        }
        $array = $array[$key];
    }

    return $array;
}

/**
 * Ustawia wartość $value elementu w tablicy $array po kluczach $keys,
 * zwraca $default jeżeli nie znajdzie elementu
 * setValueByKeys($_POST, ['sample', 'example'], 'value');
 * $_POST['sample']['example'] = 'value';
 */
function setValueByKeys(array &$array, array $keys, $value)
{
    if (count($keys) == 0) {
        return;
    }

    $lastKey = array_pop($keys);
    $arrayCurrent = &$array;

    foreach ($keys as $key) {
        if (!isset($arrayCurrent[$key])) {
            $arrayCurrent[$key] = [];
        }
        $arrayCurrent = &$arrayCurrent[$key];
    }

    $arrayCurrent[$lastKey] = $value;
}

/**
 * Pomocna do sprawdzania czy dany element istnieje w tabeli $_POST
 */
function post(string $name, $default = '')
{
    return (isset($_POST[$name])) ? $_POST[$name] : $default;
}

/**
 * Pomocna do sprawdzania czy dany element istnieje w tabeli $_REQUEST
 */
function request(string $name, $default = '')
{
    return (isset($_REQUEST[$name])) ? $_REQUEST[$name] : $default;
}

/**
 * Zwraca spreparowaną date dla MySQL. Można podać czas w zmiennej $timestamp
 */
function sqldate($timestamp = null): string
{
    if ($timestamp === null) {
        $timestamp = time();
    }

    return date('Y-m-d H:i:s', $timestamp);
}

/**
 * Ustawia krótkie wiadomości, które są wyświetlane po wykonaniu jakiejś akcji, np coś zostało usunięte.
 * $message należy przetłumaczyć samodzielnie. W rzeczywistości dodaje tylko dane do zmiennej sesyjnej.
 */
function flashBox(string $message, string $theme = 'success', int $time = 4000): void
{
    $_SESSION['flashBox'] = [
        'message' => $message,
        'theme' => $theme,
        'time' => $time,
    ];
}

/**
 * Usuwa sieroty z tekstu
 */
function removeOrphan(string $text): string
{
    return preg_replace('~ ([aiowzu]) ~', ' $1&nbsp;', $text);
}

/**
 * Tłumaczy wprowadzony tekst na jego odpowiednik
 */
function trans(string $text, array $params = []): string
{
    return $GLOBALS['config']['translator']['enabled']
        ? GC\Translator::getInstance()->translate($text, $params)
        : vsprintf($text, $params);
}

/**
 * Tłumaczy wprowadzony tekst na jego odpowiednik
 */
function logger(string $message, array $params = []): void
{
    if ($GLOBALS['config']['logger']['enabled']) {
        GC\Logger::getInstance()->info($message, $params);
    }
}

/**
 * Służy do zapisywania wyrzuconych wyjątków do loggera
 */
function logException(Throwable $exception): void
{
    $previous = $exception->getPrevious();
    if ($previous) {
        logException($previous);
    }
    logger(sprintf("[EXCEPTION] %s: %s [%s]\n%s",
        get_class($exception),
        $exception->getMessage(),
        $exception->getCode(),
        $exception->getTraceAsString()
    ));
}

/**
 * Zamienia ścieżkę absolutną na ścieżkę relatywną na podstawie katalogu głównego
 */
function relativePath(string $absolutePath): string
{
    $realpath = realpath($absolutePath);
    $documentRoot = $_SERVER['DOCUMENT_ROOT'];

    do {
        if (strpos($realpath, $documentRoot) === 0) {
            $relativePath = str_replace($documentRoot, '', $realpath);
            $relativePath = str_replace('\\', '/', $relativePath);

            return $relativePath;
        }
        $documentRoot = dirname($documentRoot);
    } while ($documentRoot !== dirname($documentRoot));

    return $absolutePath;
}

/**
 * Generuje losowy kolor CSS zapisany jako "#000000"
 */
function randomColor(): string
{
    return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
}

function random(int $length): string
{
    $string = openssl_random_pseudo_bytes(ceil($length));
    $string = base64_encode($string);
    $string = str_replace(['/', '+', '='], '', $string);
    $string = substr($string, 0, $length);

    return $string;
}

/**
 * Formatuje rozmiar w bajtach, np. 5.42MB
 */
function humanFilesize(int $bytes, int $decimals = 3): string
{
    static $size = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
    $factor = floor((strlen($bytes) - 1) / 3);

    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . $size[$factor];
}

/**
 * Zamienia wszystkie specialne znaki na ich odpowiedniki. Oczyszcza tekst
 */
function normalize(string $unformattedString): string
{
    # usuń białe znaki na początku i na końcu
    $normalizing = trim($unformattedString);

    static $replace = [
        'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A',
        'Æ' => 'AE', 'Ç' => 'C', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E',
        'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ð' => 'D', 'Ñ' => 'N',
        'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O',
        'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'ß' => 's',
        'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a',
        'æ' => 'ae', 'ç' => 'c', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e',
        'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ñ' => 'n', 'ò' => 'o',
        'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u',
        'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ý' => 'y', 'ÿ' => 'y', 'Ā' => 'A',
        'ā' => 'a', 'Ă' => 'A', 'ă' => 'a', 'Ą' => 'A', 'ą' => 'a', 'Ć' => 'C',
        'ć' => 'c', 'Ĉ' => 'C', 'ĉ' => 'c', 'Ċ' => 'C', 'ċ' => 'c', 'Č' => 'C',
        'č' => 'c', 'Ď' => 'D', 'ď' => 'd', 'Đ' => 'D', 'đ' => 'd', 'Ē' => 'E',
        'ē' => 'e', 'Ĕ' => 'E', 'ĕ' => 'e', 'Ė' => 'E', 'ė' => 'e', 'Ę' => 'E',
        'ę' => 'e', 'Ě' => 'E', 'ě' => 'e', 'Ĝ' => 'G', 'ĝ' => 'g', 'Ğ' => 'G',
        'ğ' => 'g', 'Ġ' => 'G', 'ġ' => 'g', 'Ģ' => 'G', 'ģ' => 'g', 'Ĥ' => 'H',
        'ĥ' => 'h', 'Ħ' => 'H', 'ħ' => 'h', 'Ĩ' => 'I', 'ĩ' => 'i', 'Ī' => 'I',
        'ī' => 'i', 'Ĭ' => 'I', 'ĭ' => 'i', 'Į' => 'I', 'į' => 'i', 'İ' => 'I',
        'ı' => 'i', 'Ĳ' => 'IJ', 'ĳ' => 'ij', 'Ĵ' => 'J', 'ĵ' => 'j',
        'Ķ' => 'K', 'ķ' => 'k', 'Ĺ' => 'L', 'ĺ' => 'l', 'Ļ' => 'L', 'ļ' => 'l',
        'Ľ' => 'L', 'ľ' => 'l', 'Ŀ' => 'L', 'ŀ' => 'l', 'Ł' => 'l', 'ł' => 'l',
        'Ń' => 'N', 'ń' => 'n', 'Ņ' => 'N', 'ņ' => 'n', 'Ň' => 'N', 'ň' => 'n',
        'ŉ' => 'n', 'Ō' => 'O', 'ō' => 'o', 'Ŏ' => 'O', 'ŏ' => 'o', 'Ő' => 'O',
        'ő' => 'o', 'Œ' => 'OE', 'œ' => 'oe', 'Ŕ' => 'R', 'ŕ' => 'r',
        'Ŗ' => 'R', 'ŗ' => 'r', 'Ř' => 'R', 'ř' => 'r', 'Ś' => 'S', 'ś' => 's',
        'Ŝ' => 'S', 'ŝ' => 's', 'Ş' => 'S', 'ş' => 's', 'Š' => 'S', 'š' => 's',
        'Ţ' => 'T', 'ţ' => 't', 'Ť' => 'T', 'ť' => 't', 'Ŧ' => 'T', 'ŧ' => 't',
        'Ũ' => 'U', 'ũ' => 'u', 'Ū' => 'U', 'ū' => 'u', 'Ŭ' => 'U', 'ŭ' => 'u',
        'Ů' => 'U', 'ů' => 'u', 'Ű' => 'U', 'ű' => 'u', 'Ų' => 'U', 'ų' => 'u',
        'Ŵ' => 'W', 'ŵ' => 'w', 'Ŷ' => 'Y', 'ŷ' => 'y', 'Ÿ' => 'Y', 'Ź' => 'Z',
        'ź' => 'z', 'Ż' => 'Z', 'ż' => 'z', 'Ž' => 'Z', 'ž' => 'z', 'ſ' => 's',
        'ƒ' => 'f', 'Ơ' => 'O', 'ơ' => 'o', 'Ư' => 'U', 'ư' => 'u', 'Ǎ' => 'A',
        'ǎ' => 'a', 'Ǐ' => 'I', 'ǐ' => 'i', 'Ǒ' => 'O', 'ǒ' => 'o', 'Ǔ' => 'U',
        'ǔ' => 'u', 'Ǖ' => 'U', 'ǖ' => 'u', 'Ǘ' => 'U', 'ǘ' => 'u', 'Ǚ' => 'U',
        'ǚ' => 'u', 'Ǜ' => 'U', 'ǜ' => 'u', 'Ǻ' => 'A', 'ǻ' => 'a', 'Ǽ' => 'AE',
        'ǽ' => 'ae', 'Ǿ' => 'O', 'ǿ' => 'o',
    ];

    # zamień znak niestandardowy na jego odpowiednik
    $normalizing = str_replace(array_keys($replace), $replace, $normalizing);

    # zamień wszystkie wielkie litery na małe
    $normalizing = mb_strtolower($normalizing);

    # zamień znaki na myślnik
    static $whitespaces = [' ', '&', '\r\n', '\n', '+', ',', '//'];
    $normalizing = str_replace($whitespaces, '-', $normalizing);

    # zastosuj wyrażenia na ich odpowiedniki
    static $regex = [
        # usuwa wszystkie znaki oprócz:
        # cyfr, liter, kropki, myślnika, podkreślnika
        '/[^a-z0-9\._\-\/]/' => '',
        # redukuje nadmiar myślinków
        '/[\-]+/' => '-',
        # redukuje nadmiar kropek
        '/[\.]+/' => '.',
    ];
    $normalizing = preg_replace(array_keys($regex), $regex, $normalizing);

    return $normalizing;
}

/**
 * Tworzy przyjazny adres dla wyszukiwarek na podstawie wprowadzonego ciągu
 */
function normalizeSlug(string $string): string
{
    if (empty($string)) {
        return '';
    }

    $normalized = trim(normalize($string), '/.-');

    return '/'.$normalized;
}

/**
 * Tworzy prawidłową ścieżkę do pliku z relatywnych katalogów
 */
function normalizePath(string $path): string
{
    $parts = array(); # Array to build a new path from the good parts
    $path = str_replace('\\', '/', $path); # Replace backslashes with forwardslashes
    $path = preg_replace('/\/+/', '/', $path); # Combine multiple slashes into a single slash
    $segments = explode('/', $path); # Collect path segments
    $test = ''; # Initialize testing variable

    foreach ($segments as $segment) {
        if ($segment != '.') {
            $test = array_pop($parts);
            if (is_null($test)) {
                $parts[] = $segment;
            } elseif ($segment == '..') {
                if ($test == '..') {
                    $parts[] = $test;
                }
                if ($test == '..' || $test == '') {
                    $parts[] = $segment;
                }
            } else {
                $parts[] = $test;
                $parts[] = $segment;
            }
        }
    }

    return implode('/', $parts);
}

/**
 * Funkcja przekierowuje na odwiedzającego na adres
 */
function redirect(string $location, int $code = 303): void
{
    http_response_code($code);
    header("Location: {$location}");

    logger(
        sprintf("[REDIRECT] %s %s -- Time: %.3fs -- Memory: %sMiB",
            $code,
            $location,
            microtime(true) - START_TIME,
            memory_get_peak_usage(true) / 1048576
        )
    );

    die();
}

/**
 * Tworzy nową tablice ze starymi kluczami, gdzie elementy tablicy
 * są przekazywane do $callback(), a zwracana wartość to nowy element tablicy
 */
function array_rebuild(array $array, callable $callback): array
{
    $results = [];
    foreach ($array as $key => $value) {
        $results[$key] = $callback($value);
    }

    return $results;
}

/**
 *
 */
function array_trans(array $array): array
{
    return array_rebuild($array, 'trans');
}

/**
 * Dzieli tablice na $p równych tablic
 */
function array_partition(array $array, int $p): array
{
    $listlen = count($array);
    $partlen = floor($listlen / $p);
    $partrem = $listlen % $p;
    $partition = array();
    $mark = 0;
    for ($px = 0; $px < $p; $px++) {
        $incr = ($px < $partrem) ? $partlen + 1 : $partlen;
        $partition[$px] = array_slice($array, $mark, $incr);
        $mark += $incr;
    }

    return $partition;
}

/**
 * Łączy wielowymiarową tablice w jedną tablicę
 */
function array_unchunk(array $array): array
{
    if (count($array)) {
        return call_user_func_array('array_merge', $array);
    }

    return [];
}

/**
 * Pobiera informacje geolokalizacyjne adresu IP
 */
function geoIP(string $ip = null): array
{
    if (!filter_var($ip, FILTER_VALIDATE_IP)) {
        return [];
    }

    $continents = array(
        "AF" => "Africa",
        "AN" => "Antarctica",
        "AS" => "Asia",
        "EU" => "Europe",
        "OC" => "Australia (Oceania)",
        "NA" => "North America",
        "SA" => "South America"
    );

    $ipdat = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));

    return [
        "ip" => $ip,
        "city" => $ipdat->geoplugin_city,
        "state" => $ipdat->geoplugin_regionName,
        "country" => $ipdat->geoplugin_countryName,
        "countryCode" => $ipdat->geoplugin_countryCode,
        "continent" => $continents[strtoupper($ipdat->geoplugin_continentCode)] ?? '',
        "continentCode" => $ipdat->geoplugin_continentCode,
        "userAgent" => $_SERVER['HTTP_USER_AGENT'] ?? '',
    ];
}

/**
 * Tworzy wrapper dla renderowania pliku
 */
function render(string $templateName, array $arguments = []): string
{
    extract($GLOBALS);
    extract($arguments, EXTR_OVERWRITE);

    ob_start();
    require $templateName;

    return ob_get_clean();
}

/**
 * Ustawia kod błędu i renderuje szablon z templates jeżeli istnieje
 */
function renderError(int $code, array $arguments = []): string
{
    http_response_code($code);

    $firstLetter = substr($code, 0, 1);
    $extension = (isset($GLOBALS['request']) and $GLOBALS['request']->extension)
        ? $GLOBALS['request']->extension
        : 'html';

    $files = [
        TEMPLATE_PATH."/errors/{$code}.{$extension}.php",
        TEMPLATE_PATH."/errors/{$firstLetter}xx.{$extension}.php",
        TEMPLATE_PATH."/errors/xxx.{$extension}.php",
    ];

    foreach ($files as $file) {
        if (file_exists($file)) {
            return render($file, $arguments);
        }
    }

    return '';
}

/**
 * Zapisuje zadane dane do pliku w formie łatwego do odczytu pliku PHP
 */
function exportDataToPHPFile(array $data, string $file): void
{
    makeFile($file);

    $date = sqldate();
    $export = var_export($data, true);

    $content = "<?php\n\n/** @generated {$date} */\n\nreturn {$export};";
    file_put_contents($file, $content);
}

/**
 * Wyszukuje wszystkie pliki rekursywnie w katalogu
 */
function globRecursive(string $pattern, int $flags = 0): array
{
    $files = glob($pattern, $flags);
    foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir) {
        $files = array_merge($files, globRecursive($dir.'/'.basename($pattern), $flags));
    }

    return $files;
}

/**
 * Funkcja pobiera tylko pliki źródłowe aplikacji
 */
function getSourceFiles(): array
{
    $webDataPath = realpath(WEB_PATH.'/data');

    return array_filter(globRecursive('*.*'), function ($value) use (&$webDataPath) {
        if (strpos(realpath($value), $webDataPath) !== false) {
            return [];
        }

        return in_array(pathinfo($value, PATHINFO_EXTENSION), [
            'php', 'js', 'css', 'json', 'txt', 'md', 'html'
        ]);
    });
}

/**
 * Zapisuje do bazy danych sumy kontrolne plików
 */
function refreshChecksums(): void
{
    \GC\Storage\Database::getInstance()->transaction(function () {
        \GC\Model\Checksum::delete()
            ->execute();

        foreach (getSourceFiles() as $file) {
            \GC\Model\Checksum::insert([
                'file' => trim($file, '.'),
                'hash' => sha1(file_get_contents($file)),
            ]);
        }
    });
}

/**
 * Tworzy rekursywnie katalogi
 */
function makeDirRecursive(string $dir, int $mode = 0775): void
{
    $path = '';
    $dirs = explode('/', trim($dir, '/ '));

    while (count($dirs)) {
        $folder = array_shift($dirs);
        $path .= $folder.'/';
        if (!is_readable($path) and !is_dir($path)) {
            mkdir($path, $mode);
        }
        chmod($path, $mode);
    }
}

/**
 * Tworzy plik oraz katalogi, jeżeli ich brakuje
 */
function makeFile(string $filepath, int $mode = 0775): void
{
    makeDirRecursive(dirname($filepath));
    if (!file_exists($filepath)) {
        touch($filepath);
    }
    chmod($filepath, $mode);
}

/**
 * Usuwa katalogu oraz pliki i katalogi wewnątrz
 */
function removeDirRecursive(string $dir): void
{
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                $file = $dir.DIRECTORY_SEPARATOR.$object;
                if (filetype($file) == "dir") {
                    removeDirRecursive($file);
                } else {
                    unlink($file);
                }
            }
        }
        reset($objects);
        rmdir($dir);
    }
}

/**
 * Wysyła request w celu zweryfikowania recatchy od Googla
 */
function curlReCaptcha(): array
{
    if (isset($_POST['g-recaptcha-response'])) {
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $curlConfig = array(
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_POSTFIELDS => [
                'secret' => $config['reCaptcha']['secret'],
                'response' => post('g-recaptcha-response'),
                'remoteip' => $_SERVER['REMOTE_ADDR']
            ]
        );

        $curl = curl_init();
        curl_setopt_array($curl, $curlConfig);
        $response = curl_exec($curl);
        if ($response) {
            return json_decode($response, true);
        }
        logger("[CURL] {$url}", [curl_error($curl)]);
    }

    return [
        'success' => false,
    ];
}

/**
 * Tworzy adres miniaturki dla zadanego zdjęcia
 */
function makeThumbnailUri(string $imageUri, int $width, int $height): string
{
    $thumbsUri      = $GLOBALS['config']['thumbnail']['uri'];
    $imageUri       = urldecode($imageUri);
    $size           = "{$width}x{$height}";
    $normalized     = normalize($imageUri);
    $filename       = pathinfo($normalized, PATHINFO_FILENAME);
    $folderUri      = dirname($normalized);
    $extension      = strtolower(pathinfo($imageUri, PATHINFO_EXTENSION));
    $thumbnailUri   = "{$thumbsUri}{$folderUri}/{$filename}/{$size}.{$extension}";

    return $thumbnailUri;
}

/**
 * Zwraca adres do miniaturki zadanego zdjęcia. Tworzy miniaturkę w razie potrzeby
 */
function thumbnail(string $imageUri, int $width, int $height, string $mode = 'outbound'): string
{
    # jeżeli generowanie minaturek jest wyłączone wtedy zwróć adres zdjęcia
    if (!$GLOBALS['config']['thumbnail']['enabled']) {
        return $imageUri;
    }

    # jeżeli adres obrazka jest pusty
    if (empty($imageUri)) {
        return $imageUri;
    }

    $path           = $GLOBALS['config']['thumbnail']['path'];
    $imagePath      = $path.$imageUri;
    $thumbnailUri   = makeThumbnailUri($imageUri, $width, $height);
    $thumnailPath   = $path.$thumbnailUri;

    # jeżeli istnieje miniaturka to zwróć jej adres
    if (is_readable($thumnailPath)) {
        return $thumbnailUri;
    }

    # jeżeli nie istnieje plik zdjęcia to zwróć oryginalny adres
    if (!is_readable($imagePath)) {
        return $imageUri;
    }

    # utwórz katalogi do pliku z miniaturką
    makeDirRecursive(pathinfo($thumnailPath, PATHINFO_DIRNAME));

    # tworzenie miniaturki
    try {
        $imagine = new Imagine\Gd\Imagine();
        $size    = new Imagine\Image\Box($width, $height);
        $imagine
            ->open($imagePath)
            ->thumbnail($size, $mode)
            ->save($thumnailPath, $GLOBALS['config']['thumbnail']['options']);
    } catch (Imagine\Exception\Exception $exception) {
        logException($exception);
    }

    logger("[THUMBNAIL] Generated {$thumbnailUri}");

    # zwróć adres miniaturki
    return $thumbnailUri;
}

/**
 * Odczytuje cache sesyjny o nazwie $name i czasie życia mniejszym niż $ttl
 * wyrażanym w sekundach. Jeżeli trzeba odświeżyć wartość wtedy wywołuje
 * przekazanego $callback i zapisuje rezultat funkcji w cachu
 */
function sessionCache(string $name, int $ttl, callable $callback)
{
    # spróbuj pobrać tablice z sesji
    $pool = getValueByKeys($_SESSION, ['cache', $name], null);

    # jeżeli istnieje skeszowany $pool wtedy zwróć
    if ($pool and $pool['expires'] > time()) {
        logger("[SESSION-CACHE] {$name} was load from cache");

        # zwróć skeszowane dane
        return $_SESSION['cache'][$name]['data'];
    }

    # wywołaj długi callback
    $result = $callback();

    # zapisz w sesji dane, czyli skeszuj
    $_SESSION['cache'][$name] = [
        'data' => $result,
        'expires' => time() + $ttl,
    ];

    logger("[SESSION-CACHE] {$name} was regenerate");

    # zwróć wytworzone dane
    return $result;
}

/**
 * Zwraca język odwiedzającego stronę
 */
function getVisitorLang(): string
{
    if (isset($GLOBALS['request']) and $GLOBALS['request']->lang) {
        return $GLOBALS['request']->lang;
    }

    return $GLOBALS['config']['lang']['visitorDefault'];
}

/**
 * Zwraca adres IP clienta
 */
function getVisitorIP(): string
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']) && GC\Validate::ip($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    }

    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') !== false) {
            $iplist = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            foreach ($iplist as $ip) {
                if (GC\Validate::ip($ip)) {
                    return $ip;
                }
            }
        } elseif (GC\Validate::ip($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
    }

    if (!empty($_SERVER['HTTP_X_FORWARDED']) && GC\Validate::ip($_SERVER['HTTP_X_FORWARDED'])) {
        return $_SERVER['HTTP_X_FORWARDED'];
    }

    if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && GC\Validate::ip($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) {
        return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
    }

    if (!empty($_SERVER['HTTP_FORWARDED_FOR']) && GC\Validate::ip($_SERVER['HTTP_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_FORWARDED_FOR'];
    }

    if (!empty($_SERVER['HTTP_FORWARDED']) && GC\Validate::ip($_SERVER['HTTP_FORWARDED'])) {
        return $_SERVER['HTTP_FORWARDED'];
    }

    return $_SERVER['REMOTE_ADDR'];
}
