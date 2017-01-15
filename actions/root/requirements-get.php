<?php

$headTitle = "Wymagania systemowe";
$breadcrumbs->push([
    'url' => '/root/requirements',
    'name' => $headTitle,
]);

$requiredCore = [
    [
        'name' => 'PHP',
        'required' => '5.5.9',
        'current' => PHP_VERSION,
    ],
    [
        'name' => 'MySQL',
        'required' => '5.6',
        'current' => GC\Data::get('database')->fetch('SELECT VERSION() AS version')['version'],
    ],
];

$requiredExtensions = [
    'ctype',
    'date',
    'filter',
    'iconv',
    'json',
    'Reflection',
    'mcrypt',
    'SPL',
    'session',
    'standard',
    'zlib',
    'PDO',
    'bz2',
    'SimpleXML',
    'xml',
    'openssl',
    'curl',
    'mbstring',
    'gd',
    'pdo_mysql',
];

$ini = ini_get_all();

function ini_access($access)
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
<?php require ACTIONS_PATH.'/admin/parts/header.html.php'; ?>
<?php require ACTIONS_PATH.'/admin/parts/page-header.html.php'; ?>

<h2>System</h2>
<table class="simple-box table table-condensed table-bordered" style="table-layout: fixed;">
    <thead>
        <th>Name</th>
        <th>Required version</th>
        <th>Current version</th>
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

<h2>PHP Extensions</h2>
<table class="table table-condensed table-bordered" style="table-layout: fixed;">
    <thead>
        <th>Name</th>
        <th>Required version</th>
        <th>Current version</th>
    </thead>
    <tbody>
        <?php foreach ($requiredExtensions as $extension): ?>
            <?php $status = extension_loaded($extension) ?>
            <tr class="<?=$status ? 'success' : 'danger'?>">
                <td><?=$extension?></td>
                <td>*</td>
                <td><?=phpversion($extension)?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<h2>Settings</h2>
<table class="table table-condensed table-bordered"  style="table-layout: fixed; font-size:12px">
    <thead>
        <th>Property</th>
        <th>Global value</th>
        <th>Local value</th>
        <th>Access</th>
    </thead>
    <tbody>
        <?php foreach ($ini as $name => $i): ?>
            <tr class="<?=$i['global_value'] == $i['local_value'] ? '' : 'warning'?>">
                <td><?=$name?></td>
                <td><?=$i['global_value']?></td>
                <td><?=$i['local_value']?></td>
                <td><?=ini_access($i['access'])?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?php require ACTIONS_PATH.'/admin/parts/assets/footer.html.php'; ?>
<?php require ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>