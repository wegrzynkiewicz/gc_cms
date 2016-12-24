<?php

$getModuleTemplate = function ($type, $theme) use ($request) {

    $templates = [
        "/modules/{$type}/{$theme}-{$request->method}.html.php",
        "/modules/{$type}/{$theme}.html.php",
    ];

    foreach ($templates as $template) {
        if (is_readable(TEMPLATE_PATH.$template)) {
            return $template;
        }
    }

    return false;
};

$gridModules = [];
foreach ($modules as $module_id => $module) {
    $module['size'] = explode(':', $module['position']);
    list($x, $y, $w, $h) = $module['size'];
    $gridModules[$y][$x] = $module;
}
ksort($gridModules);

foreach ($gridModules as $row) {

    ksort($row);
    if (count($row) === 1) {
        $module = array_shift($row);
        list($x, $y, $w, $h) = $module['size'];

        $template = $getModuleTemplate($module['type'], $module['theme']);
        if ($w == 12 and $template and preg_match("~-fluid~", $template)) {
            require TEMPLATE_PATH."/parts/module-item.html.php";
            continue;
        }
        array_unshift($row, $module);
    }

    if($container) {
        echo '<div class="container">';
    }
    echo '<div class="row">';

    $previousWidth = 0;
    foreach ($row as $module) {
        list($x, $y, $w, $h) = $module['size'];
        $o = $x - $previousWidth;
        $previousWidth = $x + $w;

        $template = $getModuleTemplate($module['type'], $module['theme']);

        echo sprintf('<div class="col-md-%s col-md-offset-%s">', $w, $o);
        require TEMPLATE_PATH."/parts/module-item.html.php";
        echo '</div>';
    }


    if($container) {
        echo '</div>';
    }
    echo '</div>';
}
