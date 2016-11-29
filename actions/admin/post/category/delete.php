<?php

$staff->redirectIfUnauthorized();

$tax_id = intval(array_shift($_SEGMENTS));

if (wasSentPost()) {
    Database::transaction(function () {
        $cat_id = intval($_POST['cat_id']);
        PostCategory::deleteByPrimaryId($cat_id);
        PostCategory::deleteWithoutParentId();
    });
}

redirect("/admin/post/category/list/$tax_id");
