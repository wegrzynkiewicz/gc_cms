<?php

require ROUTES_PATH."/auth/_import.php";

// pobierz pracownika po wprowadzonym adresie emailowym
$user = GC\Model\Staff\Staff::select()
    ->equals('email', post('login'))
    ->fetch();

// jeżeli nie znaleziono pracownika wtedy zwróć błąd
if (!$user) {
    $error['login'] = trans('Nieprawidłowy adres e-mail');
    echo render(ROUTES_PATH."/auth/forgot/password-get.php");

    return;
}

$email64 = base64_encode($user['email']);
$regenerationVerifyHash = random(40);
$regenerationVerifyTime = time();
$regenerateUrl = sprintf(
    "http://%s/auth/forgot/verify/%s/%s",
    $_SERVER['HTTP_HOST'], $email64, $regenerationVerifyHash
);

// zapisz dane regeneracyjne w bazie danych
GC\Model\Staff\Meta::updateMeta($user['staff_id'], [
    'regenerationVerifyHash' => $regenerationVerifyHash,
    'regenerationVerifyTime' => $regenerationVerifyTime,
]);

// wyślij maila z linkiem weryfikującym
$mail = new GC\Mail();
$mail->buildTemplate(
    ROUTES_PATH."/auth/forgot/_email-regeneration.html.php",
    ROUTES_PATH."/admin/parts/email/_styles.css", [
        'name' => $user['name'],
        'regenerateUrl' => $regenerateUrl,
    ]
);
$mail->addAddress($user['email']);
$mail->send();

redirect($uri->make('/auth/forgot/link-sent'));
