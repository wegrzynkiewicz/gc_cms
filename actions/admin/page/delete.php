<?php

$staff->redirectIfUnauthorized();

if (wasSentPost()) {
    $page_id = $_POST['page_id'];
    PageModel::deleteFrameByPrimaryId($page_id);
}

redirect('/admin/page/list');
