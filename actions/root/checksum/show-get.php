<?php

$base64 = array_shift($_SEGMENTS);
$file = base64_decode($base64);

$headTitle = sprintf('Źródło pliku "%s"', $file);
$breadcrumbs->push($request->path, $headTitle, 'fa-file-o');

$json = file_get_contents(ROOT_PATH.'/app/storage/checksum.json');
$stored = json_decode($json, true);

$filepath = ROOT_PATH.$file;
$content = file_get_contents($filepath);
$checksum = sha1($content);
$status = isset($stored[$file]) and $stored[$file] === $checksum;
$code = substr(highlight_string($content, true), 36, -15);
$lines = explode('<br />', $code);
$lineCount = count($lines);
$padLength = strlen($lineCount);

require ACTIONS_PATH.'/admin/parts/header.html.php';
require ACTIONS_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="<?=$status ? 'bg-success' : 'bg-danger'?>">
    <pre class="simple-box" style="background-color: initial">SHA1: <span class=""><?=$checksum?></span></pre>
</div>

<pre class="simple-box" style="padding:5px; line-height: 1.1; ">
<?php foreach($lines as $i => $line): $lineNumber = str_pad($i+1,  $padLength, '0', STR_PAD_LEFT) ?>
<span style="color: #999999"> <?=$lineNumber?> | </span><?=trim($line)?>

<?php endforeach ?>
</pre>

<?php require ACTIONS_PATH.'/admin/parts/assets/footer.html.php'; ?>
<?php require ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
