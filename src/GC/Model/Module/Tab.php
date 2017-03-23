<?php

declare(strict_types=1);

namespace GC\Model\Module;

use GC\Storage\AbstractModel;

class Tab extends AbstractModel
{
    public static $table = '::module_tabs';
    public static $frame = '::module_tabs JOIN ::frames USING (frame_id)';
}
