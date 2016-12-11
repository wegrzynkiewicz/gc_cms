<?php

class PostTree extends Model
{
    public static $table    = '::post_tree';
    public static $primary  = 'node_id';
    public static $taxonomy = 'tax_id';

    use ColumnTrait;
    use TreeTrait;
}
