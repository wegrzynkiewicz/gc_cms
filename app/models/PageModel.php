<?php

class PageModel extends AbstractModel
{
    public static $table   = '::pages';
    public static $primary = 'page_id';

    use HasFrameModelTrait;
}
