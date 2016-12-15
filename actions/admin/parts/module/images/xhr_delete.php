<?php

$staff = GC\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

$image_id = intval($_POST['file_id']);

ModuleFile::deleteByPrimaryId($image_id);

http_status_code(204);
