<?php
$menu = [
    'Dashboard' => [
        'path' => '/admin',
        'icon' => 'fa fa-dashboard fa-fw',
        'perms' => [],
    ],
    'Wpisy' => [
        'path' => '',
        'icon' => 'fa fa-files-o fa-fw',
        'perms' => [],
        'children' => [
            'Wyświetl wszystkie wpisy' => [
                'path' => '/admin/post/list',
                'icon' => '',
                'perms' => [],
            ],
            'Dodaj nowy wpis' => [
                'path' => '/admin/post/new',
                'icon' => '',
                'perms' => [],
            ],
            'Wyświetl podziały wpisów' => [
                'path' => '/admin/post/taxonomy/list',
                'icon' => '',
                'perms' => [],
            ],
        ],
    ],
    'Strony' => [
        'path' => '',
        'icon' => 'fa fa-files-o fa-fw',
        'perms' => [],
        'children' => [
            'Wyświetl wszystkie strony' => [
                'path' => '/admin/page/list',
                'icon' => '',
                'perms' => [],
            ],
            'Dodaj nową stronę' => [
                'path' => '/admin/page/new',
                'icon' => '',
                'perms' => [],
            ],
        ],
    ],
    'Nawigacja' => [
        'path' => '',
        'icon' => 'fa fa fa-sitemap fa-fw',
        'perms' => [],
        'children' => [
            'Wyświetl wszystkie nawigacje' => [
                'path' => '/admin/nav/list',
                'icon' => '',
            ],
        ],
    ],
    'Galerie zdjęć' => [
        'path' => '',
        'icon' => 'fa fa-picture-o fa-fw',
        'perms' => [],
        'children' => [
            'Wyświetl wszystkie galerie' => [
                'path' => '/admin/gallery/list',
                'icon' => '',
                'perms' => [],
            ],
            'Dodaj nową galerie' => [
                'path' => '/admin/gallery/new',
                'icon' => '',
                'perms' => [],
            ],
        ],
    ],
    'Widżety' => [
        'path' => '/admin/widget/list',
        'icon' => 'fa fa-cube fa-fw',
        'perms' => [],
    ],
    'Pliki' => [
        'id' => 'navViewFiles',
        'path' => '',
        'icon' => 'fa fa-folder-open-o fa-fw',
        'perms' => [],
    ],
    'Pracownicy' => [
        'path' => '',
        'icon' => 'fa fa-users fa-fw',
        'perms' => ['manage_staff'],
        'children' => [
            'Wyświetl pracowników' => [
                'path' => '/admin/staff/list',
                'icon' => '',
                'perms' => ['manage_staff'],
            ],
            'Dodaj nowego pracownika' => [
                'path' => '/admin/staff/new',
                'icon' => '',
                'perms' => ['manage_staff'],
            ],
            'Wyświetl wszystkie grupy' => [
                'path' => '/admin/staff/group/list',
                'icon' => '',
                'perms' => ['manage_staff_groups'],
            ],
            'Dodaj nową grupę' => [
                'path' => '/admin/staff/group/new',
                'icon' => '',
                'perms' => ['manage_staff_groups'],
            ],
        ],
    ],
];
?>


<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">

            <!-- <li class="sidebar-search">
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="button">
                                <i class="fa fa-search fa-fw"></i>
                            </button>
                        </span>
                </div>
            </li> -->

            <?=view('/admin/parts/sidebar-item.html.php', [
                'menu' => $menu,
                'staff' => $staff,
                'level' => 'nav nav-second-level',
            ])?>

        </ul>
    </div>
</div>
<script>
    $(function() {
        $('#navViewFiles').elfinderInput({
            title: '<?=trans('Przeglądaj pliki')?>'
        }, function() {

        });
    });
</script>
