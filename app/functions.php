<?php

/** Zawiera definicje wszyskich funkcji */

/**
 * Zabezpiecza wyjście przed XSS zamieniając znaki specjalne na encje
 */
function e($string)
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Służy do debugowania, exportuje wynik print_r() do pliku logu
 */
function dd($mixed = null)
{
    # pobiera informacje o pliku w którym wywoływana jest funkcja dd()
    $backtrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT);
    $execution = array_shift($backtrace);

    $GLOBALS['logger']->info(sprintf('[DUMP] %s:%s - %s %s',
        $execution['file'],
        $execution['line'],
        gettype($mixed),
        print_r($mixed, true)
    ));
}

function purifyHtml($dirtyHtml)
{
    $config = HTMLPurifier_Config::createDefault();
    $purifier = new HTMLPurifier($config);
    $cleanHtml = $purifier->purify($dirtyHtml);

    return $cleanHtml;
}

/**
 * Służy do prostrzego drukowania warunku
 */
function selected($condition)
{
    return $condition ? ' selected="selected" ' : '';
}

/**
 * Służy do prostrzego drukowania warunku
 */
function checked($condition)
{
    return $condition ? ' checked="checked" ' : '';
}

/**
 * Zwraca odpowiedni $key z tablicy $array, jeżeli istnieje i jest niepusty, w przeciwnym wypadku $default
 * Pomocna w przypadku gdy nie jesteśmy pewni czy istnieje klucz w tablicy.
 * Dla większej ilości kluczy użyj funkcji getValueByKeys
 */
function def(array $array, $key, $default = '')
{
    return isset($array[$key]) ? $array[$key] : $default;
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
 * Pomocna do sprawdzania czy dany element istnieje w tabeli $_SERVER
 */
function server($name, $default = '')
{
    return isset($_SERVER[$name]) ? $_SERVER[$name] : $default;
}

/**
 * Pomocna do sprawdzania czy dany element istnieje w tabeli $_POST
 */
function post($name, $default = '')
{
    return isset($_POST[$name]) ? $_POST[$name] : $default;
}

/**
 * Zwraca spreparowaną date dla MySQL. Można podać czas w zmiennej $timestamp
 */
function sqldate($timestamp = null)
{
    if ($timestamp === null) {
        $timestamp = time();
    }

    return date('Y-m-d H:i:s', $timestamp);
}

/**
 * Zwraca obiekt DataTime z ustawionymi mikrosekundami
 */
function getMicroDateTime()
{
    $time = microtime(true);
    $micro = sprintf("%06d", ($time - floor($time)) * 1000000);

    return new DateTime(date('Y-m-d H:i:s.'.$micro, $time));
}

/**
 * Ustawia krótkie wiadomości, które są wyświetlane po wykonaniu jakiejś akcji, np coś zostało usunięte.
 * $message należy przetłumaczyć samodzielnie. W rzeczywistości dodaje tylko dane do zmiennej sesyjnej.
 */
function setNotice($message, $theme = 'success')
{
    $_SESSION['notice'] = [
        'message' => $message,
        'theme' => $theme,
    ];
}

/**
 * Usuwa sieroty z tekstu
 */
function removeOrphan($text)
{
    return preg_replace('~ ([aiowzu]) ~', ' $1&nbsp;', $text);
}

/**
 * Zamienia ścieżkę absolutną na ścieżkę relatywną na podstawie katalogu głównego
 */
function relativePath($absolutePath)
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
function randomColor()
{
    return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
}

/**
 * Formatuje rozmiar w bajtach, np. 5.42MB
 */
function humanFilesize($bytes, $decimals = 3)
{
    static $size = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
    $factor = floor((strlen($bytes) - 1) / 3);

    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . $size[$factor];
}

/**
 * Zamienia wszystkie specialne znaki na ich odpowiedniki. Oczyszcza tekst
 */
function normalize($unformattedString)
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
        # cyfr, liter, kropki, myślnika, podkreślnika i slasha
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
 * Funkcja przekierowuje na adres obowiązujący wewnątrz aplikacji
 */
function redirect($location, $code = 303)
{
    $path = $GLOBALS['uri']->make($location);
    absoluteRedirect($path, $code);
}

/**
 * Funkcja przekierowuje na zewnętrzny adres. Ustawia nagłówki i kod odpowiedzi
 */
function absoluteRedirect($location, $code = 303)
{
    http_response_code($code);
    header("Location: {$location}");

    $GLOBALS['logger']->info(
        sprintf("[REDIRECT] %s %s :: Time: %ss :: Memory: %sMiB",
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
function array_rebuild(array $array, $callback)
{
   $results = [];
   foreach ($array as $key => $value) {
       $results[$key] = $callback($value);
   }

   return $results;
}

/**
 * Dzieli tablice na $p równych tablic
 */
function array_partition(array $array, $p)
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
function array_unchunk($array)
{
   return call_user_func_array('array_merge', $array);
}

/**
 * Pobiera informacje geolokalizacyjne adresu IP
 */
function geoIP($ip = null)
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
        "continent" => def($continents, strtoupper($ipdat->geoplugin_continentCode)),
        "continentCode" => $ipdat->geoplugin_continentCode,
        "userAgent" => server('HTTP_USER_AGENT', ''),
    ];
}

/**
 * Tworzy wrapper dla renderowania pliku
 */
function render($templateName, array $arguments = [])
{
    extract($GLOBALS);
    extract($arguments, EXTR_OVERWRITE);

    ob_start();
    require $templateName;

    return ob_get_clean();
}

/**
 * Zapisuje zadane dane do pliku w formie łatwego do odczytu pliku PHP
 */
function exportDataToPHPFile($data, $file)
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
function globRecursive($pattern, $flags = 0)
{
    $files = glob($pattern, $flags);
    foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir) {
        $files = array_merge($files, globRecursive($dir.'/'.basename($pattern), $flags));
    }

    return $files;
}

/**
 * Tworzy rekursywnie katalogi
 */
function makeDirRecursive($dir, $mode = 0775)
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
function makeFile($filepath, $mode = 0775)
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
function removeDirRecursive($dir)
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
function curlReCaptcha()
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
        $GLOBALS['logger']->info("[CURL] {$url}", [curl_error($curl)]);
    }

    return [
        'success' => false,
    ];
}
