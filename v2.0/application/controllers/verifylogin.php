<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Verifylogin extends CI_Controller {

    function __construct() {
        parent::__construct();
        //load session and connect to database
        $this->load->model('admin_model', 'admin_model', TRUE);
    }

    function index() {        $this->form_validation->set_rules('username', 'Username',
                'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password',
                'trim|required|css_clean|callback_check_database');

        if($this->form_validation->run() == FALSE) {
            $this->load->view('login/loginform');
        } else {
            redirect('home/index', 'refresh');
            // echo 'redirect';
        }
    }

    function check_database($password) {
        $username = $this->input->post('username');
        $result = $this->admin_model->login($username, $password);
        // console($result);
        if($result) {
            $sess_array = array();
            foreach($result as $row) {
                $sess_array = array('id' => $row->id, 'username' => $row->username);
                $this->session->set_userdata('logged_in', $sess_array);
            }
        return TRUE;
        } else {
            $this->form_validation->set_message('check_database', 'Invalid username or password');
            return FALSE;
        }
    }

}
