<?php

$module_id = intval(post('module_id'));
$module = GC\Model\Module\Module::fetchByPrimaryId($module_id);

GC\Model\Module\File::deleteAllByForeign($module_id);
GC\Model\Module\Module::deleteModuleByPrimaryId($module_id);

flashBox($trans("%s został usunięty", [$config['modules'][$module['type']]['name']]));
redirect($breadcrumbs->getLast('uri'));
