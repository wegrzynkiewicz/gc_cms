<?php

$gridModules = [];
foreach ($modules as $module_id => $module) {
    list($x, $y, $w, $h) = explode(':', $module['grid']);
    $module['size'] = [
        'x' => $x, 'y' => $y,
        'w' => $w, 'h' => $h,
    ];
    $module['templateArgs'] = [
        'module_id' => $module_id,
        'module' => $module,
        'content' => $module['content'],
        'settings' => json_decode($module['settings'], true),
    ];
    $gridModules[$y][$x] = $module;
}
ksort($gridModules);

foreach ($gridModules as $row) {

    ksort($row);
    if (count($row) === 1) {
        $module = array_shift($row);
        $fullTemplatePath = sprintf("/modules/%s-%s-full.html.php", $module['type'], $module['theme']);
        if ($module['size']['w'] == 12 and is_readable(TEMPLATE_PATH.$fullTemplatePath)) {
            echo templateView($fullTemplatePath, $module['templateArgs']);
            continue;
        }
        array_unshift($row, $module);
    }

    echo '<div class="container">';
    echo '<div class="row">';

    $previousWidth = 0;
    foreach ($row as $module) {
        list($x, $y, $w, $h) = explode(':', $module['grid']);
        $o = $x - $previousWidth;
        $previousWidth = $x + $w;
        require TEMPLATE_PATH."/parts/module-item.html.php";
    }

    echo '</div>';
    echo '</div>';
}
