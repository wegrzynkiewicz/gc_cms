<?php

namespace GC\Model;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\PrimaryTrait;
use GC\Storage\Database;

class Session extends AbstractModel
{
    public static $table   = '::sessions';
    public static $primary = 'session_id';

    use PrimaryTrait;
}
