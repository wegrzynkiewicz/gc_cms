<?php

namespace GC;

/**
 * Zawiera przydatne statyczne metody do obsługi plików i katalogów
 */
class Disc
{
    /**
     * Zapisuje zadane dane do pliku w formie łatwego do odczytu pliku PHP
     */
    public static function exportDataToPHPFile($data, $file)
    {
        if (!is_writable($file)) {
            return;
        }

        static::makeDirRecursive(dirname($file));

        $content = "<?php\n\nreturn ".var_export($data, true).';';
        file_put_contents($file, $content);
    }

    /**
     * Wyszukuje wszystkie pliki rekursywnie w katalogu
     */
    public static function globRecursive($pattern, $flags = 0)
    {
        $files = glob($pattern, $flags);
        foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir) {
            $files = array_merge($files, static::globRecursive($dir.'/'.basename($pattern), $flags));
        }

        return $files;
    }

    /**
     * Tworzy rekursywnie katalogi
     */
    public static function makeDirRecursive($dir, $mode = 0775)
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
    public static function makeFile($filepath, $mode = 0775)
    {
        static::makeDirRecursive(dirname($filepath));
        if (!file_exists($filepath)) {
            touch($filepath);
        }
        chmod($filepath, $mode);
    }

    /**
     * Usuwa katalogu oraz pliki i katalogi wewnątrz
     */
    public static function removeDirRecursive($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    $file = $dir.DIRECTORY_SEPARATOR.$object;
                    if (filetype($file) == "dir") {
                        static::removeDirRecursive($file);
                    } else {
                        unlink($file);
                    }
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }
}
