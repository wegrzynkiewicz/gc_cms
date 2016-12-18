<?php
$menu = [
    'Dashboard' => [
        'id' => 'dashboard',
        'path' => '/admin',
        'icon' => 'fa fa-dashboard fa-fw',
        'perms' => [],
    ],
    'Wpisy' => [
        'id' => 'posts',
        'path' => '#',
        'icon' => 'fa fa-pencil-square-o fa-fw',
        'perms' => [],
        'children' => [
            'Wyświetl wszystkie wpisy' => [
                'id' => 'all_posts',
                'path' => '/admin/post/list',
                'icon' => '',
                'perms' => [],
            ],
            'Dodaj nowy wpis' => [
                'id' => 'add_post',
                'path' => '/admin/post/new',
                'icon' => '',
                'perms' => [],
            ],
            'Wyświetl podziały wpisów' => [
                'id' => 'post_taxonomy',
                'path' => '/admin/post/taxonomy/list',
                'icon' => '',
                'perms' => [],
            ],
        ],
    ],
    'Strony' => [
        'id' => 'pages',
        'path' => '#',
        'icon' => 'fa fa-files-o fa-fw',
        'perms' => [],
        'children' => [
            'Wyświetl wszystkie strony' => [
                'id' => 'all_pages',
                'path' => '/admin/page/list',
                'icon' => '',
                'perms' => [],
            ],
            'Dodaj nową stronę' => [
                'id' => 'add_page',
                'path' => '/admin/page/new',
                'icon' => '',
                'perms' => [],
            ],
        ],
    ],
    'Nawigacja' => [
        'id' => 'nav',
        'path' => '#',
        'icon' => 'fa fa fa-sitemap fa-fw',
        'perms' => [],
        'children' => [
            'Wyświetl wszystkie nawigacje' => [
                'id' => 'all_nav',
                'path' => '/admin/nav/list',
                'icon' => '',
            ],
        ],
    ],
    'Galerie zdjęć' => [
        'id' => 'galleries',
        'path' => '#',
        'icon' => 'fa fa-picture-o fa-fw',
        'perms' => [],
        'children' => [
            'Wyświetl wszystkie galerie' => [
                'id' => 'all_galleries',
                'path' => '/admin/gallery/list',
                'icon' => '',
                'perms' => [],
            ],
            'Dodaj nową galerie' => [
                'id' => 'add_gallery',
                'path' => '/admin/gallery/new',
                'icon' => '',
                'perms' => [],
            ],
        ],
    ],
    'Widżety' => [
        'id' => 'widgets',
        'path' => '/admin/widget/list',
        'icon' => 'fa fa-cube fa-fw',
        'perms' => [],
    ],
    'Formularze' => [
        'id' => 'forms',
        'path' => '/admin/form/list',
        'icon' => 'fa fa-envelope-o fa-fw',
        'perms' => [],
    ],
    'Pliki' => [
        'id' => 'files',
        'path' => '#',
        'icon' => 'fa fa-folder-open-o fa-fw',
        'perms' => [],
    ],
    'Pracownicy' => [
        'id' => 'staff',
        'path' => '#',
        'icon' => 'fa fa-users fa-fw',
        'perms' => ['manage_staff'],
        'children' => [
            'Wyświetl pracowników' => [
                'id' => 'all_staff',
                'path' => '/admin/staff/list',
                'icon' => '',
                'perms' => ['manage_staff'],
            ],
            'Dodaj nowego pracownika' => [
                'id' => 'add_staff',
                'path' => '/admin/staff/new',
                'icon' => '',
                'perms' => ['manage_staff'],
            ],
            'Wyświetl wszystkie grupy' => [
                'id' => 'all_staff_groups',
                'path' => '/admin/staff/group/list',
                'icon' => '',
                'perms' => ['manage_staff_groups'],
            ],
            'Dodaj nową grupę' => [
                'id' => 'add_staff_group',
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
        $('#nav_files').elfinderInput({
            title: '<?=trans('Przeglądaj pliki')?>'
        }, function() {

        });

        $('#side-menu').metisMenu();
    });
</script>
