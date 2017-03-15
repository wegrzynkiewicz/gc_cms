<?php

namespace GC\Model\Module;

use GC\Storage\AbstractModel;

class FileRelation extends AbstractModel
{
    public static $table = '::module_file_relations';
    public static $files = '::files LEFT JOIN ::module_file_relations USING(file_id)';
}
