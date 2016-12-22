<?php

$headTitle = trans("Wymagana zmiana hasła");

if (isPost()) {

    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    $user = GC\Model\Staff::selectByPrimaryId($_SESSION['staff']['entity']['staff_id']);

    if ($newPassword !== $confirmPassword) {
        $error = trans('Podane nowe hasła nie są identyczne');
    } elseif (strlen($newPassword) < $config['password']['minLength']) {
        $error = trans('Hasło nie może być krótsze niż %s znaków', $config['password']['minLength']);
    } elseif (verifyPassword($newPassword, $user['password'])) {
        $error = trans('Nowe hasło nie może być takie samo jak poprzednie');
    } else {
        GC\Model\Staff::updateByPrimaryId($user['staff_id'], [
            'password' => hashPassword($newPassword),
            'force_change_password' => 0,
        ]);

        redirect('/admin');
    }
}

$_POST = [];

require ACTIONS_PATH.'/admin/parts/header-login.html.php'; ?>

<div class="vertical-center">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?=($headTitle)?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form action="" method="post" id="form" class="form-horizontal">

                            <p class="text-center">
                                <?=trans('Dla bezpieczeństwa musisz zmienić swoje hasło')?>
                            </p>

                            <?php if (isset($error)): ?>
                                <p class="text-danger text-center">
                                    <?=e($error)?>
                                </p>
                            <?php endif ?>

                            <?=view('/admin/parts/input/editbox.html.php', [
                                'name' => 'new_password',
                                'type' => 'password',
                                'label' => 'Nowe hasło',
                                'help' => sprintf('Twoje hasło musi składać się z przynajmniej %s znaków', $config['password']['minLength']),
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

<?php require ACTIONS_PATH.'/admin/parts/assets/footer.html.php';; ?>

<script>
$(function () {
    $('#form').validate({
        rules: {
            new_password: {
                required: true,
                minlength : <?=e($config['password']['minLength'])?>
            },
            confirm_password: {
                required: true,
                equalTo: "#new_password"
            }
        },
        messages: {
            new_password: {
                required: "<?=trans('Wprowadź nowe hasło')?>",
                minlength: "<?=trans('Nowe hasło powinno mieć przynajmniej %s znaków', $config['password']['minLength'])?>"
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
