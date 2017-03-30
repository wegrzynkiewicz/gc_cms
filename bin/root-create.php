<?php

/** Dodaje konto administratora do bazy danych **/

require_once __DIR__.'/_import.php';

echo PHP_EOL;
echo "Creating root staff account...".PHP_EOL;
$email = $inputValue('Enter root account email (empty to abort): ');
if ($email and GC\Validation\Validate::staffEmail($email)) {
    echo 'Your password is: root'.PHP_EOL;
    $hash = password_hash('root', PASSWORD_DEFAULT);

    GC\Model\Staff\Staff::insert([
        'name' => 'Buildin Root Account',
        'email' => $email,
        'password' => $hash,
        'lang' => 'pl',
        'root' => 1,
        'force_change_password' => 1,
    ]);

    echo "Root staff account was created.".PHP_EOL;
} else {
    echo "Root staff account was not created.".PHP_EOL;
}
