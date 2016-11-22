<?php

/* Plik pobiera i przygotowuje najważniejsze dane z bazy */

$lang = $config['lang'];

$topMenu = $menuTreeBuilder->buildTree('top', $lang);
$sideMenu = $menuTreeBuilder->buildTree('side', $lang);
