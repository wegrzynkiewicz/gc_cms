<?php

declare(strict_types=1);

use GC\Uri;
use GC\Request;
use League\Uri\Schemes\Http;
use League\Uri\Components\Host;
use League\Uri\Components\Path;
use League\Uri\Components\HierarchicalPath;
use PHPUnit\Framework\TestCase;

final class RequestTest extends TestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testCorrectProcessingSlug($scriptName, $url, $slug)
    {
        $request = new Request(
            'GET',
            Http::createFromString($url),
            new HierarchicalPath($scriptName)
        );
        $request->detectLanguageCodes(['en', 'pl']);

        $this->assertEquals($slug, (string)$request->slug);
    }

    public function urlProvider()
    {
        return [
            ['/index.php', '/admin', '/admin'],
            ['/index.php', '/admin.html', '/admin'],
            ['/index.php', '/admin/file.json', '/admin/file'],
            ['/index.php', '/pl/admin', '/pl/admin'],
            ['/index.php', '/pl/admin.html', '/pl/admin'],
            ['/index.php', '/pl/admin/file.json', '/pl/admin/file'],
            ['/index.php', '/index.php/admin', '/admin'],
            ['/index.php', '/index.php/admin.html', '/admin'],
            ['/index.php', '/index.php/admin/file.json', '/admin/file'],
            ['/index.php', '/index.php/en/admin', '/en/admin'],
            ['/index.php', '/index.php/en/admin.html', '/en/admin'],
            ['/index.php', '/index.php/en/admin/file.json', '/en/admin/file'],
            ['/web/index.php', '/web/admin', '/admin'],
            ['/web/index.php', '/web/admin.html', '/admin'],
            ['/web/index.php', '/web/admin/file.json', '/admin/file'],
            ['/web/index.php', '/web/pl/admin', '/pl/admin'],
            ['/web/index.php', '/web/pl/admin.html', '/pl/admin'],
            ['/web/index.php', '/web/pl/admin/file.json', '/pl/admin/file'],
            ['/web/index.php', '/web/index.php/admin', '/admin'],
            ['/web/index.php', '/web/index.php/admin.html', '/admin'],
            ['/web/index.php', '/web/index.php/admin/file.json', '/admin/file'],
            ['/web/index.php', '/web/index.php/en/admin', '/en/admin'],
            ['/web/index.php', '/web/index.php/en/admin.html', '/en/admin'],
            ['/web/index.php', '/web/index.php/en/admin/file.json', '/en/admin/file'],
        ];
    }
}
