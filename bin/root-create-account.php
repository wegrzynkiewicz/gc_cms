<?php

/** Dodaje konto administratora do bazy danych **/

require_once __DIR__.'/_import.php';

echo PHP_EOL;
echo "Creating root staff account...".PHP_EOL;
$email = $inputValue('Enter root account email (empty to abort): ');
if ($email) {
    $password = $inputValue('Enter root password (empty to generate): ');
    if (empty($password)) {
        $password = random($config['password']['minLength']);
        echo 'Your password is: '.$password.PHP_EOL;
    }
    $hash = password_hash($password, PASSWORD_DEFAULT);

    GC\Model\Staff\Staff::insert([
        'name' => 'Buildin Master Account',
        'email' => $email,
        'password' => $hash,
        'lang' => 'pl',
        'root' => 1,
    ]);

    echo "Root staff account was created.".PHP_EOL;
} else {
    echo "Root staff account was not created.".PHP_EOL;
}
