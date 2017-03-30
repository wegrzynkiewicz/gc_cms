<?php require ROUTES_PATH."/admin/parts/_header.html.php"; ?>
<?php require ROUTES_PATH."/admin/parts/_page-header.html.php"; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="<?=$request->uri?>" method="post" class="form-horizontal">

            <div class="simple-box">
                <?=render(ROUTES_PATH."/admin/parts/input/_editbox.html.php", [
                    'name' => 'content',
                    'label' => trans('Adres URL do filmu na YouTube'),
                ])?>

                <?=render(ROUTES_PATH."/admin/parts/input/_editbox.html.php", [
                    'name' => 'width',
                    'label' => trans('Szerokość odtwarzacza'),
                ])?>

                <?=render(ROUTES_PATH."/admin/parts/input/_editbox.html.php", [
                    'name' => 'height',
                    'label' => trans('Wysokość odtwarzacza'),
                ])?>
            </div>


            <?=render(ROUTES_PATH."/admin/parts/input/_submitButtons.html.php", [
                'saveLabel' => trans('Zapisz moduł tekstowy'),
            ])?>

        </form>
    </div>
</div>

<?php require ROUTES_PATH."/admin/parts/_scripts.html.php"; ?>
<?php require ROUTES_PATH."/admin/parts/_end.html.php"; ?>
