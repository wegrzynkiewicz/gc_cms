<?php

$headTitle = $trans('Zapomniałem hasła');

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
                        <form action="" method="post" class="form-horizontal">

                            <?php if (isset($error)): ?>
                                <p class="text-danger text-center">
                                    <?=e($error)?>
                                </p>
                            <?php endif ?>

                            <?=render(ACTIONS_PATH.'/admin/parts/input/editbox.html.php', [
                                'name' => 'login',
                                'label' => 'Adres email',
                                'help' => 'Na wprowadzony powyżej adres email zostanie wysłane nowe hasło',
                            ])?>

                            <button type="submit" class="btn btn-lg btn-success btn-block">
                                <?=$trans('Wyślij nowe hasło')?>
                            </button>

                            <div class="btn-group btn-group-justified" style="margin-top:5px">
                                <a href="<?=$uri->make("/")?>" class="btn btn-link">
                                    <?=$trans('Przejdź na stronę główną')?></a>
                                <a href="<?=$uri->make("/auth/login")?>" class="btn btn-link">
                                    <?=$trans('Wróć do logowania')?></a>
                            </div>

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
    $('form').validate({
        rules: {
            login: {
                required: true,
                email: true
            }
        },
        messages: {
            login: {
                required: "<?=$trans('Wprowadź adres e-mail')?>",
                email: "<?=$trans('Adres e-mail jest nieprawidłowy')?>"
            }
        },
    });
});
</script>

</body>
</html>
