<?php

$staff = Staff::createFromSession();
$staff->redirectIfUnauthorized();

if (wasSentPost()) {
    $page_id = $_POST['page_id'];
    Page::deleteFrameByPrimaryId($page_id);
}

redirect('/admin/page/list');
