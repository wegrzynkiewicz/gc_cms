<?php

if (isPost()) {
    $grid = json_decode($_POST['grid'], true);
    GC\Model\ModulePosition::updateGridByFrameId($frame_id, $grid);

    redirect($breadcrumbs->getBeforeLastUrl());
}

$modules = GC\Model\Module::joinAllWithKeyByForeign($frame_id);

require_once ACTIONS_PATH.'/admin/parts/header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="page-header">
            <div class="btn-toolbar pull-right">
                <a href="<?=$getPreviewUrl()?>"
                    target="_blank"
                    type="button"
                    class="btn btn-primary">
                    <i class="fa fa-search fa-fw"></i>
                    <?=trans('Podgląd')?>
                </a>
                <a href="<?=$surl("/new")?>"
                    type="button"
                    class="btn btn-success">
                    <i class="fa fa-plus fa-fw"></i>
                    <?=trans('Dodaj nowy moduł')?>
                </a>
            </div>
            <h1><?=($headTitle)?></h1>
        </div>
    </div>
</div>

<?php require_once ACTIONS_PATH.'/admin/parts/breadcrumbs.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form id="gridForm" action="" method="post" class="form-horizontal">
            <input name="grid" type="hidden"/>
            <?php if (empty($modules)): ?>
                <div class="simple-box">
                    <?=trans('Brak modułów')?>
                </div>
            <?php else: ?>
                <div class="grid-stack">
                    <?php foreach ($modules as $module_id => $module): ?>
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
                                        <a href="<?=$surl("/$module_id/edit")?>">
                                            <?=trans($config['modules'][$module['type']]['name'])?>
                                        </a>
                                        <button data-toggle="modal"
                                            data-id="<?=e($module_id)?>"
                                            data-target="#deleteModal"
                                            title="<?=trans('Usuń moduł')?>"
                                            type="button"
                                            class="close pull-right">
                                            <span>&times;</span>
                                        </button>
                                    </div>
                                    <div class="panel-body">
                                        <?=view(sprintf('/admin/parts/module/types/%s/grid-item-preview.html.php', $module['type']), [
                                            'module_id' => $module['module_id'],
                                            'module' => $module,
                                            'content' => $module['content'],
                                            'settings' => json_decode($module['settings'], true),
                                        ])?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            <?php endif ?>

            <?=view('/admin/parts/input/submitButtons.html.php', [
                'saveLabel' => 'Zapisz pozycje kafelków',
            ])?>

        </form>
    </div>
</div>

<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="deleteModalForm" method="post" action="<?=$surl("/delete")?>" class="modal-content">
            <input name="module_id" type="hidden" value="">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
                <h2 class="modal-title">
                    <?=trans("Czy na pewno usunąć?")?>
                </h2>
            </div>
            <div class="modal-body">
                <?=trans("Czy jesteś pewien, że chcesz usunąć ten moduł?")?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <?=trans('Anuluj')?>
                </button>
                <button type="submit" value="" class="btn btn-danger btn-ok" href="">
                    <?=trans('Usuń')?>
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once ACTIONS_PATH.'/admin/parts/footer-assets.html.php'; ?>

<script>

$('#deleteModal').on('show.bs.modal', function(e) {
    $(this).find('[name="module_id"]').val($(e.relatedTarget).data('id'));
});

$('.grid-stack').gridstack({
    cellHeight: 215,
    verticalMargin: 20
});

$("#gridForm").submit(function(event) {

    var serializedData = _.map($('.grid-stack .grid-stack-item:visible'), function (el) {
        el = $(el);
        var node = el.data('_gridstack_node');
        return {
            id: el.attr('data-id'),
            x: node.x,
            y: node.y,
            width: node.width,
            height: node.height
        };
    });

    $('[name=grid]').val(JSON.stringify(serializedData));
});

</script>

<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
