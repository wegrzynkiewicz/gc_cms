<?php

/* Plik pobiera i przygotowuje najważniejsze dane z bazy dla frontend */

$lang = $config['lang']['client'];

$topMenu = Menu::buildTree('top', $lang);
$sideMenu = Menu::buildTree('side', $lang);
