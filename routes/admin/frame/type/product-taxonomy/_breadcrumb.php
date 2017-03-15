<?php

# pobranie taksonomii po kluczu głównym
$taxonomy = GC\Model\Frame::fetchByPrimaryId($taxonomy_id);

$headTitle = trans('Struktura węzłów: %s', [$taxonomy['name']]);
$breadcrumbs->push([
    'uri' => $uri->mask("/{$taxonomy_id}/tree"),
    'name' => $headTitle,
]);
