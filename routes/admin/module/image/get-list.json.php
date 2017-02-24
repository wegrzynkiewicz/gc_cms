<?php

require ROUTES_PATH.'/admin/_import.php';

$module_id = intval(array_shift($_PARAMETERS));

$images = GC\Model\Module\File::select()
    ->fields(['file_id', 'name', 'slug', 'width', 'height'])
    ->source('::moduleFiles')
    ->equals('module_id', $module_id)
    ->order('position', 'ASC')
    ->fetchAll();

foreach ($images as &$image) {
    $image['thumbnail'] = $uri->root(thumbnail($image['slug'], 300, 200));
    $image['slug'] = $uri->root($image['slug']);
}
unset($image);

header("Content-Type: application/json; charset=utf-8");
echo json_encode($images);
