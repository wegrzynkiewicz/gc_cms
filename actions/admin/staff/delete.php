<?php

if (wasSentPost()) {
    $staff_id = $_POST['staff_id'];
    GC\Model\Staff::deleteByPrimaryId($staff_id);
}

redirect($breadcrumbs->getLastUrl());
