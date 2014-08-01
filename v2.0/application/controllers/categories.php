<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categories extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('categories_model','',TRUE);
    }

    function index() {
        $data['categories'] = $this->categories_model->get_all_categories();
        $this->load->view('admin/categories', $data);
    }

    /**
     * Create a new link in the database
     */
    function newCategory() {
        $newCategoryEntry['name'] = $this->input->post('name');
        $newCategoryEntry['description'] = $this->input->post('description');
        $this->categories_model->add_new_category($newCategoryEntry);
        $data['categories'] = $this->categories_model->get_all_categories();
        $this->load->view('admin/categories', $data);
    }

}
