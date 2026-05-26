<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loader {
    public $views = array();
    public $vars = array();
    protected $_db_objects = array();

    public function view($view, $vars = array(), $return = FALSE) {
        return $this->_load(array('_ci_view' => $view, '_ci_vars' => $vars, '_ci_return' => $return), '_display');
    }

    public function model($model, $name = '', $db_conn = FALSE) {
        if (empty($model)) {
            return $this;
        }
        
        $model = strtolower($model);
        
        if ( ! file_exists(APPPATH.'models/'.$model.'.php')) {
            return FALSE;
        }

        require_once(APPPATH.'models/'.$model.'.php');
        $model_name = ucfirst($model);
        
        if (empty($name)) {
            $name = $model;
        }

        $CI = &get_instance();
        $CI->$name = new $model_name();
        return $this;
    }

    public function database($params = '', $return = FALSE, $query_builder = NULL) {
        // Load database
        require_once APPPATH.'config/database.php';
        
        if ( ! isset($db) || count($db) === 0) {
            return FALSE;
        }

        if ($return === TRUE) {
            return $this->_database($db['default']);
        }

        $CI = &get_instance();
        $CI->db = $this->_database($db['default']);
        return $this;
    }

    protected function _database($config) {
        $driver = 'mysqli';
        require_once APPPATH.'drivers/Database.php';
        $DB = new Database($config);
        return $DB;
    }

    protected function _load($data) {
        extract($data);

        if (is_file($_ci_view)) {
            include $_ci_view;
        } else {
            show_error('Unable to load the requested file: '.$_ci_view);
        }

        if ($_ci_return === TRUE) {
            $buffer = ob_get_clean();
            return $buffer;
        }

        if (ob_get_level() > $this->_ci_ob_level + 1) {
            ob_end_flush();
        } else {
            ob_end_clean();
        }
    }
}
