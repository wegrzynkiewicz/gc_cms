<?php

$form_id = intval(array_shift($_SEGMENTS));

$count = GC\Model\FormSent::countBy('form_id', $form_id);

require_once ACTIONS_PATH.'/admin/parts/header.html.php';
require_once ACTIONS_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-md-12">
        <div class="simple-box">
            <?php if ($count == 0): ?>
                <?=trans('Nie znaleziono żadnego wysłanego formularza w języku: ')?>
                <?=view('/admin/parts/language.html.php')?>
            <?php else: ?>
                <form action="" method="post" id="form" class="form-horizontal">
                    <table class="table vertical-middle" data-table="">
                        <thead>
                            <tr>
                                <th data-name="name"
                                    data-searchable="1"
                                    data-sortable="1">
                                    <?=trans('Pierwsze pole formularza')?>
                                </th>
                                <th data-name="status"
                                    data-searchable="0"
                                    data-sortable="1">
                                    <?=trans('Status wiadomości')?>
                                </th>
                                <th data-name="sent_date"
                                    data-searchable="1"
                                    data-sortable="1">
                                    <?=trans('Data nadesłania')?>
                                </th>
                                <th data-name="options"
                                    data-searchable="0"
                                    data-sortable="0"
                                    class="text-right"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ([] as $sent_id => $message): ?>
                                <?=view('/admin/form/received/list-item.html.php', [
                                    'sent_id' => $sent_id,
                                    'form_id' => $form_id,
                                    'message' => $message,
                                    'config' => $config,
                                ])?>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </form>
            <?php endif ?>
        </div>
        <?=view('/admin/parts/input/submitButtons.html.php')?>
    </div>
</div>

<?php require_once ACTIONS_PATH.'/admin/parts/footer-assets.html.php'; ?>

<script id="options-template" type="text/html">
    <div class="text-right">
        <a href="<?=url("/admin/form/received/show")?>/{{sent_id}}/<?=$form_id?>"
            class="btn btn-primary btn-sm">
            <i class="fa fa-search fa-fw"></i>
            <?=trans('Podgląd')?>
        </a>

        <a data-toggle="modal"
            data-id="{{sent_id}}"
            data-name="{{name}}"
            data-target="#deleteModal"
            title="<?=trans('Usuń wiadomość')?>"
            class="btn btn-danger btn-sm">
            <i class="fa fa-times fa-fw"></i>
            <?=trans("Usuń")?>
        </a>
    </div>
</script>

<script>
    $(function(){
        var optionsTemplate = $('#options-template').html();
        var statuses = <?=json_encode($config['formStatuses'])?>;
        var table = $('[data-table]').DataTable({
            order: [[2, 'desc']],
	        processing: true,
            serverSide: true,
            searchDelay: 500,
            ajax: {
                url: '<?=url("/admin/form/received/xhr_get/$form_id")?>',
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
                {data: "sent_date"},
                {
                    data: 'options',
                    render: function (data, type, row) {
                        return Mustache.render(optionsTemplate, row);
                    }
                }
            ]
        })
    });
</script>

<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
