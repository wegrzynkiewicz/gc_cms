<?php

/* Zawiera definicje wszystkich funkcji w aplikacji */

/**
 * Zabezpiecza wyjście przed XSS zamieniając znaki specjalne na encje
 */
function e($string)
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

function purifyHtml($dirtyHtml)
{
    $config = HTMLPurifier_Config::createDefault();
    $purifier = new HTMLPurifier($config);
    $cleanHtml = $purifier->purify($dirtyHtml);

    return $cleanHtml;
}

/**
 * Pomocnicza dla efektywniejszego drukowania warunku
 */
function selected($condition)
{
    return $condition ? ' selected="selected" ' : '';
}

/**
 * Pomocnicza dla efektywniejszego drukowania warunku
 */
function checked($condition)
{
    return $condition ? ' checked="checked" ' : '';
}

/**
 * Zwraca odpowiedni $key z tablicy $array, jeżeli istnieje i jest niepusty, w przeciwnym wypadku $default
 */
function def(array $array, $key, $default = '')
{
    return isset($array[$key]) ? $array[$key] : $default;
}

/**
 * Zwraca spreparowaną date dla MySQL
 */
function sqldate($time = null)
{
    if ($time === null) {
        $time = time();
    }

    return date('Y-m-d H:i:s', $time);
}

/**
 * Wyszukuje wszystkie pliki rekursywnie w katalogu
 */
function rglob($pattern, $flags = 0)
{
    $files = glob($pattern, $flags);
    foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir) {
        $files = array_merge($files, rglob($dir.'/'.basename($pattern), $flags));
    }

    return $files;
}

/**
 * Ustawia mime type, jeżeli nagłówek nie został jeszcze wysłany
 */
function setHeaderMimeType($mimeType)
{
    if (!headers_sent()) {
        header("Content-Type: $mimeType; charset=utf-8");
    }
}

/**
 *
 */
function shiftSegmentAsInteger()
{
    global $_SEGMENTS;

    if (count($_SEGMENTS) and intval($_SEGMENTS[0])) {
        return intval(array_shift($_SEGMENTS));
    }

    return 0;
}

/**
 * Pomocnicza dla sprawdzania czy dany element w tabeli $_POST istnieje
 */
function inputValue($postName, $default = '')
{
    if (isset($_POST[$postName])) {
        return $_POST[$postName];
    }

    return $default;
}

/**
 * Zwraca obiekt config; przydatne w miejscach niedostępnych
 */
function getConfig()
{
    global $config;

    return $config;
}

/**
 * Zwraca kod jezyka, aktualnie uzywanego przez klienta
 */
function getClientLang()
{
    if (isset($_SESSION['lang']['routing'])) {
        return $_SESSION['lang']['routing'];
    }

    if (isset($_SESSION['lang']['staff'])) {
        return $_SESSION['lang']['staff'];
    }

    return getConfig()['lang']['clientDefault'];
}

function transDateTime($dateTime)
{
    return $dateTime;
}

/**
 * Ustawia krótkie wiadomości, które są wyświetlane po wykonaniu jakiejś akcji, np coś zostało usunięte
 */
function setNotice($message, $theme = 'success')
{
    $_SESSION['notice']['message'] = $message;
    $_SESSION['notice']['theme'] = $theme;
}

/**
 * Usuwa sieroty z tekstu bez html!
 */
function removeOrphan($text)
{
    return preg_replace('~ ([aiowzu]) ~', ' $1&nbsp;', $text);
}

/**
 * Zamienia ścieżkę absolutną na ścieżkę relatywną na podtawie katalogu głównego
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
 * Tłumaczy wprowadzony ciąg na inny znaleziony w plikach tłumaczeń
 */
function trans($text, array $params = [])
{
    return e(GC\Translator::getInstance()->translate($text, $params));
}

/**
 * Tworzy plik oraz katalogi, jeżeli ich brakuje
 */
function createFile($filename, $mode = 0775)
{
    rmkdir(dirname($filename));
    if (!file_exists($filename)) {
        touch($filename);
    }
    chmod($filename, $mode);
}

/**
 * Usuwa katalogu oraz pliki i katalogi wewnątrz
 */
function rrmdir($dir)
{
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                $file = $dir.DIRECTORY_SEPARATOR.$object;
                if (filetype($file) == "dir") {
                    rrmdir($file);
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
 * Tworzy rekursywnie katalogi z odpowiednimi katalogami
 */
function rmkdir($dir, $mode = 0775)
{
    $path = '';
    $dirs = explode('/', trim($dir, '/ '));

    while (count($dirs)) {
        $folder = array_shift($dirs);
        $path .= $folder.'/';
        @mkdir($path, $mode);
        @chmod($path, $mode);
    }
}

/**
 * Zapisuje zadane dane do pliku w formie łatwego do odczytu pliku PHP
 */
function exportDataToPHPFile($data, $file)
{
    if (!is_writable($file)) {
        return;
    }

    rmkdir(dirname($cacheFile));

    $content = "<?php\n\nreturn ".var_export($data, true);

    return file_put_contents($file, $content);
}

/**
 *
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
function array_partition(array $list, $p)
{
    $listlen = count($list);
    $partlen = floor($listlen / $p);
    $partrem = $listlen % $p;
    $partition = array();
    $mark = 0;
    for ($px = 0; $px < $p; $px++) {
        $incr = ($px < $partrem) ? $partlen + 1 : $partlen;
        $partition[$px] = array_slice($list, $mark, $incr);
        $mark += $incr;
    }

    return $partition;
}

/**
 * Łączy macierz w jedną tablicę
 */
function array_unchunk($array)
{
    return call_user_func_array('array_merge', $array);
}

/**
 * Zapisuje w sesji adres miniaturki do wygenerowania
 */
function generateThumb($imageUrl)
{
    $token = GC\Password::random(40);
    $imageUrl64 = base64_encode($imageUrl);
    $_SESSION['generateThumb'][$imageUrl] = $token;

    return GC\Url::root("/thumb/$imageUrl64/$token");
}

/**
 * Zwraca tablicę właściwośćCSS => wartośćCSS
 */
function parseCSS($css)
{
    $attrs = explode(";", $css);

    foreach ($attrs as $attr) {
        if (strlen(trim($attr)) > 0) {
            $kv = explode(":", trim($attr));
            $parsed[trim($kv[0])] = trim($kv[1]);
        }
    }

    return $parsed;
}

/**
 * Generuje css na podstawie tablicy właściwośćCSS => wartośćCSS
 */
function outputCSS($parsed)
{
    $parts = array();
    foreach ($parsed as $option => $value) {
        $parts[] = $option.':'.$value;
    }

    return implode(';', $parts);
}

/**
 * Get either a Gravatar URL or complete image tag for a specified email address.
 *
 * @param  string $email The email address
 * @param  string $s     Size in pixels, defaults to 80px [ 1 - 2048 ]
 * @param  string $d     Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
 * @param  string $r     Maximum rating (inclusive) [ g | pg | r | x ]
 * @return String containing either just a URL or a complete image tag
 * @source https://gravatar.com/site/implement/images/php/
 */
function getGravatar($email, $s = 80, $d = 'mm', $r = 'g')
{
    return sprintf(
        'https://www.gravatar.com/avatar/%s?s=%s&d=%s&r=%s',
        md5(strtolower(trim($email))), $s, $d, $r
    );
}

/**
 * Generuje losowy kolor CSS
 */
function randomColor()
{
    return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
}

function getXMLTag($tag, $content = null, $attributes = array())
{
    $attrs = array();
    foreach ($attributes as $name => $value) {
        $attrs[] = "$name=\"$value\"";
    }
    $attributes = join(' ', $attrs);

    $content = (trim($content) == "") ? "/" : ">$content</$tag";
    $return = "<$tag $attributes $content>";

    return $return;
}

function makeThumbsCallback($matches)
{
    $content = $matches[0];

    $element = simplexml_load_string($content);
    $attributes = current($element->attributes());

    $src = trim(urldecode($attributes['src']), '/ ');
    list($ow, $oh) = @getimagesize($src);
    if ($ow == 0 && $oh == 0) {
        return $content;
    }

    $style = $attributes['style'];
    $css = parseCSS($style);
    $width = trim($css['width'], 'px');
    $height = trim($css['height'], 'px');
    if ($width == $ow && $height == $oh) {
        return $content;
    }

    $thumb = Thumb::make($src, $width, $height);
    list($x, $y) = getimagesize($thumb);

    $css['width'] = $x.'px';
    $css['height'] = $y.'px';
    $style = outputCSS($css);

    $attributes['src'] = '/'.$thumb;
    $attributes['style'] = $style;

    return getXMLTag('img', '', $attributes);
}

/**
 * Wysyła request w celu zweryfikowania recatchy
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
                'secret' => getConfig()['reCaptcha']['secret'],
                'response' => $_POST['g-recaptcha-response'],
                'remoteip' => $_SERVER['REMOTE_ADDR']
            ]
        );

        $curl = curl_init();
        curl_setopt_array($curl, $curlConfig);
        $response = curl_exec($curl);
        if ($response) {
            return json_decode($response, true);
        }
        GC\Logger::curl($url.' '.curl_error($curl));
    }

    return [
        'success' => false,
    ];
}

function validateIP($string)
{
    return filter_var($string, FILTER_VALIDATE_IP);
}

function infoIP($ip = null)
{
    if (validateIP($ip) === false) {
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

    $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));

    return [
        "ip" => $ip,
        "city" => @$ipdat->geoplugin_city,
        "state" => @$ipdat->geoplugin_regionName,
        "country" => @$ipdat->geoplugin_countryName,
        "countryCode" => @$ipdat->geoplugin_countryCode,
        "continent" => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
        "continentCode" => @$ipdat->geoplugin_continentCode,
        "userAgent" => def($_SERVER, 'HTTP_USER_AGENT', ''),
    ];
}

function getIP()
{
    // check for shared internet/ISP IP
    if (!empty($_SERVER['HTTP_CLIENT_IP']) && validateIP($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    }

    // check for IPs passing through proxies
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // check if multiple ips exist in var
        if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') !== false) {
            $iplist = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            foreach ($iplist as $ip) {
                if (validateIP($ip)) {
                    return $ip;
                }
            }
        } else {
            if (validateIP($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
        }
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED']) && validateIP($_SERVER['HTTP_X_FORWARDED'])) {
        return $_SERVER['HTTP_X_FORWARDED'];
    }
    if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && validateIP($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) {
        return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
    }
    if (!empty($_SERVER['HTTP_FORWARDED_FOR']) && validateIP($_SERVER['HTTP_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_FORWARDED_FOR'];
    }
    if (!empty($_SERVER['HTTP_FORWARDED']) && validateIP($_SERVER['HTTP_FORWARDED'])) {
        return $_SERVER['HTTP_FORWARDED'];
    }

    // return unreliable ip since all else failed
    return $_SERVER['REMOTE_ADDR'];
}
