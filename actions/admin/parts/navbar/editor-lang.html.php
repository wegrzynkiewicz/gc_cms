<?php if (count($config['langs']) > 1): ?>
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <span class="hidden-xs">
                <?=trans('Edytuj: ')?>
            </span>
            <?=view('/admin/parts/language.html.php', [
                'lang' => $_SESSION['lang']['editor']
            ])?>
            <b class="caret"></b>
        </a>
        <ul class="dropdown-menu dropdown-user">
            <?php foreach ($config['langs'] as $lang => $label): ?>
                <li>
                    <a href="<?=url("/admin/account/change-editor-lang/$lang")?>">
                        <?=view('/admin/parts/language.html.php', [
                            'lang' => $lang
                        ])?>
                    </a>
                </li>
            <?php endforeach ?>
        </ul>
    </li>
<?php endif ?>
