<?php

GC\Storage\Backup::make($_POST['name']);
redirect($breadcrumbs->getLast('uri'));
