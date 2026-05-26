<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CI_Controller {
    protected $load;
    public static $instance;

    public function __construct() {
        self::$instance = &$this;
        
        // Inisialisasi basic properties
        foreach (is_loaded() as $var => $class) {
            $this->$var =& load_class($class);
        }
        
        log_message('debug', "Controller Class Initialized");
    }

    public function __get($key) {
        return isset(self::$instance->$key) ? self::$instance->$key : null;
    }
}

function &get_instance() {
    return CI_Controller::$instance;
}
