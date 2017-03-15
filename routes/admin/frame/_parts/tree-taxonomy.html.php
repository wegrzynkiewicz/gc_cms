<?php require ROUTES_PATH.'/admin/_parts/header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="page-header">
            <div class="btn-toolbar pull-right">
                <a href="<?=$addHref?>" type="button" class="btn btn-success">
                    <i class="fa fa-plus fa-fw"></i>
                    <?=trans('Dodaj nowy węzeł')?>
                </a>
            </div>
            <h1><?=$headTitle?></h1>
        </div>
    </div>
</div>

<?php require ROUTES_PATH.'/admin/_parts/breadcrumbs.html.php'; ?>

<div class="row">
    <div class="col-md-12">
        <form id="savePosition" action="" method="post">
            <input name="positions" type="hidden"/>
            <?php if ($tree and $tree->hasChildren()):?>
                <ol id="sortable" class="sortable">
                    <?php foreach ($tree->getChildren() as $node): ?>
                        <?=render(ROUTES_PATH.'/admin/frame/_parts/tree-taxonomy-node.html.php', $node->getData())?>
                    <?php endforeach?>
                </ol>
            <?php else:?>
                <div class="simple-box">
                    <?=trans('Nie znaleziono żadnych węzłów')?>
                </div>
            <?php endif?>

            <?=render(ROUTES_PATH.'/admin/_parts/input/submitButtons.html.php', [
                'saveLabel' => $tree->hasChildren() ? trans('Zapisz pozycję') : null,
            ])?>
        </form>
    </div>
</div>

<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="deleteModalForm"
            method="post"
            action="<?=$uri->mask('/delete')?>"
            class="modal-content">
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
                <?=trans('Czy jesteś pewien, że chcesz usunąć węzeł')?>
                <span id="node_name" style="font-weight:bold; color:red;"></span>
                <?=trans('i wszystkie jego podwęzły?')?>?
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

<?php require ROUTES_PATH.'/admin/_parts/assets/footer.html.php'; ?>

<script>
$(function(){
    $('#sortable').nestedSortable({
        handle: 'div',
        items: 'li',
        toleranceElement: '> div',
        excludeRoot: true,
    });

    $("#savePosition").submit(function(event) {
        var sortabled = $('#sortable').nestedSortable('toArray');
        $('[name=positions]').val(JSON.stringify(sortabled));
   });

   $('#deleteModal').on('show.bs.modal', function (event) {
       $(this).find('#node_name').html($(event.relatedTarget).data('name'));
       $(this).find('[name="frame_id"]').val($(event.relatedTarget).data('id'));
   });
});
</script>

<?php require ROUTES_PATH.'/admin/_parts/end.html.php'; ?>
