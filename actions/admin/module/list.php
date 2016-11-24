<?php

$headTitle = trans("Moduły na stronie");

checkPermissions();

$page_id = intval(array_shift($_SEGMENTS));
$page = PageModel::selectFrameByPrimaryId($page_id);
$frame_id = $page['frame_id'];
$modules = FrameModuleModel::selectAllByGroupId($frame_id);
$headTitle .= makeLink("/admin/page/list", $page['name']);

require_once ACTIONS_PATH.'/admin/parts/header.html.php'; ?>

<div class="row">
    <div class="col-lg-8 text-left">
        <h1 class="page-header">
            <?=$headTitle?>
        </h1>
    </div>
    <div class="col-lg-4 text-right">
        <h1 class="page-header">
            <a href="<?=url("/admin/module/new/$page_id")?>" type="button" class="btn btn-success">
                <i class="fa fa-plus fa-fw"></i>
                <?=trans('Dodaj nowy moduł')?>
            </a>
        </h1>
    </div>
</div>

<div class="grid-stack">
        <?php if (empty($modules)): ?>
            <p>
                <?=trans('Nie znaleziono modułów')?>
            </p>
        <?php else: foreach ($modules as $module_id => $module): ?>

        <div class="grid-stack-item"
            data-gs-x="0" data-gs-y="0"
            data-gs-width="2" data-gs-height="1"
            data-gs-min-width="2"
            data-gs-max-height="1"
            >
                <div class="grid-stack-item-content">

            <div class="panel panel-default panel-module">
                <div class="panel-heading">

                        <a href="<?=url("/admin/module/edit/$module_id/$page_id")?>">
                            <?=trans($config['modules'][$module['type']])?>
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
                    <?php require sprintf(ACTIONS_PATH.'/admin/module/previews/%s.php', $module['type']); ?>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
        <?php endforeach; endif ?>
</div>

<?=view('/admin/parts/input/submitButtons.html.php', [
    'cancelHref' => "/admin/module/list/$page_id",
    'saveLabel' => 'Dodaj nowy moduł',
])?>

<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="deleteModalForm" method="post" action="<?=url("/admin/module/delete/$page_id")?>" class="modal-content">
            <input name="module_id" type="hidden" value="">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
                <h2 class="modal-title">
                    <?=trans("Czy na pewno usunąć??")?>
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

<?php require_once ACTIONS_PATH.'/admin/parts/assets.html.php'; ?>

<script>
    $('#deleteModal').on('show.bs.modal', function(e) {
        $(this).find('[name="module_id"]').val($(e.relatedTarget).data('id'));
    });
    $('.grid-stack').gridstack({
        cellHeight: 215,
        verticalMargin: 20
    });
</script>

<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
