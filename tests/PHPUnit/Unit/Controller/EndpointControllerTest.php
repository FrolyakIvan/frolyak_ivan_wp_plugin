<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use Frolyak\FrolyakIvanWpPlugin\Controller\EndpointController;
use Frolyak\FrolyakIvanWpPlugin\Service\APIService;
use Frolyak\FrolyakIvanWpPlugin\View\ViewController;

class EndpointControllerTest extends TestCase
{
    private $apiServiceMock;
    private $viewControllerMock;
    private $endpointController;

    protected function setUp(): void
    {
        $this->apiServiceMock = $this->createMock(APIService::class);
        $this->viewControllerMock = $this->createMock(ViewController::class);
        $this->endpointController = new EndpointController($this->apiServiceMock, $this->viewControllerMock);

        if ( !defined('PLUGIN_DIR') )
        {
            define('PLUGIN_DIR', dirname(dirname(dirname(dirname(dirname(__FILE__))))). '/');
        }
    }

    public function testHandleTemplate() : void
    {

        /**
         * In case you visit the custom endpoint
         */
        WP_Mock::userFunction('get_query_var')
            ->once()
            ->with('custom_endpoint', false)
            ->andReturn('1');


        $this->apiServiceMock->method('getApiData')->willReturn([
            'name'  => 'Ivan Frolyak',
            'username'  => 'ivos_frolyak'
        ]);

        $this->viewControllerMock->method('setTemplate')->willReturn(PLUGIN_DIR . 'templates/basicTemplate.php');

        $this->assertSame(
            PLUGIN_DIR . 'templates/basicTemplate.php',
            $this->endpointController->handleTemplate('testTemplate')
        );

    }

    public function testSetCustomEndpoint()
    {
        WP_Mock::userFunction('add_rewrite_rule')
            ->once()
            ->with('^custom-endpoint/?$', 'index.php?custom_endpoint=1', 'top')
            ->andReturn('1');

        $this->assertEquals('1', $this->endpointController->setCustomEndpoint());
    }
}
