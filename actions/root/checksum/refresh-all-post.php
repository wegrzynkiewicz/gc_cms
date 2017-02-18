<?php

require ACTIONS_PATH.'/root/_import.php';
require ACTIONS_PATH.'/root/checksum/_import.php';

refreshChecksums();

flashBox(trans('Odświeżono wszystkie pliki.'));
redirect($breadcrumbs->getLast('uri'));
