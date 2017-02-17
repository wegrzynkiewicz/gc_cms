<?php

require ACTIONS_PATH.'/auth/_import.php';

if (isset($_SESSION['staff'])) {
    redirect('/admin');
}

$headTitle = $trans('Logowanie do panelu administracyjnego');

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
                        <form action="" method="post" class="form-horizontal">

                            <?php if(isset($error)): ?>
                                <p class="text-danger text-center" style="margin-bottom:20px">
                                    <?=$error?>
                                </p>
                            <?php endif ?>

                            <?=render(ACTIONS_PATH.'/admin/parts/input/editbox.html.php', [
                                'name' => 'login',
                                'placeholder' => $trans('Adres e-mail'),
                            ])?>

                            <?=render(ACTIONS_PATH.'/admin/parts/input/editbox.html.php', [
                                'name' => 'password',
                                'type' => 'password',
                                'placeholder' => $trans('Hasło'),
                            ])?>

                            <button type="submit" class="btn btn-md btn-success btn-block">
                                <?=$trans('Zaloguj się')?>
                            </button>

                            <div class="btn-group btn-group-justified" style="margin-top:5px">
                                <a href="<?=$uri->root()?>/" class="btn btn-link">
                                    <?=$trans('Przejdź na stronę główną')?></a>
                                <a href="<?=$uri->make("/auth/forgot/password")?>" class="btn btn-link">
                                    <?=$trans('Zapomniałem hasła')?></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require ACTIONS_PATH.'/admin/parts/assets/footer.html.php'; ?>

</body>
</html>
