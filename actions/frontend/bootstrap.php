<?php

/* Plik pobiera i przygotowuje najważniejsze dane z bazy dla frontend */

$lang = $config['lang']['client'];

# wyciągnij z bazy węzły menu i zbuduj drzewo
$topMenu = Menu::buildTree('top', $lang);
$sideMenu = Menu::buildTree('side', $lang);

# jezeli moduly zostaly pobrane, wtedy ułoz z nich grida i pobierz wartości
if (isset($modules)) {
    $gridModules = [];
    foreach ($modules as $module_id => &$module) {
        list($x, $y, $w, $h) = explode(':', $module['position']);
        $module['grid'] = [
            'x' => $x,
            'y' => $y,
            'w' => $w,
            'h' => $h,
        ];

        require sprintf(ACTIONS_PATH."/frontend/modules/%s.php", $module['type']);

        $gridModules[$y][$x] = $module;
    }
    unset($module);

    foreach ($gridModules as $y => &$row) {
        $previousWidth = 0;
        ksort($row);
        foreach ($row as $x => &$module) {
            $offset = $x - $previousWidth;
            $module['grid']['o'] = $offset;
            $previousWidth = $x + $module['grid']['w'];
        }
        unset($module);
    }
    unset($row);
}
