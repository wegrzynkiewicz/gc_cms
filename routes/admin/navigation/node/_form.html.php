<?php require ROUTES_PATH.'/admin/parts/_header.html.php'; ?>
<?php require ROUTES_PATH.'/admin/parts/_page-header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="<?=$request->uri?>" method="post" class="form-horizontal">

            <div class="simple-box">
                <fieldset>
                    <legend><?=trans('Ustawienia podstawowe')?></legend>
                    <?=render(ROUTES_PATH.'/admin/parts/input/_select2-single.html.php', [
                        'name' => 'type',
                        'label' => trans('Typ węzła'),
                        'help' => trans('Typ pozwala na wybranie niestandardowego zachowania linku.'),
                        'placeholder' => trans('Wybierz typ węzła'),
                        'options' => array_trans($config['navigation']['nodeTypes']),
                        'hideSearch' => true,
                    ])?>

                    <?php if (count($config['navigation']['nodeThemes']) > 1): ?>
                        <?=render(ROUTES_PATH.'/admin/parts/input/_select2-single.html.php', [
                            'name' => 'theme',
                            'label' => trans('Wyróżnienie węzła'),
                            'help' => trans('Istnieje możliwość, aby wyróżnić wybrany węzeł poprzez nadanie odpowiedniej opcji'),
                            'placeholder' => trans('Wybierz wyróżnienie węzła'),
                            'options' => array_trans($config['navigation']['nodeThemes']),
                            'hideSearch' => true,
                        ])?>
                    <?php endif ?>
                </fieldset>
            </div>

            <div id="nodeType"></div>

            <?=render(ROUTES_PATH.'/admin/parts/input/_submitButtons.html.php', [
                'saveLabel' => trans('Zapisz węzeł'),
            ])?>

        </form>
    </div>
</div>

<?php require ROUTES_PATH.'/admin/parts/assets/_footer.html.php'; ?>

<script>
$(function() {
    function refreshType(type) {
        $.get("<?=$uri->make("/admin/navigation/node/{$node_id}/type")?>/"+type, function(data) {
            $('#nodeType').html(data);
        });
    }

    $('#type').change(function() {
        refreshType($(this).val());
    });

    <?php if (isset($nodeType)): ?>
        refreshType('<?=$nodeType?>');
    <?php endif ?>
});
</script>

<?php require ROUTES_PATH.'/admin/parts/_end.html.php'; ?>
