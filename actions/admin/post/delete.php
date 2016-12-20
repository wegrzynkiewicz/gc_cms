<?php

if (isPost()) {
    $post_id = intval($_POST['post_id']);
    $post = GC\Model\Post::selectWithFrameByPrimaryId($post_id);
    GC\Model\Post::deleteFrameByPrimaryId($post_id);

    setNotice(trans('Wpis "%s" został usunięty.', [$post['name']]));
}

redirect($breadcrumbs->getLastUrl());
