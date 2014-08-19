<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Verifylogin extends CI_Controller {

    function __construct() {
        parent::__construct();
        //load session and connect to database
        $this->load->model('admin_model', 'admin_model', TRUE);
    }

    function index() {
        $this->form_validation->set_rules('username', 'Username',
                'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password',
                'trim|required|css_clean|callback_check_database');

        if($this->form_validation->run() == FALSE) {
            $this->load->view('login/loginform');
        } else {
            $this->check_database($this->input->post('username'), $this->input->post('password'));
        }
    }

    function check_database($password) {
        $username = $this->input->post('username');
        $result = $this->admin_model->login($username, $password);
        // console($result);
        if($result) {
            $sess_array = array();
            foreach($result as $row) {
                $this->session->set_userdata('logged_in', TRUE);
                $this->session->set_userdata('id', $row->id);
                $this->session->set_userdata('username', $row->username);
            }
            $this->session->set_userdata('loginfail', false);
            redirect('home/index', 'refresh');
        } else {
            $this->form_validation->set_message('check_database', 'Invalid username or password');
            $this->session->set_userdata('loginfail', true);
            redirect('login');
        }
    }

}
