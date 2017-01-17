<?php

$page = GC\Model\Page::selectWithFrameByPrimaryId($page_id);

GC\Model\Module\Frame::updateByFrameId($page['frame_id'], [
    'name' => post('name'),
    'keywords' => post('keywords'),
    'description' => post('description'),
    'image' => GC\Url::upload($_POST['image']),
]);

setNotice($trans('Strona "%s" została zaktualizowana.', [$_POST['name']]));

redirect($breadcrumbs->getLast('url'));
