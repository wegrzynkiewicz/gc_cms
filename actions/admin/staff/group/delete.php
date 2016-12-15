<?php

$staff = GC\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

if (wasSentPost()) {
    $group_id = $_POST['group_id'];
    GC\Model\StaffGroup::deleteByPrimaryId($group_id);
}

redirect('/admin/staff/group/list');
