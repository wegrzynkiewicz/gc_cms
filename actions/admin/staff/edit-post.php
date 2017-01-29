<?php

$staff_id = intval(array_shift($_PARAMETERS));
$email = post('email');

$existedStaff = GC\Model\Staff\Staff::select()->equals('email', $email)->fetch();
if ($existedStaff and $existedStaff['staff_id'] != $staff_id) {
    $error = $trans('Taki adres email już istnieje');

    return require ACTIONS_PATH.'/admin/staff/edit-get.php';
}

GC\Model\Staff\Staff::updateByPrimaryId($staff_id, [
    'name' => post('name'),
    'email' => post('email'),
    'avatar' => post('avatar'),
]);
GC\Model\Staff\Staff::updateGroups($staff_id, post('groups', []));

redirect($breadcrumbs->getLast('uri'));
