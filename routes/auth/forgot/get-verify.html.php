<?php

require ROUTES_PATH.'/auth/_import.php';

$validate = function() use ($_SEGMENTS)
{
    # link ma zawierać równo dwa segmenty
    if (count($_SEGMENTS)<2) {
        return false;
    }

    $email64 = array_shift($_SEGMENTS);
    $email = base64_decode($email64);
    $regenerationVerifyHash = array_shift($_SEGMENTS);

    # pobierz pracownika po adresie email
    $user = GC\Model\Staff\Staff::select()
        ->equals('email', $email)
        ->fetch();

    if (!$user) {
        return false;
    }

    # pobierz wszystkie meta dane
    $meta = GC\Model\Staff\Meta::fetchMeta($user['staff_id']);

    if (!isset($meta['regenerationVerifyHash']) or $meta['regenerationVerifyHash'] !== $regenerationVerifyHash) {
        return false;
    }

    if (!isset($meta['regenerationVerifyTime']) or time() - $meta['regenerationVerifyTime'] > 3600) {
        return false;
    }

    # ustawienie sesji pracownika
    $_SESSION['staff']['staff_id'] = $user['staff_id'];

    return true;
};

if ($validate() === true) {
    redirect($uri->make('/auth/forgot/enter-new-password'));
}

$headTitle = trans('Wystąpił problem podczas resetowia hasła');

?>
<?php require ROUTES_PATH.'/admin/parts/header-login.html.php'; ?>

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
                            <?=trans('Link do zmiany hasła wygasł lub hasło zostało już zresetowane');?>
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

<?php require ROUTES_PATH.'/admin/parts/assets/footer.html.php'; ?>

</body>
</html>
