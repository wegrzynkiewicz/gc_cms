<?php

$taxonomy_id = intval(array_shift($_PARAMETERS));

require ROUTES_PATH."/admin/frame/type/product-taxonomy/_breadcrumb.php";

GC\Model\Frame\Tree::insertFrameToTaxonomy($frame_id, $taxonomy_id);

flashBox(trans('Nowy węzeł produkt "%s" została utworzony.', [post('name')]));
