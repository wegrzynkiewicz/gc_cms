<?php

$headTitle = trans("Wszystkie wpisy");

$staff = GC\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

$posts = GC\Model\Post::selectAllWithFrames();
$package = GC\Model\PostNode::selectAllWithTaxonomyId();
$taxonomies = GC\Model\PostTaxonomy::selectAllCorrectWithPrimaryKey();

foreach ($package as $stack) {
    $posts[$stack['post_id']]['taxonomies'][$stack['tax_id']][] = $stack;
}
foreach ($posts as &$post) {
    if (!isset($post['taxonomies'])) {
        $post['tree_taxonomies'] = [];
        continue;
    }
    foreach ($post['taxonomies'] as $tax_id => $taxonomy) {
        $tree = GC\Model\PostNode::createTree($taxonomy);
        $post['tree_taxonomies'][$tax_id] = $tree;
    }
}
unset($post);

require_once ACTIONS_PATH.'/admin/parts/header.html.php'; ?>

<div class="row">
    <div class="col-lg-8 text-left">
        <h1 class="page-header">
            <?=$headTitle?>
        </h1>
    </div>
    <div class="col-lg-4 text-right">
        <h1 class="page-header">
            <a href="<?=url("/admin/post/new")?>" type="button" class="btn btn-success">
                <i class="fa fa-plus fa-fw"></i>
                <?=trans('Dodaj nowy wpis')?>
            </a>
        </h1>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <?php if (empty($posts)): ?>
            <p>
                <?=trans('Nie znaleziono żadnych wpisów w języku: ')?>
                <?=view('/admin/parts/language.html.php')?>
            </p>
        <?php else: ?>
            <table class="table vertical-middle" data-table="">
                <thead>
                    <tr>
                        <th>
                            <?=trans('Nazwa wpisu')?>
                        </th>
                        <th>
                            <?=trans('Podziały według')?>
                        </th>
                        <th class="text-right"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $post_id => $post): ?>
                        <tr>
                            <td>
                                <?php if ($post['image']): ?>
                                    <img src="<?=GC\Thumb::make($post['image'], 64, 64)?>" height="64" style="margin-right:5px"/>
                                <?php endif ?>
                                <a href="<?=url("/admin/post/edit/$post_id")?>"
                                    title="<?=trans('Edytuj wpis')?>">
                                    <?=$post['name']?>
                                </a>
                            </td>
                            <td>
                                <?php if (empty($post['tree_taxonomies'])): ?>
                                    <?=trans('Ten wpis nie został nigdzie przypisany')?>
                                <?php else: ?>
                                    <?php foreach($post['tree_taxonomies'] as $tax_id => $tree): ?>
                                        <a href="<?=url("/admin/post/node/list/$tax_id")?>"
                                            title="<?=trans('Przejdź do podziału')?>">
                                            <strong>
                                                <?=$taxonomies[$tax_id]['name']?>:
                                            </strong>
                                        </a>
                                        <?=view('/admin/post/list-tax-preview.html.php', [
                                            'category' => $tree,
                                            'tax_id' => $tax_id,
                                        ])?>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </td>
                            <td class="text-right">
                                <a href="<?=url("/admin/post/module/list/$post_id")?>"
                                    title="<?=trans('Wyświetl moduły wpisu')?>"
                                    class="btn btn-success btn-sm">
                                    <i class="fa fa-file-text-o fa-fw"></i>
                                    <?=trans("Moduły")?>
                                </a>

                                <a data-toggle="modal"
                                    data-id="<?=$post_id?>"
                                    data-name="<?=$post['name']?>"
                                    data-target="#deleteModal"
                                    title="<?=trans('Usuń wpis')?>"
                                    class="btn btn-danger btn-sm">
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
        <form id="deleteModalForm" method="post" action="<?=url("/admin/post/delete")?>" class="modal-content">
            <input name="post_id" type="hidden" value="">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
                <h2 class="modal-title">
                    <?=trans("Czy na pewno usunąć?")?>
                </h2>
            </div>
            <div class="modal-body">
                <?=trans("Czy jesteś pewien, że chcesz usunąć wpis")?>
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
            $(this).find('[name="post_id"]').val($(e.relatedTarget).data('id'));
        });
        $('[data-table]').DataTable();
    });
</script>

<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
