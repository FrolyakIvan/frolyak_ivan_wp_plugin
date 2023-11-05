<?php

namespace Frolyak\FrolyakIvanWpPlugin\Cache;

class CacheHandler {

    /**
     * @var int expiresIn
     * For testing purposes the default value is set to 300sec = 5min
     */
    private $expiresIn;


    /**
     * CacheHandler constructor

     * @param int expiresIn
     */
    public function __construct(int $expiresIn = 300) {
        $this->expiresIn = $expiresIn;
    }

    /**
     * Gets a transient from Wordpress Database

     * @param string key
     * @return mixed If the register exists return the value, otherwise returns False
     */
    public function get(string $key) {
        $value = get_transient($key);

        return $value ?: false;
    }

    /**
     * Sets new transient in Wordpress Database

     * @param string key
     * @param mixed value Could be any type of data
     * @return bool If the value set is correct True, otherwise False
     */
    public function set(string $key, $value) {
        return set_transient($key, $value, $this->expiresIn);
    }

    /**
     * Deletes a transient in Wordpress Database

     * @param string key
     * @return bool If the action is correct, True, otherwise False
     */
    public function delete(string $key) {
        return delete_transient($key);
    }
}