<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/staff/_import.php';

$staff_id = $_POST['staff_id'];
GC\Model\Staff\Staff::deleteByPrimaryId($staff_id);
redirect($breadcrumbs->getLast('uri'));
