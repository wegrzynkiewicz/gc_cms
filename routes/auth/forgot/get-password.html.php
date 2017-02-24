<?php

require ROUTES_PATH.'/auth/_import.php';

$headTitle = trans('Zapomniałem hasła');

?>
<?php require ROUTES_PATH.'/admin/_parts/header-login.html.php'; ?>

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
                        <form action="<?=$request->uri?>" method="post" class="form-horizontal">

                            <p class="text-center" style="margin-bottom:20px">
                                <?=trans('Na wprowadzony poniżej adres email zostanie wysłane nowe hasło')?>
                            </p>

                            <?=render(ROUTES_PATH.'/admin/_parts/input/editbox.html.php', [
                                'name' => 'login',
                                'placeholder' => trans('Adres e-mail'),
                            ])?>

                            <button type="submit" class="btn btn-md btn-success btn-block">
                                <?=trans('Wyślij nowe hasło')?>
                            </button>

                            <div class="btn-group btn-group-justified" style="margin-top:5px">
                                <a href="<?=$uri->root()?>/" class="btn btn-link">
                                    <?=trans('Przejdź na stronę główną')?></a>
                                <a href="<?=$uri->make("/auth/login")?>" class="btn btn-link">
                                    <?=trans('Wróć do logowania')?></a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require ROUTES_PATH.'/admin/_parts/assets/footer.html.php'; ?>

</body>
</html>
