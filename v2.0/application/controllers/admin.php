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
        if(isset($this->session->userdata('logged_in') &&
            $this->session->userdata('logged_in') == true)) {
                return true;
        } else {
            redirect('login');
        }
    }

    /**
     * Get and display information about the admin of this account
     */
    function info() {
        $data['admin_info'] = $this->admin_model->get_all_admin_info($this->session->userdata['id']);
        $this->load->view('layout/header');
        $this->load->view('layout/navbar');
        $this->load->view('admin/info', $data);
        $this->load->view('layout/footer');
    }

    /**
     * Updates the admin's user information
     */
    function updateInfo() {
        if(md5($this->input->post('currentpassword')) != $this->admin_model->get_password($this->session->userdata['id'])){
            $status['message'] = "Error: You entered the wrong password.";
            redirect('admin/info', $status);
        }

        $admin_info_data['name'] = $this->input->post('name');
        $admin_info_data['email'] = $this->input->post('email');
        $admin_info_data['website'] = $this->input->post('website');

        $login_info_data['username'] = $this->input->post('username');
        if($this->input->post('newpassword') == "" && $this->input->post('newpassword') == $this->input->post('confpassword')) {
            $login_info_data['password'] = $this->admin_model->get_password($this->session->userdata['id']);
        } else {
            $login_info_data['password'] = md5($this->input->post('newpassword'));
        }

        $this->admin_model->update_admin_info($admin_info_data);
        $this->admin_model->update_login_info($login_info_data);

        $this->session->set_userdata('username', $this->input->post('username'));

        $data['message'] = "Success: Your information has been successfully updated.";
        redirect('admin/info', $data);
    }

}
