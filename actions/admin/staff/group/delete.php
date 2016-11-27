<?php

$staff->redirectIfUnauthorized();

if (wasSentPost()) {
    $group_id = $_POST['group_id'];
    StaffGroupModel::deleteByPrimaryId($group_id);
}

redirect('/admin/staff/group/list');
