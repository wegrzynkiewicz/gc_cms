<?php

$mail = new Mail();
$mail->compileTemplate('/admin/staff/staff-created-email', [
    'name' => 'Łukasz Węgrzynkiewicz'
]);
$mail->Body = 'siema';
$mail->addAddress('wegrzynkiewicz.lukasz@gmail.com');
$mail->send();
