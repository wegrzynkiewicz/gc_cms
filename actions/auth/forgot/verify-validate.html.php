<?php

if (count($_SEGMENTS)<2) {
    GC\Response::redirect('/admin');
}

$email64 = array_shift($_SEGMENTS);
$verifyHash = array_shift($_SEGMENTS);

$email = base64_decode($email64);

$user = GC\Model\Staff::selectSingleBy('email', $email);
if (!$user) {
    $error = trans("Wystąpił problem podczas resetowania hasła");

    return;
}

$regeneration = json_decode($user['regeneration'], true);

if (empty($regeneration)) {
    $error = trans("Wystąpił problem podczas resetowania hasła");

    return;
}

if ($regeneration['verifyHash'] !== $verifyHash) {
    $error = trans("Link do zmiany hasła wygasł lub hasło zostało już zresetowane");

    return;
}

if (time() - $regeneration['time'] > 3600) {
    $error = trans("Link do zmiany hasła wygasł lub hasło zostało już zresetowane");

    return;
}
