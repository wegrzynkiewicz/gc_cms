<?php

$headTitle = trans("Wymagana zmiana hasła");

if (wasSentPost()) {

    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];
    $newPasswordHash = sha1($newPassword);

    $user = GrafCenter\CMS\Model\Staff::selectByPrimaryId($_SESSION['staff']['staff_id']);
    if (!$user) {
        redirect('/admin/account/logout');
    }

    if ($newPasswordHash === $user['password']) {
        $error = trans('Nowe hasło nie może być takie samo jak poprzednie');
    } elseif (strlen($newPassword) < $config['minPasswordLength']) {
        $error = trans('Hasło nie może być krótsze niż %s znaków', $config['minPasswordLength']);
    } elseif ($newPassword !== $confirmPassword) {
        $error = trans('Podane nowe hasła nie są identyczne');
    } else {
        GrafCenter\CMS\Model\Staff::updateByPrimaryId($user['staff_id'], [
            'password' => $newPasswordHash,
            'force_change_password' => 0,
        ]);

        redirect('/admin');
    }
}

$_POST = [];

require_once ACTIONS_PATH.'/admin/parts/header-login.html.php'; ?>

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
                        <form action="" method="post" id="form" class="form-horizontal">

                            <p class="text-center">
                                <?=trans('Dla bezpieczeństwa musisz zmienić swoje hasło')?>
                            </p>

                            <?php if (isset($error)): ?>
                                <p class="text-danger text-center">
                                    <?=$error?>
                                </p>
                            <?php endif ?>

                            <?=view('/admin/parts/input/editbox.html.php', [
                                'name' => 'new_password',
                                'type' => 'password',
                                'label' => 'Nowe hasło',
                                'help' => sprintf('Twoje hasło musi składać się z przynajmniej %s znaków', $config['minPasswordLength']),
                            ])?>

                            <?=view('/admin/parts/input/editbox.html.php', [
                                'name' => 'confirm_password',
                                'type' => 'password',
                                'label' => 'Powtórz nowe hasło',
                                'help' => 'Powtórz swoje nowe hasło w celu wyeliminowania pomyłki',
                            ])?>

                            <button type="submit" class="btn btn-lg btn-success btn-block">
                                <?=trans('Zmień hasło')?>
                            </button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once ACTIONS_PATH.'/admin/parts/assets.html.php'; ?>

<script>
$(function () {
    $('#form').validate({
        rules: {
            new_password: {
                required: true,
                minlength : <?=$config['minPasswordLength']?>
            },
            confirm_password: {
                required: true,
                equalTo: "#new_password"
            }
        },
        messages: {
            new_password: {
                required: "<?=trans('Wprowadź nowe hasło')?>",
                minlength: "<?=trans('Nowe hasło powinno mieć przynajmniej %s znaków', $config['minPasswordLength'])?>"
            },
            confirm_password: {
                required: "<?=trans('Musisz powtórzyć swoje nowe hasło dla bezpieczeństwa')?>",
                equalTo: "<?=trans('Hasła nie są jednakowe')?>"
            }
        },
    });
});
</script>

</body>
</html>
