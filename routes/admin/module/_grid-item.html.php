<div id="grid_<?=$module_id?>"
    data-id="<?=$module_id?>"
    data-gs-x="<?=$x?>"
    data-gs-y="<?=$y?>"
    data-gs-width="<?=$w?>"
    data-gs-height="<?=$h?>"
    data-gs-min-width="2"
    data-gs-min-height="1"
    data-gs-max-width="12"
    data-gs-max-height="1"
    class="grid-stack-item">
    <div class="grid-stack-item-content">
        <div class="panel panel-default panel-module">
            <div class="panel-heading">
                <a href="<?=$uri->make("/admin/module/{$module_id}/edit")?>">
                    <?=trans($config['module']['types'][$type]['name'])?>
                </a>
                <button data-toggle="modal"
                    data-id="<?=$module_id?>"
                    data-target="#deleteModal"
                    title="<?=trans('Usuń moduł')?>"
                    type="button"
                    class="close pull-right">
                    <span>&times;</span>
                </button>
            </div>
            <div class="panel-body">
                <?=render(ROUTES_PATH."/admin/module/types/{$type}/_grid-preview.html.php", $module)?>
            </div>
        </div>
    </div>
</div>
