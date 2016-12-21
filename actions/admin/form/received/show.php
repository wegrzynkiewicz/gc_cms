<?php

$message = GC\Model\FormSent::selectByPrimaryId($sent_id);
$data = json_decode($message['data'], true);
$name = reset($data);
$localization = json_decode($message['localization'], true);

$headTitle = trans('Wyświetl wiadomość');
$breadcrumbs->push($request, $headTitle);

if(isPost()) {

    GC\Model\FormSent::updateByPrimaryId($sent_id, [
        'status' => $_POST['status'],
    ]);

    setNotice(trans('Status wiadomośći został zaktualizowany.'));

	redirect($breadcrumbs->getBeforeLastUrl());
}

$_POST = $message;

require_once ACTIONS_PATH.'/admin/parts/header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="page-header">
            <div class="btn-toolbar pull-right">
                <a href="<?=$surl("/$sent_id/delete")?>"
                    type="button"
                    class="btn btn-danger btn-md">
                    <i class="fa fa-trash fa-fw"></i>
                    <?=trans('Usuń wiadomość')?>
                </a>
            </div>
            <h1><?=($headTitle)?></h1>
        </div>
    </div>
</div>

<?php require_once ACTIONS_PATH.'/admin/parts/breadcrumbs.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="post" id="form" class="form-horizontal">

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
                        <td><?=def($localization, 'ip')?></td>
                    </tr>
                    <tr>
                        <td><?=trans('Kraj / Miasto')?></td>
                        <td><?=def($localization, 'country', '').' / '.def($localization, 'city', '')?></td>
                    </tr>
                    <tr>
                        <td>User Agent</td>
                        <td><?=def($localization, 'userAgent', '')?></td>
                    </tr>
                </tbody>
            </table>

            <div class="simple-box">
                <?=view('/admin/parts/input/selectbox.html.php', [
                    'name' => 'status',
                    'label' => 'Status',
                    'help' => 'Status wiadomości jest pomocny przy filtrowaniu wiadomości.',
                    'options' => array_map(function ($status) {
                        return $status['name'];
                    }, $config['formStatuses']),
                ])?>
            </div>

            <?=view('/admin/parts/input/submitButtons.html.php', [
                'saveLabel' => 'Zapisz status',
            ])?>

        </form>
    </div>
</div>

<?php require_once ACTIONS_PATH.'/admin/parts/footer-assets.html.php'; ?>
<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
