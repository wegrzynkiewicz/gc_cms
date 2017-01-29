<?php

$pages = GC\Model\Page::selectWithFrames()->fetchByPrimaryKey();

?>
<?php require ACTIONS_PATH.'/admin/parts/header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="page-header">
            <div class="btn-toolbar pull-right">
                <a href="<?=$uri->mask('/new')?>" type="button" class="btn btn-success btn-md">
                    <i class="fa fa-plus fa-fw"></i>
                    <?=$trans('Dodaj nową stronę')?>
                </a>
            </div>
            <h1><?=($headTitle)?></h1>
        </div>
    </div>
</div>

<?php require ACTIONS_PATH.'/admin/parts/breadcrumbs.html.php'; ?>

<!-- <div class="alert alert-info alert-dismissible">
    <button type="button" class="close" data-dismiss="alert">
        <span>&times;</span>
    </button>
    <strong>Pomoc:</strong> <?=$trans('')?>
</div> -->

<div class="row">
    <div class="col-md-12">
        <div class="simple-box">
            <?php if (empty($pages)): ?>
                <?=$trans('Nie znaleziono żadnej strony w języku: ')?>
                <?=render(ACTIONS_PATH.'/admin/parts/language.html.php', [
                    'lang' => GC\Auth\Staff::getEditorLang(),
                ])?>
            <?php else: ?>
                <table class="table vertical-middle" data-table="">
                    <thead>
                        <tr>
                            <th style="width:1px"><?=$trans('Zdjęcie')?></th>
                            <th><?=$trans('Nazwa strony')?></th>
                            <th class="text-right no-sort"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pages as $page_id => $page): ?>
                            <?=render(ACTIONS_PATH.'/admin/page/list-item.html.php', [
                                'page_id' => $page_id,
                                'page' => $page,
                            ])?>
                        <?php endforeach ?>
                    </tbody>
                </table>
            <?php endif ?>
        </div>
        <?php require ACTIONS_PATH.'/admin/parts/input/submitButtons.html.php'; ?>
    </div>
</div>

<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="deleteModalForm"
            method="post"
            action="<?=$uri->mask("/delete")?>"
            class="modal-content">
            <input name="page_id" type="hidden" value="">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
                <h2 class="modal-title">
                    <?=$trans('Czy na pewno usunąć?')?>
                </h2>
            </div>
            <div class="modal-body">
                <?=$trans('Czy jesteś pewien, że chcesz usunąć stronę')?>
                <span id="name" style="font-weight:bold; color:red;"></span>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <?=$trans('Anuluj')?>
                </button>
                <button type="submit" class="btn btn-danger btn-ok">
                    <?=$trans('Usuń')?>
                </button>
            </div>
        </form>
    </div>
</div>

<?php require ACTIONS_PATH.'/admin/parts/assets/footer.html.php'; ?>

<script>
    $(function(){
        $('#deleteModal').on('show.bs.modal', function(e) {
            $(this).find('#name').html($(e.relatedTarget).data('name'));
            $(this).find('[name="page_id"]').val($(e.relatedTarget).data('id'));
        });
        $('[data-table]').DataTable({
            order: [[2, 'asc']],
            iDisplayLength: <?=$config['dataTable']['iDisplayLength']?>,
        });
    });
</script>

<?php require ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
