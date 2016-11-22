<?php

class FrameModuleModel extends AbstractModel
{
    public static $table      = '::frame_modules';
    public static $primary    = 'module_id';
    public static $groupTable = '::frame_positions';
    public static $groupName  = 'frame_id';

    use GroupModelTrait;
}
