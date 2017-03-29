<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/navigation/_import.php';

# pobierz wszystkie posortowane nawigacje z języka
$navigations = GC\Model\Navigation::select()
    ->equals('lang', GC\Staff::getInstance()->getEditorLang())
    ->order('name', 'ASC')
    ->fetchByPrimaryKey();

# pobierz wszystkie węzły przygotowane do budowy drzewa
$nodes = GC\Model\Navigation\Node::select()
    ->fields('::withFrameFields, navigation_id')
    ->source('::withFrameSource')
    ->order('position', 'ASC')
    ->fetchAll();

# umieść każdy węzeły dla konkretnych nawigacji
$navigationNodes = [];
foreach ($nodes as $node) {
    $navigationNodes[$node['navigation_id']][] = $node;
}

# zbuduj drzewa dla konkretnych nawigacji
foreach ($navigations as $navigation_id => &$navigation) {
    $navigation['tree'] = isset($navigationNodes[$navigation_id])
        ? GC\Model\Navigation\Node::createTree($navigationNodes[$navigation_id])
        : null;
}
unset($navigation);

?>
<?php require ROUTES_PATH.'/admin/_parts/header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="page-header">
            <div class="btn-toolbar pull-right">
                <a href="<?=$uri->make('/admin/navigation/new')?>" type="button" class="btn btn-success btn-md">
                    <i class="fa fa-plus fa-fw"></i>
                    <?=trans('Dodaj nową nawigację')?>
                </a>
            </div>
            <h1><?=$headTitle?></h1>
        </div>
    </div>
</div>

<?php require ROUTES_PATH.'/admin/_parts/breadcrumbs.html.php'; ?>

<div class="row">
    <div class="col-md-12">
        <div class="simple-box">
            <?php if (empty($navigations)): ?>
                <?=trans('Nie znaleziono żadnej nawigacji w języku: ')?>
                <?=render(ROUTES_PATH.'/admin/_parts/language.html.php', [
                    'lang' => GC\Staff::getInstance()->getEditorLang(),
                ])?>
            <?php else: ?>
                <table class="table vertical-middle" data-table="">
                    <thead>
                        <tr>
                            <th><?=trans('Nazwa nawigacji')?></th>
                            <th><?=trans('Podgląd węzłów')?></th>
                            <th class="text-right"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($navigations as $navigation_id => $navigation): ?>
                            <?=render(ROUTES_PATH.'/admin/navigation/_list-item.html.php', $navigation)?>
                        <?php endforeach ?>
                    </tbody>
                </table>
            <?php endif ?>
        </div>
        <?php require ROUTES_PATH.'/admin/_parts/input/submitButtons.html.php'; ?>
    </div>
</div>

<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="deleteModalForm" method="post" action="<?=$uri->make('/admin/navigation/delete')?>" class="modal-content">
            <input name="navigation_id" type="hidden" value="">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
                <h2 class="modal-title">
                    <?=trans('Czy na pewno usunąć?')?>
                </h2>
            </div>
            <div class="modal-body">
                <?=trans('Czy jesteś pewien, że chcesz usunąć nawigację')?>
                <span id="navigation_name" style="font-weight:bold; color:red;"></span>?
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
        $('#deleteModal').on('show.bs.modal', function (event) {
            $(this).find('#navigation_name').html($(event.relatedTarget).data('name'));
            $(this).find('[name="navigation_id"]').val($(event.relatedTarget).data('id'));
        });
    });
</script>

<?php require ROUTES_PATH.'/admin/_parts/end.html.php'; ?>
