<?php

namespace GC\Model\Module;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\JoinTrait;

class Tab extends AbstractModel
{
    public static $table       = '::module_tabs';
    public static $frame       = '::module_tabs JOIN ::frames USING (frame_id)';

    use JoinTrait;
}
