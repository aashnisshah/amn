<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Config extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('admin_model','',TRUE);
    }

    function setup() {

        if($this->admin_model->admin_exists()) {
            $this->load->view('layout/header');
            $this->load->view('layout/navbar');
            $this->load->view('admin/complete');
            $this->load->view('layout/footer');
        } else {

            $newUser['username'] = $this->input->get_post('username');
            $newUser['password'] = $this->input->get_post('password');
            $newUser['passconf'] = $this->input->get_post('passconf');
            $newUser['email'] = $this->input->get_post('email');
            $newUser['name'] = $this->input->get_post('name');
            $newUser['website'] = $this->input->get_post('website');

            $this->load->library('form_validation');
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('website', 'URL to Website', 'required');

            if($newUser['password'] !== $newUser['passconf']){
                echo 'error passwords dont match' . '<br>';
                echo 'passw: ' . $newUser['password'] . '<br>';
                echo 'passconf: ' . $newUser['passconf'] . '<br>';
            }

            if($this->form_validation->run() == true) {
                $this->admin_model->create_admin($newUser);
                $this->load->view('layout/header');
                $this->load->view('layout/navbar');
                $this->load->view('admin/setup_complete');
                $this->load->view('layout/footer');

            } else {
                echo 'crap...' . '<br>';
            }
        }
    }

}
