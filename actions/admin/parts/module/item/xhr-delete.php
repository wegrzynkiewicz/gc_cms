<?php

if (isPost()) {
    $item_id = intval($_POST['item_id']);
    GC\Model\Module\Item::deleteFrameByPrimaryId($item_id);
}

GC\Response::setMimeType('application/json');
http_status_code(204);
