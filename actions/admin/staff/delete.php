<?php

$staff = Staff::createFromSession();
$staff->redirectIfUnauthorized();

if (wasSentPost()) {
    $staff_id = $_POST['staff_id'];
    Staff::deleteByPrimaryId($staff_id);
}

redirect('/admin/staff/list');
