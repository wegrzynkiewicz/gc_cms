<?php

/** Plik instaluje aplikację, czyli tworzy losowe wartości */

require __DIR__.'/../vendor/autoload.php';

# wygenerowanie losowych wartości dla aplikacji
$generated = [
    'datetime' => date('Y-m-d H:i:s'),
    'session.name' => GC\Auth\Password::random(40),
    'password.salt' => GC\Auth\Password::random(40),
];
$export = var_export($generated, true);

$content = '<?php'.PHP_EOL.<<<GENERATED

/** Plik został wygenerowany automatycznie */

# jeżeli chcesz ponownie wygenerować wartości to odkomentuj poniższą linijkę
# return require __DIR__.'/install.php';

\$generated = $export;

require __DIR__.'/bootstrap.php';

GENERATED;

# zapisanie nowego pliku start.php z generowanym kontentem
file_put_contents(__DIR__.'/start.php', $content);

require __DIR__.'/start.php';
