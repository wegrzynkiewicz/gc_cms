<?php

require ROUTES_PATH.'/root/_import.php';
require ROUTES_PATH.'/root/checksum/_import.php';

refreshChecksums();

flashBox(trans('Odświeżono wszystkie pliki.'));
redirect($breadcrumbs->getLast('uri'));