<?php

$staff = GC\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

if (wasSentPost()) {
    $page_id = $_POST['page_id'];
    GC\Model\Page::deleteFrameByPrimaryId($page_id);
}

redirect('/admin/page/list');
