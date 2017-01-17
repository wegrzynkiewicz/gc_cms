<?php

$module_id = intval(array_shift($_SEGMENTS));
$positions = $_POST['positions'];
$positions = array_filter($_POST['positions'], function ($node) {
    return isset($node['id']);
});
GC\Model\Module\ItemPosition::updatePositionsByModuleId($module_id, $positions);

header("Content-Type: application/json; charset=utf-8");
http_response_code(204);
