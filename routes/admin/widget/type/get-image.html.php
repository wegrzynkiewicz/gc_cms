<?php

$headTitle = trans('Edycja widżetu zdjęcia: %s', [$widget['name']]);
$breadcrumbs->push([
    'name' => $headTitle,
]);

?>
<?php require ROUTES_PATH.'/admin/parts/_header.html.php'; ?>
<?php require ROUTES_PATH.'/admin/parts/_page-header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="<?=$request->uri?>" method="post" class="form-horizontal">

            <div class="simple-box">
                <?=render(ROUTES_PATH.'/admin/parts/input/_image.html.php', [
                    'name' => 'content',
                    'label' => trans('Zdjęcie'),
                    'placeholder' => trans('Ścieżka do pliku zdjęcia'),
                ])?>
            </div>

            <?=render(ROUTES_PATH.'/admin/parts/input/_submitButtons.html.php', [
                'saveLabel' => trans('Zapisz zmiany'),
            ])?>

        </form>
    </div>
</div>

<?php require ROUTES_PATH.'/admin/parts/assets/_footer.html.php'; ?>
<?php require ROUTES_PATH.'/admin/parts/_end.html.php'; ?>
