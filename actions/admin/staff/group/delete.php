<?php

$staff = Staff::createFromSession();
$staff->redirectIfUnauthorized();

if (wasSentPost()) {
    $group_id = $_POST['group_id'];
    StaffGroup::deleteByPrimaryId($group_id);
}

redirect('/admin/staff/group/list');
