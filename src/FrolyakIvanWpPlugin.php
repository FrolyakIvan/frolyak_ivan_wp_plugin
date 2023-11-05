<?php

namespace Frolyak\FrolyakIvanWpPlugin;

use Frolyak\FrolyakIvanWpPlugin\Controller\EndpointController;

use Frolyak\FrolyakIvanWpPlugin\Service\APIService;
use Frolyak\FrolyakIvanWpPlugin\Cache\CacheHandler;
use Frolyak\FrolyakIvanWpPlugin\View\ViewController;

/**
 * Class FrolyakIvanWpPlugin
*/

class FrolyakIvanWpPlugin {

    /**
     * @var EndpointController endpointController
    */
    private $endpointController;


    /**
     * Constructs the main plugin Class

     * Initializes main objects needed for the plugin...
     */
    public function __construct() {
        $cacheHandler = new CacheHandler();
        $apiService = new APIService($cacheHandler);
        $viewController = new ViewController();

        $this->endpointController = new EndpointController($apiService, $viewController);
    }

    /**
     * Activates the plugin, creates a custom endpoint and flushes the
     *  rewrite rules.
     */
    public function activate() {
        $this->endpointController->setCustomEndpoint();
        flush_rewrite_rules();
    }

    /**
     * Deactivates the plugin and flushes the rewrite rules.
     */
    public function deactivate() {
        flush_rewrite_rules();
    }
}