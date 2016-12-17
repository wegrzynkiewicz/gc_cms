<?php

$headTitle = trans("Logowanie do panelu admina");

if (isset($_SESSION['staff'])) {
    redirect('/admin');
}

if (isPost()) {

    $user = GC\Model\Staff::selectSingleBy('email', $_POST['email']);
    $password = $_POST['password'];

    # jeżeli hasło w bazie nie jest zahaszowane, a zgadza się
    if ($config['debug']['enabled'] and $user and $password === $user['password']) {
        $newPasswordHash = hashPassword($password);
        GC\Model\Staff::updateByPrimaryId($user['staff_id'], [
            'password' => $newPasswordHash,
        ]);
        $user['password'] = $newPasswordHash;
    }

    if ($user and verifyPassword($password, $user['password'])) {

        if (password_needs_rehash($user['password'], PASSWORD_DEFAULT, $config['password']['options'])) {
            GC\Model\Staff::updateByPrimaryId($user['staff_id'], [
                'password' => hashPassword($password),
            ]);
        }

        $_SESSION['staff'] = [
            'entity' => $user,
            'sessionTimeout' => time() + $config['session']['staffTimeout']
        ];

        redirect('/admin');
    } else {
        $error = trans('Nieprawidłowy login lub hasło');
    }
}

require_once ACTIONS_PATH.'/admin/parts/header-login.html.php'; ?>

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
                            <form action="" method="post">

                                <?php if(isset($error)): ?>
                                    <p class="text-center">
                                        <?=e($error)?>
                                    </p>
                                <?php endif ?>

                                <div class="form-group">
                                    <input name="email"
                                        placeholder="<?=trans('E-mail')?>"
                                        value="<?=inputValue('email')?>"
                                        autofocus
                                        class="form-control">
                                </div>

                                <div class="form-group">
                                    <input name="password"
                                        type="password"
                                        placeholder="<?=trans('Hasło')?>"
                                        class="form-control">
                                </div>

                                <button type="submit" class="btn btn-lg btn-success btn-block">
                                    <?=trans('Zaloguj się')?>
                                </button>

                                <div class="btn-group btn-group-justified" style="margin-top:5px">
                                    <a href="<?=url("/")?>" class="btn btn-link">
                                        <?=trans('Przejdź na stronę główną')?></a>
                                    <a href="<?=url("/auth/forgot/password")?>" class="btn btn-link">
                                        <?=trans('Zapomniałem hasła')?></a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once ACTIONS_PATH.'/admin/parts/footer-assets.html.php'; ?>

</body>
</html>
