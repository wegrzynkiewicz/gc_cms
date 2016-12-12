<?php

$staff = Staff::createFromSession();
$staff->redirectIfUnauthorized();

$module_id = intval(array_shift($_SEGMENTS));

foreach ($_POST['filePaths'] as $file) {
    ModuleFile::insert([
        'filepath' => uploadUrl($file),
        'settings' => json_encode([]),
    ], $module_id);
}
