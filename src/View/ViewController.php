<?php

declare(strict_types=1);

namespace Frolyak\FrolyakIvanWpPlugin\View;

/**
 * Class ViewController
 */

class ViewController
{

    /**
     * @var ViewController instance
     */
    private static $instance = null;

    /**
     * @var array data
     */
    private $data;


    private function __construct()
    {
        //...
    }

    /**
     * Returns the unique instance of this class

     * @return self instance
     */
    public static function instance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Sets the template to be returned

     * @param  array data
     * @param  string template
     * @return string|bool Depending of template existence
     */
    public function setTemplate($data, $template)
    {
        $templateFile = PLUGIN_DIR . 'templates/basicTemplate.php';

        $this->setData($data);
        // if (is_array($data) && count($data)) $this->setData($data);
        if ( is_string($data) || empty($data) || !count($data) )
        {
            $this->setData(
                [
                    'error' => 'EMPTY_DATA',
                    'message' => 'The request URL might be mistaken or external
                    API is not available at this moment.'
                ]
            );
        }

        if (file_exists($templateFile))
        {
            return $templateFile;
        }

        return $template;
    }

    /**
     * Retrieves the stored data

     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Setter of data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

}
