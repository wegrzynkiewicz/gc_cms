<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/dump/_import.php';

GC\Storage\Backup::make(post('name'));
redirect($breadcrumbs->getLast('uri'));
