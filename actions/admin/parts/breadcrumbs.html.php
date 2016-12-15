<?php if (isset($breadcrumbs) and count($breadcrumbs->getLinks()) > 1): ?>
    <ol class="breadcrumb" style="background-color: #eeeeee">
        <?php foreach ($breadcrumbs->getLinks() as $e): ?>
            <li class="<?=empty($e['url']) ? '' : 'active'?>">
                <?php if (!empty($e['url'])): ?>
                    <a href="<?=$e['url']?>">
                <?php endif ?>
                    <?php if ($e['icon']): ?>
                        <i class="fa <?=$e['icon']?> fa-fw"></i>
                    <?php endif ?>
                    <?=$e['title']?>
                <?php if (!empty($e['url'])): ?>
                    </a>
                <?php endif ?>
            </li>
        <?php endforeach ?>
    </ol>
<?php endif ?>
