<?php

$stored = GC\Model\Checksum::selectAllWithPrimaryKey();

$checksums = [];
foreach($getFiles() as $file) {
    $key = trim($file, '.');
    $hash = sha1(file_get_contents($file));
    $checksums[$key] = [
        'file' => $key,
        'hash' => $hash,
        'exists' => isset($stored[$key]),
        'status' => isset($stored[$key]) and ($stored[$key]['hash'] == $hash)
    ];
}

usort($checksums, function ($a, $b) {
    if ($a['status'] > $b['status']) {
        return true;
    } elseif ($a['status'] == $b['status']) {
        return strnatcmp($a['file'], $b['file']);
    }

    return false;
});

require ACTIONS_PATH.'/admin/parts/header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="page-header">
            <div class="btn-toolbar pull-right">
                <button
                    data-toggle="modal"
                    data-target="#refreshAllModal"
                    class="btn btn-primary">
                    <i class="fa fa-refresh fa-fw"></i>
                    <?=trans('Odśwież wszystkie')?>
                </button>
            </div>
            <h1><?=($headTitle)?></h1>
        </div>
    </div>
</div>

<?php require ACTIONS_PATH.'/admin/parts/breadcrumbs.html.php'; ?>

<table class="simple-box table table-condensed">
    <thead>
        <th>Scieżka pliku</th>
        <th>Suma kontrolna pliku SHA1</th>
        <th></th>
    </thead>
    <tbody style="font-family: monospace;">
        <?php foreach ($checksums as $checksum): ?>
            <?=GC\Render::action('/root/checksum/list-item.html.php', [
                'checksum' => $checksum,
            ])?>
        <?php endforeach ?>
    </tbody>
</table>

<div id="refreshAllModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="refreshAllModalForm"
            method="post"
            action="<?=GC\Url::mask("/refresh-all")?>"
            class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
                <h2 class="modal-title">
                    <?=trans("Czy na pewno odświeżyć?")?>
                </h2>
            </div>
            <div class="modal-body">
                <?=trans("Czy jesteś pewien, że chcesz odświeżyć wszystkie pliki?")?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <?=trans('Anuluj')?>
                </button>
                <button type="submit" class="btn btn-primary btn-ok">
                    <?=trans('Odśwież')?>
                </button>
            </div>
        </form>
    </div>
</div>

<div id="refreshModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="refreshModalForm"
            method="post"
            action="<?=GC\Url::mask("/refresh")?>"
            class="modal-content">
            <input name="file" type="hidden" value="">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
                <h2 class="modal-title">
                    <?=trans("Czy na pewno odświeżyć?")?>
                </h2>
            </div>
            <div class="modal-body">
                <?=trans("Czy jesteś pewien, że chcesz odświeżyć plik")?>
                <span id="name" style="font-weight:bold; color:blue;"></span>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <?=trans('Anuluj')?>
                </button>
                <button type="submit" class="btn btn-primary btn-ok">
                    <?=trans('Odśwież')?>
                </button>
            </div>
        </form>
    </div>
</div>

<?php require ACTIONS_PATH.'/admin/parts/assets/footer.html.php'; ?>

<script>
    $(function(){
        $('#refreshModal').on('show.bs.modal', function(e) {
            $(this).find('#name').html($(e.relatedTarget).data('name'));
            $(this).find('[name="file"]').val($(e.relatedTarget).data('id'));
        });
    });
</script>

<?php require ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
