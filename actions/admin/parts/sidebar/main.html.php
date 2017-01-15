<?php $menu = require ACTIONS_PATH.'/admin/parts/sidebar/structure.html.php'; ?>

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

            <?=GC\Render::file(ACTIONS_PATH.'/admin/parts/sidebar/items.html.php', [
                'menu' => $menu,
                'attr' => 'class="nav nav-second-level"',
            ])?>

        </ul>
    </div>
</div>

<script>
    $(function() {
        $('#nav_files').elfinderInput({
            title: '<?=$trans('Przeglądaj pliki')?>',
            url: '<?=GC\Url::make('/admin/elfinder/connector')?>',
            lang: '<?=GC\Auth\Visitor::getLang()?>',
        }, function() {

        });

        $('#side-menu').metisMenu();
    });
</script>
