<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->view_folder = "home";
    }
    public function index(){
        $this->render_template();
    }
}
