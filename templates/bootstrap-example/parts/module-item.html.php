<div id="module_<?=e($module['module_id'])?>"
    data-theme="<?=e($module['theme'])?>">
    <?=GC\Render::template($template, [
        'module_id' => $module['module_id'],
        'module' => $module,
        'type' => $module['type'],
        'theme' => $module['theme'],
        'content' => $module['content'],
        'settings' => json_decode($module['settings'], true),
    ])?>
</div>
