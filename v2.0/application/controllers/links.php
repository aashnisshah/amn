<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Links extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('link_model','',TRUE);
    }

    function index() {
        $this->load->view('admin/addlink');
    }

    /**
     * Create a new link in the database
     */
    function newLink() {
        $data['url'] = $this->input->post('url');
        $data['name'] = $this->input->post('name');
        $data['groups'] = $this->input->post('groups');
        $data['image'] = $this->input->post('image');
        $this->link_model->add_new_link($data);
        $this->load->view('admin/links', $data);
    }

    function viewLinks() {
        $data['allLinks'] = $this->link_model->get_all_links();
        $this->load->view('admin/links', $data);
    }

}
