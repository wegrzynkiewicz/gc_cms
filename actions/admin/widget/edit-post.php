<?php

require ACTIONS_PATH.'/admin/widget/edit-get.php';

GC\Response::redirect($breadcrumbs->getLastUrl());
