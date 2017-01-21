<?php

$item_id = intval(post('item_id'));
GC\Model\Module\Item::deleteFrameByPrimaryId($item_id);

http_response_code(204);
