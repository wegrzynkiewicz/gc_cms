<?php

$password = GC\Auth\Password::random($config['password']['minLength']);

$staff_id = GC\Model\Staff\Staff::insert([
    'name' => post('name'),
    'password' => GC\Auth\Password::hash($password),
    'email' => post('email'),
    'avatar' => post('avatar'),
    'lang' => $config['lang']['visitorDefault'],
    'force_change_password' => 1,
]);
GC\Model\Staff\Staff::updateGroups($staff_id, post('groups', []));

$mail = new GC\Mail();
$mail->buildTemplate(
    ACTIONS_PATH.'/admin/staff/staff-created.email.html.php',
    ACTIONS_PATH.'/admin/parts/email/styles.css', [
        'name' => post('name'),
        'login' => post('email'),
        'password' => $password,
    ]
);
$mail->addAddress($_POST['email']);
$mail->send();

redirect($breadcrumbs->getLast('uri'));
