<?php

# funkcja która wybiera najodpowiedniejszy szablon dla modułu
$getModuleTemplate = function ($type, $theme) use ($request) {
    $templates = [
        TEMPLATE_PATH."/modules/{$type}/{$request->method}-{$theme}.html.php",
        TEMPLATE_PATH."/modules/{$type}/{$theme}.html.php",
    ];

    foreach ($templates as $template) {
        if (is_readable($template)) {
            return $template;
        }
    }

    throw new RuntimeException("Not found module template for ({$type}, {$theme})");
};

# pobierz moduły wraz z pozycjami grida dla rusztowania
$modules = GC\Model\Module::select()
    ->source('::grid')
    ->equals('frame_id', $frame_id)
    ->fetchByPrimaryKey();

# jeżeli żaden moduł nie istnieje, wtedy przerwij
if (empty($modules)) {
    return;
}

# pobierz meta tagi dla wszystkich modułów w rusztowaniu
$metas = GC\Model\Module\Meta::select()
    ->source('::forFrameModules')
    ->equals('frame_id', $frame_id)
    ->fetchAll();

foreach ($metas as $meta) {
    $modules[$meta['module_id']]['meta'][$meta['name']] = $meta['value'];
}

# pobierz ustawienia wierszy dla rusztowania
$rows = GC\Model\Module\Row::select()
    ->equals('frame_id', $frame_id)
    ->order('position', 'ASC')
    ->fetchByKey('position');

foreach ($modules as $module_id => $module) {
    $module['template'] = $getModuleTemplate($module['type'], $module['theme']);
    $rows[$module['y']]['module']['types'][$module['x']] = $module;
}

foreach ($rows as $y => $row) {
    if (isset($forceContainerType)) {
        $row['type'] = $forceContainerType;
    }
    if (isset($row['module']['types'])) {
        echo render(TEMPLATE_PATH."/parts/_row.html.php", $row);
    }
}
