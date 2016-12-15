<?php

$headTitle = trans("Dodawanie nowej strony");

$staff = GrafCenter\CMS\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

if (wasSentPost()) {

    $frame_id = GrafCenter\CMS\Model\Frame::insert([
        'name' => $_POST['name'],
        'lang' => $_SESSION['lang']['editor'],
        'keywords' => $_POST['keywords'],
        'description' => $_POST['description'],
        'image' => uploadUrl($_POST['image']),
    ]);

    GrafCenter\CMS\Model\Page::insert([
        'frame_id' => $frame_id,
    ]);

    redirect('/admin/page/list');
}

require_once ACTIONS_PATH.'/admin/page/form.html.php';
