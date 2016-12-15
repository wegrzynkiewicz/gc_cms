<?php if (isset($breadcrumbs)): $links = $breadcrumbs->getLinks() ?>
    <?php if (count($links) > 1): ?>
        <ol class="breadcrumb" style="background-color: #eeeeee">
            <?php foreach ($links as $i => $link): ?>
                <?php $isLink = !(empty($link['url']) or $link['url'] == $request); ?>
                <li class="<?=e($isLink ? '' : 'active')?>">
                    <?php if ($isLink): ?>
                        <a href="<?=e($link['url'])?>">
                    <?php endif ?>
                        <?php if ($link['icon']): ?>
                            <i class="fa <?=e($link['icon'])?> fa-fw"></i>
                        <?php endif ?>
                        <?=($link['title'])?>
                    <?php if ($isLink): ?>
                        </a>
                    <?php endif ?>
                </li>
            <?php endforeach ?>
        </ol>
    <?php endif ?>
<?php endif ?>
