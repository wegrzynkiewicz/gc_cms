<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        <i class="fa fa-user fa-fw"></i>
        <span class="hidden-xs hidden-sm">
            <?=e(getConfig()['instance']['staff']['name'])?>
        </span>
        <b class="caret"></b>
    </a>
    <ul class="dropdown-menu dropdown-user">
        <li>
            <a href="<?=$uri->make('/admin/account/profil')?>">
                <i class="fa fa-user fa-fw"></i>
                <?=$trans('Profil użytkownika')?>
            </a>
        </li>
        <li>
            <a href="<?=$uri->make('/admin/account/change-password')?>">
                <i class="fa fa-unlock-alt fa-fw"></i>
                <?=$trans('Zmień hasło')?>
            </a>
        </li>
        <li class="divider"></li>
        <li>
            <a href="<?=$uri->make("/admin/account/logout")?>">
                <i class="fa fa-sign-out fa-fw"></i>
                <?=$trans('Wyloguj się')?>
            </a>
        </li>
    </ul>
</li>
