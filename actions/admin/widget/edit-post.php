<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/widget/_import.php';

require ACTIONS_PATH.'/admin/widget/edit-get.php';

redirect($breadcrumbs->getLast('uri'));
