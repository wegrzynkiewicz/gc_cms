<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/_breadcrumbs.php';

$module_id = intval(post('module_id'));

# pobierz moduł po kluczu głównym
$module = GC\Model\Module::fetchByPrimaryId($module_id);

# usuń moduł i wszystkie jego dodatki
GC\Model\Module::deleteByModuleId($module_id);

flashBox(trans("%s został usunięty", [$config['module']['types'][$module['type']]['name']]));
redirect($breadcrumbs->getLast('uri'));
