<?php

$headTitle = trans("Zmiana hasła");
$breadcrumbs->push($request, $headTitle, 'fa-unlock-alt');

if (wasSentPost()) {

    $oldPassword = $_POST['old_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];
    $oldPasswordHash = sha1($oldPassword);
    $newPasswordHash = sha1($newPassword);

    $user = GC\Model\Staff::selectByPrimaryId($_SESSION['staff']['entity']['staff_id']);
    if (!$user) {
        redirect('/admin/account/logout');
    }

    # jeżeli hasło w bazie nie jest zahaszowane, a zgadza się
    if (!isSha1($user['password']) and $oldPassword === $user['password']) {
        GC\Model\Staff::updateByPrimaryId($user['staff_id'], [
            'password' => $oldPasswordHash,
        ]);
        $user['password'] = $oldPasswordHash;
    }

    if (strlen($newPassword) < $config['minPasswordLength']) {
        $error = trans('Hasło nie może być krótsze niż %s znaków', $config['minPasswordLength']);
    } elseif ($oldPasswordHash !== $user['password']) {
        $error = trans('Stare hasło nie zgadza się z obecnym hasłem');
    } elseif ($newPassword !== $confirmPassword) {
        $error = trans('Podane nowe hasła nie są identyczne');
    } else {
        GC\Model\Staff::updateByPrimaryId($user['staff_id'], [
            'password' => $newPasswordHash,
        ]);
        $user['password'] = $newPasswordHash;

        redirect('/admin');
    }
}

$_POST = [];

require_once ACTIONS_PATH.'/admin/parts/header.html.php';
require_once ACTIONS_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="post" id="form" class="form-horizontal">

            <?php if (isset($error)): ?>
                <p class="text-danger text-center">
                    <?=e($error)?>
                </p>
            <?php endif ?>

            <?=view('/admin/parts/input/editbox.html.php', [
                'name' => 'old_password',
                'type' => 'password',
                'label' => 'Stare hasło',
                'help' => 'Wprowadź swoje stare hasło dla bezpieczeństwa',
            ])?>

            <?=view('/admin/parts/input/editbox.html.php', [
                'name' => 'new_password',
                'type' => 'password',
                'label' => 'Nowe hasło',
                'help' => sprintf('Twoje hasło musi składać się z przynajmniej %s znaków', $config['minPasswordLength']),
            ])?>

            <?=view('/admin/parts/input/editbox.html.php', [
                'name' => 'confirm_password',
                'type' => 'password',
                'label' => 'Powtórz nowe hasło',
                'help' => 'Powtórz swoje nowe hasło dla bezpieczeństwa',
            ])?>

            <?=view('/admin/parts/input/submitButtons.html.php', [
                'saveLabel' => 'Zmień hasło',
            ])?>

        </form>
    </div>
</div>

<?php require_once ACTIONS_PATH.'/admin/parts/assets.html.php'; ?>

<script>
$(function () {
    $('#form').validate({
        rules: {
            old_password: {
                required: true
            },
            new_password: {
                required: true,
                minlength : <?=e($config['minPasswordLength'])?>
            },
            confirm_password: {
                required: true,
                equalTo: "#new_password"
            }
        },
        messages: {
            old_password: {
                required: "<?=trans('Stare hasło jest wymagane')?>"
            },
            new_password: {
                required: "<?=trans('Wprowadź nowe hasło')?>",
                minlength: "<?=trans('Nowe hasło powinno mieć przynajmniej %s znaków', $config['minPasswordLength'])?>"
            },
            confirm_password: {
                required: "<?=trans('Musisz powtórzyć swoje nowe hasło dla bezpieczeństwa')?>",
                equalTo: "<?=trans('Hasła nie są jednakowe')?>"
            }
        },
    });
});
</script>

<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
