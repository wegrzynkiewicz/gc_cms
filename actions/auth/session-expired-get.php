<?php

require ACTIONS_PATH.'/auth/_import.php';

$headTitle = $trans('Czas trwania sesji minął');

require ACTIONS_PATH.'/admin/parts/header-login.html.php'; ?>

<div class="vertical-center">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?=($headTitle)?>
                        </h3>
                    </div>
                    <div class="panel-body">

                        <p class="text-center">
                            <?=$trans('Zostałeś wylogowany, ponieważ minął czas trwania Twojej sesji.')?><br>
                        </p>

                        <div class="btn-group btn-group-justified" style="margin-top:5px">
                            <a href="<?=$uri->make("/auth/login")?>" class="btn btn-link">
                            <?=$trans('Zaloguj się ponownie')?></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require ACTIONS_PATH.'/admin/parts/assets/footer.html.php'; ?>

</body>
</html>
