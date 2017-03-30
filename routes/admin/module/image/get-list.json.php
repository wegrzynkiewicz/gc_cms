<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/_breadcrumbs.php';

$module_id = intval(array_shift($_PARAMETERS));

$images = GC\Model\Module\FileRelation::select()
    ->fields(['file_id', 'name', 'slug', 'width', 'height'])
    ->source('::files')
    ->equals('module_id', $module_id)
    ->order('position', 'ASC')
    ->fetchAll();

foreach ($images as &$image) {
    $image['thumbnail'] = $uri->root(thumbnail($image['slug'], 300, 200));
    $image['slug'] = $uri->root($image['slug']);
}
unset($image);

echo json_encode($images);
