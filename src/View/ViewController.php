<?php

namespace Frolyak\FrolyakIvanWpPlugin\View;

/**
 * Class ViewController
*/

class ViewController {

    // public function __construct() {}

    // TODO: FEATURES
    // public function getTemplates() {}

    /**
     * Sets the template to be returned

     * @param array data
     * @return string|bool Depending of template existence
     */
    public function setTemplate($data) {
        $templateFile = PLUGIN_DIR . 'templates/basicTemplate.php';

        if (file_exists($templateFile)) return $templateFile;

        // FIXME: ERROR
        return false;
    }
}