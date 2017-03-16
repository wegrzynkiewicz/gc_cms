<?php

$taxonomy_id = intval(array_shift($_PARAMETERS));

require ROUTES_PATH."/admin/frame/_parts/taxonomy-breadcrumbs.php";

GC\Model\Frame\Tree::insertFrameToTaxonomy($frame_id, $taxonomy_id);

flashBox(trans('Nowy węzeł wpisu "%s" został utworzony.', [post('name')]));
