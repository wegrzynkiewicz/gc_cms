<?php

GC\Storage\Dump::makeBackup($_POST['name']);
GC\Response::redirect($breadcrumbs->getLastUrl());
