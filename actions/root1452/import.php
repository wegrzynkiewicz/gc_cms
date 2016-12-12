<?php

if (!$config['debug']) {
    redirect('/');
}

$staff = Staff::createFromSession();

if (!$staff['root']) {
    redirect('/');
}
