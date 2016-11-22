<?php

$headTitle = "Wylogowałeś się z panelu admina";

checkPermissions();

unset($_SESSION['admin']);

?>

<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
          zostałeś wylogowany
        </div>
    </div>
</div>
