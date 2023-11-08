<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use Frolyak\FrolyakIvanWpPlugin\View\ViewController;

class ViewControllerTest extends TestCase
{

    protected function setUp() : void
    {
        if ( !defined('PLUGIN_DIR') )
        {
            define('PLUGIN_DIR', dirname(dirname(dirname(dirname(dirname(__FILE__))))). '/');
        }
    }

    public function testInstanceReturnsSameInstance()
    {
        $viewController1 = ViewController::instance();
        $viewController2 = ViewController::instance();

        $this->assertInstanceOf(ViewController::class, $viewController1);
        $this->assertSame(
            $viewController1,
            $viewController2,
            'ViewController::instance() should return the same instance...'
        );
    }

    public function testSetTemplateReturnsCorrectTemplate()
    {
        $viewController = ViewController::instance();
        $data = ['name' => 'Leanne Graham'];
        $template = 'testTemplate.php';
        $expectedTemplatePath = PLUGIN_DIR . 'templates/basicTemplate.php';

        $result = $viewController->setTemplate($data, $template);
        $this->assertSame($expectedTemplatePath, $result);
    }

}
