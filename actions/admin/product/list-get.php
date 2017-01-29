<?php
$count = GC\Model\Product\Product::select()
    ->fields('COUNT(*) AS count')
    ->fetch()['count'];
?>
<?php require ACTIONS_PATH.'/admin/parts/header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="page-header">
            <div class="btn-toolbar pull-right">
                <a href="<?=$uri->mask('/new')?>" type="button" class="btn btn-success btn-md">
                    <i class="fa fa-plus fa-fw"></i>
                    <?=$trans('Dodaj nowy produkt')?>
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
            <?php if ($count == 0): ?>
                <?=$trans('Nie znaleziono żadnego produktu w języku: ')?>
                <?=render(ACTIONS_PATH.'/admin/parts/language.html.php', [
                    'lang' => GC\Auth\Staff::getEditorLang(),
                ])?>
            <?php else: ?>
                <form action="" method="post" id="form" class="form-horizontal">
                    <table class="table vertical-middle" data-table="" style="width:100%">
                        <thead>
                            <tr>
                                <th data-name="image"
                                    data-searchable="0"
                                    data-sortable="0"></th>
                                <th data-name="name"
                                    data-searchable="1"
                                    data-sortable="1">
                                    <?=$trans('Nazwa produktu')?>
                                </th>
                                <th data-name="options"
                                    data-searchable="0"
                                    data-sortable="0"
                                    class="text-right"></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </form>
            <?php endif ?>
        </div>
        <?php require ACTIONS_PATH.'/admin/parts/input/submitButtons.html.php'; ?>
    </div>
</div>

<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="deleteModalForm" method="post" action="<?=$uri->mask('/delete')?>" class="modal-content">
            <input name="product_id" type="hidden" value="">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
                <h2 class="modal-title">
                    <?=$trans('Czy na pewno usunąć?')?>
                </h2>
            </div>
            <div class="modal-body">
                <?=$trans('Czy jesteś pewien, że chcesz usunąć produkt')?>
                <span id="product_name" style="font-weight:bold; color:red;"></span>?
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

<script id="row-template" type="text/html">
    <td style="width:64px">
        <img src="{{image}}" width="64"/>
    </td>

    <td>
        <a href="<?=$uri->mask()?>/{{product_id}}/edit"
            title="<?=$trans('Edytuj stronę')?>">
            {{name}}
        </a>
    </td>

    <td class="text-right">
        <a href="<?=$uri->make("/page")?>/{{product_id}}"
            target="_blank"
            title="<?=$trans('Podejrzyj tą stronę')?>"
            class="btn btn-primary btn-sm">
            <i class="fa fa-search fa-fw"></i>
            <?=$trans('Podgląd')?>
        </a>

        <a href="<?=$uri->mask()?>/{{product_id}}/module/list"
            title="<?=$trans('Wyświetl moduły strony')?>"
            class="btn btn-success btn-sm">
            <i class="fa fa-file-text-o fa-fw"></i>
            <?=$trans('Moduły')?>
        </a>

        <a data-toggle="modal"
            data-id="{{product_id}}"
            data-name="{{name}}"
            data-target="#deleteModal"
            title="<?=$trans('Usuń stronę')?>"
            class="btn btn-danger btn-sm">
            <i class="fa fa-times fa-fw"></i>
            <?=$trans('Usuń')?>
        </a>
    </td>
</script>

<?php require ACTIONS_PATH.'/admin/parts/assets/footer.html.php'; ?>

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
                type: 'POST'
            },
            createdRow: function (row, data, index) {
                $(row).html(Mustache.render(rowTemplate, data));
            },
            columns: [
                {data: "image"},
                {data: "name"},
            ],
        });

        $('#deleteModalForm').on('submit', function(e) {
            e.preventDefault();
            $.post($(this).attr('action'), $(this).serialize(), function() {
                table.ajax.reload();
                $('#deleteModal').modal('hide');
            });
        });

        $('#deleteModal').on('show.bs.modal', function(e) {
            $(this).find('#product_name').html($(e.relatedTarget).data('name'));
            $(this).find('[name="product_id"]').val($(e.relatedTarget).data('id'));
        });
    });
</script>

<?php require ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
