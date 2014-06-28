http
====

Http Component

```php
<?php 

use Http\HttpRequest;
use Storage\ImmutableKeyValue;

$request = new HttpRequest(
    new ImmutableKeyValue($_GET),
    new ImmutableKeyValue($_POST),
    new ImmutableKeyValue($_SERVER),
    new ImmutableKeyValue($_FILES),
    new ImmutableKeyValue($_COOKIE)
);
```
