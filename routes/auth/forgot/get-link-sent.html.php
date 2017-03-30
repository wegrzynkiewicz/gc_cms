<?php

require ROUTES_PATH.'/auth/_import.php';

$headTitle = trans('Wysłano e-maila z weryfikacją przypomnienia hasła');

?>
<?php require ROUTES_PATH.'/admin/parts/_header-login.html.php'; ?>

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
                            <?=trans('Na zadany adres email zostały wysłane dalsze instrukcje.')?>
                        </p>

                        <a href="<?=$uri->make("/auth/login")?>" class="btn btn-md btn-success btn-block">
                            <?=trans('Wróć do logowania')?>
                        </a>

                        <div class="btn-group btn-group-justified" style="margin-top:5px">
                            <a href="<?=$uri->root()?>/" class="btn btn-link">
                                <?=trans('Przejdź na stronę główną')?></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require ROUTES_PATH.'/admin/parts/assets/_footer.html.php'; ?>

</body>
</html>
