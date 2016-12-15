<?php

$headTitle = trans("Edytowanie pracownika");

$staff = GCC\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

$staff_id = intval(array_shift($_SEGMENTS));
$staffData = GCC\Model\Staff::selectByPrimaryId($staff_id);

if (!$staffData) {
    redirect('/admin/staff/list');
}

if (wasSentPost()) {

    $email = inputValue('email');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = trans('Adres email jest nieprawidłowy');
    }

    $existedStaff = GCC\Model\Staff::selectSingleBy('email', $email);
    if ($existedStaff and $existedStaff['staff_id'] != $staff_id) {
        $error = trans('Taki adres email już istnieje');
    }

    if (!isset($error)) {
        $groups = isset($_POST['groups']) ? $_POST['groups'] : [];
        GCC\Model\Staff::update($staff_id, $_POST, $groups);

        redirect('/admin/staff/list');
    }

} else {
    $_POST = $staffData;
}

$headTitle .= makeLink("/admin/staff/list", $staffData['name']);
$groups = array_keys(StaffGroup::selectAllAsOptionsByStaffId($staff_id));

require_once ACTIONS_PATH.'/admin/staff/form.html.php';
