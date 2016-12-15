<?php

if (!$config['debug']) {
    redirect('/');
}

$staff = GC\Model\Staff::createFromSession();

if (!$staff['root']) {
    redirect('/');
}
