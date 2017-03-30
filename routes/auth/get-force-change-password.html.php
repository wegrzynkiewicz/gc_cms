<?php

require ROUTES_PATH."/auth/_import.php";

$headTitle = trans('Wymagana zmiana hasła');
$_POST = [];

?>
<?php require ROUTES_PATH."/auth/parts/_header.html.php"; ?>

<div class="vertical-center">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?=$headTitle?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form action="<?=$request->uri?>" method="post" id="form" class="form-horizontal">

                            <?php if (isset($error)): ?>
                                <p class="text-danger text-center">
                                    <?=e($error)?>
                                </p>
                            <?php else: ?>
                                <p class="text-center">
                                    <?=trans('Dla bezpieczeństwa musisz zmienić swoje hasło')?>
                                </p>
                            <?php endif ?>

                            <?=render(ROUTES_PATH."/admin/parts/input/_editbox.html.php", [
                                'name' => 'new_password',
                                'label' => trans('Nowe hasło'),
                                'help' => trans('Twoje hasło musi składać się z przynajmniej %s znaków', [$config['password']['minLength']]),
                                'attributes' => [
                                    'type' => 'password',
                                ],
                            ])?>

                            <?=render(ROUTES_PATH."/admin/parts/input/_editbox.html.php", [
                                'name' => 'confirm_password',
                                'label' => trans('Powtórz nowe hasło'),
                                'help' => trans('Powtórz swoje nowe hasło w celu wyeliminowania pomyłki'),
                                'attributes' => [
                                    'type' => 'password',
                                ],
                            ])?>

                            <button type="submit" class="btn btn-md btn-success btn-block">
                                <?=trans('Zmień hasło')?>
                            </button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require ROUTES_PATH."/admin/parts/_scripts.html.php"; ?>
<?php require ROUTES_PATH."/auth/parts/_end.html.php"; ?>
