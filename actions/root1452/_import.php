<?php

if (!$config['debug']['enabled']) {
    GC\Response::redirect('/');
}

$staff = GC\Model\Staff::createFromSession();

if (!$staff['root']) {
    GC\Response::redirect('/');
}
