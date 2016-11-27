<?php

$staff->redirectIfUnauthorized();

if (wasSentPost()) {
    $staff_id = $_POST['staff_id'];
    StaffModel::deleteByPrimaryId($staff_id);
}

redirect('/admin/staff/list');
