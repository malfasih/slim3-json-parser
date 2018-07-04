# slim3-json-parser

Parsing JSON response for Slim v3 REST API with CORS management - https://projects.alal.io

## Installation

Before we get started, please make sure that you have installed Slim 3 Framework. I was using [slim-born](https://github.com/HavenShen/slim-born/) from [HavenShen](https://github.com/HavenShen) for developing this module.


```shell
$ composer require malfasih/slim3-json-parser
```
or

*composer.json*
```javascript
"require": {
    "malfasih/slim3-json-parser": "@dev"
}
```



## Registering Component

```php
<?php
require __DIR__ . '/../vendor/autoload.php';
$app = new \Slim\App();
$container = $app->getContainer();

$container['json'] = function($container) {
	return new \Malfasih\Slim\JsonParser();
};
```



## Testing

Just with a single line of code, and it actually works.

```php
<?php

public function getUserData($request, $response)
{
  return $this->json->print($response, 200, 'OK');
}
```
