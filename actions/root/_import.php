<?php

# panel roota jest dostępny tylko jeżeli jest włączony debug
if (!$config['debug']['enabled']) {
    GC\Response::redirect('/');
}

$staff = GC\Model\Staff\Staff::createFromSession();

$breadcrumbs = new GC\Breadcrumbs();
$breadcrumbs->push('/admin', 'Dashboard', 'fa-dashboard');
$breadcrumbs->push('/root', 'Panel programisty', 'fa-bug');

# panel roota jest dostępny tylko dla pracowników z polem 'root'
if (!$staff['root']) {
    GC\Response::redirect('/');
}
