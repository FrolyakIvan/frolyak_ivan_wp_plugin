<?php

namespace Frolyak\FrolyakIvanWpPlugin\Service;

use Frolyak\FrolyakIvanWpPlugin\Cache\CacheHandler;

/**
 * Class APIService
 */
class APIService {

    /**
     * @var string API_URL
     */
    private $API_URL;

    /**
     * @var CacheHandler cacheHandler
     */
    private $cacheHandler;


    /**
     * APIService constructor

     * @param CacheHandler cacheHandler
     */
    public function __construct(CacheHandler $cacheHandler) {
        $this->API_URL = "https://jsonplaceholder.typicode.com";
        $this->cacheHandler = $cacheHandler;
    }

    /**
     * Manages the Cache and Fetch data from API

     * @param string endpoint
     * @return array|bool returns the parsed data fetched from the request
     *  or, in case of a error a false
     */
    public function get_api_data(string $endpoint) {
        // Check if cached
        $apiRequestUrl = "$this->API_URL$endpoint";

        $key = self::generate_cache_key($apiRequestUrl);

        if ($cachedValue = $this->cacheHandler->get($key)) return self::parse_api_data($cachedValue);

        $fetchedData = $this->fetch_data($apiRequestUrl);

        // If an error has ocurred return error details to the endpoint...
        if(is_array($fetchedData) && isset($fetchedData['error'])) return $fetchedData;

        // If not cached, get and set new data
        $this->cacheHandler->set($key, $fetchedData);

        return self::parse_api_data($fetchedData);
    }

    /**
     * Makes the HTTP request (GET)

     * @param string url
     * @return string Returns the request body data
     */
    private function fetch_data($url) {

        $response = wp_remote_get($url);

        if (is_wp_error($response)) {
            return [
                'error' => 'REQUEST_ERROR',
                'error_code' => $response->get_error_code(),
                'error_message' => $response->get_error_message(),
                'message' => 'API request failed.',
            ];
        }

        $data = wp_remote_retrieve_body($response);

        // If body is empty return error
        if (is_string($data) && empty(trim($data))) {
            return [
                'error' => 'EMPTY_DATA',
                'message' => 'The request URL might be mistaken or external API
                    is not available at this moment.'
            ];
        }

        return $data;
    }

    /**
     * Generates a cache key

     * @param string url
     * @return string Returns a hashed identifier
     */
    private static function generate_cache_key($url) {
        return md5($url);
    }

    /**
     * Parses JSON data string to an array

     * @param string data
     * @return array|bool
     */
    private static function parse_api_data($data) {
        $parsedData = null;

        if (!empty($data) && is_string($data)) {
            $parsedData = json_decode($data, true);
            if (json_last_error() === JSON_ERROR_NONE) return $parsedData;
            else {
                $jsonErrorMsg = json_last_error_msg();
                return [
                    'error' => 'JSON_ERROR',
                    'error_message' => $jsonErrorMsg,
                    'message' => 'Given response body is not a valid JSON'
                ];
            }
        }
        else if (!empty($data) && is_array($data)) return $data;
        else return [];
    }
}