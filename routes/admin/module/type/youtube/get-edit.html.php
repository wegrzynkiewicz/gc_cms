<?php

require ROUTES_PATH."/admin/module/type/youtube/_import.php";

?>
<?php require ROUTES_PATH.'/admin/_parts/header.html.php'; ?>
<?php require ROUTES_PATH.'/admin/_parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="<?=$request->uri?>" method="post" class="form-horizontal">

            <div class="simple-box">
                <?=render(ROUTES_PATH.'/admin/_parts/input/editbox.html.php', [
                    'name' => 'content',
                    'label' => trans('Adres URL do filmu na YouTube'),
                ])?>

                <?=render(ROUTES_PATH.'/admin/_parts/input/editbox.html.php', [
                    'name' => 'width',
                    'label' => trans('Szerokość odtwarzacza'),
                ])?>

                <?=render(ROUTES_PATH.'/admin/_parts/input/editbox.html.php', [
                    'name' => 'height',
                    'label' => trans('Wysokość odtwarzacza'),
                ])?>
            </div>


            <?=render(ROUTES_PATH.'/admin/_parts/input/submitButtons.html.php', [
                'saveLabel' => trans('Zapisz moduł tekstowy'),
            ])?>

        </form>
    </div>
</div>

<?php require ROUTES_PATH.'/admin/_parts/assets/footer.html.php'; ?>
<?php require ROUTES_PATH.'/admin/_parts/end.html.php'; ?>
