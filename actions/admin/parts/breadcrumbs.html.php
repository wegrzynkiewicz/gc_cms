
<?php if (isset($_SESSION['notice'])): ?>
    <div class="alert alert-<?=$_SESSION['notice']['theme']?> alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
        <?=$_SESSION['notice']['message']?>
    </div>

    <script>
        $(".alert").delay(4000).slideUp(200, function() {
            $(this).alert('close');
        });
    </script>

    <?php unset($_SESSION['notice']); ?>
<?php endif ?>

<?php if (isset($breadcrumbs)): $links = $breadcrumbs->getLinks() ?>
    <?php if (count($links)): ?>
        <ol class="breadcrumb">
            <?php foreach ($links as $i => $link): ?>
                <?php $isLink = !(empty($link['url']) or $link['url'] == $request->path); ?>
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
