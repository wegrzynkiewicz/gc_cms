<?php 

GC\Model\Staff::updateByPrimaryId($_SESSION['staff']['entity']['staff_id'], [
    'lang' => $_POST['lang'],
]);

GC\Response::redirect($breadcrumbs->getBeforeLastUrl());
