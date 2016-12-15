<?php

if (!$config['debug']) {
    redirect('/');
}

$staff = GCC\Model\Staff::createFromSession();

if (!$staff['root']) {
    redirect('/');
}
