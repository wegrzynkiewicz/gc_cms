<?php

declare(strict_types=1);

namespace GC;

use League\Uri\Schemes\Http;
use League\Uri\Components\Host;
use League\Uri\Components\HierarchicalPath;

class Redirect
{
    private $request = null;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Przekierowuje na inny adres jeżeli adres url żądania nie zgadza się z polityką seo
     */
    public function getCorrectSeoUrl(array $seo): string
    {
        $target = clone $this->request->url;

        if ($seo['forceHTTPS'] === true) {
            $target = $target->withScheme('https');
        }

        if ($seo['forceHTTPS'] === false) {
            $target = $target->withScheme('http');
        }

        if ($seo['forceDomain'] !== null) {
            $target = $target->withHost($seo['forceDomain']);
        }

        $host = new Host($target->getHost());

        if ($seo['forceWWW'] === true and $host->getLabel(0) !== 'www') {
            $host = $host->prepend('www');
        }

        if ($seo['forceWWW'] === false and $host->getLabel(0) === 'www') {
            $host = $host->withoutLabels([0]);
        }

        $target = $target->withHost((string)$host);

        if ($seo['forceIndexPhp'] !== null) {
            $target->frontController = (bool)$seo['forceIndexPhp'];
        }

        if ($seo['forcePort'] !== null) {
            $target = $target->withPort(intval($seo['forcePort']));
        }

        return (string) $target;
    }

    /**
     * Przekierowuje jeżeli któryś z niestandardowych rewritów okaże się pasować
     */
    public function ifSeoPolicyFaild(array $seo): void
    {
        $currentUrl = (string) $this->request->url;
        $targetUrl = (string) $this->getCorrectSeoUrl($seo);

        # przekierowanie na prawidłowy adres
        if ($currentUrl !== $targetUrl) {
            logger("[SEO] {$targetUrl}");
            redirect($targetUrl, $seo['responseCode']);
        }
    }

    /**
     * Przekierowuje jeżeli któryś z niestandardowych rewritów okaże się pasować
     */
    public function ifRewriteCorrect(array $rewrites)
    {
        $target = (string) $this->request->uri;

        foreach ($rewrites as $pattern => $destination) {
            if (preg_match($pattern, $target)) {
                $result = preg_replace($pattern, $destination, $target);
                redirect($result, 301); # 301 Moved Permanently
            }
        }
    }
}
