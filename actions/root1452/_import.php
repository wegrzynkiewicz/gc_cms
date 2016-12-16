<?php

if (!$config['debug']['enabled']) {
    redirect('/');
}

$staff = GC\Model\Staff::createFromSession();

if (!$staff['root']) {
    redirect('/');
}
