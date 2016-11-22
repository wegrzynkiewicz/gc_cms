<?php
    $menu = [

        'Dashboard' => [
            'path' => '/admin',
            'icon' => 'fa fa-dashboard fa-fw',
        ],

        'Strony' => [
            'path' => '',
            'icon' => 'fa fa-files-o fa-fw',
            'children' => [
                'Wyświetl wszystkie strony' => [
                    'path' => '/admin/page/list',
                    'icon' => '',
                ],
                'Dodaj nową stronę' => [
                    'path' => '/admin/page/new',
                    'icon' => '',
                ],
            ],
        ],

        'Nawigacja' => [
            'path' => '',
            'icon' => 'fa fa-picture-o fa-fw',
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
            'children' => [
                'Wyświetl wszystkie galerie' => [
                    'path' => '/admin/gallery/list',
                    'icon' => '',
                ],
                'Dodaj nową galerie' => [
                    'path' => '/admin/gallery/new',
                    'icon' => '',
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
                'level' => 'nav nav-second-level'
            ])?>

        </ul>
    </div>
</div>
