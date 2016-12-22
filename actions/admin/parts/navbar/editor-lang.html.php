<?php if (count($config['langs']) > 1): ?>
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <span class="hidden-xs">
                <?=trans('Edytuj: ')?>
            </span>
            <?=GC\Render::action('/admin/parts/language.html.php', [
                'lang' => $_SESSION['lang']['editor']
            ])?>
            <b class="caret"></b>
        </a>
        <ul class="dropdown-menu dropdown-user">
            <?php foreach ($config['langs'] as $lang => $label): ?>
                <li>
                    <a href="<?=GC\Url::make("/admin/account/change-editor-lang/$lang")?>">
                        <?=GC\Render::action('/admin/parts/language.html.php', [
                            'lang' => $lang
                        ])?>
                    </a>
                </li>
            <?php endforeach ?>
        </ul>
    </li>
<?php endif ?>
