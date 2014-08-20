<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Config extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('admin_model','',TRUE);
    }

    function setup() {

        $this->create_database();

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

    function create_database() {

        //-- Table structure for table `admin_info` --
        $query_admin_info = "CREATE TABLE `admin_info` (";
        $query_admin_info .= "  `id` int(11) NOT NULL,";
        $query_admin_info .= "  `name` varchar(64) NOT NULL,";
        $query_admin_info .= "  `email` varchar(128) NOT NULL,";
        $query_admin_info .= "  `website` varchar(128) NOT NULL,";
        $query_admin_info .= "  PRIMARY KEY (`id`)";
        $query_admin_info .= ");";

        // -- Table structure for table `admin_login` --
        $query_admin_login = "CREATE TABLE `admin_login` (";
        $query_admin_login .= "  `id` int(11) NOT NULL AUTO_INCREMENT,";
        $query_admin_login .= "  `username` varchar(36) NOT NULL,";
        $query_admin_login .= "  `password` varchar(32) NOT NULL,";
        $query_admin_login .= "  PRIMARY KEY (`id`),";
        $query_admin_login .= "  UNIQUE KEY `user` (`username`)";
        $query_admin_login .= ");";

        //-- Table structure for table `categories` --
        $query_categories = "CREATE TABLE IF NOT EXISTS `categories` (";
        $query_categories .= "  `id` int(11) NOT NULL AUTO_INCREMENT,";
        $query_categories .= "  `name` varchar(32) NOT NULL,";
        $query_categories .= "  `description` text NOT NULL,";
        $query_categories .= "  PRIMARY KEY (`id`)";
        $query_categories .= ") ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;";

        //-- Table structure for table `links` --
        $query_links = "CREATE TABLE IF NOT EXISTS `links` (";
        $query_links .= "  `id` int(11) NOT NULL AUTO_INCREMENT,";
        $query_links .= "  `url` varchar(128) NOT NULL,";
        $query_links .= "  `name` varchar(64) NOT NULL,";
        $query_links .= "  `status` varchar(24) NOT NULL,";
        $query_links .= "  `groups` varchar(32) NOT NULL,";
        $query_links .= "  `image` varchar(128) NOT NULL,";
        $query_links .= "  `description` text NOT NULL,";
        $query_links .= "  PRIMARY KEY (`id`),";
        $query_links .= "  UNIQUE KEY `url` (`url`)";
        $query_links .= ") ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=77 ;";

        include 'settings.php';

        $con = mysqli_connect($hostname,$username,$password,$database);
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        } else {
            $result_admin_info = mysqli_query($con, $query_admin_info) or die(mysqli_error($con));
            $result_admin_login = mysqli_query($con, $query_admin_login) or die(mysqli_error($con));
            $result_admin_categories = mysqli_query($con, $query_categories) or die(mysqli_error($con));
            $result_admin_links = mysqli_query($con, $query_links) or die(mysqli_error($con));
        }
    }

}
