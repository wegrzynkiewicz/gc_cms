<?php

$headTitle = $trans('Resetowanie hasła');

require ACTIONS_PATH.'/auth/forgot/verify-validate.html.php';
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
                        <?php if (isset($error)): ?>
                            <div class="text-danger text-center">
                                <?=e($error)?>
                            </div>
                        <?php else: ?>
                            <form action="" method="post" class="form-horizontal">

                                <?=render(ACTIONS_PATH.'/admin/parts/input/editbox.html.php', [
                                    'name' => 'new_password',
                                    'type' => 'password',
                                    'label' => 'Nowe hasło',
                                    'help' => sprintf('Twoje hasło musi składać się z przynajmniej %s znaków', $config['password']['minLength']),
                                ])?>

                                <?=render(ACTIONS_PATH.'/admin/parts/input/editbox.html.php', [
                                    'name' => 'confirm_password',
                                    'type' => 'password',
                                    'label' => 'Powtórz nowe hasło',
                                    'help' => 'Powtórz swoje nowe hasło dla bezpieczeństwa',
                                ])?>

                                <?=render(ACTIONS_PATH.'/admin/parts/input/submitButtons.html.php', [
                                    'saveLabel' => 'Zmień hasło',
                                    'cancelHref' => $uri->make('/auth/login'),
                                ])?>
                            </form>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require ACTIONS_PATH.'/admin/parts/assets/footer.html.php'; ?>

<script>
$(function () {
    $('form').validate({
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
                required: "<?=$trans('Wprowadź nowe hasło')?>",
                minlength: "<?=$trans('Nowe hasło powinno mieć przynajmniej %s znaków', [$config['password']['minLength']])?>"
            },
            confirm_password: {
                required: "<?=$trans('Musisz powtórzyć swoje nowe hasło dla bezpieczeństwa')?>",
                equalTo: "<?=$trans('Hasła nie są jednakowe')?>"
            }
        },
    });
});
</script>

</body>
</html>
