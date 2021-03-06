<?php

require ROUTES_PATH."/root/_only-debug.php";
require ROUTES_PATH."/root/_only-root.php";
require ROUTES_PATH."/root/_import.php";
require ROUTES_PATH."/admin/_breadcrumbs.php";
require ROUTES_PATH."/root/_breadcrumbs.php";
require ROUTES_PATH."/root/checksum/_import.php";

$stored = GC\Model\Checksum::select()
    ->fields(['file', 'hash'])
    ->fetchByPrimaryKey();

$checksums = [];
foreach(getSourceFiles() as $file) {
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

?>
<?php require ROUTES_PATH."/admin/parts/_header.html.php"; ?>

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
            <h1><?=$headTitle?></h1>
        </div>
    </div>
</div>

<?php require ROUTES_PATH."/admin/parts/_breadcrumbs.html.php"; ?>

<table class="simple-box table table-condensed">
    <thead>
        <th>Scieżka pliku</th>
        <th>Suma kontrolna pliku SHA1</th>
        <th></th>
    </thead>
    <tbody style="font-family: monospace;">
        <?php foreach ($checksums as $checksum): ?>
            <?=render(ROUTES_PATH."/root/checksum/_list-item.html.php", [
                'checksum' => $checksum,
            ])?>
        <?php endforeach ?>
    </tbody>
</table>

<div id="refreshAllModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="refreshAllModalForm"
            method="post"
            action="<?=$uri->make("/root/checksum/refresh-all")?>"
            class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
                <h2 class="modal-title">
                    <?=trans('Czy na pewno odświeżyć?')?>
                </h2>
            </div>
            <div class="modal-body">
                <?=trans('Czy jesteś pewien, że chcesz odświeżyć wszystkie pliki?')?>
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
            action="<?=$uri->make("/root/checksum/refresh")?>"
            class="modal-content">
            <input name="file" type="hidden" value="">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
                <h2 class="modal-title">
                    <?=trans('Czy na pewno odświeżyć?')?>
                </h2>
            </div>
            <div class="modal-body">
                <?=trans('Czy jesteś pewien, że chcesz odświeżyć plik')?>
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

<?php require ROUTES_PATH."/admin/parts/_scripts.html.php"; ?>

<script>
    $(function(){
        $('#refreshModal').on('show.bs.modal', function (event) {
            $(this).find('#name').html($(event.relatedTarget).data('name'));
            $(this).find('[name="file"]').val($(event.relatedTarget).data('id'));
        });
    });
</script>

<?php require ROUTES_PATH."/admin/parts/_end.html.php"; ?>
