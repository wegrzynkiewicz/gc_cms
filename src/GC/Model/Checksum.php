<?php

declare(strict_types=1);

namespace GC\Model;

use GC\Storage\Database;
use GC\Storage\AbstractModel;

class Checksum extends AbstractModel
{
    public static $table = '::checksums';
    public static $primary = 'file';

    public static function refreshChecksums()
    {
        Database::getInstance()->transaction(function () {
            static::delete()
                ->execute();

            foreach (getSourceFiles() as $file) {
                static::insert([
                    'file' => trim($file, '.'),
                    'hash' => sha1(file_get_contents($file)),
                ]);
            }
        });
    }
}
