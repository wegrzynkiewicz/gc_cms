<?php

$staff = Staff::createFromSession();
$staff->redirectIfUnauthorized();

$_SESSION['staff']['sessionTimeout'] = time() + $config['sessionTimeout'];

?>
