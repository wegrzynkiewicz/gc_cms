<?php

require ROUTES_PATH."/root/_only-root.php";
require ROUTES_PATH."/root/_import.php";
require ROUTES_PATH."/admin/_breadcrumbs.php";
require ROUTES_PATH."/root/_breadcrumbs.php";

$headTitle = trans("Panel kontrolny");
$breadcrumbs->push([
    'uri' => '/root/requirements',
    'name' => $headTitle,
]);

# przeparsowanie pliku composer.lock
$composer = json_decode(file_get_contents(ROOT_PATH."/composer.lock"), true);

# ustawienie wymagań systemowych
$requiredCore = [
    [
        'name' => 'PHP',
        'required' => $composer['platform']['php'] ?? '*',
        'current' => PHP_VERSION,
    ],
    [
        'name' => 'MySQL',
        'required' => '5.6.*',
        'current' => GC\Storage\Database::getInstance()->fetch('SELECT VERSION() AS version')['version'],
    ],
];

# pobranie wymaganych rozszerzeń z pliku composer.lock
$requiredExtensions = array_filter($composer['platform'], function($version, $extension) {
    return (bool) preg_match("~ext\-~", $extension);
}, ARRAY_FILTER_USE_BOTH);
ksort($requiredExtensions);

$ini = ini_get_all();

$ini_access = function ($access)
{
    $names = [
        1 => 'PHP_INI_USER',
        2 => 'PHP_INI_PERDIR',
        4 => 'PHP_INI_SYSTEM',
    ];

    if ($access == 7) {
        return 'PHP_INI_ALL';
    }

    $values = [];

    $bit = 0;
    foreach ($names as $key => $name) {
        $flag = $access & (1 << $bit);
        $bit++;
        if ($flag) {
            $values[] = $name;
        }
    }

    return implode('&nbsp;|&nbsp;', $values);
}

?>
<?php require ROUTES_PATH."/admin/parts/_header.html.php"; ?>
<?php require ROUTES_PATH."/admin/parts/_page-header.html.php"; ?>

<h2><?=trans('Wymagania systemowe')?></h2>
<table class="simple-box table table-condensed table-bordered" style="table-layout: fixed;">
    <thead>
        <th><?=trans('Nazwa wymagania')?></th>
        <th><?=trans('Wymagana wersja')?></th>
        <th><?=trans('Zainstalowana wersja')?></th>
    </thead>
    <tbody>
        <?php foreach ($requiredCore as $core): ?>
            <?php $status = version_compare($core['current'], $core['required'], '>='); ?>
            <tr class="<?=$status ? 'success' : 'danger'?>">
                <td><?=$core['name']?></td>
                <td><?=$core['required']?></td>
                <td><?=$core['current']?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<h2><?=trans('Rozszerzenia PHP')?></h2>
<table class="table table-condensed table-bordered" style="table-layout: fixed;">
    <thead>
        <th><?=trans('Nazwa rozszerzenia')?></th>
        <th><?=trans('Wymagana wersja')?></th>
        <th><?=trans('Zainstalowana wersja')?></th>
    </thead>
    <tbody>
        <?php foreach ($requiredExtensions as $extension => $required): ?>
            <?php $extension = substr($extension, 4); ?>
            <?php $status = extension_loaded($extension) ?>
            <tr class="<?=$status ? 'success' : 'danger'?>">
                <td><?=$extension?></td>
                <td><?=$required?></td>
                <td><?=phpversion($extension)?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<h2><?=trans('Foldery z prawami do zapisu')?></h2>
<table class="table table-condensed table-bordered" style="table-layout: fixed;">
    <thead>
        <th><?=trans('Katalog')?></th>
        <th><?=trans('Prawa dostępu')?></th>
    </thead>
    <tbody>
        <?php foreach (getWriteableDirs() ?? [] as $dir): ?>
            <?php $status = is_writeable($dir) ?>
            <tr class="<?=$status ? 'success' : 'danger'?>">
                <td><?=relativePath($dir)?></td>
                <td><?=decoct(fileperms($dir) & 0777)?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<h2><?=trans('Ustawienia PHP INI')?></h2>
<table class="table table-condensed table-bordered"  style="table-layout: fixed; font-size:12px">
    <thead>
        <th><?=trans('Właściwość')?></th>
        <th><?=trans('Wartość globalna')?></th>
        <th><?=trans('Wartość lokalna')?></th>
        <th><?=trans('Dostęp')?></th>
    </thead>
    <tbody>
        <?php foreach ($ini as $name => $i): ?>
            <tr class="<?=$i['global_value'] == $i['local_value'] ? '' : 'warning'?>">
                <td><?=$name?></td>
                <td><?=$i['global_value']?></td>
                <td><?=$i['local_value']?></td>
                <td><?=$ini_access($i['access'])?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?php require ROUTES_PATH."/admin/parts/_scripts.html.php"; ?>
<?php require ROUTES_PATH."/admin/parts/_end.html.php"; ?>
