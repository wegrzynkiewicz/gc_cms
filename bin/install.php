<?php

/** Zawiera szereg rutynowych zadań podczas instalowania bazy danych **/

require_once __DIR__.'/_import.php';

echo PHP_EOL;
echo 'IMPORTANT!! This command remove important data!!'.PHP_EOL;
$areYouSure();

// Usunięcie plików tymczasowych
require __DIR__.'/temp-delete.php';

// usuń wszystkie sesje
echo PHP_EOL;
echo "Deleting sessions...".PHP_EOL;
removeDirRecursive(STORAGE_PATH.'/sessions');
echo "Sessions were deleted.".PHP_EOL;

// Tworzenie katalogów
echo PHP_EOL;
foreach (getWriteableDirs() ?? [] as $dir) {
    echo "Creating dir: {$dir}".PHP_EOL;
    makeDirRecursive($dir);
}

// wszyszukaj wszystkich translacji
require __DIR__.'/translations-dump.php';

// utwórz pliki translacji dla wszyskich języków
echo PHP_EOL;
echo "Creating translation files...".PHP_EOL;
$json = file_get_contents(TEMP_PATH.'/translations-dump.json');
foreach ($config['lang']['installed'] as $code => $lang) {
    $path = $config['translator']['folder']."/{$code}.json";
    echo "Creating file: {$path}".PHP_EOL;
    makeDirRecursive(dirname($path));
    file_put_contents($path, $json);
}
echo "Translation files were created.".PHP_EOL;

// utwórz tabele w bazie danych
echo PHP_EOL;
echo "Creating database structure...".PHP_EOL;
$structure = file_get_contents(ROOT_PATH.'/app/etc/database.sql');
GC\Storage\Database::getInstance()->pdo->exec($structure);
echo "Database structure was created.".PHP_EOL;

// Tworzenie konta roota
require __DIR__.'/root-create.php';

// Tworzenie sum kontrolnych
echo PHP_EOL;
echo "Calculating checksums...".PHP_EOL;
GC\Model\Checksum::refreshChecksums();
echo "Checksums were verified.".PHP_EOL;

// finalizacja
echo PHP_EOL;
echo 'Successfully installed.'.PHP_EOL;
