<?php

$groups = isset($_POST['groups']) ? $_POST['groups'] : [];
$password = GC\Auth\Password::random($config['password']['minLength']);

$staff_id = GC\Model\Staff\Staff::insertWithGroups([
    'name' => $_POST['name'],
    'password' => GC\Auth\Password::hash($password),
    'email' => $_POST['email'],
    'avatar' => $_POST['avatar'],
    'lang' => $config['lang']['clientDefault'],
    'force_change_password' => 1,
], $groups);

$mail = new GC\Mail();
$mail->buildTemplate(
    '/admin/staff/staff-created.email.html.php',
    '/admin/parts/email/styles.css', [
        'name' => $_POST['name'],
        'login' => $_POST['email'],
        'password' => $password,
    ]
);
$mail->addAddress($_POST['email']);
$mail->send();

GC\Response::redirect($breadcrumbs->getLastUrl());
