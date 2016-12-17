<?php

$headTitle = trans("Dodawanie nowego wpisu");

$staff = GC\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

if (isPost()) {

    $frame_id = GC\Model\Frame::insert([
        'name' => $_POST['name'],
        'lang' => $_SESSION['lang']['editor'],
        'keywords' => $_POST['keywords'],
        'description' => $_POST['description'],
        'image' => uploadUrl($_POST['image']),
    ]);

    $relations = isset($_POST['taxonomy']) ? array_unchunk($_POST['taxonomy']) : [];

    GC\Model\Post::insertWithRelations([
        'frame_id' => $frame_id,
    ], $relations);

    redirect('/admin/post/list');
}

$checkedValues = [];

require_once ACTIONS_PATH.'/admin/post/form.html.php';
