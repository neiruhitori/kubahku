<?php

class Home extends Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $data['title'] = 'SIKUBAH - Jasa Kubah Masjid';
        $this->load_view('home/index', $data);
    }
}
