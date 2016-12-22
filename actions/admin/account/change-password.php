<?php

$headTitle = trans("Zmiana hasła");
$breadcrumbs->push($request, $headTitle, 'fa-unlock-alt');

if (isPost()) {

    $oldPassword = $_POST['old_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    $user = GC\Model\Staff::selectByPrimaryId($_SESSION['staff']['entity']['staff_id']);

    if (strlen($newPassword) < $config['password']['minLength']) {
        $error = trans('Hasło nie może być krótsze niż %s znaków', $config['password']['minLength']);
    } elseif (!GC\Password::verify($oldPassword, $user['password'])) {
        $error = trans('Stare hasło nie zgadza się z obecnym hasłem');
    } elseif ($newPassword !== $confirmPassword) {
        $error = trans('Podane nowe hasła nie są identyczne');
    } else {

        GC\Model\Staff::updateByPrimaryId($user['staff_id'], [
            'password' => GC\Password::hash($newPassword),
        ]);

        $_SESSION['flash-notice'] = trans("Twoje hasło zostało zmienione");

        GC\Response::redirect($breadcrumbs->getBeforeLastUrl());
    }
}

$_POST = [];

require ACTIONS_PATH.'/admin/parts/header.html.php';
require ACTIONS_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="post" id="form" class="form-horizontal">
            <div class="simple-box">
                <?php if (isset($error)): ?>
                    <div class="text-danger text-center">
                        <?=e($error)?>
                    </div>
                <?php endif ?>

                <?=GC\Render::action('/admin/parts/input/editbox.html.php', [
                    'name' => 'old_password',
                    'type' => 'password',
                    'label' => 'Stare hasło',
                    'help' => 'Wprowadź swoje stare hasło dla bezpieczeństwa',
                ])?>

                <?=GC\Render::action('/admin/parts/input/editbox.html.php', [
                    'name' => 'new_password',
                    'type' => 'password',
                    'label' => 'Nowe hasło',
                    'help' => sprintf('Twoje hasło musi składać się z przynajmniej %s znaków', $config['password']['minLength']),
                ])?>

                <?=GC\Render::action('/admin/parts/input/editbox.html.php', [
                    'name' => 'confirm_password',
                    'type' => 'password',
                    'label' => 'Powtórz nowe hasło',
                    'help' => 'Powtórz swoje nowe hasło dla bezpieczeństwa',
                ])?>
            </div>

            <?=GC\Render::action('/admin/parts/input/submitButtons.html.php', [
                'saveLabel' => 'Zmień hasło',
            ])?>

        </form>
    </div>
</div>

<?php require ACTIONS_PATH.'/admin/parts/assets/footer.html.php';; ?>

<script>
$(function () {
    $('#form').validate({
        rules: {
            old_password: {
                required: true
            },
            new_password: {
                required: true,
                minlength : <?=e($config['password']['minLength'])?>
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
                minlength: "<?=trans('Nowe hasło powinno mieć przynajmniej %s znaków', $config['password']['minLength'])?>"
            },
            confirm_password: {
                required: "<?=trans('Musisz powtórzyć swoje nowe hasło dla bezpieczeństwa')?>",
                equalTo: "<?=trans('Hasła nie są jednakowe')?>"
            }
        },
    });
});
</script>

<?php require ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
