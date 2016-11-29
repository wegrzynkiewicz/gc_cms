<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">

    <div class="navbar-header">
        <a class="navbar-brand" href="<?=url("/admin")?>">
            <?=trans($config['adminNavbarTitle'])?>
        </a>
    </div>

    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>

    <!-- Top MenuTaxonomyigation: Left Menu -->
    <!-- <ul class="nav navbar-nav navbar-left navbar-top-links">
        <li>
            <a href="#">
                <i class="fa fa-home fa-fw"></i>
            </a>
        </li>
    </ul> -->

    <!-- Top MenuTaxonomyigation: Right Menu -->
    <ul class="nav navbar-right navbar-top-links">


        <!-- <li class="dropdown navbar-inverse">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-bell fa-fw"></i> <b class="caret"></b>
            </a>
            <ul class="dropdown-menu dropdown-alerts">
                <li>
                    <a href="#">
                        <div>
                            <i class="fa fa-comment fa-fw"></i> New Comment
                            <span class="pull-right text-muted small">4 minutes ago</span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a class="text-center" href="#">
                        <strong>See All Alerts</strong>
                        <i class="fa fa-angle-right fa-fw"></i>
                    </a>
                </li>
            </ul>
        </li> -->

        <?php if (count($config['langs']) > 1): ?>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <?=trans('Wyświetl: ')?>
                    <?=view('/admin/parts/language.html.php', ['lang' => $_SESSION['lang']['editor']])?>
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <?php foreach ($config['langs'] as $lang => $label): ?>
                        <li>
                            <a href="<?=url("/admin/account/change-lang/$lang")?>">
                                <?=view('/admin/parts/language.html.php', ['lang' => $lang])?>
                            </a>
                        </li>
                    <?php endforeach ?>
                </ul>
            </li>
        <?php endif ?>

        <li class="dropdown">

            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i>
                <?=escape($_SESSION['staff']['name'])?>
                <b class="caret"></b>
            </a>

            <ul class="dropdown-menu dropdown-user">

                <li>
                    <a href="<?=url('/admin/account/profil')?>">
                        <i class="fa fa-user fa-fw"></i>
                        <?=trans('Profil użytkownika')?>
                    </a>
                </li>

                <li>
                    <a href="<?=url('/admin/account/password')?>">
                        <i class="fa fa-unlock-alt fa-fw"></i>
                        <?=trans('Zmień hasło')?>
                    </a>
                </li>

                <li class="divider"></li>

                <li>
                    <a href="<?=url("/admin/logout")?>">
                        <i class="fa fa-sign-out fa-fw"></i>
                        <?=trans('Wyloguj się')?>
                    </a>
                </li>
            </ul>
        </li>

    </ul>

    <?php require_once ACTIONS_PATH.'/admin/parts/sidebar.html.php'; ?>

</nav>
