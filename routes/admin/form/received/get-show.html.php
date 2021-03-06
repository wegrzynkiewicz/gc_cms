<?php

require ROUTES_PATH."/admin/_import.php";
require ROUTES_PATH."/admin/_breadcrumbs.php";
require ROUTES_PATH."/admin/form/_import.php";
require ROUTES_PATH."/admin/form/received/_import.php";

$sent_id = intval(array_shift($_PARAMETERS));
$message = GC\Model\Form\Sent::fetchByPrimaryId($sent_id);
$data = json_decode($message['data'], true);
$name = reset($data);
$localization = json_decode($message['localization'], true);

$headTitle = trans('Wyświetl wiadomość');
$breadcrumbs->push([
    'name' => $headTitle,
]);

$_POST = $message;

?>
<?php require ROUTES_PATH."/admin/parts/_header.html.php"; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="page-header">
            <div class="btn-toolbar pull-right">
                <a href="<?=$uri->make("/admin/form/received/{$sent_id}/delete")?>"
                    type="button"
                    class="btn btn-danger btn-md">
                    <i class="fa fa-trash fa-fw"></i>
                    <?=trans('Usuń wiadomość')?>
                </a>
            </div>
            <h1><?=$headTitle?></h1>
        </div>
    </div>
</div>

<?php require ROUTES_PATH."/admin/parts/_breadcrumbs.html.php"; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="<?=$request->uri?>" method="post" id="form" class="form-horizontal">

            <h3><?=trans('Treść formularza')?></h3>
            <table class="table table-bordered vertical-middle simple-box">
                <tbody>
                    <?php foreach ($data as $label => $value): ?>
                        <tr>
                            <td><?=e($label)?></td>
                            <td><?=e($value)?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>

            <h3><?=trans('Dane lokalizacyjne')?></h3>
            <table class="table table-bordered vertical-middle simple-box">
                <tbody>
                    <tr>
                        <td><?=trans('Data wysłania')?></td>
                        <td><?=sqldate()?></td>
                    </tr>
                    <tr>
                        <td>IP</td>
                        <td><?=$localization['ip'] ?? ''?></td>
                    </tr>
                    <tr>
                        <td><?=trans('Kraj / Miasto')?></td>
                        <td><?=($localization['country'] ?? '').' / '.($localization['city'] ?? '')?></td>
                    </tr>
                    <tr>
                        <td>User Agent</td>
                        <td><?=$localization['userAgent'] ?? ''?></td>
                    </tr>
                </tbody>
            </table>

            <div class="simple-box">
                <?=render(ROUTES_PATH."/admin/parts/input/_selectbox.html.php", [
                    'name' => 'status',
                    'label' => trans('Status'),
                    'help' => trans('Status wiadomości jest pomocny przy filtrowaniu wiadomości.'),
                    'options' => array_map(function ($status) {
                        return $status['name'];
                    }, $config['formStatuses']),
                ])?>
            </div>

            <?=render(ROUTES_PATH."/admin/parts/input/_submitButtons.html.php", [
                'saveLabel' => trans('Zapisz status'),
            ])?>

        </form>
    </div>
</div>

<?php require ROUTES_PATH."/admin/parts/_scripts.html.php"; ?>
<?php require ROUTES_PATH."/admin/parts/_end.html.php"; ?>
