## Http framework for a training project.

## Requirements

PHP >= 7.4

## Installation

[anso/http](https://github.com/VioletTrain/http) can be installed via [Composer](https://getcomposer.org).

```bash
composer require anso/http:dev-master
```

## Usage

A few configuration files must be created and placed in a single folder before instantiating __Application__ object 
and calling __start()__ method:

- exception_handler.php - must return instance of
[ExceptionHandler](https://github.com/VioletTrain/contract/blob/master/src/ExceptionHandler.php)
- providers.php - must return array of
[Providers](https://github.com/VioletTrain/contract/blob/master/src/Provider.php) 
that are used to register DI container's bindings.
- routes.php - must return instance of 
[RouteCollection](https://github.com/VioletTrain/http/blob/master/src/Routing/RouteCollection.php). 
It contains routes that can be created using 
[BaseRouter](https://github.com/VioletTrain/http/blob/master/src/Routing/BaseRouter.php).
Every route has an 
[Action](https://github.com/VioletTrain/http/blob/master/src/Contract/Routing/Action.php) 
that handles 
[Request](https://github.com/VioletTrain/http/blob/master/src/Request.php)
and returns
[Response](https://github.com/VioletTrain/http/blob/master/src/Response.php).

Afterwards application can be started like this (/public/index.php):

```php
<?php

define('BASE_PATH', __DIR__ . '/..');

require __DIR__ . '/../vendor/autoload.php';

use Anso\Framework\Base\Configuration;
use Anso\Framework\Base\Container;
use Anso\Framework\Base\Contract\Application;
use Anso\Framework\Http\HttpApp;

$configuration = new Configuration('/config/http');
$container = new Container($configuration);
$app = new HttpApp($container, $configuration);

$container->addResolved(Application::class, $app);

$app->start();
```

- BASE_PATH constant is needed to include config files and extract values from them later.
- To enable autoloading composer's autoload.php must be required.
- Then 
[Configuration](https://github.com/VioletTrain/base/blob/master/src/Configuration.php), 
[Container](https://github.com/VioletTrain/base/blob/master/src/Container.php) 
and 
[HttpApp](https://github.com/VioletTrain/http/blob/master/src/HttpApp.php)
objects must be created. Be sure that you have 
[Application](https://github.com/VioletTrain/contract/blob/master/src/Application.php), 
[Container](https://github.com/VioletTrain/contract/blob/master/src/Container.php)
and 
[Configuration](https://github.com/VioletTrain/base/blob/master/src/Configuration.php)
registered as singletons either in a provider or right after creating $app object.
- $app object should be marked as resolved, so that if it is required later, a duplicate app object with wrong config wouldn't be created.
- Finally the app can start working.
