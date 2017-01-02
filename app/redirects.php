<?php

$seoUrl = $config['seoUrl'];

$protocol = 'http'.(stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 's' : '').'://';
$www = substr($_SERVER['HTTP_HOST'], 0, 4) === 'www.' ? 'www.' : '';
$domain = isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : parse_url($_SERVER["HTTP_HOST"], \PHP_URL_HOST);
$uri = rtrim($_SERVER['REQUEST_URI'], '/');
$port = isset($_SERVER["SERVER_PORT"]) ? intval($_SERVER["SERVER_PORT"]) : 80;
$currentLocation = $protocol.$_SERVER['HTTP_HOST'].$uri;

if ($seoUrl['forceHTTPS'] !== null) {
    $protocol = 'http'.((bool)$seoUrl['forceHTTPS'] ? 's' : '').'://';
}

if ($seoUrl['forceWWW'] !== null) {
    $www = (bool)$seoUrl['forceWWW'] ? 'www.' : '';
}

if ($seoUrl['forceDomain'] !== null  and $domain !== $seoUrl['forceDomain']) {
    $domain = $seoUrl['forceDomain'];
}

if ($seoUrl['forcePort'] !== null and $port !== $seoUrl['forcePort']) {
    $port = $seoUrl['forcePort'];
}

$port = $port === 80 ? '' : ":{$port}";
$target = $protocol.$www.$domain.$port.$uri;

if ($currentLocation != $target) {
    header("Location: {$target}", true, 301);
    exit;
}
