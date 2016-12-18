<?php

$headTitle = trans("Zapomniałem hasła");

if (isset($_SESSION['staff'])) {
    redirect('/admin');
}

if (isPost()) {

    $user = GC\Model\Staff::selectSingleBy('email', $_POST['login']);
    if ($user) {

        $email64 = base64_encode($user['email']);
        $regeneration = [
            'verifyHash' => pseudoRandom(80),
            'time' => time(),
        ];

        $regenerateUrl = sprintf(
            "http://%s/auth/forgot/verify/%s/%s",
            $_SERVER['HTTP_HOST'], $email64, $regeneration['verifyHash']
        );

        GC\Model\Staff::updateByPrimaryId($user['staff_id'], [
            'regeneration' => json_encode($regeneration),
        ]);

        $mail = new GC\Mail();
        $mail->buildTemplate(
            '/auth/forgot/verify-generation.email.html.php',
            '/admin/parts/email/styles.css', [
                'name' => $user['name'],
                'regenerateUrl' => $regenerateUrl,
            ]
        );
        $mail->addAddress($user['email']);
        $mail->send();

        redirect('/auth/forgot/sent-verification');
    } else {
        $error = trans('Nieprawidłowy adres e-mail');
    }
}

require_once ACTIONS_PATH.'/admin/parts/header-login.html.php'; ?>

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

                            <?php if (isset($error)): ?>
                                <p class="text-danger text-center">
                                    <?=e($error)?>
                                </p>
                            <?php endif ?>

                            <?=view('/admin/parts/input/editbox.html.php', [
                                'name' => 'login',
                                'label' => 'Adres email',
                                'help' => 'Na wprowadzony powyżej adres email zostanie wysłane nowe hasło',
                            ])?>

                            <button type="submit" class="btn btn-lg btn-success btn-block">
                                <?=trans('Wyślij nowe hasło')?>
                            </button>

                            <div class="btn-group btn-group-justified" style="margin-top:5px">
                                <a href="<?=url("/")?>" class="btn btn-link">
                                    <?=trans('Przejdź na stronę główną')?></a>
                                <a href="<?=url("/auth/login")?>" class="btn btn-link">
                                    <?=trans('Wróć do logowania')?></a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once ACTIONS_PATH.'/admin/parts/footer-assets.html.php'; ?>

<script>
$(function () {
    $('#form').validate({
        rules: {
            login: {
                required: true,
                email: true
            }
        },
        messages: {
            login: {
                required: "<?=trans('Wprowadź adres e-mail')?>",
                email: "<?=trans('Adres e-mail jest nieprawidłowy')?>"
            }
        },
    });
});
</script>

</body>
</html>
