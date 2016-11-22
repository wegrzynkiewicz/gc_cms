<?php

$headTitle = trans("Nawigacje");

checkPermissions();

$navs = NavModel::selectAll();

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
                <?=trans('Nie znaleziono żadnej nawigacji.')?>
            </p>
        <?php else: ?>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th class="col-md-7">
                            <?=trans('Nazwa nawigacji:')?>
                        </th>
                        <th class="col-md-3">
                            <?=trans('Język:')?>
                        </th>
                        <th lass="col-md-2 text-right"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($navs as $nav_id => $nav): ?>
                        <tr>
                            <td><?=escape($nav['name'])?></td>
                            <td><?=trans($config['langs'][$nav['lang']])?></td>
                            <td class="text-right">
                                <a href="<?=url("/admin/nav-node/list/$nav_id")?>" class="btn btn-success btn-md">
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
<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
