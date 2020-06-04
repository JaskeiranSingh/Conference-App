<?php
/**
 *  Class super that constructs keys for applicationRegistry 
 */ 
Abstract Class Registry {
    private function __construct() {}
    abstract protected function get($key);
    abstract protected function set($key, $value);
}
?>
