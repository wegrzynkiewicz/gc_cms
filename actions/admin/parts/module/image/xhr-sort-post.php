<?php

$positions = $_POST['positions'];
$positions = array_filter($_POST['positions'], function ($node) {
    return isset($node['id']);
});
GC\Model\ModuleFilePosition::updatePositionsByModuleId($module_id, $positions);

http_response_code(204);
