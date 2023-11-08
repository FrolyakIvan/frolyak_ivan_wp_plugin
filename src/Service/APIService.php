<?php

declare(strict_types=1);

namespace Frolyak\FrolyakIvanWpPlugin\Service;

use Frolyak\FrolyakIvanWpPlugin\Cache\CacheHandler;

/**
 * Class APIService
 */
class APIService
{

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
    public function __construct(CacheHandler $cacheHandler)
    {
        $this->API_URL = "https://jsonplaceholder.typicode.com";
        $this->cacheHandler = $cacheHandler;
    }

    /**
     * Manages the Cache and Fetch data from API

     * If request URL have been used before, it means that it
     * has to be in cache. Otherwise we make a HTTP request
     * to get the data from the external API.

     * @param  string endpoint
     * @return array returns the parsed data fetched from the request
     *  or, in case of a error an error Array...
     */
    public function getApiData(string $endpoint)
    {
        $apiRequestUrl = "$this->API_URL$endpoint";

        $key = self::generateCacheKey($apiRequestUrl);

        if ( $cachedValue = $this->cacheHandler->get($key) )
        {
            return self::parseApiData($cachedValue);
        }

        $fetchedData = $this->fetchData($apiRequestUrl);

        // If an error has ocurred return error details to the frontend...
        if( is_array($fetchedData) && isset($fetchedData['error']) )
        {
            return $fetchedData;
        }

        // If not in cache, set new data
        $this->cacheHandler->set($key, $fetchedData);

        return self::parseApiData($fetchedData);
    }

    /**
     * Makes the HTTP request (GET)

     * @param  string url
     * @return string Returns the request body data
     */
    private function fetchData($url)
    {
        $response = wp_remote_get($url);

        if ( is_wp_error($response) )
        {
            return [
                'error' => 'REQUEST_ERROR',
                'error_code' => $response->get_error_code(),
                'error_message' => $response->get_error_message(),
                'message' => 'API request failed.',
            ];
        }

        $data = wp_remote_retrieve_body($response);

        // If body is empty return error
        if ( is_string($data) && empty(trim($data)) )
        {
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

     * @param  string url
     * @return string Returns a hashed identifier
     */
    private static function generateCacheKey(string $url)
    {
        return md5($url);
    }

    /**
     * Parses JSON data string to an array

     * @param  string data
     * @return array
     */
    private static function parseApiData(string $data)
    {
        $parsedData = null;

        if ( !empty($data) && is_string($data) )
        {
            $parsedData = json_decode($data, true);
            if ( json_last_error() === JSON_ERROR_NONE )
            {
                return $parsedData;
            }
            else
            {
                $jsonErrorMsg = json_last_error_msg();
                return [
                    'error' => 'JSON_ERROR',
                    'error_message' => $jsonErrorMsg,
                    'message' => 'Given response body is not a valid JSON'
                ];
            }
        }
        else if ( !empty($data) && is_array($data) )
        {
            return $data;
        }
        else return [];
    }
}
