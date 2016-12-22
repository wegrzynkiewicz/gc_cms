<?php

$headTitle = trans("Dodawanie nowego pracownika");
$breadcrumbs->push($request, $headTitle);

if (isPost()) {

    $groups = isset($_POST['groups']) ? $_POST['groups'] : [];
    $password = GC\Password::random($config['password']['minLength']);

    $staff_id = GC\Model\Staff::insertWithGroups([
        'name' => $_POST['name'],
        'password' => GC\Password::hash($password),
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

    GC\Response::redirect($breadcrumbs->getBeforeLastUrl());
}

$groups = [];

require ACTIONS_PATH.'/admin/parts/header.html.php';
require ACTIONS_PATH.'/admin/parts/page-header.html.php';
require ACTIONS_PATH.'/admin/staff/form.html.php'; ?>
