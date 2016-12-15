<?php

$headTitle = trans("Węzły w");

$staff = GrafCenter\CMS\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

$tax_id = intval(array_shift($_SEGMENTS));

if (wasSentPost()) {
    $positions = json_decode($_POST['positions'], true);
    $positions = array_filter($positions, function ($node) {
        return isset($node['id']);
    });
    GrafCenter\CMS\Model\PostTree::update($tax_id, $positions);
    redirect("/admin/post/taxonomy/list");
}

$taxonomy = GrafCenter\CMS\Model\PostTaxonomy::selectByPrimaryId($tax_id);
$category = GrafCenter\CMS\Model\PostNode::buildTreeByTaxonomyId($tax_id);

$headTitle .= makeLink("/admin/post/taxonomy/list", $taxonomy['name']);

require_once ACTIONS_PATH.'/admin/parts/header.html.php'; ?>

<div class="row">
    <div class="col-lg-8 text-left">
        <h1 class="page-header">
            <?=$headTitle?>
        </h1>
    </div>
    <div class="col-lg-4 text-right">
        <h1 class="page-header">
            <a href="<?=url("/admin/post/node/new/$tax_id")?>" type="button" class="btn btn-success">
                <i class="fa fa-plus fa-fw"></i>
                <?=trans('Dodaj nowy węzeł')?>
            </a>
        </h1>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <?php if ($category->hasChildren()):?>
            <ol id="sortable" class="sortable">
                <?=view('/admin/post/node/list-item.html.php', [
                    'category' => $category,
                    'tax_id' => $tax_id,
                ])?>
            </ol>
        <?php else:?>
            <p>
                <?=trans('Brak węzłów w %s', [$taxonomy['name']])?>
            </p>
        <?php endif?>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <form id="savePosition" action="" method="post">

            <input name="positions" type="hidden"/>

            <?=view('/admin/parts/input/submitButtons.html.php', [
                'cancelHref' => "/admin/post/taxonomy/list",
                'saveLabel' => 'Zapisz pozycję',
            ])?>

        </form>
    </div>
</div>

<?php require_once ACTIONS_PATH.'/admin/parts/assets.html.php'; ?>

<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="deleteModalForm" method="post" action="<?=url("/admin/nav/menu/delete/$tax_id")?>" class="modal-content">
            <input name="node_id" type="hidden" value="">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
                <h2 class="modal-title">
                    <?=trans("Czy na pewno usunąć?")?>
                </h2>
            </div>
            <div class="modal-body">
                <?=trans("Czy jesteś pewien, że chcesz usunąć węzeł")?>
                <span id="name" style="font-weight:bold; color:red;"></span>
                <?=trans("i wszystkie jego podwęzły?")?>?
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
    $('#deleteModal').on('show.bs.modal', function(e) {
        $(this).find('#name').html($(e.relatedTarget).data('name'));
        $(this).find('[name="node_id"]').val($(e.relatedTarget).data('id'));
    });
</script>

<script>
$(function(){
    $('#sortable').nestedSortable({
        handle: 'div',
        items: 'li',
        toleranceElement: '> div'
    });

    $("#savePosition").submit(function(event) {
        var sortabled = $('#sortable').nestedSortable('toArray');
        $('[name=positions]').val(JSON.stringify(sortabled));
   });

});
</script>

<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
