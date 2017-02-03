<?php

namespace GC\Storage;

use GC\Logger;
use GC\Password;
use GC\Data;
use GC\Model\Dump;
use Ifsnop\Mysqldump as IMysqldump;

class Backup
{
    public static $delimiter = ';';

    public static function make($name)
    {
        $dumpPath = $GLOBALS['config']['dump']['path'];
        $time = time();
        $creation_datetime = date('Y-m-d-His', $time);
        $filepath = "{$dumpPath}/dump-{$creation_datetime}.sql.gz";
        static::export($filepath);

        Dump::insert([
            'name' => $name,
            'creation_datetime' => date('Y-m-d H:i:s', $time),
            'path' => relativePath($filepath),
            'size' => filesize($filepath),
        ]);
    }

    public static function export($filename)
    {
        makeFile($filename);

        $dumpConfig = $GLOBALS['config']['dump'];
        $dbConfig = $GLOBALS['config']['database'];

        $GLOBALS['logger']->info('[DUMP-EXPORT] '.relativePath($filename));

        $dump = new IMysqldump\Mysqldump(
            $dbConfig['dns'],
            $dbConfig['username'],
            $dbConfig['password'],
            $dumpConfig['settings']
        );

        $dump->start($filename);
    }

    public static function import($filepath)
    {
        $file = $filepath;

        $GLOBALS['logger']->info("[DUMP-IMPORT] {$filename}");

        if (pathinfo($filepath, \PATHINFO_EXTENSION) === 'gz') {

            $path = $GLOBALS['config']['dump']['tmpPath'];
            $file = $path.'/'.basename($filepath, '.gz');
            static::decompress($filepath, $file);
            static::openAndExecute($file);
            unlink($file);

            return;
        }

        static::openAndExecute($file);
    }

    public static function openAndExecute($file)
    {
        $file = fopen($file, 'r');
        if (is_resource($file) === false) {
            return;
        }

        $query = array();

        while (feof($file) === false) {
            $query[] = fgets($file);

            if (preg_match('~' . preg_quote(static::$delimiter, '~') . '\s*$~iS', end($query)) === 1) {
                $query = trim(implode('', $query));

                Database::getInstance()->pdo->exec($query);
            }

            if (is_string($query) === true) {
                $query = array();
            }
        }

        fclose($file);
    }

    protected static function decompress($filepath, $destination)
    {
        if (is_file($filepath) === false) {
            return;
        }

        makeFile($destination);

        $file = gzopen($filepath, 'rb');
        $outFile = fopen($destination, 'wb');

        while (!gzeof($file)) {
            fwrite($outFile, gzread($file, 4096));
        }

        fclose($outFile);
        gzclose($file);
    }
}
