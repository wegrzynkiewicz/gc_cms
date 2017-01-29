<?php

$staff_id = $_POST['staff_id'];
GC\Model\Staff\Staff::deleteByPrimaryId($staff_id);
redirect($breadcrumbs->getLast('uri'));
