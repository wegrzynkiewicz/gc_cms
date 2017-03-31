<?php

// spłaszcz nadesłane przynależności do węzłów taksonomii
$relations = array_unchunk(post('taxonomy', []));
GC\Model\Frame\Relation::updateRelations($frame_id, $relations);

flashBox(trans('Nowy produkt "%s" został utworzony.', [post('name')]));
