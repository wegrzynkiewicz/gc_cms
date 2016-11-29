<?php

$headTitle = trans("Dodawanie nowego wpisu");

$staff->redirectIfUnauthorized();

if (wasSentPost()) {

    $frame_id = Frame::insert([
        'name' => $_POST['name'],
        'lang' => $_SESSION['lang']['editor'],
        'keywords' => $_POST['keywords'],
        'description' => $_POST['description'],
        'image' => uploadUrl($_POST['image']),
    ]);

    Post::insert([
        'frame_id' => $frame_id,
    ]);

    redirect('/admin/post/list');
}

require_once ACTIONS_PATH.'/admin/post/form.html.php';
