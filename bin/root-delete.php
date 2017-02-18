<?php

/** Usuwa konta administratorów z bazy danych **/

require_once __DIR__.'/_import.php';

echo PHP_EOL;
echo "Deleting root staff accounts...".PHP_EOL;

GC\Model\Staff\Staff::delete()
    ->equals('root', 1)
    ->execute();

echo "Root staff accounts were deleted.".PHP_EOL;
