<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

    function index() {
        //$this->load->help(array('form', 'html'));
        $this->load->view('login/loginform');
    }

}
