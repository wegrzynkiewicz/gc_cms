<?php

$staff->redirectIfUnauthorized();

$module_id = intval(array_shift($_SEGMENTS));
$positions = $_POST['ids']; 
ModuleFilePosition::updatePositionsByModuleId($module_id, $positions);
