<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/form/_import.php';
require ACTIONS_PATH.'/admin/form/field/_import.php';

$field_id = intval($_POST['field_id']);
GC\Model\Form\Field::deleteByPrimaryId($field_id);
redirect($breadcrumbs->getLast('uri'));
