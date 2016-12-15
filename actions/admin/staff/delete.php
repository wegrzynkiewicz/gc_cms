<?php

$staff = GCC\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

if (wasSentPost()) {
    $staff_id = $_POST['staff_id'];
    GCC\Model\Staff::deleteByPrimaryId($staff_id);
}

redirect('/admin/staff/list');
