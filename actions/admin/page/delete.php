<?php

if (wasSentPost()) {
    $page_id = $_POST['page_id'];
    GC\Model\Page::deleteFrameByPrimaryId($page_id);
}

redirect($breadcrumbs->getLastUrl());
