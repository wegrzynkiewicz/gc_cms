<?php

$staff->redirectIfUnauthorized();

$image_id = intval($_POST['file_id']);

ModuleFile::deleteByPrimaryId($image_id);
