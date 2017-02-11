<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/dump/_import.php';

GC\Storage\Backup::make($_POST['name']);
redirect($breadcrumbs->getLast('uri'));
