<?php

declare(strict_types=1);

namespace GC\Test;

use GC\Model\Frame;
use PHPUnit\Framework\TestCase;

final class ResponseTest extends TestCase
{
    public function assertHtmlResponse(string $uri): void
    {
        $uri = $_ENV['testUrl'].$uri;
        $content = file_get_contents($uri);
        $this->assertRegExp('~</html>~', $content, $uri);
    }

    /**
     * @dataProvider dataUriProvider
     */
    public function testSelectedRoutes($uri)
    {
        $this->assertHtmlResponse($uri);
    }

    public function dataUriProvider()
    {
        return [
            ['/admin'],
            ['/admin/account/profil'],
            ['/admin/account/change-password'],
            ['/admin/frame/list/page'],
            ['/admin/frame/new/page'],
            ['/admin/frame/list/product'],
            ['/admin/frame/new/product'],
            ['/admin/frame/list/product-taxonomy'],
            ['/admin/frame/new/product-taxonomy'],
            ['/admin/frame/list/post'],
            ['/admin/frame/new/post'],
            ['/admin/frame/list/post-taxonomy'],
            ['/admin/frame/new/post-taxonomy'],
            ['/admin/dump/list'],
            ['/admin/form/list'],
            ['/admin/navigation/list'],
            ['/admin/navigation/new'],
            ['/admin/popup/list'],
            ['/admin/popup/new'],
            ['/admin/staff/list'],
            ['/admin/staff/new'],
            ['/admin/widget/list'],
            ['/root/phpinfo'],
            ['/root/requirements'],
        ];
    }

    public function testFrames()
    {
        $frames = Frame::select()
            ->fields('slug, frame_id')
            ->condition("slug != ''")
            ->fetchAll();

        foreach ($frames as ['slug' => $slug, 'frame_id' => $id]) {
            $this->assertHtmlResponse($slug);
            $this->assertHtmlResponse("/admin/frame/{$id}/edit");
            $this->assertHtmlResponse("/admin/frame/{$id}/module/grid");
        }
    }
}
