<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use Frolyak\FrolyakIvanWpPlugin\FrolyakIvanWpPlugin;
use Frolyak\FrolyakIvanWpPlugin\Controller\EndpointController;

class FrolyakIvanWpPluginTest extends TestCase
{

    private $frolyakIvanWpPlugin;

    protected function setUp() : void
    {
        $this->frolyakIvanWpPlugin = new FrolyakIvanWpPlugin();
    }

    /**
     * This test block of code is to test if FrolyakIvanWpPlugin class
     * is creating  all needed instances objects of necessary classes.

     * There is a private property, to access it I would use Reflection.
     */
    public function testConstructor()
    {
        $reflectFrolyakClass = new ReflectionClass(FrolyakIvanWpPlugin::class);
        $endpointControllerProperty = $reflectFrolyakClass->getProperty('endpointController');
        $endpointControllerProperty->setAccessible(true);

        $this->assertInstanceOf(
            EndpointController::class,
            $endpointControllerProperty->getValue($this->frolyakIvanWpPlugin)
        );

    }

    // public function testActivate() : void
    // {
    //     WP_Mock::userFunction('flush_rewrite_rules')
    //         ->once();

    //     $this->frolyakIvanWpPlugin->activate();

    // }

}
