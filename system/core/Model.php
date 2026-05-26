<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CI_Model {
    protected $db;

    public function __construct() {
        // Auto-connect to database
        $this->load =& load_class('Loader');
        $this->db =& $this->load->database();
    }
}
