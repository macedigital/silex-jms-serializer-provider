silex-jms-serializer-provider
=============================

This Silex service provider registers [JMS-Serializer][1] for
(de-)serialization of object graphs of any complexity.


## Installation

The preferred way of installing this service provider is [through
composer](http://getcomposer.org):

    composer.phar require macedigital/jms-serializer-provider

## Example

As this is a drop-in replacement for the
[Silex SerializerServiceProvider](http://silex.sensiolabs.org/doc/providers/serializer.html)
this slightly adapted example from the docs will work:

```php
<?php
$loader = require_once __DIR__.'/../vendor/autoload.php';

// If you're are using class annotations
Doctrine\Common\Annotations\AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

$app = new Silex\Application();

// optional: whether to stat cached files or not, defaults to $app['debug']
$app['serializer.debug'] = true;

// optional: defaults to system's default temporary folder 
$app['serializer.cache_dir] = '/some/writable/folder';

$app->register(new Macedigital\Silex\Provider\SerializerProvider);

// only accept content types supported by the serializer via the assert method.
$app->get("/pages/{id}.{_format}", function ($id) use ($app) {
    // assume a page_repository service exists that returns a Page object
    $page = $app['page_repository']->find($id);
    $format = $app['request']->getRequestFormat();

    if (!$page instanceof Page) {
        $app->abort("No page found for id: $id");
    }

    return new Response($app['serializer']->serialize($page, $format), 200, array(
        "Content-Type" => $app['request']->getMimeType($format)
    ));
})->assert("_format", "xml|json|yml")
  ->assert("id", "\d+");

$app->run();
```


[1]: http://jmsyst.com/libs/serializer