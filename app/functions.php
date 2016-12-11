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
 * Zapisuje wiadomości do pliku logów
 */
function logger($message, array $params = [], $file = null, $line = null)
{
    global $config;
    $enabled = $config['logger']['enabled'];
    $folder = $config['logger']['folder'];
    $wasExecuted = isset($config['logger']['wasExecuted']);

    if (!$enabled) {
        return;
    }

    $filename = sprintf("%s/%s.log", $folder, date('Y-m-d'));

    if (!is_readable($filename)) {
        rmkdir(dirname($filename));
    }

    if (!$wasExecuted) {
        $config['logger']['wasExecuted'] = true;
        $content = "=================\n";
        file_put_contents($filename, $content, FILE_APPEND);
    }

    $backtrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT);
    $execution = array_shift($backtrace);

    $content = sprintf("[%s] %s :: %s :: %s:%s\n",
        microDateTime()->format('H:i:s.u'),
        $message,
        json_encode($params),
        relativePath($file === null ? $execution['file'] : $file),
        $line === null ? $execution['line'] : $line
    );

    file_put_contents($filename, $content, FILE_APPEND);
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
 * Tworzy i zapisuje miniaturkę dla pliku; zwraca ścieżkę miniaturki
 */
function thumb($imageUrl, $width, $height)
{
    global $config;

    if (!$config['thumb']['enabled']) {
        return rootUrl($imageUrl);
    }

    $thumbsUrl      = $config['thumb']['thumbsUrl'];
    $thumbsPath     = $config['thumb']['thumbsPath'];
    $options        = $config['thumb']['options'];
    $imageUrl       = urldecode($imageUrl);
    $extension      = strtolower(pathinfo($imageUrl, PATHINFO_EXTENSION));
    if (!isset($options[$extension])) {
        return rootUrl($imageUrl);
    }
    $params         = $options[$extension];
    $prefix         = '_'.$width.'x'.$height;
    $imagePath      = Normalizer::normalize($imageUrl);
    $filename       = pathinfo($imagePath, PATHINFO_FILENAME);
    $folder         = dirname($imagePath);
    $thumbUrl       = "{$thumbsUrl}{$folder}/{$filename}{$prefix}.{$extension}";
    $destFilePath   = "{$thumbsPath}{$folder}/{$filename}{$prefix}.{$extension}";
    $sourceFilePath = "./{$imagePath}";

    if (!is_readable($destFilePath)) {

        if (!is_readable($sourceFilePath)) {
            return $sourceFilePath;
        }

        $pathDir = pathinfo($destFilePath, PATHINFO_DIRNAME);
        rmkdir($pathDir);

        $loader = $params['loader'];
        $sourceImage = $loader($sourceFilePath);
        $sourceWidth = imagesx($sourceImage);
        $sourceHeight = imagesy($sourceImage);

        $distWidth = $width;
        $distHeight = $height;

        $ratio = $sourceWidth / $sourceHeight;

        if ($distWidth / $distHeight > $ratio) {
            $distWidth = $distHeight * $ratio;
        } else {
            $distHeight = $distWidth / $ratio;
        }

        $thumbImage = imagecreatetruecolor($distWidth, $distHeight);

        if ($params['transparent'] === true) {
            $backgroundColor = imagecolorallocate($thumbImage, 0, 0, 0);
            imagecolortransparent($thumbImage, $backgroundColor);
            imagealphablending($thumbImage, false);
            imagesavealpha($thumbImage, true);
        }

        imagecopyresampled($thumbImage, $sourceImage, 0, 0, 0, 0, $distWidth,
                           $distHeight, $sourceWidth, $sourceHeight);

        $saver = $params['saver'];
        $saver($thumbImage, $destFilePath, $params['quality']);
        chmod($destFilePath, 0775);
    }

    return rootUrl($thumbUrl);
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

    $thumb = thumb($src, $width, $height);
    list($x, $y) = getimagesize($thumb);

    $css['width'] = $x.'px';
    $css['height'] = $y.'px';
    $style = outputCSS($css);

    $attributes['src'] = '/'.$thumb;
    $attributes['style'] = $style;

    return getXMLTag('img', '', $attributes);
}
