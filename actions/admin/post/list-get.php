<?php

$posts = GC\Model\Post\Post::selectAllWithFrames();
$nodes = GC\Model\Post\Node::selectAllForTaxonomyTree();
$taxonomies = GC\Model\Post\Taxonomy::selectAllCorrectWithPrimaryKey();

foreach ($nodes as $node) {
    $posts[$node['post_id']]['taxonomies'][$node['tax_id']][] = $node;
}
foreach ($posts as &$post) {
    if (isset($post['taxonomies'])) {
        foreach ($post['taxonomies'] as $tax_id => $taxonomy) {
            $post['taxonomies'][$tax_id] = GC\Model\Post\Node::createTree($taxonomy);
        }
    }
}
unset($post);

require ACTIONS_PATH.'/admin/parts/header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="page-header">
            <div class="btn-toolbar pull-right">
                <a href="<?=GC\Url::mask('/new')?>" type="button" class="btn btn-success btn-md">
                    <i class="fa fa-plus fa-fw"></i>
                    <?=trans('Dodaj nowy wpis')?>
                </a>
            </div>
            <h1><?=($headTitle)?></h1>
        </div>
    </div>
</div>

<?php require ACTIONS_PATH.'/admin/parts/breadcrumbs.html.php'; ?>

<div class="row">
    <div class="col-md-12">
        <div class="simple-box">
            <?php if (empty($posts)): ?>
                <?=trans('Nie znaleziono żadnych wpisów w języku: ')?>
                <?=GC\Render::action('/admin/parts/language.html.php')?>
            <?php else: ?>
                <table class="table vertical-middle" data-table="">
                    <thead>
                        <tr>
                            <th style="width:1px">
                                <?=trans('Zdjęcie')?>
                            </th>
                            <th>
                                <?=trans('Nazwa wpisu')?>
                            </th>
                            <th>
                                <?=trans('Data i czas publikacji')?>
                            </th>
                            <th>
                                <?=trans('Podziały')?>
                            </th>
                            <th class="text-right"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($posts as $post_id => $post): ?>
                            <?=GC\Render::action('/admin/post/list-item.html.php', [
                                'post_id' => $post_id,
                                'post' => $post,
                                'taxonomies' => $taxonomies,
                            ])?>
                        <?php endforeach ?>
                    </tbody>
                </table>
            <?php endif ?>
        </div>
        <?=GC\Render::action('/admin/parts/input/submitButtons.html.php')?>
    </div>
</div>

<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="deleteModalForm" method="post" action="<?=GC\Url::mask('/delete')?>" class="modal-content">
            <input name="post_id" type="hidden" value="">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
                <h2 class="modal-title">
                    <?=trans("Czy na pewno usunąć?")?>
                </h2>
            </div>
            <div class="modal-body">
                <?=trans("Czy jesteś pewien, że chcesz usunąć wpis")?>
                <span id="post_name" style="font-weight:bold; color:red;"></span>?
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

<?php require ACTIONS_PATH.'/admin/parts/assets/footer.html.php'; ?>

<script>
    $(function(){
        $('#deleteModal').on('show.bs.modal', function(e) {
            $(this).find('#post_name').html($(e.relatedTarget).data('name'));
            $(this).find('[name="post_id"]').val($(e.relatedTarget).data('id'));
        });
        $('[data-table]').DataTable({
            order: [[2, 'desc']]
        });
    });
</script>

<?php require ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
