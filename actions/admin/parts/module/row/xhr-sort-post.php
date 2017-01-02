<?php

$grid = json_decode($_POST['grid'], true);
GC\Model\Module\Position::updateGridByFrameId($frame_id, $grid);

http_response_code(204);
