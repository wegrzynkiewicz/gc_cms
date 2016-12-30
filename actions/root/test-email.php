<?php

$mail = new Mail();
$mail->buildTemplate(
    '/admin/staff/staff-created-email.html.php',
    '/admin/parts/email/styles.css', [
    'name' => 'Łukasz Węgrzynkiewicz',
    'login' => 'wegrzynkiewicz.lukasz@gmail.com',
]);
$mail->addAddress('wegrzynkiewicz.lukasz@gmail.com');

$mail->send();
