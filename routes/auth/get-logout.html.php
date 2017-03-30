<?php

require ROUTES_PATH."/auth/_import.php";

$headTitle = trans('Zostałeś wylogowany');

unset($_SESSION['staff']);

?>
<?php require ROUTES_PATH."/auth/parts/_header.html.php"; ?>

<div class="vertical-center">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">
                            <?=$headTitle?>
                        </h3>
                    </div>
                    <div class="panel-body">

                        <p class="text-center" style="margin-bottom:20px">
                            <?=trans('Zostałeś bezpiecznie wylogowany z panelu admina.')?><br>
                            <?=trans('Mamy nadzieje, że praca z naszym systemem była przyjemna :)')?>
                        </p>

                        <a href="<?=$uri->make("/auth/login")?>" class="btn btn-md btn-success btn-block">
                            <?=trans('Zaloguj się ponownie')?>
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require ROUTES_PATH."/admin/parts/_scripts.html.php"; ?>
<?php require ROUTES_PATH."/auth/parts/_end.html.php"; ?>
