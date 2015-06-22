<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct(){

        parent::__construct();
        $this->load->model('master');
    }
    public function index(){

        $data = array(
            'title' => 'Welcome, Geekerbyte!',
        );

        $this->load->view('templates/pub_head',$data);
        $this->load->view('home',$data);
        $this->load->view('templates/pub_foot',$data);
    }
}
