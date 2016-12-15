<?php

$headTitle = trans("Zostałeś wylogowany");

unset($_SESSION['staff']);

require_once ACTIONS_PATH.'/admin/parts/header-login.html.php'; ?>

<div class="vertical-center">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?=$headTitle?>
                        </h3>
                    </div>
                    <div class="panel-body">

                        <p class="text-center">
                            <?=trans('Zostałeś bezpiecznie wylogowany z panelu admina.')?><br>
                            <?=trans('Mamy nadzieje, że praca z naszym systemem była przyjemna :)')?>
                        </p>

                        <div class="btn-group btn-group-justified" style="margin-top:5px">
                            <a href="<?=url("/")?>" class="btn btn-link">
                                <?=trans('Przejdź na stronę główną')?></a>
                            <a href="<?=url("/auth/login")?>" class="btn btn-link">
                            <?=trans('Wróć do logowania')?></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once ACTIONS_PATH.'/admin/parts/assets.html.php'; ?>

</body>
</html>
