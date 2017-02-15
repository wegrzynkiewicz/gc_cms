<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/account/_import.php';

$headTitle = $trans('Zmiana hasła');
$breadcrumbs->push([
    'uri' => $request->uri,
    'name' => $headTitle,
    'icon' => 'unlock-alt',
]);

$_POST = [];

?>
<?php require ACTIONS_PATH.'/admin/parts/header.html.php'; ?>
<?php require ACTIONS_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="post" id="form" class="form-horizontal">
            <div class="simple-box">
                <?php if (isset($error)): ?>
                    <div class="text-danger text-center">
                        <?=e($error)?>
                    </div>
                <?php endif ?>

                <?=render(ACTIONS_PATH.'/admin/parts/input/editbox.html.php', [
                    'name' => 'old_password',
                    'type' => 'password',
                    'label' => $trans('Stare hasło'),
                    'help' => $trans('Wprowadź swoje stare hasło dla bezpieczeństwa'),
                ])?>

                <?=render(ACTIONS_PATH.'/admin/parts/input/editbox.html.php', [
                    'name' => 'new_password',
                    'type' => 'password',
                    'label' => $trans('Nowe hasło'),
                    'help' => $trans('Twoje hasło musi składać się z przynajmniej %s znaków', [$config['password']['minLength']]),
                ])?>

                <?=render(ACTIONS_PATH.'/admin/parts/input/editbox.html.php', [
                    'name' => 'confirm_password',
                    'type' => 'password',
                    'label' => $trans('Powtórz nowe hasło'),
                    'help' => $trans('Powtórz swoje nowe hasło dla bezpieczeństwa'),
                ])?>
            </div>

            <?=render(ACTIONS_PATH.'/admin/parts/input/submitButtons.html.php', [
                'saveLabel' => $trans('Zmień hasło'),
            ])?>

        </form>
    </div>
</div>

<?php require ACTIONS_PATH.'/admin/parts/assets/footer.html.php'; ?>

<script>
$(function () {
    $('form').validate({
        rules: {
            old_password: {
                required: true
            },
            new_password: {
                required: true,
                minlength : <?=$config['password']['minLength']?>
            },
            confirm_password: {
                required: true,
                equalTo: "#new_password"
            }
        },
        messages: {
            old_password: {
                required: "<?=$trans('Stare hasło jest wymagane')?>"
            },
            new_password: {
                required: "<?=$trans('Wprowadź nowe hasło')?>",
                minlength: "<?=$trans('Nowe hasło powinno mieć przynajmniej %s znaków', [$config['password']['minLength']])?>"
            },
            confirm_password: {
                required: "<?=$trans('Musisz powtórzyć swoje nowe hasło dla bezpieczeństwa')?>",
                equalTo: "<?=$trans('Hasła nie są jednakowe')?>"
            }
        },
    });
});
</script>

<?php require ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
