<?php

declare(strict_types=1);

namespace GC\Model\Module;

use GC\Storage\AbstractModel;

class Meta extends AbstractModel
{
    public static $table = '::module_meta';
    public static $meta = 'module_id';
    public static $forFrameModules = '::module_grid JOIN ::module_meta USING(module_id)';
}
