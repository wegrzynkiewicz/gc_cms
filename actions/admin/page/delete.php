<?php

$staff = GrafCenter\CMS\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

if (wasSentPost()) {
    $page_id = $_POST['page_id'];
    GrafCenter\CMS\Model\Page::deleteFrameByPrimaryId($page_id);
}

redirect('/admin/page/list');
