<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('admin_model','',TRUE);
    }

    function something() {
        $name = $this->admin_model->get_name(1);
        echo $name;
    }

    function isLoggedIn() {
        if($this->session->userdata('logged_in')) {
                return true;
        } else {
            redirect('login');
        }
    }

    /**
     * Get and display information about the admin of this account
     */
    function info() {
        if($this->isLoggedIn()) {
            $data['admin_info'] = $this->admin_model->get_all_admin_info($this->session->userdata['id']);
            if(isset($message)) {
                $data['message'] = $message;
            }
            $this->load->view('layout/header');
            $this->load->view('layout/navbar');
            $this->load->view('admin/info', $data);
            $this->load->view('layout/footer');
        } else {
            redirect('login');
        }
    }

    /**
     * Updates the admin's user information
     */
    function updateInfo() {

        // validate input
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean|min_length[6]|');
        $this->form_validation->set_rules('newpassword', 'Password', 'trim|matches[confpassword]|xss_clean');
        $this->form_validation->set_rules('confpassword', 'Password Confirmation', 'trim|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|xss_clean');
        $this->form_validation->set_rules('name', 'Name', 'trim|xss_clean|xss_clean');
        $this->form_validation->set_rules('website', 'URL to Website', 'trim|required|xss_clean');
        $this->form_validation->set_rules('currentpassword', 'Current Password', 'trim|required|xss_clean');

        // checking if currentpassword matches password stored in database
        if(MD5(SHA1($this->input->post('currentpassword'))) !=
            $this->admin_model->get_password($this->session->userdata['id'])){
            $data['message'] = "Error: You entered the wrong password.";
            redirect('admin/info', $data);
        }

        if($this->form_validation->run() == true) {

            $admin_info_data['name'] = $this->input->post('name');
            $admin_info_data['email'] = $this->input->post('email');
            $admin_info_data['website'] = $this->input->post('website');

            $login_info_data['username'] = $this->input->post('username');
            if($this->input->post('newpassword') == "") {
                $login_info_data['password'] = $this->admin_model->get_password($this->session->userdata['id']);
            } else {
                $login_info_data['password'] = MD5(SHA1($this->input->post('newpassword')));
            }

            $this->admin_model->update_admin_info($admin_info_data);
            $this->admin_model->update_login_info($login_info_data);

            $this->session->set_userdata('username', $this->input->post('username'));

            $data['message'] = "Success: Your information has been successfully updated.";
            redirect('admin/info', $data);
        } else {
            $data['message'] = "There was a problem updating your information.<br>Please try again.";
            redirect('admin/info', $data);
        }
    }

}
