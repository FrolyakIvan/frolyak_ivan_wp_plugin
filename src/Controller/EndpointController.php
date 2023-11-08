<?php

declare(strict_types=1);

namespace Frolyak\FrolyakIvanWpPlugin\Controller;

use Frolyak\FrolyakIvanWpPlugin\Service\APIService;
use Frolyak\FrolyakIvanWpPlugin\View\ViewController;

/**
 * Class EndpointController
 */

class EndpointController
{

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
    public function __construct(APIService $apiService, ViewController $viewController)
    {
        $this->apiService = $apiService;
        $this->viewController = $viewController;

        $this->setHooks();
        $this->setEnqueueScriptsAndAjax();
    }

    /**
     * Enqueue styles and scripts for the template of this plugin
     */
    public function setScripts()
    {
        wp_enqueue_style('frolyak-main-css', PLUGIN_URL . 'assets/css/main.css');
        wp_enqueue_script(
            'frolyak-main-js',
            PLUGIN_URL . 'assets/js/index.js',
            ['jquery'],
            null,
            true
        );

        // Localizes the defined script and includes 'ajaxurl' global variable for AJAX requests...
        wp_localize_script('frolyak-main-js', 'ajaxurl', admin_url('admin-ajax.php'));
    }

    /**
     * Sets the required filters through Wordpress hooks
     */
    public function setHooks()
    {
        add_filter('query_vars', [$this, 'setQueryVars']);
        add_filter('template_include', [$this, 'handleTemplate']);
    }

    /**
     * Sets Wordpress actions for enqueuing scripts and handles AJAX requests
     */
    public function setEnqueueScriptsAndAjax()
    {
        add_action('wp_enqueue_scripts', [$this, 'setScripts']);
        add_action('wp_ajax_nopriv_get_users_details', [$this, 'getUsersDetails']);
    }

    /**
     * Adds a rewrite rule for a custom endpoint to Wordpress
     */
    public function setCustomEndpoint()
    {
        return add_rewrite_rule('^custom-endpoint/?$', 'index.php?custom_endpoint=1', 'top');
    }

    /**
     * Adds query custom endpoint vars

     * @var    array vars Array of exisitng query vars
     * @return array An Array of query vars
     */
    public function setQueryVars(array $vars)
    {
        $vars[] = "custom_endpoint";
        return $vars;
    }

    /**
     * Handles the selection of a correct template

     * @param  string template
     * @return string The path to the appropiate template
     */
    public function handleTemplate(string $template)
    {
        if ( get_query_var('custom_endpoint', false) !== false )
        {
            $data = $this->apiService->getApiData('/users');
            return $this->viewController->setTemplate($data, $template);
        }
        return $template;

    }

    /**
     * Handles the AJAX request to get the user information
     */
    public function getUsersDetails()
    {
        $data = null;
        $userId = isset( $_POST['userId'] ) && !empty( $_POST['userId'] ) ?
            $_POST['userId'] : false;

        if ( is_bool($userId) )
        {
            wp_send_json_error(
                [ 'message'=>"There is no user id specified in the request payload." ],
                500
            );
        } else {
            $data = $this->apiService->getApiData("/users/$userId");
            wp_send_json_success($data);
        }

    }

}
