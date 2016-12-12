<?php

$headTitle = trans("Profil użytkownika");

$staff = Staff::createFromSession();
$staff->redirectIfUnauthorized();

if (wasSentPost()) {
    Staff::updateByPrimaryId($_SESSION['staff']['staff_id'], [
        'lang' => $_POST['lang'],
    ]);

    redirect('/admin');
}

$_POST = $staff->getData();

$headTitle .= makeLink("/admin/account/profil", $_SESSION['staff']['name']);

require_once ACTIONS_PATH.'/admin/parts/header.html.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?=$headTitle?>
        </h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <form action="" method="post" id="form" class="form-horizontal">

            <?=view('/admin/parts/input/select2-language.html.php', [
                'name' => 'lang',
                'label' => 'Język',
                'help' => 'Wyświetla panel i komunikaty w tym języku',
            ])?>

            <?=view('/admin/parts/input/submitButtons.html.php', [
                'cancelHref' => "/admin",
                'saveLabel' => 'Zapisz profil',
            ])?>

        </form>
    </div>
</div>

<?php require_once ACTIONS_PATH.'/admin/parts/assets.html.php'; ?>
<?php require_once ACTIONS_PATH.'/admin/parts/footer.html.php'; ?>
