<?php

$headTitle = trans("Resetowanie hasła");

if (count($_SEGMENTS)<2) {
    redirect('/admin');
}

if (isset($_SESSION['staff'])) {
    redirect('/admin');
}

$email64 = array_shift($_SEGMENTS);
$email = base64_decode($email64);
$verifyHash = array_shift($_SEGMENTS);

$user = GC\Model\Staff::selectSingleBy('email', $email);
if ($user) {
    $regeneration = json_decode($user['regeneration'], true);
    if (empty($regeneration)) {
        $message = trans("Wystąpił problem podczas resetowania hasła");
    } elseif ($regeneration['verifyHash'] !== $verifyHash) {
        $message = trans("Link do zmiany hasła wygasł lub hasło zostało już zresetowane");
    } elseif (time() - $regeneration['time'] > 3600) {
        $message = trans("Link do zmiany hasła wygasł lub hasło zostało już zresetowane");
    } else {

        $password = pseudoRandom($config['password']['minLength']);

        GC\Model\Staff::updateByPrimaryId($user['staff_id'], [
            'password' => hashPassword($password),
            'force_change_password' => 1,
            'regeneration' => json_encode([]),
        ]);

        $mail = new GC\Mail();
        $mail->buildTemplate(
            '/auth/forgot/password-reseted.email.html.php',
            '/admin/parts/email/styles.css', [
                'name' => $user['name'],
                'login' => $user['email'],
                'password' => $password,
            ]
        );
        $mail->addAddress($user['email']);
        $mail->send();

        $message = trans("Twoje nowe hasło zostało wysłane na Twój adres e-mail");
    }
} else {
    $message = trans("Wystąpił problem podczas resetowania hasła");
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

                        <?php if (isset($message)): ?>
                            <p class="text-center">
                                <?=e($message)?>
                            </p>
                        <?php endif ?>

                        <div class="btn-group btn-group-justified" style="margin-top:5px">
                            <a href="<?=url("/auth/login")?>" class="btn btn-link">
                                <?=trans('Wróć do logowania')?></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once ACTIONS_PATH.'/admin/parts/footer-assets.html.php'; ?>

</body>
</html>
