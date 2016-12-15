<?php

$headTitle = trans("Dodawanie nowego pracownika");

$staff = GC\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

if (wasSentPost()) {

    $groups = isset($_POST['groups']) ? $_POST['groups'] : [];

    $password = randomPassword($config['minPasswordLength']);
    $passwordHash = sha1($password);

    $staff_id = GC\Model\Staff::insert([
        'name' => $_POST['name'],
        'password' => $passwordHash,
        'email' => $_POST['email'],
        'avatar' => $_POST['avatar'],
        'lang' => $config['lang']['clientDefault'],
        'force_change_password' => 1,
    ], $groups);

    $mail = new Mail();
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

    redirect('/admin/staff/list');
}

$groups = [];

require_once ACTIONS_PATH.'/admin/staff/form.html.php';
