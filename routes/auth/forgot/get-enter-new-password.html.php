<?php

require ROUTES_PATH."/auth/_import.php";

$headTitle = trans('Resetowanie hasła');

# pobranie klucza głównego zalogowanego pracownika
$staff_id = GC\Staff::getInstance()['staff_id'];

# pobierz wszystkie meta dane
$meta = GC\Model\Staff\Meta::fetchMeta($staff_id);

# jeżeli regeneracja jest nieaktualna wtedy przekieruj
if (!isset($meta['regenerationVerifyHash'])) {
    unset($_SESSION['staff']);
    redirect($uri->make('/login'));
}

?>
<?php require ROUTES_PATH."/auth/parts/_header.html.php"; ?>

<div class="vertical-center">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">
                            <?=$headTitle?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form action="<?=$request->uri?>" method="post" class="form-horizontal">

                            <p class="text-center">
                                <?=trans('Weryfikacja adresu email przebiegła pomyślnie. Możesz zmienić swoje hasło.')?>
                            </p>

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
                                'help' => trans('Powtórz swoje nowe hasło dla bezpieczeństwa'),
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
