<?php

/** Zawiera definicje wszystkich funkcji w aplikacji */

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
 * Pomocnicza dla sprawdzania czy dany element w tabeli $_POST istnieje
 */
function post($name, $default = '')
{
    return isset($_POST[$name]) ? $_POST[$name] : $default;
}

/**
 * Pomocnicza dla sprawdzania czy dany element w tabeli $_SERVER istnieje
 */
function server($name, $default = '')
{
    return isset($_SERVER[$name]) ? $_SERVER[$name] : $default;
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
        GC\Data::get('logger')->curl($url.' '.curl_error($curl));
    }

    return [
        'success' => false,
    ];
}

function humanFilesize($bytes, $decimals = 3)
{
    $size = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
    $factor = floor((strlen($bytes) - 1) / 3);

    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . $size[$factor];
}

function normalize($unformatted)
{
    $url = mb_strtolower(trim($unformatted));

    $search = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì',
        'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü',
        'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì',
        'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý',
        'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č',
        'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ',
        'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī',
        'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ',
        'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō',
        'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś',
        'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū',
        'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź',
        'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ',
        'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ',
        'ǽ', 'Ǿ', 'ǿ');

    $replace = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E',
        'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U',
        'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e',
        'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u',
        'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C',
        'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e',
        'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I',
        'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l',
        'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n',
        'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S',
        's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u',
        'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y',
        'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I',
        'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a',
        'AE', 'ae', 'O', 'o');

    $url = str_replace($search, $replace, $url);

    //replace common characters
    $search = array('&', '£', '$');
    $url = str_replace($search, '', $url);

    // remove - for spaces and union characters
    $find = array(' ', '&', '\r\n', '\n', '+', ',', '//');
    $url = str_replace($find, '-', $url);

    //delete and replace rest of special chars
    $find = array('/[^a-z0-9\._\-<>\/]/', '/[\-]+/', '/<[^>]*>/');
    $replace = array('', '-', '');

    $url = preg_replace($find, $replace, $url);

    $preString = $url;
    while (($url = str_replace('..', '.', $url)) != $preString)
    {
        $preString = $url;
    }

    return $url;
}

function redirect($location, $code = 303)
{
    $url = GC\Url::make($location);
    absoluteRedirect($url, $code);
}

function absoluteRedirect($location, $code = 303)
{
    http_response_code($code);
    header("Location: {$location}");

    GC\Data::get('logger')->redirect(
        sprintf("%s %s :: Time: %ss :: Memory: %sMiB",
            $code,
            $location,
            microtime(true) - START_TIME,
            memory_get_peak_usage(true) / 1048576
        )
    );

    die();
}
