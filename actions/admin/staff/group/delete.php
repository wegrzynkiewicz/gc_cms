<?php

$staff = GrafCenter\CMS\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

if (wasSentPost()) {
    $group_id = $_POST['group_id'];
    GrafCenter\CMS\Model\StaffGroup::deleteByPrimaryId($group_id);
}

redirect('/admin/staff/group/list');
