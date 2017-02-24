<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/staff/_import.php';

$password = random($config['password']['minLength']);
$groups = post('groups', []);

# wstaw nowego pracownika do bazy
$staff_id = GC\Model\Staff\Staff::insert([
    'name' => post('name'),
    'password' => password_hash($password, \PASSWORD_DEFAULT),
    'email' => post('email'),
    'avatar' => post('avatar'),
    'lang' => $config['lang']['visitorDefault'],
    'force_change_password' => 1,
]);

# wstaw przynależność pracownika do grup
foreach ($groups as $group_id) {
    GC\Model\Staff\Membership::insert([
        'group_id' => $group_id,
        'staff_id' => $staff_id,
    ]);
}

# wyślij maila z hasłem
$mail = new GC\Mail();
$mail->buildTemplate(
    ROUTES_PATH.'/admin/staff/_email-staff-created.html.php',
    ROUTES_PATH.'/admin/_parts/email/styles.css', [
        'name' => post('name'),
        'login' => post('email'),
        'password' => $password,
    ]
);
$mail->addAddress($_POST['email']);
$mail->send();

flashBox(trans('Pracownik "%s" został utworzony.', [post('name')]));
redirect($breadcrumbs->getLast('uri'));
