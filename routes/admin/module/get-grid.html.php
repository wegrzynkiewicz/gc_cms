<?php

require ROUTES_PATH.'/admin/_import.php';

$frame_id = intval(array_shift($_PARAMETERS));

# pobierz rusztowanie po kluczu głównym
$frame = GC\Model\Frame::select()
    ->equals('frame_id', $frame_id)
    ->fetch();

require ROUTES_PATH."/admin/module/_breadcrumbs-loop.php";

$headTitle = $breadcrumbs->getLast()['name'];

# pobierz moduły wraz z pozycjami grida dla rusztowania $frame_id
$modules = GC\Model\Module::select()
    ->source('::grid')
    ->equals('frame_id', $frame_id)
    ->fetchByPrimaryKey();

$metas = GC\Model\Module\Meta::select()
    ->source('::forFrameModules')
    ->equals('frame_id', $frame_id)
    ->fetchAll();

foreach ($metas as $meta) {
    $modules[$meta['module_id']]['meta'][$meta['name']] = $meta['value'];
}

?>
<?php require ROUTES_PATH.'/admin/_parts/header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="page-header">
            <div class="btn-toolbar pull-right">
                <a href="<?=$uri->make($frame['slug'])?>"
                    target="_blank"
                    type="button"
                    class="btn btn-primary">
                    <i class="fa fa-search fa-fw"></i>
                    <?=trans('Podgląd')?>
                </a>
                <a href="<?=$uri->make("/admin/module/new/{$frame_id}")?>"
                    type="button"
                    class="btn btn-success">
                    <i class="fa fa-plus fa-fw"></i>
                    <?=trans('Dodaj nowy moduł')?>
                </a>
            </div>
            <h1><?=$headTitle?></h1>
        </div>
    </div>
</div>

<?php require ROUTES_PATH.'/admin/_parts/breadcrumbs.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form id="gridForm" action="" method="post" class="form-horizontal">
            <input type="hidden" name="grid">
            <?php if (empty($modules)): ?>
                <div class="simple-box">
                    <?=trans('Nie znaleziono żadnego modułu.')?>
                </div>
            <?php else: ?>
                <div class="grid-with-rows">
                    <div id="grid-rows-wrapper"></div>
                    <div class="grid-stack">
                        <?php foreach ($modules as $module_id => $module): ?>
                            <?=render(ROUTES_PATH.'/admin/module/_grid-item.html.php', $module)?>
                        <?php endforeach ?>
                    </div>
                </div>
            <?php endif ?>

            <?=render(ROUTES_PATH.'/admin/_parts/input/submitButtons.html.php', [
                'saveLabel' => empty($modules) ? null : trans('Zapisz pozycje kafelków'),
            ])?>

        </form>
    </div>
</div>

<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="deleteModalForm" method="post" action="<?=$uri->make('/admin/module/delete')?>" class="modal-content">
            <input name="module_id" type="hidden" value="">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
                <h2 class="modal-title">
                    <?=trans('Czy na pewno usunąć?')?>
                </h2>
            </div>
            <div class="modal-body">
                <?=trans('Czy jesteś pewien, że chcesz usunąć ten moduł?')?>
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

<div id="rowSettingsModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="rowSettingsModalForm" method="post" action="" class="modal-content form-horizontal">
            <input name="module_id" type="hidden" value="">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
                <h2 class="modal-title">
                    <?=trans('Ustawienia wiersza')?>
                </h2>
            </div>
            <div id="rowSettingsModalContent" class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <?=trans('Anuluj')?>
                </button>
                <button type="submit" class="btn btn-success btn-ok">
                    <?=trans('Zapisz')?>
                </button>
            </div>
        </form>
    </div>
</div>

<script id="grid-row-settings" type="text/html">
    <div class="grid-row-settings-container" style="top: {{top}}px;">
        <a href="#"
            data-toggle="modal"
            data-y="{{y}}"
            data-target="#rowSettingsModal"
            title="<?=trans('Ustawienia wiersza')?>"
            class="simple-box grid-row-settings-item">
            <i class="fa fa-gear fa-fw"></i>
        </a>

        {{#gutter}}
        <span class="simple-box grid-row-settings-item">{{gutter}}</span>
        {{/gutter}}

        {{#bg_color}}
        <span class="simple-box grid-row-settings-item"
            style="background-color: {{bg_color}};"></span>
        {{/bg_color}}

        {{#bg_image}}
        <span class="simple-box grid-row-settings-item"
            style="background-image: url('{{thumbnail}}');"></span>
        {{/bg_image}}
    </div>
</script>

<?php require ROUTES_PATH.'/admin/_parts/assets/footer.html.php'; ?>

<script>
    var rowSettingsTemplate = $('#grid-row-settings').html();
    var editRowUri = "<?=$uri->make("/admin/module/row/edit/{$frame_id}")?>/";
    var listRowsUri = "<?=$uri->make("/admin/module/row/{$frame_id}/list.json")?>";

    $('#deleteModal').on('show.bs.modal', function (event) {
        $(this).find('[name="module_id"]').val($(event.relatedTarget).data('id'));
    });

    var grid = $('.grid-stack').gridstack({
        cellHeight: 215,
        verticalMargin: 20
    }).on('change', refreshRows).data('gridstack');

    function refreshRows() {
        if (!grid) {
            return;
        }
        $.get(listRowsUri, function(rows) {
            var y = 0;
            var content = '';
            $('#grid-rows-wrapper').html();
            while (!grid.isAreaEmpty(0, y, 12, 1)) {
                var row = {
                    y: y,
                    top: (y*215)+(y*20),
                };
                row = $.extend(row, rows[y]);
                content += Mustache.render(rowSettingsTemplate, row);
                y++;
            }
            $('#grid-rows-wrapper').html(content);
        });
    }

    refreshRows();

    $('#rowSettingsModalForm').on('submit', function (event) {
        event.preventDefault();
        $.post($(this).attr('action'), $(this).serialize(), function() {
            $('#rowSettingsModal').modal('hide');
            refreshRows();
        });
    });

    $('#rowSettingsModal').on('show.bs.modal', function (event) {
        var url = editRowUri + $(event.relatedTarget).data('y');
        $.get(url, function(data) {
            $('#rowSettingsModalContent').html(data);
            $('#rowSettingsModalForm').attr('action', url);
        });
    });

    $("#gridForm").submit(function(event) {
        var serializedData = _.map($('.grid-stack .grid-stack-item:visible'), function (el) {
            el = $(el);
            var node = el.data('_gridstack_node');
            return {
                id: el.attr('data-id'),
                x: node.x,
                y: node.y,
                width: node.width,
                height: node.height
            };
        });
        $('[name="grid"]').val(JSON.stringify(serializedData));
    });

</script>

<?php require ROUTES_PATH.'/admin/_parts/end.html.php'; ?>
