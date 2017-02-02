<?php

if (GC\Auth\Staff::existsSessionCookie()) {
    redirect('/admin');
}

$headTitle = $trans('Logowanie do panelu administracyjnego');

require ACTIONS_PATH.'/admin/parts/header-login.html.php'; ?>

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
                            <form action="" method="post">

                                <?php if(isset($error)): ?>
                                    <p class="text-center">
                                        <?=e($error)?>
                                    </p>
                                <?php endif ?>

                                <div class="form-group">
                                    <input name="email"
                                        placeholder="<?=$trans('E-mail')?>"
                                        value="<?=post('email')?>"
                                        autofocus
                                        class="form-control">
                                </div>

                                <div class="form-group">
                                    <input name="password"
                                        type="password"
                                        placeholder="<?=$trans('Hasło')?>"
                                        class="form-control">
                                </div>

                                <button type="submit" class="btn btn-md btn-success btn-block">
                                    <?=$trans('Zaloguj się')?>
                                </button>

                                <div class="btn-group btn-group-justified" style="margin-top:5px">
                                    <a href="<?=$uri->make("/")?>" class="btn btn-link">
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
