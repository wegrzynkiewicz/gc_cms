<?php

# panel roota jest dostępny tylko jeżeli jest włączony debug
if (!$config['debug']['enabled']) {
    GC\Response::redirect('/');
}

$staff = GC\Model\Staff\Staff::createFromSession();

# panel roota jest dostępny tylko dla pracowników z polem 'root'
if (!$staff['root']) {
    GC\Response::redirect('/');
}
