<?php

/* Zawiera definicje wszystkich funkcji w aplikacji */

/**
 * Zabezpiecza wyjście przed XSS zamieniając znaki specjalne na encje
 */
function escape($string)
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
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
function def(array $array, $key, $default = null)
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
 * Zwraca losowy sha1
 */
function randomSha1()
{
    return sha1(time().mt_rand());
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
 * Sprawdza czy zadany string jest SHA1
 */
function isSha1($string)
{
    return (bool) preg_match('/^[0-9a-f]{40}$/i', $string);
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
 * Pomocnicza funkcja do generowania linku htmla
 */
function makeLink($href, $name)
{
    return sprintf(' <a href="%s">%s</a> ', url($href), escape($name));
}

/**
 * Sprawdza czy wysłane żądanie jest POSTem
 */
function wasSentPost()
{
    return $_SERVER['REQUEST_METHOD'] === 'POST';
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

    if (isset($_SESSION['lang']['user'])) {
        return $_SESSION['lang']['user'];
    }

    if (isset($_SESSION['lang']['staff'])) {
        return $_SESSION['lang']['staff'];
    }

    return getConfig()['lang']['clientDefault'];
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
    $relativePath = str_replace($_SERVER['DOCUMENT_ROOT'], '', $realpath);
    $relativePath = str_replace('\\', '/', $relativePath);

    return $relativePath;
}

/**
 * Przekierowuje na zadany adres
 */
function redirect($location, $code = 303)
{
    http_response_code($code);
    header("Location: ".url($location));

    Logger::redirect(sprintf("%s %s :: ExecutionTime: %s",
        $code,
        $location,
        (microtime(true) - START_TIME)
    ));

    die();
}

/**
 * Przekierowuje na adres z ktorego nastąpiło wejście lub na podany w parametrze
 */
function redirectToRefererOrDefault($defaultLocation, $code = 303)
{
    if (isset($_SERVER['HTTP_REFERER'])) {
        $referer = $_SERVER['HTTP_REFERER'];
        $referer = parse_url($referer, PHP_URL_PATH);
        redirect($referer, $code);
    }

    redirect($defaultLocation, $code);
}

/**
 * Tłumaczy wprowadzony ciąg na inny znaleziony w plikach tłumaczeń
 */
function trans($text, array $params = [])
{
    return Translator::getInstance()->translate($text, $params);
}

/**
 * Pomocnicza, tworzy wrapper dla renderowania pliku w akcjach
 */
function view($templateName, array $arguments = [])
{
    global $config;

    extract($arguments, EXTR_OVERWRITE);

    ob_start();
    require ACTIONS_PATH.$templateName;

    return ob_get_clean();
}

/**
 * Pomocnicza, tworzy wrapper dla renderowania pliku szablonu
 */
function templateView($templateName, array $arguments = [])
{
    global $config;

    extract($arguments, EXTR_OVERWRITE);

    ob_start();
    require TEMPLATE_PATH.$templateName;

    return ob_get_clean();
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
    $token = randomSha1();
    $imageUrl64 = base64_encode($imageUrl);
    $_SESSION['generateThumb'][$imageUrl] = $token;

    return rootUrl("/thumb/$imageUrl64/$token");
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
 * @param string $email The email address
 * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
 * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
 * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
 * @return String containing either just a URL or a complete image tag
 * @source https://gravatar.com/site/implement/images/php/
 */
function getGravatar($email, $s = 80, $d = 'mm', $r = 'g')
{
	$url = 'https://www.gravatar.com/avatar/';
	$url .= md5( strtolower( trim( $email ) ) );
	$url .= "?s=$s&d=$d&r=$r";

	return $url;
}

/**
 * Generuje losowy kolor CSS
 */
function randomColor()
{
    return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
}

/**
 * Generate a random string, using a cryptographically secure
 *
 * @param int $length      How many characters do we want?
 * @param string $keyspace A string of all possible characters to select from
 * @return string
 */
function randomPassword($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
{
    $password = '';
    $max = strlen($keyspace) - 1;
    for ($i = 0; $i < $length; ++$i) {
        $password .= $keyspace[mt_rand(0, $max)];
    }

    return $password;
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
