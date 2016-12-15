<?php

$headTitle = trans('Dashboard');

$staff = GC\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

require_once ACTIONS_PATH.'/admin/parts/header.html.php';


$actions = [ [
        'id' => 'pages',
        'name' => 'Strony',
        'icon' => 'fa-close',
        'path' => '/admin/page/list',
        'perms' => [],
    ], [
        'id' => 'add_page',
        'name' => 'Dodaj stronę',
        'path' => '/admin/post/list',
        'icon' => 'fa-pencil-square-o',
        'perms' => [],
    ], [
        'id' => 'all_posts',
        'name' => 'Wpisy',
        'path' => '/admin/post/list',
        'icon' => 'fa-pencil-square-o',
        'perms' => [],
    ], [
        'id' => 'add_posts',
        'name' => 'Dodaj wpis',
        'path' => '/admin/post/list',
        'icon' => 'fa-pencil-square-o',
        'perms' => [],
    ], /*
    'Strony' => [
        'id' => 'pages',
        'path' => '',
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
        'path' => '',
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
        'path' => '',
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
    'Pliki' => [
        'id' => 'files',
        'path' => '',
        'icon' => 'fa fa-folder-open-o fa-fw',
        'perms' => [],
    ],
    'Pracownicy' => [
        'id' => 'staff',
        'path' => '',
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
    */
]
?>

<div class="row">
    <div class="col-lg-12 text-left">
        <h1 class="page-header">
            <?=($headTitle)?>
        </h1>
    </div>
</div>

<div class="row">
    <?php foreach($actions as $action): ?>
        <div class="col-lg-2">
            <a class="dashboard-action">
                <i class="fa <?=e($action['icon'])?> fa-fw fa-3x"></i><br>
                <span class="dashboard-action-title"><?=e($action['name'])?></span>
            </a>
        </div>
    <?php endforeach ?>
</div>

<?php require_once ACTIONS_PATH.'/admin/parts/assets.html.php'; ?>
<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
