<?php

$headTitle = $trans("Wymagana zmiana hasła");
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
                                <?=$trans('Dla bezpieczeństwa musisz zmienić swoje hasło')?>
                            </p>

                            <?php if (isset($error)): ?>
                                <p class="text-danger text-center">
                                    <?=e($error)?>
                                </p>
                            <?php endif ?>

                            <?=GC\Render::action('/admin/parts/input/editbox.html.php', [
                                'name' => 'new_password',
                                'type' => 'password',
                                'label' => 'Nowe hasło',
                                'help' => sprintf('Twoje hasło musi składać się z przynajmniej %s znaków', GC\Data::get('config')['password']['minLength']),
                            ])?>

                            <?=GC\Render::action('/admin/parts/input/editbox.html.php', [
                                'name' => 'confirm_password',
                                'type' => 'password',
                                'label' => 'Powtórz nowe hasło',
                                'help' => 'Powtórz swoje nowe hasło w celu wyeliminowania pomyłki',
                            ])?>

                            <button type="submit" class="btn btn-lg btn-success btn-block">
                                <?=$trans('Zmień hasło')?>
                            </button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require ACTIONS_PATH.'/admin/parts/assets/footer.html.php'; ?>

<script>
$(function () {
    $('#form').validate({
        rules: {
            new_password: {
                required: true,
                minlength : <?=e(GC\Data::get('config')['password']['minLength'])?>
            },
            confirm_password: {
                required: true,
                equalTo: "#new_password"
            }
        },
        messages: {
            new_password: {
                required: "<?=$trans('Wprowadź nowe hasło')?>",
                minlength: "<?=$trans('Nowe hasło powinno mieć przynajmniej %s znaków', GC\Data::get('config')['password']['minLength'])?>"
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
