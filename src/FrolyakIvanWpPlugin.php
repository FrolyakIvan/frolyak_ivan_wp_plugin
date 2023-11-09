<?php

declare(strict_types=1);

namespace Frolyak\FrolyakIvanWpPlugin;

use Frolyak\FrolyakIvanWpPlugin\Controller\EndpointController;
use Frolyak\FrolyakIvanWpPlugin\Service\APIService;
use Frolyak\FrolyakIvanWpPlugin\Cache\CacheHandler;
use Frolyak\FrolyakIvanWpPlugin\View\ViewController;
use Frolyak\FrolyakIvanWpPlugin\Admin\AdminController;

/**
 * Class FrolyakIvanWpPlugin
 */

class FrolyakIvanWpPlugin
{

    /**
     * @var EndpointController endpointController
    */
    private $endpointController;


    /**
     * Constructs the main plugin Class

     * Initializes main objects needed for the plugin
     */
    public function __construct()
    {
        $cacheHandler = new CacheHandler();
        $apiService = new APIService($cacheHandler);
        $viewController = ViewController::instance();

        $this->endpointController = new EndpointController($apiService, $viewController);

        $this->setAdminPage();
    }

    /**
     * Activates the plugin, creates a custom endpoint and flushes the
     *  rewrite rules.
     */
    public function activate()
    {
        $this->endpointController->setCustomEndpoint();
        flush_rewrite_rules();
    }

    /**
     * Deactivates the plugin and flushes the rewrite rules.
     */
    public function deactivate()
    {
        delete_option('frolyak_ivan_custom_endpoint');
        flush_rewrite_rules();
    }

    /**
     * Sets the Admin Page once the plugin is loaded
     */
    public function setAdminPage()
    {
        add_action('plugins_loaded', function()
        {
            new AdminController();
            // Update option with a default value
            if ( get_option('frolyak_ivan_custom_endpoint') === false )
            {
                update_option('frolyak_ivan_custom_endpoint', 'custom-endpoint');
            }
            add_action(
                'updated_option',
                [$this->endpointController, 'updateCustomEndpoint'],
                10,
                2
            );
        });
    }

}
