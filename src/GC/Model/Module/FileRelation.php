<?php

declare(strict_types=1);

namespace GC\Model\Module;

use GC\Storage\AbstractModel;

class FileRelation extends AbstractModel
{
    public static $table = '::module_file_relations';
    public static $files = '::files LEFT JOIN ::module_file_relations USING(file_id)';

    public static function updateRelations(int $module_id, array $relations): void
    {
        // usuń wszyskie przynależności
        static::delete()
            ->equals('module_id', $module_id)
            ->execute();

        // każdą nadesłaną pozycję wstaw do bazy danych
        $position = 1;
        foreach ($relations as $file) {
            static::insert([
                'file_id' => $file['id'],
                'module_id' => $module_id,
                'position' => $position,
            ]);
            $position++;
        }
    }
}
