<?php

$taxonomy_id = intval(array_shift($_PARAMETERS));

require ROUTES_PATH.'/admin/frame/parts/_taxonomy-breadcrumbs.php';

GC\Model\Frame\Tree::insertFrameToTaxonomy($frame_id, $taxonomy_id);

flashBox(trans('Nowy węzeł produkt "%s" został utworzony.', [post('name')]));
