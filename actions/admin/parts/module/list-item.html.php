<?php list($x, $y, $w, $h) = explode(":", $module['position']); ?>
<div id="grid_<?=e($module_id)?>"
    data-id="<?=e($module_id)?>"
    data-gs-x="<?=e($x)?>"
    data-gs-y="<?=e($y)?>"
    data-gs-width="<?=e($w)?>"
    data-gs-height="<?=e($h)?>"
    data-gs-min-width="2"
    data-gs-min-height="1"
    data-gs-max-width="12"
    data-gs-max-height="1"
    class="grid-stack-item">
    <div class="grid-stack-item-content">
        <div class="panel panel-default panel-module">
            <div class="panel-heading">
                <a href="<?=$uri->mask("/{$module_id}/edit")?>">
                    <?=$trans($config['modules'][$module['type']]['name'])?>
                </a>
                <button data-toggle="modal"
                    data-id="<?=e($module_id)?>"
                    data-target="#deleteModal"
                    title="<?=$trans('Usuń moduł')?>"
                    type="button"
                    class="close pull-right">
                    <span>&times;</span>
                </button>
            </div>
            <div class="panel-body">
                <?=render(ACTIONS_PATH."/admin/parts/module/type/{$type}/grid-preview.html.php", [
                    'module_id' => $module['module_id'],
                    'module' => $module,
                    'content' => $module['content'],
                    'settings' => json_decode($module['settings'], true),
                ])?>
            </div>
        </div>
    </div>
</div>
