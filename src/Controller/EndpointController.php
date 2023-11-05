<?php

namespace Frolyak\FrolyakIvanWpPlugin\Controller;

use Frolyak\FrolyakIvanWpPlugin\Service\APIService;
use Frolyak\FrolyakIvanWpPlugin\View\ViewController;

/**
* Class EndpointController
*/

class EndpointController {

    /**
     * @var APIService apiService
     */
    private $apiService;

    /**
     * @var ViewController viewController
     */
    private $viewController;


    /**
     * EndpointController constructor

     * @param APIService apiService
     * @param ViewController viewController
     */

    public function __construct(APIService $apiService, ViewController $viewController) {
        $this->apiService = $apiService;
        $this->viewController = $viewController;

        $this->setHooks();
    }

    /**
     * Sets the required filters through Wordpress hooks
     */
    public function setHooks() {
        add_filter('query_vars', [$this, 'setQueryVars']);
        add_filter('template_include', [$this, 'handleTemplate']);
    }

    /**
     * Adds a rewrite rule for a custom endpoint to Wordpress
     */
    public function setCustomEndpoint() {
        add_rewrite_rule('^custom-endpoint/?$', 'index.php?custom_endpoint=1', 'top');
    }

    /**
     * Adds query custom endpoint vars
     * @var array $vars Array of exisitng query vars
     * @return array An Array of query vars
     */
    public function setQueryVars(array $vars) {
        $vars[] = "custom_endpoint";
        return $vars;
    }

    /**
     * Handles the selection of a correct template

     * @param string template
     * @return string The path to the appropiate template
     */
    public function handleTemplate(string $template) {
        if (get_query_var('custom_endpoint', false) !== false) {

            // FIXME: Error
            $data = $this->apiService->get_api_data('/users');

            if (!is_bool($data)) return $this->viewController->setTemplate($data);
            else echo 'Error';

        }
        return $template;

    }




}