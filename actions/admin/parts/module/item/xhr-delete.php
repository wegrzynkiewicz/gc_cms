<?php

if (isPost()) {
    $item_id = intval($_POST['item_id']);
    GC\Model\Module\Item::deleteFrameByPrimaryId($item_id);
}

header("Content-Type: application/json; charset=utf-8");
http_status_code(204);
