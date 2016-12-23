<?php

$staff_id = $_POST['staff_id'];
GC\Model\Staff::deleteByPrimaryId($staff_id);
GC\Response::redirect($breadcrumbs->getLastUrl());
