<?php

GC\Model\PopUp\PopUp::updateByPrimaryId($popup_id, [
    'content' => $uri->relative(post('content')),
]);
