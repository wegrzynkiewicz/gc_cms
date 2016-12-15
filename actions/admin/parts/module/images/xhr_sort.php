<?php

$staff = GC\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

$module_id = intval(array_shift($_SEGMENTS));
$positions = $_POST['ids'];
GC\Model\ModuleFilePosition::updatePositionsByModuleId($module_id, $positions);
