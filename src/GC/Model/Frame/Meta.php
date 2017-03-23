<?php

declare(strict_types=1);

namespace GC\Model\Frame\Meta;

use GC\Storage\AbstractModel;

class Meta extends AbstractModel
{
    public static $table = '::module_file_meta';
    public static $meta = 'file_id';
    public static $forMetaFields = 'file_id, ::module_file_meta.name, ::module_file_meta.value';
    public static $moduleFilesMeta = '::module_files LEFT JOIN ::module_file_pos USING(file_id) LEFT JOIN ::module_file_meta USING(file_id)';
}
