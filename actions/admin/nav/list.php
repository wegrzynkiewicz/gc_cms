<?php

$headTitle = trans("Nawigacje");

$staff = GCC\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

$navs = GCC\Model\MenuTaxonomy::selectAllCorrectWithPrimaryKey();

require_once ACTIONS_PATH.'/admin/parts/header.html.php'; ?>

<div class="row">
    <div class="col-lg-12 text-left">
        <h1 class="page-header">
            <?=$headTitle?>
        </h1>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <?php if (empty($navs)): ?>
            <p>
                <?=trans('Nie znaleziono żadnej nawigacji w języku: ')?>
                <?=view('/admin/parts/language.html.php')?>
            </p>
        <?php else: ?>
            <table class="table vertical-middle" data-table="">
                <thead>
                    <tr>
                        <th class="col-md-5">
                            <?=trans('Nazwa nawigacji:')?>
                        </th>
                        <th lass="col-md-7 text-right"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($navs as $nav_id => $nav): ?>
                        <tr>
                            <td><?=escape($nav['name'])?></td>
                            <td class="text-right">
                                <a href="<?=url("/admin/nav/menu/list/$nav_id")?>" class="btn btn-success btn-xs">
                                    <i class="fa fa-file-text-o fa-fw"></i>
                                    <?=trans('Węzły nawigacji')?>
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
