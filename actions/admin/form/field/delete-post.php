<?php

$field_id = intval($_POST['field_id']);
GC\Model\Form\Field::deleteByPrimaryId($field_id);
redirect($breadcrumbs->getLast('url'));
