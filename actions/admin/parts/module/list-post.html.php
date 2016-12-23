<?php

$grid = json_decode($_POST['grid'], true);
GC\Model\ModulePosition::updateGridByFrameId($frame_id, $grid);
GC\Response::redirect($breadcrumbs->getBeforeLastUrl());
