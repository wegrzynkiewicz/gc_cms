<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/staff/_import.php';
require ACTIONS_PATH.'/admin/staff/group/_import.php';

GC\Model\Staff\Group::deleteByPrimaryId(post('group_id'));
redirect($breadcrumbs->getLast('uri'));
