<?php
$langs = GC\Model\Lang::select()->sort('position', 'ASC')->fetchByPrimaryKey();
$currentLang = $langs[$_SESSION['lang']['editor']];
?>

<?php if (count($langs) > 1): ?>
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <span class="hidden-xs">
                <?=trans('Edytuj: ')?>
            </span>
            <?=GC\Render::action('/admin/parts/language.html.php', [
                'lang' => $currentLang,
            ])?>
            <b class="caret"></b>
        </a>
        <ul class="dropdown-menu dropdown-user">
            <?php foreach ($langs as $code => $lang): ?>
                <li>
                    <a href="<?=GC\Url::make("/admin/account/change-editor-lang/{$code}")?>">
                        <?=GC\Render::action('/admin/parts/language.html.php', [
                            'lang' => $lang,
                        ])?>
                    </a>
                </li>
            <?php endforeach ?>
        </ul>
    </li>
<?php endif ?>
