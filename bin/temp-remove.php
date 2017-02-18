<?php

/** Dodaje konto administratora do bazy danych **/

require_once __DIR__.'/_import.php';

echo PHP_EOL;
echo "Removing temporary files...".PHP_EOL;

$removeDirRecursive = function ($dir) use (&$removeDirRecursive)
{
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                $file = $dir.DIRECTORY_SEPARATOR.$object;
                if (filetype($file) == "dir") {
                    removeDirRecursive($file);
                } else {
                    echo 'Deleting file: '.$file.PHP_EOL;
                    @unlink($file);
                }
            }
        }
        reset($objects);
        echo 'Deleting dir: '.$dir.PHP_EOL;
        @rmdir($dir);
    }
};

$removeDirRecursive(TEMP_PATH);
$path = $config['thumbnail']['thumbsPath'].$config['thumbnail']['thumbsUri'];
$removeDirRecursive($path);

echo "Temporary files and dirs was deleted.".PHP_EOL;
