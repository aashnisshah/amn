<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Links extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('link_model','',TRUE);
        $this->load->model('categories_model', '', TRUE);
    }

    function index() {
        $categories = $this->categories_model->get_all_categories();
        foreach ($categories as $cat) {
            $catArray[$cat['id']] = $cat['name'];
        }
        $cat['categories'] = $catArray;

        $data = $this->viewLinks();

        if(isset($status)) {
            $data['status'] = $status;
        }

        // $this->load->view('layout/header');
        // $this->load->view('layout/navbar');
        $this->load->view('admin/addlink', $cat);
        $this->load->view('admin/links', $data);
    }

    /**
     * Create a new link in the database
     */
    function newLink() {
        $groupList = "";
        foreach($this->input->post('groups') as $group) {
            if(strlen($groupList) == 0) {
                $groupList = $group . " ";
            } else {
                $groupList = $groupList . " " . $group;
            }
        }

        $data['url'] = $this->input->post('url');
        $data['name'] = $this->input->post('name');
        $data['groups'] = $groupList;
        $data['image'] = $this->input->post('image');
        $data['description'] = $this->input->post('description');
        $this->link_model->add_new_link($data);
        $data['status'] = "success";
        redirect('links/index', $data);
    }

    function viewLinks() {
        $data['allLinks'] = $this->link_model->get_all_links();
        $data['accepted'] = $this->link_model->get_accepted_links();
        $data['pending'] = $this->link_model->get_pending_links();
        $data['rejected'] = $this->link_model->get_rejected_links();
        return $data;
    }

}
