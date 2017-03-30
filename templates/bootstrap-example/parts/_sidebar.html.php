<?php require TEMPLATE_PATH."/navigations/side/_nav.html.php"; ?>

<?php if (isset($widgets['about'])): ?>
    <div class="well">
        <h4><?=trans('Parę słów o nas')?></h4>
        <div>
            <?=$widgets['about']['content']?>
        </div>
    </div>
<?php endif ?>
