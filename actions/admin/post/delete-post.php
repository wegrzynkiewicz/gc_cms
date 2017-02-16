<?php

$post_id = intval($_POST['post_id']);
$post = GC\Model\Post\Post::selectWithFrameByPrimaryId($post_id);
GC\Model\Post\Post::deleteFrameByPrimaryId($post_id);

flashBox($trans('Wpis "%s" został usunięty.', [$post['name']]));

redirect($breadcrumbs->getLast('uri'));
