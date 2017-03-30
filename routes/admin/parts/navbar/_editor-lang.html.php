<?php
$langs = $config['langs'];
?>
<?php if (count($langs) > 1): ?>
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <span class="hidden-xs">
                <?=trans('Edytuj: ')?>
            </span>
            <?=render(ROUTES_PATH.'/admin/parts/_language.html.php', [
                'lang' => GC\Staff::getInstance()->getEditorLang(),
            ])?>
            <b class="caret"></b>
        </a>
        <ul class="dropdown-menu dropdown-user">
            <?php foreach ($langs as $code => $lang): ?>
                <li>
                    <a href="<?=$uri->make("/admin/account/change-editor-lang/{$code}")?>">
                        <?=render(ROUTES_PATH.'/admin/parts/_language.html.php', [
                            'lang' => $code,
                        ])?>
                    </a>
                </li>
            <?php endforeach ?>
        </ul>
    </li>
<?php endif ?>
