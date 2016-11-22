<?php

$headTitle = trans("Logowanie do panelu admina");

if (isset($_SESSION['admin'])) {
    redirect('/admin');
}

if (wasSentPost()) {
    $passwordHash = sha1($_POST['password']);
    $user = UserModel::selectByEmail($_POST['email']);

    # jeżeli hasło w bazie nie jest zahaszowane, a zgadza się
    if (!isSha1($user['password']) and $_POST['password'] === $user['password']) {
        UserModel::update($user['user_id'], [
            'password' => $passwordHash,
        ]);
        $user['password'] = $passwordHash;
    }

    if ($passwordHash === $user['password']) {
        $_SESSION['admin']['user'] = $user;
        redirect('/admin');
    } else {
        $error = trans('Nieprawidłowy login lub hasło');
    }
}

?>
<!DOCTYPE html>
<html lang="<?=$config['lang']?>">
<head>
    <meta charset="utf-8" >
	<title><?=$headTitle.' - '.$config['adminHeadTitleBase']?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?=assetsUrl("/admin/styles/login.css")?>">

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
</head>
<body>
    <div class="vertical-center">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <?=$headTitle?>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <form action="" method="post">

                                <?php if(isset($error)): ?>
                                    <p class="text-center">
                                        <?=$error?>
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

                                <button href="index.html" type="submit" class="btn btn-lg btn-success btn-block">
                                    <?=trans('Zaloguj się')?>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once ACTIONS_PATH.'/admin/parts/assets.html.php'; ?>

</body>
</html>
