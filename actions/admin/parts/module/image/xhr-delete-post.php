<?php

$image_id = intval($_POST['file_id']);
GC\Model\Module\File::deleteByPrimaryId($image_id);

header("Content-Type: application/json; charset=utf-8");
http_status_code(204);
