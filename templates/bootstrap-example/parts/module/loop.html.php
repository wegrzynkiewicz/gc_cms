<?php

$frameSettings = json_decode($frame['settings'], true);
if (!isset($frameSettings['rows'])) {
    $frameSettings['rows'] = [];
}

$gridModules = [];
foreach ($modules as $module_id => $module) {
    $module['size'] = explode(':', $module['position']);
    list($x, $y, $w, $h) = $module['size'];
    $gridModules[$y][$x] = $module;
}
ksort($gridModules);

foreach ($gridModules as $y => $row) {

    $rowSettings = isset($frameSettings['rows'][$y]) ? $frameSettings['rows'][$y] : [];

    $rowHtml = GC\Render::template('/parts/module/row-container.html.php', [
        'row' => $row,
        'container' => $container,
        'rowSettings' => $rowSettings,
    ]);

    echo $rowHtml;
}
