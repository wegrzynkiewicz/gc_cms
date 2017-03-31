User-agent: *
Disallow: <?=$uri->make('/auth').PHP_EOL?>
Disallow: <?=$uri->make('/admin').PHP_EOL?>

Sitemap: <?=$request->url?><?=$uri->root('/sitemap.xml').PHP_EOL?>
