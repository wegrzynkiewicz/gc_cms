<?php

$headTitle = trans("Galerie zdjęć");

$staff = GCC\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();
$rows = GCC\Model\Gallery::selectAllCorrectWithPrimaryKey();

require_once ACTIONS_PATH.'/admin/parts/header.html.php'; ?>

<div class="row">
    <div class="col-lg-8 text-left">
        <h1 class="page-header">
            <?=$headTitle?>
        </h1>
    </div>
    <div class="col-lg-4 text-right">
        <h1 class="page-header">
            <a href="<?=url("/admin/gallery/new")?>" type="button" class="btn btn-success">
                <i class="fa fa-plus fa-fw"></i>
                <?=trans('Dodaj nową galerię')?>
            </a>
        </h1>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <?php if (empty($rows)): ?>
            <p>
                <?=trans('Nie znaleziono galerii w języku: ')?>
                <?=view('/admin/parts/language.html.php')?>
            </p>
        <?php else: ?>
            <table class="table vertical-middle" data-table="">
                <thead>
                    <tr>
                        <th class="col-md-5 col-lg-4">
                            <?=trans('Nazwa galerii:')?>
                        </th>
                        <th class="col-md-7 col-lg-8 text-right"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $id => $row): ?>
                        <tr>
                            <td>
                                <a href="<?=url("/admin/gallery/edit/$id")?>"
                                    title="<?=trans('Edytuj galerię')?>">
                                    <?=$row['name']?>
                                </a>
                            </td>
                            <td class="text-right">

                                <a href="<?=url("/admin/gallery/images/list/$id")?>"
                                    title="<?=trans('Wyświetl zdjęcia galerii')?>"
                                    class="btn btn-success btn-xs">
                                    <i class="fa fa-file-text-o fa-fw"></i>
                                    <?=trans("Zdjęcia")?>
                                </a>

                                <a data-toggle="modal"
                                    data-id="<?=$id?>"
                                    data-name="<?=$row['name']?>"
                                    data-target="#deleteModal"
                                    title="<?=trans('Usuń galerię')?>"
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

<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="deleteModalForm" method="post" action="<?=url("/admin/gallery/delete")?>" class="modal-content">
            <input name="gallery_id" type="hidden" value="">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
                <h2 class="modal-title">
                    <?=trans("Czy na pewno usunąć?")?>
                </h2>
            </div>
            <div class="modal-body">
                <?=trans("Czy jesteś pewien, że chcesz usunąć galerię")?>
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

<?php require_once ACTIONS_PATH.'/admin/parts/assets.html.php'; ?>

<script>
$(function(){

    $('#deleteModal').on('show.bs.modal', function(e) {
        $(this).find('#name').html($(e.relatedTarget).data('name'));
        $(this).find('[name="gallery_id"]').val($(e.relatedTarget).data('id'));
    });

    $('[data-table]').DataTable();
});
</script>

<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
