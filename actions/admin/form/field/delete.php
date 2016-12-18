<?php

if (isPost()) {
    $field_id = intval($_POST['field_id']);
    GC\Model\FormField::deleteByPrimaryId($field_id);
}

redirect($breadcrumbs->getLastUrl());
