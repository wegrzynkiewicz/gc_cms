<?php

# pobierz pracownika po prowadzonym adresie emailowym
$user = GC\Model\Staff\Staff::select()
    ->equals('email', post('login'))
    ->fetch();

# jeżeli nie znaleziono pracownika wtedy zwróć błąd
if (!$user) {
    return print(render(ACTIONS_PATH.'/auth/forgot/password-get.php', [
        'error' => $trans('Nieprawidłowy adres e-mail'),
    ]));
}

$email64 = base64_encode($user['email']);
$regeneration = [
    'verifyHash' => GC\Auth\Password::random(40),
    'time' => time(),
];

$regenerateUrl = sprintf(
    "http://%s/auth/forgot/verify/%s/%s",
    $_SERVER['HTTP_HOST'], $email64, $regeneration['verifyHash']
);

# zapisz dane regeneracyjne w bazie danych
GC\Model\Staff\Staff::updateByPrimaryId($user['staff_id'], [
    'regeneration' => json_encode($regeneration),
]);

$mail = new GC\Mail();
$mail->buildTemplate(
    ACTIONS_PATH.'/auth/forgot/verify-generation.email.html.php',
    ACTIONS_PATH.'/admin/parts/email/styles.css', [
        'name' => $user['name'],
        'regenerateUrl' => $regenerateUrl,
    ]
);
$mail->addAddress($user['email']);
$mail->send();

redirect('/auth/forgot/link-sent');
