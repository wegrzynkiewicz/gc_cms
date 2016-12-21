<?php
if (isset($frame_id) and ($frame_id > 0)) {
    $modules = GC\Model\Module::joinAllWithKeyByForeign($frame_id);
}
?>
<?php if (empty($modules)): ?>
    Nie znaleziono modułów
<?php else: ?>
    <?=templateView("/parts/modules-loop.html.php", [
        'modules' => $modules,
        'withoutContainer' => isset($withoutContainer),
    ])?>
<?php endif ?>
