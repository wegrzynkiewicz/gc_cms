<?php

require ROUTES_PATH."/admin/module/type/youtube/_import.php";

$yt = post('content');
$yt = preg_match('/[a-zA-Z0-9]+$/', $yt, $matches);

GC\Model\Module::updateByPrimaryId($module_id, [
    'content' => $matches[0],
    'theme' => 'default',
]);

GC\Model\Module\Meta::updateMeta($module_id, [
    'width' => intval(post('width')),
    'height' => intval(post('height')),
]);

redirect($breadcrumbs->getBeforeLast()['uri']);
