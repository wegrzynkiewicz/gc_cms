<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/_breadcrumbs.php';

$file_id = intval(post('file_id'));
GC\Model\File::deleteByPrimaryId($file_id);

http_response_code(204);
