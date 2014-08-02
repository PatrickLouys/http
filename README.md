## Http Component

## Installation

You can use composer to install this component. The package is: 
```
patricklouys/http
```

## Basic Usage

### Request

The Request class provides an object oriented wrapper around the PHP superglobals. This makes it possible to inject it as a dependency into any of your classes that require it.


In most cases, you will want to use the `RequestBuilder` to create the `HttpRequest` from the superglobals.

```php
use Http\RequestBuilder;

$requestBuilder = new RequestBuilder;

$request = $requestBuilder->buildFromSuperglobals();
```

Now you can use the following methods on the `$request` object:
```php
$request->getParameter($key, $defaultValue = null);
$request->getFile($key, $defaultValue = null);
$request->getCookie($key, $defaultValue = null);
$request->getParameters();
$request->getCookies();
$request->getFiles();
$request->getMethod();
$request->getHttpAccept();
$request->getReferer();
$request->getUserAgent();
$request->getIpAddress();
$request->isSecure();
$request->getQueryString();
```

Please note that both GET and POST parameters are merged together and accessible with `getParameter`.

### Example

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
    $response->addCookie($cookie);
}

$response->setContent($content);

foreach ($response->getHeaders() as $header) {
    header($header);
}

echo $response->getContent();
```
None of the classes have side effects like sending data to the browser, so it is up to you to do that. The objects only hold data.
