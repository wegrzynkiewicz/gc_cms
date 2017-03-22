<?php $menu = require ROOT_PATH.'/app/etc/admin-nav.php'; ?>

<div class="navbar-default sidebar">
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

            <?php foreach ($menu as $node_id => $node): ?>
                <?=render(ROUTES_PATH.'/admin/_parts/sidebar/item.html.php', [
                    'node_id' => $node_id,
                    'node' => $node,
                    'attr' => 'class="nav nav-second-level collapse"',
                ])?>
            <?php endforeach ?>

        </ul>
    </div>
</div>

<script>
    $(function() {
        $('#nav_files').elfinderInput({
            title: '<?=trans('Przeglądaj pliki')?>',
        }, function() {

        });

        $('#side-menu').metisMenu();
    });
</script>
