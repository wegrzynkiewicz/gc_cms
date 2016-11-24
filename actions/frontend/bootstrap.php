<?php

/* Plik pobiera i przygotowuje najważniejsze dane z bazy */

$lang = $config['lang'];

$menuTreeBuilder = new MenuTreeBuilder();
$topMenu = $menuTreeBuilder->buildTree('top', $lang);
$sideMenu = $menuTreeBuilder->buildTree('side', $lang);
