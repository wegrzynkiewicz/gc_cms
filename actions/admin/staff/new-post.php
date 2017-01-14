<?php

$groups = isset($_POST['groups']) ? $_POST['groups'] : [];
$password = GC\Auth\Password::random(GC\Data::get('config')['password']['minLength']);

$staff_id = GC\Model\Staff\Staff::insertWithGroups([
    'name' => post('name'),
    'password' => GC\Auth\Password::hash($password),
    'email' => post('email'),
    'avatar' => post('avatar'),
    'lang' => GC\Data::get('config')['lang']['clientDefault'],
    'force_change_password' => 1,
], $groups);

$mail = new GC\Mail();
$mail->buildTemplate(
    '/admin/staff/staff-created.email.html.php',
    '/admin/parts/email/styles.css', [
        'name' => post('name'),
        'login' => post('email'),
        'password' => $password,
    ]
);
$mail->addAddress($_POST['email']);
$mail->send();

GC\Response::redirect($breadcrumbs->getLastUrl());
