<nav class="navbar navbar-inverse navbar-static-top" style="margin-bottom: 0">

    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only"><?=trans('Rozwiń nawigację')?></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?=$uri->make("/admin")?>">
            <?=trans($config['adminNavbarTitle'])?>
        </a>
    </div>

    <ul class="nav navbar-top-links navbar-right text-right">

        <?php require ROUTES_PATH.'/admin/_parts/navbar/editor-lang.html.php'; ?>
        <?php require ROUTES_PATH.'/admin/_parts/navbar/session-timeout.html.php'; ?>
        <?php require ROUTES_PATH.'/admin/_parts/navbar/staff.html.php'; ?>

    </ul>

    <?php require ROUTES_PATH.'/admin/_parts/sidebar/main.html.php'; ?>

</nav>
