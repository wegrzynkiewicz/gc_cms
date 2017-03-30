<?php if (isset($breadcrumbs)): $links = $breadcrumbs->getLinks() ?>
    <?php if (count($links)): ?>
        <ol class="breadcrumb">
            <?php foreach ($links as $i => $link): ?>
                <?php $isLink = !(empty($link['uri']) or $link['uri'] == $request->uri); ?>
                <li class="<?=$isLink ? '' : 'active'?>">
                    <?php if ($isLink): ?>
                        <a href="<?=$link['uri']?>">
                    <?php endif ?>
                        <?php if (isset($link['icon'])): ?>
                            <i class="fa fa-<?=$link['icon']?> fa-fw"></i>
                        <?php endif ?>
                        <?=$link['name']?>
                    <?php if ($isLink): ?>
                        </a>
                    <?php endif ?>
                </li>
            <?php endforeach ?>
        </ol>
    <?php endif ?>
<?php endif ?>

<?php if (isset($_SESSION['flashBox'])): ?>

    <div class="alert alert-<?=$_SESSION['flashBox']['theme']?> alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
        <?=$_SESSION['flashBox']['message']?>
    </div>

    <?php if ($_SESSION['flashBox']['time'] > 0): ?>
        <script>
            $(".alert").delay(<?=$_SESSION['flashBox']['time']?>).slideUp(200, function() {
                $(this).alert('close');
            });
        </script>
    <?php endif ?>

    <?php unset($_SESSION['flashBox']); ?>
<?php endif ?>
