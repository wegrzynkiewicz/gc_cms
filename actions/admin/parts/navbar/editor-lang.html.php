<?php
$langs = $config['langs'];
?>
<?php if (count($langs) > 1): ?>
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <span class="hidden-xs">
                <?=$trans('Edytuj: ')?>
            </span>
            <?=GC\Render::file(ACTIONS_PATH.'/admin/parts/language.html.php', [
                'lang' => GC\Auth\Staff::getEditorLang(),
            ])?>
            <b class="caret"></b>
        </a>
        <ul class="dropdown-menu dropdown-user">
            <?php foreach ($langs as $code => $lang): ?>
                <li>
                    <a href="<?=GC\Url::make("/admin/account/change-editor-lang/{$code}")?>">
                        <?=GC\Render::file(ACTIONS_PATH.'/admin/parts/language.html.php', [
                            'lang' => $code,
                        ])?>
                    </a>
                </li>
            <?php endforeach ?>
        </ul>
    </li>
<?php endif ?>
