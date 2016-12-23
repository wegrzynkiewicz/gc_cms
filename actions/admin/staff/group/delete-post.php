<?php

$group_id = $_POST['group_id'];
GC\Model\StaffGroup::deleteByPrimaryId($group_id);
GC\Response::redirect($breadcrumbs->getLastUrl());
