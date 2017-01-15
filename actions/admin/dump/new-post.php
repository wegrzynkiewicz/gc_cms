<?php

GC\Storage\Backup::make($_POST['name']);
GC\Response::redirect($breadcrumbs->getLast('url'));
