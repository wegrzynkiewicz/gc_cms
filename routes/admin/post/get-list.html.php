<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/post/_import.php';

# pobierz liczbę stron
$count = GC\Model\Frame::select()
    ->fields('COUNT(*) AS count')
    ->equals('type', 'post')
    ->equals('lang', GC\Staff::getInstance()->getEditorLang())
    ->fetch()['count'];

?>
<?php require ROUTES_PATH.'/admin/parts/header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="page-header">
            <div class="btn-toolbar pull-right">
                <a href="<?=$uri->mask('/new')?>" type="button" class="btn btn-success btn-md">
                    <i class="fa fa-plus fa-fw"></i>
                    <?=trans('Dodaj nowy wpis')?>
                </a>
            </div>
            <h1><?=($headTitle)?></h1>
        </div>
    </div>
</div>

<?php require ROUTES_PATH.'/admin/parts/breadcrumbs.html.php'; ?>

<div class="row">
    <div class="col-md-12">
        <div class="simple-box table-responsive">
            <?php if ($count == 0): ?>
                <?=trans('Nie znaleziono żadnego wpisu w języku: ')?>
                <?=render(ROUTES_PATH.'/admin/parts/language.html.php', [
                    'lang' => GC\Staff::getInstance()->getEditorLang(),
                ])?>
            <?php else: ?>
                <form action="" method="post" id="form" class="form-horizontal">
                    <div class="">
                    <table class="table vertical-middle" data-table="" style="width:100%">
                        <thead>
                            <tr>
                                <th data-name="image"
                                    data-searchable="0"
                                    data-sortable="0"></th>
                                <th data-name="name"
                                    data-searchable="1"
                                    data-sortable="1">
                                    <?=trans('Nazwa wpisu')?>
                                </th>
                                <th data-name="slug"
                                    data-searchable="1"
                                    data-sortable="1">
                                    <?=trans('Adres strony wpisu')?>
                                </th>
                                <th data-name="options"
                                    data-searchable="0"
                                    data-sortable="0"
                                    class="text-right"></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                </form>
            <?php endif ?>
        </div>
        <?php require ROUTES_PATH.'/admin/parts/input/submitButtons.html.php'; ?>
    </div>
</div>

<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="deleteModalForm" method="post" action="<?=$uri->mask('/delete')?>" class="modal-content">
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
                <?=trans('Czy jesteś pewien, że chcesz usunąć produkt')?>
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

<script id="row-template" type="text/html">
    <td style="width:64px">
        <img src="{{image}}" width="64" height="64"/>
    </td>

    <td>
        <a href="<?=$uri->mask()?>/{{frame_id}}/edit"
            title="<?=trans('Edytuj produkt')?>">
            {{name}}
        </a>
    </td>

    <td>
        <a href="{{href}}"
            target="_blank"
            title="<?=trans('Podejrzyj ten produkt')?>">
            {{slug}}</a>
    </td>

    <td class="text-right">

        <a href="<?=$uri->mask()?>/{{frame_id}}/module/grid"
            title="<?=trans('Wyświetl moduły wpisu')?>"
            class="btn btn-success btn-sm">
            <i class="fa fa-file-text-o fa-fw"></i>
            <?=trans('Moduły')?>
        </a>

        <a data-toggle="modal"
            data-id="{{frame_id}}"
            data-name="{{name}}"
            data-target="#deleteModal"
            title="<?=trans('Usuń produkt')?>"
            class="btn btn-danger btn-sm">
            <i class="fa fa-times fa-fw"></i>
            <?=trans('Usuń')?>
        </a>
    </td>
</script>

<?php require ROUTES_PATH.'/admin/parts/assets/footer.html.php'; ?>

<script>
    $(function(){
        var rowTemplate = $('#row-template').html();
        var table = $('[data-table]').DataTable({
            order: [[1, 'asc']],
            iDisplayLength: <?=$config['dataTable']['iDisplayLength']?>,
	        processing: true,
            serverSide: true,
            searchDelay: 500,
            autoWidth: false,
            ajax: {
                url: '<?=$uri->mask("/xhr-list")?>',
                type: 'GET'
            },
            createdRow: function (row, data, index) {
                $(row).html(Mustache.render(rowTemplate, data));
            },
            columns: [
                {data: "image"},
                {data: "name"},
                {data: "slug"},
            ],
        });

        $('#deleteModal').on('show.bs.modal', function (event) {
            $(this).find('#frame_name').html($(event.relatedTarget).data('name'));
            $(this).find('[name="frame_id"]').val($(event.relatedTarget).data('id'));
        });
    });
</script>

<?php require ROUTES_PATH.'/admin/parts/end.html.php'; ?>
