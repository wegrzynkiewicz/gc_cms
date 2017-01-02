<?php

$group_id = $_POST['group_id'];
GC\Model\Staff\Group::deleteByPrimaryId($group_id);
GC\Response::redirect($breadcrumbs->getLastUrl());
