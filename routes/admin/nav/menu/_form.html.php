<?php require ROUTES_PATH.'/admin/_parts/header.html.php'; ?>
<?php require ROUTES_PATH.'/admin/_parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="<?=$request->uri?>" method="post" id="form" class="form-horizontal">

            <div class="simple-box">
                <?=render(ROUTES_PATH.'/admin/_parts/input/editbox.html.php', [
                    'name' => 'name',
                    'label' => trans('Nazwa węzła'),
                    'help' => trans('Zostaw pustą, aby wygenerować na podstawie nazwy odnośnika'),
                ])?>

                <?php if (!isset($nodeType)): ?>
                    <?=render(ROUTES_PATH.'/admin/_parts/input/selectbox.html.php', [
                        'name' => 'type',
                        'label' => trans('Typ węzła'),
                        'help' => trans('Typ pozwala na wybranie niestandardowego zachowania linku.'),
                        'options' => $config['nodeTypes'],
                        'firstOption' => trans('Wybierz typ węzła'),
                    ])?>
                <?php endif ?>
            </div>

            <div id="nodeType">
                <?php if (isset($nodeType)): ?>
                    <?=$nodeType?>
                <?php endif ?>
            </div>

            <?=render(ROUTES_PATH.'/admin/_parts/input/submitButtons.html.php', [
                'saveLabel' => trans('Zapisz węzeł'),
            ])?>

        </form>
    </div>
</div>

<?php require ROUTES_PATH.'/admin/_parts/assets/footer.html.php'; ?>

<script>
$(function() {

    $('#type').change(function() {
        $.get("<?=$uri->mask('/type')?>/"+$(this).val(), function(data) {
            $('#nodeType').html(data);
        });
    });

    $('#form').validate({
        rules: {
            type: {
                required: true
            },
            destination: {
                required: true
            }
        },
        messages: {
            type: {
                required: "<?=trans('Wybierz typ węzła')?>"
            },
            destination: {
                required: "<?=trans('Podaj gdzie ma kierować węzeł')?>"
            }
        },
    });
});
</script>

<?php require ROUTES_PATH.'/admin/_parts/end.html.php'; ?>
