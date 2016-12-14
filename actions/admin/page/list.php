<?php

$headTitle = trans("Wszystkie strony");

$staff = Staff::createFromSession();
$staff->redirectIfUnauthorized();

$pages = Page::selectAllWithFrames();

require_once ACTIONS_PATH.'/admin/parts/header.html.php'; ?>

<div class="row">
    <div class="col-lg-8 text-left">
        <h1 class="page-header">
            <?=$headTitle?>
        </h1>
    </div>
    <div class="col-lg-4 text-right">
        <h1 class="page-header">
            <a href="<?=url("/admin/page/new")?>" type="button" class="btn btn-success">
                <i class="fa fa-plus fa-fw"></i>
                <?=trans('Dodaj nową stronę')?>
            </a>
        </h1>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <?php if (empty($pages)): ?>
            <p>
                <?=trans('Nie znaleziono żadnej strony w języku: ')?>
                <?=view('/admin/parts/language.html.php')?>
            </p>
        <?php else: ?>
            <table class="table vertical-middle" data-table="">
                <thead>
                    <tr>
                        <th class="col-md-5 col-lg-4">
                            <?=trans('Nazwa strony:')?>
                        </th>
                        <th class="col-md-7 col-lg-8 text-right"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pages as $page_id => $page): ?>
                        <tr>
                            <td>
                                <?php if ($page['image']): ?>
                                    <img src="<?=Thumb::make($page['image'], 64, 64)?>"
                                    height="64" style="margin-right:5px"/>
                                <?php endif ?>
                                <a href="<?=url("/admin/page/edit/$page_id")?>"
                                    title="<?=trans('Edytuj stronę')?>">
                                    <?=$page['name']?>
                                </a>
                            </td>
                            <td class="text-right">

                                <a href="<?=url("/admin/page/module/list/$page_id")?>"
                                    title="<?=trans('Wyświetl moduły strony')?>"
                                    class="btn btn-success btn-xs">
                                    <i class="fa fa-file-text-o fa-fw"></i>
                                    <?=trans("Moduły")?>
                                </a>

                                <a data-toggle="modal"
                                    data-id="<?=$page_id?>"
                                    data-name="<?=$page['name']?>"
                                    data-target="#deleteModal"
                                    title="<?=trans('Usuń stronę')?>"
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
        <form id="deleteModalForm" method="post" action="<?=url("/admin/page/delete")?>" class="modal-content">
            <input name="page_id" type="hidden" value="">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
                <h2 class="modal-title">
                    <?=trans("Czy na pewno usunąć?")?>
                </h2>
            </div>
            <div class="modal-body">
                <?=trans("Czy jesteś pewien, że chcesz usunąć stronę")?>
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
            $(this).find('[name="page_id"]').val($(e.relatedTarget).data('id'));
        });
        $('[data-table]').DataTable();
    });
</script>

<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
