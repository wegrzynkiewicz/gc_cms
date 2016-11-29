<?php

/* Plik pobiera i przygotowuje najważniejsze dane z bazy dla frontend */

$lang = getClientLang();

# wyciągnij z bazy węzły menu i zbuduj drzewo
$topMenu = Menu::buildTreeByWorkName("top_$lang", $lang);
$sideMenu = Menu::buildTreeByWorkName("side_$lang");

# jezeli moduly zostaly pobrane, wtedy ułoz z nich grida i pobierz wartości
if (isset($frame_id)) {

    $modules = FrameModule::selectAllByFrameId($frame_id);

    $gridModules = [];
    foreach ($modules as $module_id => &$module) {
        list($x, $y, $w, $h) = explode(':', $module['grid']);
        $module['grid'] = [
            'x' => $x,
            'y' => $y,
            'w' => $w,
            'h' => $h,
        ];

        $content = $module['content'];

        require sprintf(ACTIONS_PATH."/frontend/modules/%s.php", $module['type']);

        $gridModules[$y][$x] = $module;
    }
    unset($module);

    ksort($gridModules);
    foreach ($gridModules as $y => &$row) {
        ksort($row);
        $previousWidth = 0;
        foreach ($row as $x => &$module) {
            $offset = $x - $previousWidth;
            $module['grid']['o'] = $offset;
            $previousWidth = $x + $module['grid']['w'];
        }
        unset($module);
    }
    unset($row);
}
