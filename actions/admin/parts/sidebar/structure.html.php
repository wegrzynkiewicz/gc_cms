<?php

return [
    'dashboard' => [
        'name' => trans('Dashboard'),
        'path' => '/admin',
        'icon' => 'dashboard',
        'perms' => [],
        'children' => [],
    ],
    'posts' => [
        'name' => trans('Wpisy'),
        'path' => '#',
        'icon' => 'pencil-square-o',
        'perms' => [],
        'children' => [
            'all_posts' => [
                'name' => trans('Wyświetl wszystkie wpisy'),
                'path' => '/admin/post/list',
                'icon' => '',
                'perms' => [],
                'children' => [],
            ],
            'add_post' => [
                'name' => trans('Dodaj nowy wpis'),
                'path' => '/admin/post/new',
                'icon' => '',
                'perms' => [],
                'children' => [],
            ],
            'post_taxonomy' => [
                'name' => trans('Wyświetl podziały wpisów'),
                'path' => '/admin/post/taxonomy/list',
                'icon' => '',
                'perms' => [],
                'children' => [],
            ],
        ],
    ],
    'pages' => [
        'name' => trans('Strony'),
        'path' => '#',
        'icon' => 'files-o',
        'perms' => [],
        'children' => [
            'all_pages' => [
                'name' => trans('Wyświetl wszystkie strony'),
                'path' => '/admin/page/list',
                'icon' => '',
                'perms' => [],
                'children' => [],
            ],
            'add_page' => [
                'name' => trans('Dodaj nową stronę'),
                'path' => '/admin/page/new',
                'icon' => '',
                'perms' => [],
                'children' => [],
            ],
        ],
    ],
    'nav' => [
        'name' => trans('Nawigacja'),
        'path' => '/admin/nav/list',
        'icon' => 'sitemap',
        'perms' => [],
        'children' => [],
    ],
    'products' => [
        'name' => trans('Katalog produktów'),
        'path' => '#',
        'icon' => 'shopping-basket',
        'perms' => [],
        'children' => [
            'all_products' => [
                'name' => trans('Wyświetl wszystkie produkty'),
                'path' => '/admin/product/list',
                'icon' => '',
                'perms' => [],
                'children' => [],
            ],
            'product_taxonomy' => [
                'name' => trans('Wyświetl podziały produktów'),
                'path' => '/admin/product/taxonomy/list',
                'icon' => '',
                'perms' => [],
                'children' => [],
            ],
        ],
    ],
    'widgets' => [
        'name' => trans('Widżety'),
        'path' => '/admin/widget/list',
        'icon' => 'cube',
        'perms' => [],
        'children' => [],
    ],
    'forms' => [
        'name' => trans('Formularze'),
        'path' => '/admin/form/list',
        'icon' => 'envelope-o',
        'perms' => [],
        'badge' => GC\Model\Form\Sent::select()->fields("SUM(status = 'unread') AS unread")->fetch()['unread'],
        'children' => [],
    ],
    'files' => [
        'name' => trans('Pliki'),
        'path' => '#',
        'icon' => 'folder-open-o',
        'perms' => [],
        'children' => [],
    ],
    'dumps' => [
        'name' => trans('Kopie zapasowe'),
        'path' => '/admin/dump/list',
        'icon' => 'database',
        'perms' => [],
        'children' => [],
    ],
    'staff' => [
        'name' => trans('Pracownicy'),
        'path' => '#',
        'icon' => 'users',
        'perms' => ['manage_staff'],
        'children' => [
            'all_staff' => [
                'name' => trans('Wyświetl pracowników'),
                'path' => '/admin/staff/list',
                'icon' => '',
                'perms' => ['manage_staff'],
                'children' => [],
            ],
            'add_staff' => [
                'name' => trans('Dodaj nowego pracownika'),
                'path' => '/admin/staff/new',
                'icon' => '',
                'perms' => ['manage_staff'],
                'children' => [],
            ],
            'all_staff_groups' => [
                'name' => trans('Wyświetl wszystkie grupy'),
                'path' => '/admin/staff/group/list',
                'icon' => '',
                'perms' => ['manage_staff_groups'],
                'children' => [],
            ],
            'add_staff_group' => [
                'name' => trans('Dodaj nową grupę'),
                'path' => '/admin/staff/group/new',
                'icon' => '',
                'perms' => ['manage_staff_groups'],
                'children' => [],
            ],
        ],
    ],
    'root' => [
        'name' => 'Panel programisty',
        'path' => '#',
        'icon' => 'bug',
        'perms' => ['root'],
        'children' => [
            'phpinfo' => [
                'name' => 'PHPInfo',
                'path' => '/root/phpinfo',
                'icon' => '',
                'perms' => [],
                'children' => [],
            ],
            'adminer' => [
                'name' => 'Adminer',
                'path' => '/root/adminer',
                'icon' => '',
                'perms' => [],
                'children' => [],
            ],
            'requirements' => [
                'name' => 'Wymagania systemowe',
                'path' => '/root/requirements',
                'icon' => '',
                'perms' => [],
                'children' => [],
            ],
            'checksum' => [
                'name' => 'Sumy kontrolne plików',
                'path' => '/root/checksum/list',
                'icon' => '',
                'perms' => [],
                'children' => [],
            ],
        ],
    ],
];
