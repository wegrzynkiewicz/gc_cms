<?php

$staff = GCC\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

if (wasSentPost()) {
    $page_id = $_POST['page_id'];
    GCC\Model\Page::deleteFrameByPrimaryId($page_id);
}

redirect('/admin/page/list');
