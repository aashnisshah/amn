<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('admin_model','',TRUE);
    }

    function index() {
        if(!$this->admin_model->table_exists()) {
            echo "<script type=\"text/javascript\">setTimeout(function () {";
            echo "window.location.href= '" . site_url() . "config.php';";
            echo "},0); </script>";
        } else {
            $this->load->view('layout/header');
            $this->load->view('layout/navbar');
            $this->load->view('login/loginform');
            $this->load->view('layout/footer');
        }
    }

}
