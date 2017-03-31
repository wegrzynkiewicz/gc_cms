<?php

# panel roota jest dostępny tylko dla pracowników z polem 'root'
if (!GC\Staff::getInstance()['root']) {
    echo renderError(403);
}
