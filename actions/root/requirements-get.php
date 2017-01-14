<?php

$headTitle = "Wymagania systemowe";
$breadcrumbs->push('/root/requirements', $headTitle);

$minimumPHPVersion = '5.5.9';
$requiredExtensions = [
    'Core',
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

<table class="simple-box table table-condensed table-bordered">
    <thead>
        <th>Wymagana wersja</th>
        <th>Czy kompatybilna?</th>
    </thead>
    <tbody>
        <?php $status = version_compare(PHP_VERSION, $minimumPHPVersion, '>=') ?>
        <tr class="<?=$status ? 'success' : 'danger'?>">
            <td>PHP &gt;= <?=$minimumPHPVersion?></td>
            <td><?=$status ? 'Tak' : 'Nie' ?></td>
        </tr>
    </tbody>
</table>

<table class="table table-condensed table-bordered">
    <thead>
        <th>Rozszerzenie</th>
        <th>Czy załadowane?</th>
    </thead>
    <tbody>
        <?php foreach ($requiredExtensions as $extension): ?>
            <?php $status = extension_loaded($extension) ?>
            <tr class="<?=$status ? 'success' : 'danger'?>">
                <td><?=$extension?></td>
                <td><?=$status ? 'Tak' : 'Nie' ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<table class="table table-condensed table-bordered" style="font-size:12px">
    <thead>
        <th>Właściwość</th>
        <th>Globalna wartość</th>
        <th>Lokalna wartość</th>
        <th>Dostęp</th>
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
