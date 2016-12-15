<?php

$staff = GCC\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

if (wasSentPost()) {
    $group_id = $_POST['group_id'];
    GCC\Model\StaffGroup::deleteByPrimaryId($group_id);
}

redirect('/admin/staff/group/list');
