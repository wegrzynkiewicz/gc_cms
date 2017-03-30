<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/_breadcrumbs.php';
require ROUTES_PATH.'/admin/staff/_import.php';

$staff_id = intval(array_shift($_PARAMETERS));
$groups = post('groups', []);

# zaktualizuj pracownika po kluczu głównym
GC\Model\Staff\Staff::updateByPrimaryId($staff_id, [
    'name' => post('name'),
    'email' => post('email'),
    'avatar' => post('avatar'),
]);

# usuń wszystkie grupy tego pracownika
GC\Model\Staff\Membership::delete()
    ->equals('staff_id', $staff_id)
    ->execute();

# wstaw przynależność pracownika do grup
foreach ($groups as $group_id) {
    GC\Model\Staff\Membership::insert([
        'group_id' => $group_id,
        'staff_id' => $staff_id,
    ]);
}

flashBox(trans('Pracownik "%s" został zaktualizowany.', [post('name')]));
redirect($breadcrumbs->getLast()['uri']);
