<?php

$headTitle = trans("Widżety");

$staff->redirectIfUnauthorized();

$widgets = Widget::selectAllCorrectWitPrimaryId();

require_once ACTIONS_PATH.'/admin/parts/header.html.php'; ?>

<div class="row">
    <div class="col-lg-12 text-left">
        <h1 class="page-header">
            <?=$headTitle?>
        </h1>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <?php if (empty($widgets)): ?>
            <p>
                <?=trans('Nie znaleziono żadnych widżetów w języku: ')?>
                <?=view('/admin/parts/language.html.php')?>
            </p>
        <?php else: ?>
            <table class="table table-striped table-bordered table-hover" data-table="">
                <thead>
                    <tr>
                        <th class="col-md-3 col-lg-3">
                            <?=trans('Nazwa widżetu')?>
                        </th>
                        <th class="col-md-8 col-lg-8">
                            <?=trans('Rodzaj')?>
                        </th>
                        <th class="col-md-1 col-lg-1 text-right"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($widgets as $widget_id => $widget): ?>
                        <tr>
                            <td>
                                <a href="<?=url("/admin/widget/edit/$widget_id")?>"
                                    title="<?=trans('Edytuj widżet')?>">
                                    <?=$widget['name']?>
                                </a>
                            </td>
                            <td>
                                <?=trans($config['widgetTypes'][$widget['type']])?>
                            </td>
                            <td class="text-right">

                                <a data-toggle="modal"
                                    data-id="<?=$widget_id?>"
                                    data-name="<?=$widget['name']?>"
                                    data-target="#deleteModal"
                                    title="<?=trans('Usuń widżet')?>"
                                    class="btn btn-danger btn-xs">
                                    <i class="fa fa-times fa-fw"></i>
                                    <?=trans("Usuń")?>
                                </a>

                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        <?php endif ?>
    </div>
</div>

<?php require_once ACTIONS_PATH.'/admin/parts/assets.html.php'; ?>

<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="deleteModalForm" method="post" action="<?=url("/admin/widget/delete")?>" class="modal-content">
            <input name="widget_id" type="hidden" value="">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
                <h2 class="modal-title">
                    <?=trans("Czy na pewno usunąć?")?>
                </h2>
            </div>
            <div class="modal-body">
                <?=trans("Czy jesteś pewien, że chcesz usunąć widżet")?>
                <span id="name" style="font-weight:bold; color:red;"></span>?
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

<script>
    $(function(){
        $('#deleteModal').on('show.bs.modal', function(e) {
            $(this).find('#name').html($(e.relatedTarget).data('name'));
            $(this).find('[name="widget_id"]').val($(e.relatedTarget).data('id'));
        });
        $('[data-table]').DataTable();
    });
</script>

<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
