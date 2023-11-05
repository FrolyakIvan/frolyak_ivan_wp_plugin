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
        // TODO: CHECK if endpoint starts with "/" ???

        // Check if cached
        $apiRequestUrl = "$this->API_URL$endpoint";

        $key = self::generate_cache_key($apiRequestUrl);

        // if ($cachedValue = $this->cacheHandler->get($key)) return $cachedValue;

        $fetchedData = $this->fetch_data($apiRequestUrl);

        // if (!$fetchedData) {} // FIXME: ERROR

        // $this->cacheHandler->set($key, $fetchedData);

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
            // FIXME: ERROR
            // echo 'API request failed: ' . $response->get_error_message();
            return false;
        }

        $data = wp_remote_retrieve_body($response);

        // if (empty($data)) // FIXME: ERROR

        return $data;
    }

    /**
     * Generates a cache key

     * @param string url
     * @return string Returns a hashed identifier
     */
    private static function generate_cache_key($url) {
        // TODO: CHECK if endpoint starts with "/" ???
        return md5($url);
    }

    /**
     * Parses JSON data string to an array

     * @param string data
     * @return array|bool
     */
    private static function parse_api_data($data) {
        $parsedData = false;

        if (!empty($data) && is_string($data)) $parsedData = json_decode($data, true);
        else if (!empty($data) && is_array($data)) return $data;

        if (json_last_error() === JSON_ERROR_NONE) return $parsedData;
        else {
            // FIXME: ERROR
        }
    }
}