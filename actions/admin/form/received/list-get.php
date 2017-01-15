<?php

$count = GC\Model\Form\Sent::select()
    ->fields('COUNT(*) AS count')
    ->equals('form_id', $form_id)
    ->fetch()
    ['count'];

?>
<?php require ACTIONS_PATH.'/admin/parts/header.html.php'; ?>
<?php require ACTIONS_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-md-12">
        <div class="simple-box">
            <?php if ($count == 0): ?>
                <?=$trans('Nie znaleziono żadnego wysłanego formularza w języku: ')?>
                <?php require ACTIONS_PATH.'/admin/parts/language.html.php'; ?>
            <?php else: ?>
                <form action="" method="post" id="form" class="form-horizontal">
                    <table class="table vertical-middle" data-table="">
                        <thead>
                            <tr>
                                <th data-name="name"
                                    data-searchable="1"
                                    data-sortable="1">
                                    <?=$trans('Pierwsze pole formularza')?>
                                </th>
                                <th data-name="status"
                                    data-searchable="0"
                                    data-sortable="1">
                                    <?=$trans('Status wiadomości')?>
                                </th>
                                <th data-name="sent_datetime"
                                    data-searchable="1"
                                    data-sortable="1">
                                    <?=$trans('Data nadesłania')?>
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
        <form id="deleteModalForm"
            method="post"
            action="<?=GC\Url::mask("/delete")?>"
            class="modal-content">
            <input name="sent_id" type="hidden" value="">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
                <h2 class="modal-title">
                    <?=$trans('Czy na pewno usunąć?')?>
                </h2>
            </div>
            <div class="modal-body">
                <?=$trans('Czy jesteś pewien, że chcesz usunąć nadesłany formularz')?>
                <span id="sent_name" style="font-weight:bold; color:red;"></span>?
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

<script id="options-template" type="text/html">
    <div class="text-right">
        <a href="<?=GC\Url::mask("/")?>{{sent_id}}/show"
            class="btn btn-primary btn-sm">
            <i class="fa fa-search fa-fw"></i>
            <?=$trans('Podgląd')?>
        </a>

        <a data-toggle="modal"
            data-id="{{sent_id}}"
            data-name="{{name}}"
            data-target="#deleteModal"
            title="<?=$trans('Usuń wiadomość')?>"
            class="btn btn-danger btn-sm">
            <i class="fa fa-times fa-fw"></i>
            <?=$trans('Usuń')?>
        </a>
    </div>
</script>

<?php require ACTIONS_PATH.'/admin/parts/assets/footer.html.php'; ?>

<script>
    $(function(){
        var optionsTemplate = $('#options-template').html();
        var statuses = <?=json_encode($config['formStatuses'])?>;
        var table = $('[data-table]').DataTable({
            order: [[2, 'desc']],
            iDisplayLength: <?=$config['dataTable']['iDisplayLength']?>,
	        processing: true,
            serverSide: true,
            searchDelay: 500,
            ajax: {
                url: '<?=GC\Url::mask("/xhr-list")?>',
                type: 'POST'
            },
            createdRow: function (row, data, index) {
                $(row).addClass(statuses[data['status']]['class']);
            },
            columns: [
                {data: "name"},
                {
                    data: "status",
                    render: function (data, type, row) {
                        return statuses[row['status']]['name'];
                    }
                },
                {data: "sent_datetime"},
                {
                    data: 'options',
                    render: function (data, type, row) {
                        return Mustache.render(optionsTemplate, row);
                    }
                }
            ]
        });

        $('#deleteModalForm').on('submit', function(e) {
            e.preventDefault();
            $.post($(this).attr('action'), $(this).serialize(), function() {
                table.ajax.reload();
                $('#deleteModal').modal('hide');
            });
        });

        $('#deleteModal').on('show.bs.modal', function(e) {
            $(this).find('#sent_name').html($(e.relatedTarget).data('name'));
            $(this).find('[name="sent_id"]').val($(e.relatedTarget).data('id'));
        });
    });
</script>

<?php require ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
