<?php require ROUTES_PATH."/admin/parts/_header.html.php"; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="page-header">
            <div class="btn-toolbar pull-right">
                <a href="<?=$uri->make("/admin/frame/new/{$frameType}")?>" type="button" class="btn btn-success btn-md">
                    <i class="fa fa-plus fa-fw"></i>
                    <?=$addCaption?>
                </a>
            </div>
            <h1><?=$headTitle?></h1>
        </div>
    </div>
</div>

<?php require ROUTES_PATH."/admin/parts/_breadcrumbs.html.php"; ?>

<div class="row">
    <div class="col-md-12">
        <div class="simple-box">
            <?php if (empty($taxonomies)): ?>
                <?=trans('Nie znaleziono żadnych podziałów w języku: ')?>
                <?=render(ROUTES_PATH."/admin/parts/_language.html.php", [
                    'lang' => GC\Staff::getInstance()->getEditorLang(),
                ])?>
            <?php else: ?>
                <table class="table vertical-middle" data-table="">
                    <thead>
                        <tr>
                            <th><!-- Image --></th>
                            <th>
                                <?=$nameCaption?>
                            </th>
                            <th>
                                <?=trans('Adres')?>
                            </th>
                            <th>
                                <?=trans('Podgląd węzłów')?>
                            </th>
                            <th><!-- Buttons --></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($taxonomies as $taxonomy): ?>
                            <?=render(ROUTES_PATH."/admin/frame/parts/_list-taxonomy-item.html.php", $taxonomy)?>
                        <?php endforeach ?>
                    </tbody>
                </table>
            <?php endif ?>
        </div>
        <?php require ROUTES_PATH."/admin/parts/input/_submitButtons.html.php"; ?>
    </div>
</div>

<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="deleteModalForm" method="post" action="<?=$uri->make('/admin/frame/delete')?>" class="modal-content">
            <input name="frame_id" type="hidden" value="">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
                <h2 class="modal-title">
                    <?=trans('Czy na pewno usunąć?')?>
                </h2>
            </div>
            <div class="modal-body">
                <?=trans('Czy jesteś pewien, że chcesz usunąć podział')?>
                <span id="frame_name" style="font-weight:bold; color:red;"></span>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <?=trans('Anuluj')?>
                </button>
                <button type="submit" class="btn btn-danger btn-ok">
                    <?=trans('Usuń')?>
                </button>
            </div>
        </form>
    </div>
</div>

<?php require ROUTES_PATH."/admin/parts/_scripts.html.php"; ?>


<script>
    $(function(){
        $('#deleteModal').on('show.bs.modal', function (event) {
            $(this).find('#frame_name').html($(event.relatedTarget).data('name'));
            $(this).find('[name="frame_id"]').val($(event.relatedTarget).data('id'));
        });
    });
</script>

<?php require ROUTES_PATH."/admin/parts/_end.html.php"; ?>
