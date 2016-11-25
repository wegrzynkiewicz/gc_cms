<?php

$headTitle = trans("Galerie zdjęć");

checkPermissions();
$rows = GalleryModel::selectAll();

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
                <?=trans('Nie znaleziono żadnej galerii.')?>
            </p>
        <?php else: ?>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th class="col-md-7">
                            <?=trans('Nazwa galerii:')?>
                        </th>
                        <th lass="col-md-2 text-right"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $id => $row): ?>
                        <tr>
                            <td><?=$row['name']?></td>
                            <td class="text-right">

                                <a href="<?=url("/admin/gallery-images/list/$id")?>"
                                    title="<?=trans('Wyświetl zdjęcia galerii')?>"
                                    class="btn btn-success btn-sm">
                                    <i class="fa fa-file-text-o fa-fw"></i>
                                    <?=trans("Zdjęcia")?>
                                </a>

                                <a href="<?=url("/admin/gallery/edit/$id")?>"
                                    title="<?=trans('Edytuj galerię')?>"
                                    class="btn btn-primary btn-sm">
                                    <i class="fa fa-cog fa-fw"></i>
                                    <?=trans("Edytuj")?>
                                </a>

                                <a data-toggle="modal"
                                    data-id="<?=$id?>"
                                    data-name="<?=$row['name']?>"
                                    data-target="#deleteModal"
                                    title="<?=trans('Usuń galerię')?>"
                                    class="btn btn-danger btn-sm">
                                    <i class="fa fa-times fa-fw"></i>
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
            <input name="id" type="hidden" value="">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
                <h2 class="modal-title">
                    <?=trans("Czy na pewno usunąć??")?>
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
    $('#deleteModal').on('show.bs.modal', function(e) {
        $(this).find('#name').html($(e.relatedTarget).data('name'));
        $(this).find('[name="id"]').val($(e.relatedTarget).data('id'));
    });
</script>

<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
