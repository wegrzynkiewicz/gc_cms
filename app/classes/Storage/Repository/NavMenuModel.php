<?php

class NavMenuModel extends AbstractModel
{
    public static $table      = '::nav_menus';
    public static $primary    = 'menu_id';
    public static $groupTable = '::nav_positions';
    public static $groupName  = 'nav_id';

    use TreeModelTrait;
}
