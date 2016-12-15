<?php

$headTitle = trans("Podziały wpisów");

$staff = GC\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

$taxonomies = GC\Model\PostTaxonomy::selectAllCorrectWithPrimaryKey();

require_once ACTIONS_PATH.'/admin/parts/header.html.php'; ?>

<div class="row">
    <div class="col-lg-12 text-left">
        <h1 class="page-header">
            <?=($headTitle)?>
        </h1>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <?php if (empty($taxonomies)): ?>
            <p>
                <?=trans('Nie znaleziono podziałów wpisów w języku: ')?>
                <?=view('/admin/parts/language.html.php')?>
            </p>
        <?php else: ?>
            <table class="table vertical-middle" data-table="">
                <thead>
                    <tr>
                        <th class="col-md-11 col-lg-11">
                            <?=trans('Nazwa widżetu')?>
                        </th>
                        <th class="col-md-1 col-lg-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($taxonomies as $tax_id => $taxonomy): ?>
                        <tr>
                            <td>
                                <?=e($taxonomy['name'])?>
                            </td>
                            <td>
                                <a href="<?=url("/admin/post/node/list/$tax_id")?>"
                                    title="<?=trans('Wyświetl węzły podziału')?>"
                                    class="btn btn-success btn-xs">
                                    <i class="fa fa-file-text-o fa-fw"></i>
                                    <?=trans("Węzły")?>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        <?php endif ?>
    </div>
</div>

<?php require_once ACTIONS_PATH.'/admin/parts/assets.html.php'; ?>

<script>
    $(function(){
        $('[data-table]').DataTable();
    });
</script>

<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
