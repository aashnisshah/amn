<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categories extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('categories_model','',TRUE);
    }

    function index() {
        $this->isLoggedIn();
        $data['categories'] = $this->categories_model->get_all_categories();
        $this->load->view('layout/header');
        $this->load->view('layout/navbar');
        $this->load->view('admin/addcategories', $data);
        $this->load->view('admin/categories', $data);
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
     * Create a new link in the database
     */
    function newCategory() {
        $newCategoryEntry['name'] = $this->input->post('name');
        $newCategoryEntry['description'] = $this->input->post('description');
        $this->categories_model->add_new_category($newCategoryEntry);
        $data['categories'] = $this->categories_model->get_all_categories();
        $this->load->view('admin/categories', $data);
        redirect('categories/index');
    }

    function delete($id) {
        $this->categories_model->delete_category($id);
        redirect('categories/index');
    }

    function updatecategory() {
        $updated['name'] = $this->input->post('name');
        $updated['description'] = $this->input->post('description');
        $this->categories_model->update_category($this->input->post('id'), $updated);
        redirect('categories/edit/' . $this->input->post('id'));
    }

    function edit($id) {
        $this->isLoggedIn();
        $category = $this->categories_model->get_category_details($id);
        $data['category'] = $category[0];

        $this->load->view('layout/header');
        $this->load->view('layout/navbar');
        $this->load->view('admin/editcategory', $data);
        $this->load->view('layout/footer');
    }

}
