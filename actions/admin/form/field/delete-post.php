<?php

$field_id = intval($_POST['field_id']);
GC\Model\FormField::deleteByPrimaryId($field_id);
GC\Response::redirect($breadcrumbs->getLastUrl());
