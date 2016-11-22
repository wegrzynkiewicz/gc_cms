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

<div class="row">
    <div class="col-lg-12 ">
        <?php if (empty($modules)): ?>
            <p>
                <?=trans('Nie znaleziono modułów')?>
            </p>
        <?php else: foreach ($modules as $module_id => $module): ?>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h2 class="panel-title pull-left">
                        <?=trans($config['modules'][$module['type']])?>
                    </h2>
                    <div class="pull-right">

                        <?php if ($module['position'] > 1): ?>
                            <a href=<?=url("/admin/module/move-up/$module_id/$page_id")?>
                                title="<?=trans('Przenieś do góry')?>" class="btn btn-primary btn-sm">
                                <i class="fa fa-arrow-up fa-fw"></i>
                            </a>
                        <?php endif ?>

                        <?php if ($module['position'] < count($modules)): ?>
                            <a href="<?=url("/admin/module/move-down/$module_id/$page_id")?>"
                                title="<?=trans('Przenieś w dół')?>" class="btn btn-primary btn-sm">
                                <i class="fa fa-arrow-down fa-fw"></i>
                            </a>
                        <?php endif ?>

                        <a href="<?=url("/admin/module/edit/$module_id/$page_id")?>"
                            class="btn btn-success btn-sm">
                            <i class="fa fa-file-text-o fa-fw"></i>
                            <?=trans('Edytuj')?>
                        </a>

                        <a data-toggle="modal"
                            data-id="<?=$module_id?>"
                            data-target="#deleteModal"
                            title="<?=trans('Usuń moduł')?>"
                            class="btn btn-danger btn-sm">
                            <i class="fa fa-times fa-fw"></i>
                        </a>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="panel-body">
                    <?php require sprintf(ACTIONS_PATH.'/admin/module/previews/%s.php', $module['type']); ?>
                </div>

            </div>
            <div class="clearfix"></div>
        <?php endforeach; endif ?>
    </div>
</div>

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
</script>

<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
