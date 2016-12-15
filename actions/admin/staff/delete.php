<?php

$staff = GrafCenter\CMS\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

if (wasSentPost()) {
    $staff_id = $_POST['staff_id'];
    GrafCenter\CMS\Model\Staff::deleteByPrimaryId($staff_id);
}

redirect('/admin/staff/list');
