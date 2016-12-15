<?php

$staff = GC\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

if (wasSentPost()) {
    $staff_id = $_POST['staff_id'];
    GC\Model\Staff::deleteByPrimaryId($staff_id);
}

redirect('/admin/staff/list');
