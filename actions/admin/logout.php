<?php

$headTitle = "Wylogowałeś się z panelu admina";

$staff->redirectIfUnauthorized();

unset($_SESSION['staff']);

?>

<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
          zostałeś wylogowany
        </div>
    </div>
</div>
