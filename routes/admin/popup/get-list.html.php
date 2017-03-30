<?php

require ROUTES_PATH."/admin/_import.php";
require ROUTES_PATH."/admin/_breadcrumbs.php";
require ROUTES_PATH."/admin/popup/_import.php";

# pobierz liczbę wyskakujących okienek
$count = GC\Model\PopUp\PopUp::select()
    ->fields('COUNT(*) AS count')
    ->equals('lang', GC\Staff::getInstance()->getEditorLang())
    ->fetch()['count'];

?>
<?php require ROUTES_PATH."/admin/parts/_header.html.php"; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="page-header">
            <div class="btn-toolbar pull-right">
                <a href="<?=$uri->make('/admin/popup/new')?>" type="button" class="btn btn-success btn-md">
                    <i class="fa fa-plus fa-fw"></i>
                    <?=trans('Dodaj nowe wyskakujące okienko')?>
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
            <?php if ($count == 0): ?>
                <?=trans('Nie znaleziono żadnego wyskakującego okienka w języku: ')?>
                <?=render(ROUTES_PATH."/admin/parts/_language.html.php", [
                    'lang' => GC\Staff::getInstance()->getEditorLang(),
                ])?>
            <?php else: ?>
                <form action="<?=$request->uri?>" method="post" id="form" class="form-horizontal">
                    <table class="table vertical-middle" data-table="" style="width:100%">
                        <thead>
                            <tr>
                                <th data-name="name"
                                    data-searchable="1"
                                    data-sortable="1">
                                    <?=trans('Nazwa okienka')?>
                                </th>
                                <th data-name="type"
                                    data-searchable="0"
                                    data-sortable="0">
                                    <?=trans('Typ okienka')?>
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
        <?php require ROUTES_PATH."/admin/parts/input/_submitButtons.html.php"; ?>
    </div>
</div>

<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="deleteModalForm" method="post" action="<?=$uri->make('/admin/popup/delete')?>" class="modal-content">
            <input name="popup_id" type="hidden" value="">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
                <h2 class="modal-title">
                    <?=trans('Czy na pewno usunąć?')?>
                </h2>
            </div>
            <div class="modal-body">
                <?=trans('Czy jesteś pewien, że chcesz usunąć wyskakujące okienko')?>
                <span id="popup_name" style="font-weight:bold; color:red;"></span>?
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
    <td>
        <a href="<?=$uri->make('/admin/popup')?>/{{popup_id}}/edit"
            title="<?=trans('Edytuj wyskakujące okienko')?>">
            {{name}}
        </a>
    </td>

    <td>
        {{typeName}}
    </td>

    <td class="text-right">
        <a data-toggle="modal"
            data-id="{{popup_id}}"
            data-name="{{name}}"
            data-target="#deleteModal"
            title="<?=trans('Usuń wyskakujące okienko')?> - {{name}}"
            class="btn btn-danger btn-sm">
            <i class="fa fa-times fa-fw"></i>
            <?=trans('Usuń')?>
        </a>
    </td>
</script>

<?php require ROUTES_PATH."/admin/parts/_scripts.html.php"; ?>

<script>
    $(function(){
        var rowTemplate = $('#row-template').html();
        var table = $('[data-table]').DataTable({
            order: [[0, 'asc']],
            iDisplayLength: <?=$config['dataTable']['iDisplayLength']?>,
	        processing: true,
            serverSide: true,
            searchDelay: 500,
            autoWidth: false,
            ajax: {
                url: '<?=$uri->make("/admin/popup/list.json")?>',
                type: 'POST'
            },
            createdRow: function (row, data, index) {
                $(row).html(Mustache.render(rowTemplate, data));
            },
            columns: [
                {data: "name"},
                {data: "type"},
            ],
        });

        $('#deleteModal').on('show.bs.modal', function (event) {
            $(this).find('#popup_name').html($(event.relatedTarget).data('name'));
            $(this).find('[name="popup_id"]').val($(event.relatedTarget).data('id'));
        });
    });
</script>

<?php require ROUTES_PATH."/admin/parts/_end.html.php"; ?>
