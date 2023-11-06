<?php

namespace Frolyak\FrolyakIvanWpPlugin\View;

/**
 * Class ViewController
*/

class ViewController {

    /**
     * @var ViewController instance
     */
    private static $instance = null;

    /**
     * @var array data
     */
    private $data;


    private function __construct() {}

    /**
     * Returns the unique instance of this class

     * @return self instance
     */
    public static function instance() {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // TODO: FEATURES
    // public function getTemplates() {}

    /**
     * Sets the template to be returned

     * @param array data
     * @return string|bool Depending of template existence
     */
    public function setTemplate($data) {
        $templateFile = PLUGIN_DIR . 'templates/basicTemplate.php';

        if (is_array($data) && count($data)) $this->setData($data);
        else if (is_string($data) || empty($data)) $data = ['error' => 'No data!'];

        if (file_exists($templateFile)) return $templateFile;

        // FIXME: ERROR
        return false;
    }

    /**
     * Retrieves the stored data

     * @return array
     */
    public function getData() {
        return $this->data;
    }

    /**
     * Setter of data
     */
    private function setData($data) {
        $this->data = $data;
    }

}