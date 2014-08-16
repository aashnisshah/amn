<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

    function index() {
        $this->load->view('layout/header');
        $this->load->view('layout/navbar');
        $this->load->view('login/loginform');
        $this->load->view('layout/footer');
    }

}
