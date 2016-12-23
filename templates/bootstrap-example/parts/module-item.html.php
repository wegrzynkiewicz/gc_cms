<div id="module_<?=e($module['module_id'])?>">
    <?=GC\Render::template($template, [
        'module_id' => $module['module_id'],
        'module' => $module,
        'type' => $module['type'],
        'content' => $module['content'],
        'settings' => json_decode($module['settings'], true),
    ])?>
</div>
