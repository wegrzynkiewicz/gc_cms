<?php

$frames = GC\Model\Frame::select()
    ->fields(['frame_id', 'name', 'type'])
    ->equals('lang', GC\Staff::getInstance()->getEditorLang())
    ->fetchByPrimaryKey();

foreach ($frames as &$frame) {
    $frame = sprintf('%s - %s',
        $frame['name'],
        $config['frame']['types'][$frame['type']]['name']
    );
}
unset($frame);

?>
<?php require ROUTES_PATH."/admin/parts/_header.html.php"; ?>
<?php require ROUTES_PATH."/admin/parts/_page-header.html.php"; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="<?=$request->uri?>" method="post" id="form" class="form-horizontal">

            <div class="simple-box">
                <?=render(ROUTES_PATH."/admin/parts/input/_editbox.html.php", [
                    'name' => 'name',
                    'label' => trans('Nazwa wyskakującego okienka'),
                    'help' => trans('W zależności od szablonu, nazwa może zostać wyświetlona odwiedzającemu.'),
                ])?>

                <?=render(ROUTES_PATH."/admin/parts/input/_selectbox.html.php", [
                    'name' => 'type',
                    'label' => trans('Typ wyskakującego okienka'),
                    'help' => trans('Typ pozwala na wybranie niestandardowego zachowania okienka.'),
                    'options' => $config['popupTypes'],
                    'firstOption' => trans('Wybierz typ wyskakującego okienka'),
                ])?>
            </div>

            <div id="popupType"></div>

            <div class="simple-box">
                <fieldset>
                    <legend><?=trans('Ustawienia okienka')?></legend>

                    <?=render(ROUTES_PATH."/admin/parts/input/_datetimepicker.html.php", [
                        'name' => 'show_after_datetime',
                        'label' => trans('Data i czas rozpoczęcia wyświetlania'),
                        'help' => trans('Zostaw puste, jeżeli okienko ma się wyświetlać od razu.'),
                    ])?>

                    <?=render(ROUTES_PATH."/admin/parts/input/_datetimepicker.html.php", [
                        'name' => 'hide_after_datetime',
                        'label' => trans('Data i czas zakończenia wyświetlania'),
                        'help' => trans('Zostaw puste, jeżeli okienko ma się wyświetlać cały czas'),
                    ])?>

                    <?=render(ROUTES_PATH."/admin/parts/input/_editbox.html.php", [
                        'name' => 'countdown',
                        'label' => trans('Po ilu sekundach okienko ma się wyświetlić?'),
                        'help' => trans('Wpisz 0, jeżeli okienko ma się wyświetlać zaraz po załadowaniu strony'),
                    ])?>

                    <?=render(ROUTES_PATH."/admin/parts/input/_select2-multi.html.php", [
                        'name' => 'frames',
                        'label' => trans('Wyświetl na stronach'),
                        'help' => trans('Zostaw puste, aby wyświetlić na wszytkich stronach.'),
                        'options' => $frames,
                        'selectedValues' => $selectedFrames,
                    ])?>

                </fieldset>
            </div>

            <?=render(ROUTES_PATH."/admin/parts/input/_submitButtons.html.php", [
                'saveLabel' => trans('Zapisz stronę'),
            ])?>

        </form>
    </div>
</div>

<?php require ROUTES_PATH."/admin/parts/_scripts.html.php"; ?>

<script type="text/javascript">
    $(function () {
        var refreshTypeUri = "<?=$uri->make("/admin/popup/{$popup_id}/type")?>/";

        function refreshType(theme) {
            $.get(refreshTypeUri+theme, function(data) {
                $('#popupType').html(data);
            });
        }

        $('#type').change(function() {
            refreshType($(this).val());
        });

        <?php if (isset($popupType)): ?>
            refreshType("<?=$popupType?>");
        <?php endif; ?>
    });
</script>

<?php require ROUTES_PATH."/admin/parts/_end.html.php"; ?>
