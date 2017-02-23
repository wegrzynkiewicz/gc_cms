<?php

namespace GC\Model\PopUp;

use GC\Storage\AbstractModel;

class PopUp extends AbstractModel
{
    public static $table = '::popups';
    public static $primary = 'popup_id';
}
