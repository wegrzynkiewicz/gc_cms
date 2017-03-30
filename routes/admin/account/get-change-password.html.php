<?php

require ROUTES_PATH."/admin/_import.php";
require ROUTES_PATH."/admin/_breadcrumbs.php";
require ROUTES_PATH."/admin/account/_import.php";

$headTitle = trans('Zmiana hasła');
$breadcrumbs->push([
    'name' => $headTitle,
    'icon' => 'unlock-alt',
]);

$_POST = [];

?>
<?php require ROUTES_PATH."/admin/parts/_header.html.php"; ?>
<?php require ROUTES_PATH."/admin/parts/_page-header.html.php"; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="<?=$request->uri?>" method="post" id="form" class="form-horizontal">
            <div class="simple-box">
                <?php if (isset($error)): ?>
                    <div class="text-danger text-center">
                        <?=e($error)?>
                    </div>
                <?php endif ?>

                <?=render(ROUTES_PATH."/admin/parts/input/_editbox.html.php", [
                    'name' => 'old_password',
                    'type' => 'password',
                    'label' => trans('Stare hasło'),
                    'help' => trans('Wprowadź swoje stare hasło dla bezpieczeństwa'),
                ])?>

                <?=render(ROUTES_PATH."/admin/parts/input/_editbox.html.php", [
                    'name' => 'new_password',
                    'type' => 'password',
                    'label' => trans('Nowe hasło'),
                    'help' => trans('Twoje hasło musi składać się z przynajmniej %s znaków', [$config['password']['minLength']]),
                ])?>

                <?=render(ROUTES_PATH."/admin/parts/input/_editbox.html.php", [
                    'name' => 'confirm_password',
                    'type' => 'password',
                    'label' => trans('Powtórz nowe hasło'),
                    'help' => trans('Powtórz swoje nowe hasło dla bezpieczeństwa'),
                ])?>
            </div>

            <?=render(ROUTES_PATH."/admin/parts/input/_submitButtons.html.php", [
                'saveLabel' => trans('Zmień hasło'),
            ])?>

        </form>
    </div>
</div>

<?php require ROUTES_PATH."/admin/parts/assets/_footer.html.php"; ?>
<?php require ROUTES_PATH."/admin/parts/_end.html.php"; ?>
