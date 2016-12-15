<?php

$image_id = intval($_POST['file_id']);

GC\Model\ModuleFile::deleteByPrimaryId($image_id);

http_status_code(204);
