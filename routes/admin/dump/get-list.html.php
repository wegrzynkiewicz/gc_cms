<?php

require ROUTES_PATH."/admin/_import.php";
require ROUTES_PATH."/admin/_breadcrumbs.php";
require ROUTES_PATH."/admin/dump/_import.php";

$dumps = GC\Model\Dump::select()
    ->order('creation_datetime', 'DESC')
    ->fetchByPrimaryKey();

?>
<?php require ROUTES_PATH."/admin/parts/_header.html.php"; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="page-header">
            <div class="btn-toolbar pull-right">
                <button
                    data-toggle="modal"
                    data-target="#addModal"
                    class="btn btn-success btn-md">
                    <i class="fa fa-plus fa-fw"></i>
                    <?=trans('Utwórz kopię zapasową')?>
                </button>
            </div>
            <h1><?=$headTitle?></h1>
        </div>
    </div>
</div>

<?php require ROUTES_PATH."/admin/parts/_breadcrumbs.html.php"; ?>

<div class="row">
    <div class="col-md-12">
        <div class="simple-box">
            <?php if (empty($dumps)): ?>
                <?=trans('Nie znaleziono żadnej kopii zapasowej')?>
            <?php else: ?>
                <table class="table vertical-middle" data-table="">
                    <thead>
                        <tr>
                            <th><?=trans('Nazwa kopii')?></th>
                            <th><?=trans('Data utworzenia')?></th>
                            <th><?=trans('Rozmiar')?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dumps as $dump_id => $dump): ?>
                            <?=render(ROUTES_PATH."/admin/dump/_list-item.html.php", [
                                'dump_id' => $dump_id,
                                'dump' => $dump,
                            ])?>
                        <?php endforeach ?>
                    </tbody>
                </table>
            <?php endif ?>
        </div>
        <?php require ROUTES_PATH."/admin/parts/input/_submitButtons.html.php"; ?>
    </div>
</div>

<div id="addModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <form id="addModalForm"
            method="post"
            action="<?=$uri->make('/admin/dump/new')?>"
            class="modal-content form-horizontal">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
                <h2 class="modal-title">
                    <?=trans('Utwórz kopię zapasową')?>
                </h2>
            </div>
            <div class="modal-body">
                <?=render(ROUTES_PATH."/admin/parts/input/_editbox.html.php", [
                    'name' => 'name',
                    'label' => trans('Nazwa kopii zapasowej'),
                ])?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <?=trans('Anuluj')?>
                </button>
                <button type="submit" class="btn btn-success btn-ok">
                    <?=trans('Dodaj')?>
                </button>
            </div>
        </form>
    </div>
</div>

<?php require ROUTES_PATH."/admin/parts/_scripts.html.php"; ?>

<script>
    $(function(){
        var table = $('[data-table]').DataTable({
            order: [],
            iDisplayLength: <?=$config['dataTable']['iDisplayLength']?>,
        });
    });
</script>

<?php require ROUTES_PATH."/admin/parts/_end.html.php"; ?>
