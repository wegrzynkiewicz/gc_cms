<?php

/** Plik sprawdza odpowiednie wartości celem przekierowania */

# jeżeli któryś z niestandardowych rewritów okaże się pasować, wtedy przekieruj na właściwy adres
$fullRequest = rtrim("{$request->uri}?{$request->query}", '?');
foreach ($config['rewrites'] as $pattern => $destination) {
    if (preg_match($pattern, $fullRequest)) {
        $result = preg_replace($pattern, $destination, $fullRequest);
        redirect($result, 301); # 301 Moved Permanently
    }
}

# pobranie najważniejszych danych o adresie strony
$seoConfig = &$config['seo'];
$httpHost = server('HTTP_HOST', 'localhost');
$protocol = 'http'.(stripos(server('SERVER_PROTOCOL', 'http'), 'https') === true ? 's' : '');
$www = substr($httpHost, 0, 4) === 'www.' ? 'www.' : '';
$domain = server('SERVER_NAME', $httpHost);
$requestUri = server('REQUEST_URI');
$parsed = parse_url($requestUri);
$path = $parsed['path'];
$query = def($parsed, 'query');
$port = intval(server('SERVER_PORT', 80));

$requestUri = $requestUri === '/' ? '' : $requestUri;
$currentUrl = $protocol.'://'.$httpHost.$requestUri;

# sprawdzenie czy adres który wpisał odbiorca zgadza się z polityką seo
if ($seoConfig['forceHTTPS'] !== null) {
    $protocol = 'http'.((bool)$seoConfig['forceHTTPS'] ? 's' : '');
}

if ($seoConfig['forceWWW'] !== null) {
    $www = (bool)$seoConfig['forceWWW'] ? 'www.' : '';
}

if ($seoConfig['forceDomain'] !== null  and $domain !== $seoConfig['forceDomain']) {
    $domain = $seoConfig['forceDomain'];
}

if ($seoConfig['forcePort'] !== null and $port !== $seoConfig['forcePort']) {
    $port = intval($seoConfig['forcePort']);
}

$targetPort = $port === 80 ? '' : ":{$port}";
$targetPath = rtrim($path, '/');
$targetUrl = $protocol.'://'.$www.$domain.$targetPort.$targetPath.'?'.$query;

# targetUrl nie powinien zawierać ? na końcu
$targetUrl = rtrim($targetUrl, '?');

# przekierowanie na docelowy adres, pomocne przy seo
if ($currentUrl !== $targetUrl) {
    $GLOBALS['logger']->info("[SEO] From: {$currentUrl} To: {$targetUrl}");
    absoluteRedirect($targetUrl, 301);  # 301 Moved Permanently
}

# jeżeli strona jest w budowie wtedy zwróć komunikat o budowie, chyba, że masz uprawnienie
if ($config['debug']['inConstruction']) {
    if (isset($_REQUEST['you-shall-not-pass'])) {
        $_SESSION['allowInConstruction'] = true;
    }
    if (!isset($_SESSION['allowInConstruction'])) {
        $GLOBALS['logger']->info('[RESPONSE] inConstruction');
        require TEMPLATE_PATH.'/errors/construction.html.php';
        exit;
    }
}
