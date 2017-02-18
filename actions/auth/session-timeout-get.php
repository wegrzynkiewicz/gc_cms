<?php

require ACTIONS_PATH.'/auth/_import.php';

$headTitle = trans('Czas trwania sesji minął');

unset($_SESSION['staff']);

?>
<?php require ACTIONS_PATH.'/admin/parts/header-login.html.php'; ?>

<div class="vertical-center">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">
                            <?=($headTitle)?>
                        </h3>
                    </div>
                    <div class="panel-body">

                        <p class="text-center" style="margin-bottom:20px">
                            <?=trans('Zostałeś wylogowany, ponieważ minął czas trwania Twojej sesji.')?><br>
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

<?php require ACTIONS_PATH.'/admin/parts/assets/footer.html.php'; ?>

</body>
</html>
