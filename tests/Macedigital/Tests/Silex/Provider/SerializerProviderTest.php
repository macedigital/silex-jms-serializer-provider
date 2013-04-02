<?php

namespace Macedigital\Tests\Silex\Provider;

use Macedigital\Silex\Provider\SerializerProvider;
use Silex\Application;

/**
 * SerializerProvider test cases.
 *
 * @author Matthias Adler <macedigital@gmail.com>
 */
class SerializerProviderTest extends \PHPUnit_Framework_TestCase
{
    
    /**
     * Test most basic integration into a Silex application
     */
    public function testRegister()
    {

        $app = new Application();

        $this->assertFalse($app->offsetExists('serializer'));

        $app->register(new SerializerProvider);

        $this->assertTrue($app->offsetExists('serializer'));
        $this->assertInstanceOf('JMS\Serializer\Serializer', $app['serializer']);
        
        $this->assertTrue(method_exists($app['serializer'], 'serialize'));
        $this->assertTrue(method_exists($app['serializer'], 'deserialize'));
        
    }

}
