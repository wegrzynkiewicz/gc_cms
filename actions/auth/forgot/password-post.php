<?php

$headTitle = trans("Wysłano e-maila z weryfikacją przypomnienia hasła");

$user = GC\Model\Staff\Staff::select()->equals('email', $_POST['login'])->fecht();

if (!$user) {
    $error = trans('Nieprawidłowy adres e-mail');

    return require ACTIONS_PATH.'/auth/forgot/password-get.php';
}

$email64 = base64_encode($user['email']);
$regeneration = [
    'verifyHash' => GC\Auth\Password::random(80),
    'time' => time(),
];

$regenerateUrl = sprintf(
    "http://%s/auth/forgot/verify/%s/%s",
    $_SERVER['HTTP_HOST'], $email64, $regeneration['verifyHash']
);

GC\Model\Staff\Staff::updateByPrimaryId($user['staff_id'], [
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
                            <p class="text-danger text-center">
                                <?=e($error)?>
                            </p>
                        <?php endif ?>

                        <p class="text-center">
                            <?=trans('Na zadany adres email zostały wysłane dalsze instrukcje.')?>
                        </p>

                        <div class="btn-group btn-group-justified" style="margin-top:5px">
                            <a href="<?=GC\Url::mask("/")?>" class="btn btn-link">
                                <?=trans('Przejdź na stronę główną')?></a>
                            <a href="<?=GC\Url::mask("/auth/login")?>" class="btn btn-link">
                            <?=trans('Wróć do logowania')?></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require ACTIONS_PATH.'/admin/parts/assets/footer.html.php'; ?>

</body>
</html>
