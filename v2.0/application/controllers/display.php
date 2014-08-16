<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Display extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('link_model','',TRUE);
        $this->load->model('categories_model','',TRUE);
    }

    function index() {
        $this->isLoggedIn();
        $data['categories'] = $this->getCategories();
        $this->load->view('layout/header');
        $this->load->view('layout/navbar');
        $this->load->view('admin/displayInstructions');
        $this->load->view('admin/display', $data);
        $this->load->view('layout/footer');
    }

    function isLoggedIn() {
        if($this->session->userdata('logged_in')) {
                return true;
        } else {
            redirect('login');
        }
    }

    /**
     * Get the list of categories and their names
     */
    function getCategories() {
        $categories = $this->categories_model->get_all_categories();
        foreach ($categories as $cat) {
            $catArray[$cat['id']] = $cat['name'];
        }
        return $catArray;
    }

}
