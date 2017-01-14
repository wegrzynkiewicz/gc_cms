<?php

$moduleType = $_POST['type'];
$module_id = GC\Model\Module\Module::insertWithFrameId([
    'type' => $moduleType,
    'theme' => 'default',
    'settings' => json_encode([]),
], $frame_id);

setNotice($trans("%s został utworzony. Edytujesz go teraz.", [GC\Data::get('config')['modules'][$moduleType]['name']]));

GC\Response::redirect(GC\Url::mask("/{$module_id}/edit"));
