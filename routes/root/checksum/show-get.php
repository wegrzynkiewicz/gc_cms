<?php

require ROUTES_PATH.'/root/_import.php';
require ROUTES_PATH.'/root/checksum/_import.php';

$base64 = array_shift($_SEGMENTS);
$file = base64_decode($base64);

$headTitle = sprintf('Źródło pliku "%s"', $file);
$breadcrumbs->push([
    'name' => $headTitle,
    'icon' => 'file-o',
]);

$filepath = ROOT_PATH.$file;
$content = file_get_contents($filepath);
$checksum = sha1($content);
$entity = GC\Model\Checksum::select()->equals('file', $file)->fetch();
$status = $entity['hash'] === $checksum;
$code = substr(highlight_string($content, true), 36, -15);
$lines = explode('<br />', $code);
$lineCount = count($lines);
$padLength = strlen($lineCount);

?>
<?php require ROUTES_PATH.'/admin/parts/header.html.php'; ?>
<?php require ROUTES_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="<?=$status ? 'bg-success' : 'bg-danger'?>">
    <pre class="simple-box" style="background-color: initial">SHA1: <span class=""><?=$checksum?></span></pre>
</div>

<pre class="simple-box" style="padding:5px; line-height: 1.1; ">
<?php foreach ($lines as $i => $line): $lineNumber = str_pad($i+1,  $padLength, '0', STR_PAD_LEFT) ?>
<span style="color: #999999"> <?=$lineNumber?> | </span><?=trim($line)?>

<?php endforeach ?>
</pre>

<?php require ROUTES_PATH.'/admin/parts/assets/footer.html.php'; ?>
<?php require ROUTES_PATH.'/admin/parts/footer.html.php'; ?>
