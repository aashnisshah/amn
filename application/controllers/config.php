<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Config extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('admin_model','',TRUE);
    }

    function setup() {

        if($this->admin_model->admin_exists()) {
            echo 'The Missing Link is already setup... ';
            echo '<br>Redirecting to the login page.';
            echo "<script type=\"text/javascript\">setTimeout(function () {
                        window.location.href= '../login';
                    },5000); </script>";
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
                // echo 'yay' . '<br>';

                $this->admin_model->create_admin($newUser);
                echo 'it is done';

            } else {
                echo 'crap...' . '<br>';
            }
        }

    //   $this->load->library('form_validation');
    //   $this->form_validation->set_rules('username','Username','required');
    //   $this->form_validation->set_rules('password','Password','required');
      //
    //   if($this->form_validation->run() == true){
      //
    //     $this->load->model('login_model');
    //     $this->load->model('customer');
    //     $valid_customer = $this->login_model->login_exists($login, $password);
    //     if($valid_customer != NULL){
    //       $this->load->library('session');
    //       $customer = new Customer();
      //
    //       // create new customer object
    //       $customer->id = $valid_customer->id;
    //       $customer->first = $valid_customer->first;
    //       $customer->last = $valid_customer->last;
    //       $customer->login = $valid_customer->login;
    //       $customer->password = $valid_customer->password;
    //       $customer->email = $valid_customer->email;
      //
    //       //check if user is admin, store user info into array
    //       if($login === "admin" || $login === "Admin"){
    //         $customer_array = array('id' => $customer->id,
    //                   'first' => $customer->first,
    //                   'last' => $customer->last,
    //                   'login' => $customer->login,
    //                   'email' => $customer->email);
    //       $this->session->set_userdata(array('id' => $customer->id, 'logged_in' => TRUE));
    //       $this->session->set_userdata($customer_array);
    //       redirect('login/admin', 'refresh');
    //       } else {
    //         $customer_array = array('id' => $customer->id,
    //                   'first' => $customer->first,
    //                   'last' => $customer->last,
    //                   'login' => $customer->login,
    //                   'email' => $customer->email);
    //       $this->session->set_userdata(array('id' => $customer->id, 'logged_in' => TRUE));
    //       $this->session->set_userdata($customer_array);
    //       redirect('login/customer', 'refresh');
    //       }
      //
    //     } else {
    //       $this->session->set_userdata(array('error' => 'The account username or password is invalid.'));
    //       redirect('login/loginForm', 'refresh');
    //     }
    //   }
    }

}
