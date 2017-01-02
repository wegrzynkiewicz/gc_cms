<?php

$files = array_filter(rglob('*.*'), function ($value) {
    return in_array(pathinfo($value, PATHINFO_EXTENSION), [
        'php', 'js', 'css', 'json', 'txt', 'md', 'html'
    ]);
});

$json = file_get_contents(ROOT_PATH.'/app/storage/checksum.json');
$stored = json_decode($json, true);

$checksums = [];
foreach($files as $file) {
    $key = trim($file, '.');
    $hash = sha1(file_get_contents($file));
    $checksums[] = [
        'file' => $key,
        'hash' => $hash,
        'status' => (isset($stored[$key]) and $stored[$key] === $hash)
    ];
}

usort($checksums, function ($a, $b) {
    return $a['status'] > $b['status'];
});

require ACTIONS_PATH.'/admin/parts/header.html.php';
require ACTIONS_PATH.'/admin/parts/page-header.html.php'; ?>

<table class="simple-box table table-condensed table-bordered">
    <thead>
        <th>Scieżka pliku</th>
        <th>Suma kontrolna pliku SHA1</th>
    </thead>
    <tbody style="font-family: monospace;">
        <?php foreach ($checksums as $checksum): ?>
            <?php $base64 = base64_encode($checksum['file']); ?>
            <tr class="<?=$checksum['status'] ? 'success' : 'danger'?>">
                <td>
                    <a href="<?=GC\Url::make("/root/checksum/show/{$base64}")?>">
                        <?=$checksum['file']?>
                    </a>
                </td>
                <td><?=$checksum['hash']?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?php require ACTIONS_PATH.'/admin/parts/assets/footer.html.php'; ?>
<?php require ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
