<?php

$email = inputValue('email');
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = $trans('Adres email jest nieprawidłowy');
}

$existedStaff = GC\Model\Staff\Staff::select()->equals('email', $email)->fetch();
if ($existedStaff and $existedStaff['staff_id'] != $staff_id) {
    $error = $trans('Taki adres email już istnieje');
}

if (!isset($error)) {
    $groups = isset($_POST['groups']) ? $_POST['groups'] : [];

    GC\Model\Staff\Staff::update($staff_id, [
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'avatar' => $_POST['avatar'],
    ], $groups);

    GC\Response::redirect($breadcrumbs->getLastUrl());
}
