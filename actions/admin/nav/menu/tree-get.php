<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/nav/_import.php';
require ACTIONS_PATH.'/admin/nav/menu/_import.php';

# pobierz węzły nawigacji i zbuduj z nich drzewo
$tree = GC\Model\Menu\Menu::select()
    ->fields('::fields')
    ->source('::tree_frame')
    ->equals('nav_id', $nav_id)
    ->fetchTree();

?>
<?php require ACTIONS_PATH.'/admin/parts/header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="page-header">
            <div class="btn-toolbar pull-right">
                <a href="<?=$uri->mask('/new')?>" type="button" class="btn btn-success">
                    <i class="fa fa-plus fa-fw"></i>
                    <?=$trans('Dodaj nowy węzeł')?>
                </a>
            </div>
            <h1><?=($headTitle)?></h1>
        </div>
    </div>
</div>

<?php require ACTIONS_PATH.'/admin/parts/breadcrumbs.html.php'; ?>

<div class="row">
    <div class="col-md-12">
        <form id="savePosition" action="" method="post">
            <input name="positions" type="hidden"/>

            <?php if ($tree->hasChildren()):?>
                <ol id="sortable" class="sortable">
                    <?php foreach ($tree->getChildren() as $node): ?>
                        <?=render(ACTIONS_PATH.'/admin/nav/menu/tree-item.html.php', [
                            'node' => $node,
                        ])?>
                    <?php endforeach ?>
                </ol>
            <?php else:?>
                <div class="simple-box">
                    <?=$trans('Brak węzłów nawigacji')?>
                </div>
            <?php endif?>

            <?=render(ACTIONS_PATH.'/admin/parts/input/submitButtons.html.php', [
                'saveLabel' => $trans('Zapisz pozycję'),
            ])?>

        </form>
    </div>
</div>

<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="deleteModalForm" method="post" action="<?=$uri->mask("/delete")?>" class="modal-content">
            <input name="menu_id" type="hidden" value="">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
                <h2 class="modal-title">
                    <?=$trans('Czy na pewno usunąć?')?>
                </h2>
            </div>
            <div class="modal-body">
                <?=$trans('Czy jesteś pewien, że chcesz usunąć węzeł')?>
                <span id="name" style="font-weight:bold; color:red;"></span>
                <?=$trans('i wszystkie jego podwęzły?')?>?
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
    $('#deleteModal').on('show.bs.modal', function(e) {
        $(this).find('#name').html($(e.relatedTarget).data('name'));
        $(this).find('[name="menu_id"]').val($(e.relatedTarget).data('id'));
    });
</script>

<script>
$(function(){
    $('#sortable').nestedSortable({
        handle: 'div',
        items: 'li',
        toleranceElement: '> div',
        maxLevels: <?=$nav['maxlevels']?>
    });

    $("#savePosition").submit(function(event) {
        var sortabled = $('#sortable').nestedSortable('toArray');
        $('[name=positions]').val(JSON.stringify(sortabled));
   });

});
</script>

<?php require ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
