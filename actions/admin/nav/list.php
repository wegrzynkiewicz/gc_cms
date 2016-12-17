<?php

$navs = GC\Model\MenuTaxonomy::selectAllCorrectWithPrimaryKey();

require_once ACTIONS_PATH.'/admin/parts/header.html.php';
require_once ACTIONS_PATH.'/admin/parts/page-header.html.php'; ?>

<div class="row">
    <div class="col-md-12">
        <div class="simple-box">
            <?php if (empty($navs)): ?>
                <?=trans('Nie znaleziono żadnej nawigacji w języku: ')?>
                <?=view('/admin/parts/language.html.php')?>
            <?php else: ?>
                <table class="table vertical-middle" data-table="">
                    <thead>
                        <tr>
                            <th><?=trans('Nazwa nawigacji')?></th>
                            <th class="text-right"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($navs as $nav_id => $nav): ?>
                            <tr>
                                <td><?=e($nav['name'])?></td>
                                <td class="text-right">
                                    <a href="<?=url("/admin/nav/menu/list/$nav_id")?>"
                                        class="btn btn-success btn-sm">
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
        <?=view('/admin/parts/input/submitButtons.html.php')?>
    </div>
</div>

<?php require_once ACTIONS_PATH.'/admin/parts/footer-assets.html.php'; ?>
<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
