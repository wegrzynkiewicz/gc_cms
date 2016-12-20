<?php

if (isPost()) {
    $item_id = intval($_POST['item_id']);
    GC\Model\ModuleItem::deleteFrameByPrimaryId($item_id);
}

http_status_code(204);
