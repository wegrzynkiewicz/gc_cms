<?php

$file_id = intval(post('file_id'));
GC\Model\Module\File::deleteByPrimaryId($file_id);

http_response_code(204);
