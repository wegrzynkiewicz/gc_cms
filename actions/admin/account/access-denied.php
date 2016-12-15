<?php

$headTitle = trans("Brak dostępu");

$permission = array_shift($_SEGMENTS);

require_once ACTIONS_PATH.'/admin/parts/header.html.php';
require_once ACTIONS_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <p>
            <?php if ($permission == 'default'): ?>
                <?=trans("Nie masz uprawnień do wykonania tej akcji.")?>
            <?php else: ?>
                <?=trans("Nie masz uprawnień do:")?>
                <strong>
                    <?=trans($config['permissions'][$permission])?>
                </strong>
            <?php endif ?>
        </p>
    </div>
</div>

<?php require_once ACTIONS_PATH.'/admin/parts/assets.html.php'; ?>
<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
