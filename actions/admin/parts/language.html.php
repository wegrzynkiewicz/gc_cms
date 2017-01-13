<?php
$lang = (isset($lang) and is_array($lang))
    ? $lang
    : GC\Container::get('config')['langs'][GC\Auth\Staff::getEditorLang()]
?>
<span class="flag-icon flag-icon-<?=e($lang['flag'])?>"></span>
<?=$trans($lang['name'])?>
