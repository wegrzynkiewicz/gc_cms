<?php

if (!$config['debug']) {
    redirect('/');
}

$staff = GrafCenter\CMS\Model\Staff::createFromSession();

if (!$staff['root']) {
    redirect('/');
}
