<?php

if (wasSentPost()) {
    $group_id = $_POST['group_id'];
    GC\Model\StaffGroup::deleteByPrimaryId($group_id);
}

redirect($breadcrumbs->getLastUrl());
