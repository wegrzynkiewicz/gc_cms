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
 * Ustawia mime type, jeżeli nagłówek nie został jeszcze wysłany
 */
function setHeaderMimeType($mimeType)
{
    if (!headers_sent()) {
        header("Content-Type: $mimeType; charset=utf-8");
    }
}

/**
 * Sprawdza czy zadany string jest SHA1
 */
function isSha1($string)
{
    return (bool) preg_match('/^[0-9a-f]{40}$/i', $string);
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
 * Zwraca obiekt DataTime z mikrosekundami
 */
function microDateTime()
{
    $time = microtime(true);
    $micro = sprintf("%06d", ($time - floor($time)) * 1000000);

    return new DateTime(date('Y-m-d H:i:s.'.$micro, $time));
}

/**
 * Sprawdza czy aktualnie zalogowany użytkownik ma uprawnienia do wykonania zadanych akcji
 */
function checkPermissions(array $permissions = [])
{
    global $userModel;

    if (!isset($_SESSION['admin']) or !isset($_SESSION['admin']['user'])) {
        unset($_SESSION['admin']);
        redirect('/admin/login');
    }

    $user = UserModel::selectByPrimaryId($_SESSION['admin']['user']['user_id']);

    if (!$user) {
        unset($_SESSION['admin']);
        redirect('/admin/login');
    }

    logger(sprintf("[GRANT] %s <%s>",
        $_SESSION['admin']['user']['name'],
        $_SESSION['admin']['user']['email']
    ), $permissions);
}

/**
 * Przekierowuje na zadany adres
 */
function redirect($location, $code = 303)
{
    http_response_code($code);
    header("Location: ".url($location));

    logger(sprintf("[REDIRECT] %s %s :: ExecutionTime: %s",
        $code,
        $location,
        (microtime(true) - START_TIME)
    ));

    die();
}

/**
 * Tłumaczy wprowadzony ciąg na inny znaleziony w plikach tłumaczeń
 */
function trans($string)
{
    return $string;
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
 * Na podstawie węzła nawigacji drukuje link do strony na którą kieruje
 */
function startlinkAttributesFromMenuNode($node, $extend = "")
{
    $id = sprintf('id="navNode_%s" %s', $node['node_id'], $extend);

    if ($node['type'] === 'empty') {
        return sprintf('<div %s>', $id);
    }

    $target = sprintf('target="%s"', $node['target']);

    if ($node['type'] === 'external') {
        return sprintf('<a %s href="%s" %s> ', $id, $node['destination'], $target);
    }
}

/**
 * Drukuje HTMLowy tag zamknięcia; używana z startlinkAttributesFromMenuNode
 */
function endlinkAttributesFromMenuNode($node)
{
    return $node['type'] === 'empty' ? '</div>' : '</a>';
}

/**
 * Tworzy plik oraz katalogi, jeżeli ich brakuje
 */
function createFile($filename, $mode = 0775)
{
    rmkdir($filename);
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
 * Tworzy i zapisuje miniaturkę dla pliku; zwraca ścieżkę miniaturki
 */
function thumb($filePath, $width, $height)
{
    $phThumbs = 'cache/thumbs';

    $extensionConfigs = array(
        'jpg' => array(
            'loader' => 'imagecreatefromjpeg',
            'saver' => 'imagejpeg',
            'mime' => 'image/jpeg',
            'transparent' => false,
            'quality' => 90,
        ),
        'png' => array(
            'loader' => 'imagecreatefrompng',
            'saver' => 'imagepng',
            'mime' => 'image/png',
            'transparent' => true,
            'quality' => 9,
        ),
    );

    $filePath = urldecode(trim($filePath, '/ '));

    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
    if (!isset($extensionConfigs[$extension])) {
        return $filePath;
    }
    $extensionParams = $extensionConfigs[$extension];

    $prefix = '_'.$width.'x'.$height;
    $filePath = normalizeFilename($filePath);
    $dir = trim(dirname($filePath), '/');
    $filename = pathinfo($filePath, PATHINFO_FILENAME);

    $destFilePath = $phThumbs.'/'.$dir.'/'.$filename.$prefix.'.'.$extension;

    if (!is_readable($destFilePath)) {
        $sourceFile = $filePath;
        if (!is_readable($sourceFile)) {
            return $filePath;
        }

        $pathDir = pathinfo($destFilePath, PATHINFO_DIRNAME);
        rmkdir($pathDir);

        $loader = $extensionParams['loader'];
        $sourceImage = $loader($sourceFile);
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

        if ($extensionParams['transparent'] === true) {
            $backgroundColor = imagecolorallocate($thumbImage, 0, 0, 0);
            imagecolortransparent($thumbImage, $backgroundColor);
            imagealphablending($thumbImage, false);
            imagesavealpha($thumbImage, true);
        }

        imagecopyresampled($thumbImage, $sourceImage, 0, 0, 0, 0, $distWidth,
                           $distHeight, $sourceWidth, $sourceHeight);

        $saver = $extensionParams['saver'];
        $saver($thumbImage, $destFilePath, $extensionParams['quality']);
        chmod($destFilePath, 0775);
    }

    return $destFilePath;
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
