<?php

$module_id = intval(post('module_id'));

# pobierz moduł po kluczu głównym
$module = GC\Model\Module\Module::fetchByPrimaryId($module_id);

# usuń moduł i wszystkie jego dodatki
GC\Model\Module\Module::deleteByModuleId($module_id);

flashBox($trans("%s został usunięty", [$config['modules'][$module['type']]['name']]));
redirect($breadcrumbs->getLast('uri'));
