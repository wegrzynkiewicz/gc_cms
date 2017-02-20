<?php

/** Wysyła testową wiadomość mailową do odbiorcy **/

require_once __DIR__.'/_import.php';

echo PHP_EOL;
echo "Sending test email message...".PHP_EOL;
$email = $inputValue('Enter email (empty to abort): ');
if (GC\Validate::email($email)) {

    $mail = new GC\Mail();
    $mail->buildTemplate(
        ROUTES_PATH.'/root/test.email.html.php',
        ROUTES_PATH.'/admin/parts/email/styles.css'
    );
    $mail->addAddress($email);
    $mail->send();

    echo "Email was sent.".PHP_EOL;
} else {
    echo "Email was not sent.".PHP_EOL;
}
