http
====

Http Component

```php
<?php

use Http\RequestBuilder;
use Http\CookieBuilder;
use Http\HttpResponse;

$loader = require_once __DIR__ . '/vendor/autoload.php';

$requestBuilder = new RequestBuilder;
$cookieBuilder = new CookieBuilder;

// Disable the secure flag because this is only an example
$cookieBuilder->setDefaultSecure(false);

$request = $requestBuilder->buildFromSuperglobals();
$response = new HttpResponse;

$content = '<h1>Hello World</h1>';
$content .= $request->getCookie('TestCookie', 'Cookie is not set.');

if ($request->getParameter('setCookie') === 'true') {
    $cookie = $cookieBuilder->build('TestCookie', 'Cookie is set.');
    $response->setCookie($cookie);
}

$response->setContent($content);

foreach ($response->getHeaders() as $header) {
    header($header);
}

echo $response->getContent();
```
