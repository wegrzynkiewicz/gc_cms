<?php

require ROUTES_PATH."/admin/module/type/see-also/_import.php";

$tabs = GC\Model\Module\Tab::select()
    ->source('::frame')
    ->equals('module_id', $module_id)
    ->fetchByKey('frame_id');

# pobierz wszystkie rusztowania i dopisz typ do nazwy
$frames = GC\Model\Frame::select()
    ->fields(['frame_id', 'name', 'type'])
    ->equals('lang', GC\Staff::getInstance()->getEditorLang())
    ->fetchByPrimaryKey();

foreach ($frames as &$frame) {
    $frame = sprintf('%s - %s', $frame['name'], $config['frames'][$frame['type']]['name']);
}
unset($frame);

?>
<?php require ROUTES_PATH.'/admin/_parts/header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="page-header">
            <div class="btn-toolbar pull-right">
                <button
                    data-toggle="modal"
                    data-target="#addModal"
                    class="btn btn-success">
                    <i class="fa fa-plus fa-fw"></i>
                    <?=trans('Dodaj')?>
                </button>
            </div>
            <h1><?=$headTitle?></h1>
        </div>
    </div>
</div>

<?php require ROUTES_PATH.'/admin/_parts/breadcrumbs.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form id="saveForm" action="" method="post">
            <input type="hidden" name="positions">

            <div class="simple-box">
                <fieldset>
                    <legend><?=trans('Ustawienia modułu')?></legend>

                    <?=render(ROUTES_PATH.'/admin/_parts/input/editbox.html.php', [
                        'name' => 'content',
                        'label' => trans('Nazwa'),
                        'help' => trans('Będzie wyświetlana nad boksem (np. Polecane produkty, Zobacz także)'),
                    ])?>

                    <?=render(ROUTES_PATH.'/admin/_parts/input/selectbox.html.php', [
                        'name' => 'theme',
                        'label' => trans('Szablon'),
                        'help' => trans('Szablon określa wygląd i zachowanie modułu'),
                        'options' => array_trans($config['modules']['see-also']['themes']),
                        'firstOption' => trans('Wybierz jeden z dostępnych szablonów modułu'),
                    ])?>
                </fieldset>
            </div>

            <div id="moduleTheme"></div>

            <h3><?=trans('Strony')?></h3>

            <?php if (empty($tabs)): ?>
                <div class="simple-box">
                    <?=trans('Nie znaleziono żadnych treści do wyświetlenia w tym module')?>
                </div>
            <?php else: ?>
                <ol id="sortable" class="sortable">
                    <?php foreach ($tabs as $tab): ?>
                        <?=render(ROUTES_PATH.'/admin/module/type/see-also/_item.html.php', $tab)?>
                    <?php endforeach?>
                </ol>
                <script>
                    $('#sortable').nestedSortable({
                        handle: 'div',
                        items: 'li',
                        toleranceElement: '> div',
                        maxLevels: 1
                    });
                </script>
            <?php endif ?>

            <?=render(ROUTES_PATH.'/admin/_parts/input/submitButtons.html.php', [
                'saveLabel' => trans('Zapisz zmiany'),
            ])?>
        </form>
    </div>
</div>

<div id="addModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form id="addModalForm"
            method="post"
            action=""
            class="modal-content form-horizontal">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
                <h2 class="modal-title">
                    <?=trans('Dodaj strony')?>
                </h2>
            </div>
            <div class="modal-body">
                <?=render(ROUTES_PATH.'/admin/_parts/input/select2-single.html.php', [
                    'name' => 'frame_id',
                    'label' => trans('Wybierz stronę'),
                    'options' => $frames,
                    'placeholder' => trans('Wybierz jedną z dostępnych stron'),
                ])?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <?=trans('Anuluj')?>
                </button>
                <button type="submit" value="" class="btn btn-success btn-ok">
                    <?=trans('Dodaj')?>
                </button>
            </div>
        </form>
    </div>
</div>

<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="deleteModalForm"
            method="post"
            action=""
            class="modal-content">
            <input name="frame_id" type="hidden" value="">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
                <h2 class="modal-title">
                    <?=trans('Czy na pewno zaprzestać wyświetlać?')?>
                </h2>
            </div>
            <div class="modal-body">
                <?=trans('Czy jesteś pewien, że chcesz zaprzestać wyświetlania treści')?>
                <span id="deleteName" style="font-weight:bold; color:red;"></span>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <?=trans('Anuluj')?>
                </button>
                <button type="submit" class="btn btn-danger btn-ok">
                    <?=trans('Zaprzestań')?>
                </button>
            </div>
        </form>
    </div>
</div>

<?php require ROUTES_PATH.'/admin/_parts/assets/footer.html.php'; ?>

<script>
$(function(){

    var refreshThemeUri = "<?=$uri->make("/admin/module/{$module_id}/type/see-also/theme")?>/";
    var addUri          = '<?=$uri->make("/admin/module/{$module_id}/type/see-also/item/add.json")?>';
    var sortUri         = '<?=$uri->make("/admin/module/{$module_id}/type/see-also/item/sort.json")?>';
    var deleteUri       = '<?=$uri->make("/admin/module/type/see-also/item/delete.json")?>';

    function refreshTheme(theme) {
        $.get(refreshThemeUri+theme, function(data) {
            $('#moduleTheme').html(data);
        });
    }

    $('#theme').change(function() {
        refreshTheme($(this).val());
    });

    $('#addModalForm').on('submit', function (event) {
        event.preventDefault();
        $.post(addUri, $(this).serialize(), function () {
            location.reload();
        });
    });

    $('#deleteModalForm').on('submit', function (event) {
        $.post(deleteUri, $(this).serialize(), function () {
            location.reload();
        });
    });

    $('#deleteModal').on('show.bs.modal', function (event) {
        $(this).find('[name="frame_id"]').val($(event.relatedTarget).data('id'));
        $(this).find('#deleteName').html($(event.relatedTarget).data('name'));
    });

    $("#saveForm").on('submit', function (event) {
        var sortabled = $('#sortable').nestedSortable('toArray');
        $('[name=positions]').val(JSON.stringify(sortabled));
    });
});
</script>

<?php require ROUTES_PATH.'/admin/_parts/end.html.php'; ?>
