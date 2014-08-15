<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Links extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('link_model','',TRUE);
        $this->load->model('categories_model', '', TRUE);
    }

    function index($filter) {
        $cat['categories'] = $this->getCategories();

        $data['allLinks'] = $this->getLinks($filter);
        $data['header'] = $filter;

        $data['categories'] = $this->getCategories();

        if(isset($status)) {
            $data['status'] = $status;
        }

        $this->load->view('layout/header');
        $this->load->view('layout/navbar');
        $this->load->view('admin/addlink', $cat);
        $this->load->view('admin/links', $data);
        $this->load->view('layout/footer');
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

    /**
     * Get the list of links
     */
    function getLinks($filter) {
        if($filter === "all") {
            $links = $this->link_model->get_all_links();
        } else {
            $links = $this->link_model->get_status_filtered_links($filter);
        }
        return $links;
    }

    /**
     * Create a new link in the database
     */
    function newLink() {
        $groupList = "";
        $groups = $this->input->post('groups');
        if($groups[0] != "") {
            foreach($groups as $group) {
                if(strlen($groupList) == 0) {
                    $groupList = $group . " ";
                } else {
                    $groupList = $groupList . " " . $group;
                }
            }
        }

        $data['url'] = $this->input->post('url');
        $data['name'] = $this->input->post('name');
        $data['groups'] = $groupList;
        $data['image'] = $this->input->post('image');
        $data['description'] = $this->input->post('description');
        $data['status'] = "Pending";
        $this->link_model->add_new_link($data);
        $data['status'] = "success";

        redirect('links/index/all', $data);
    }

    function delete($id) {
        $this->link_model->delete_link($id);
        redirect('links/index/all');
    }

    function updateStatus($id, $newStatus) {
        $this->link_model->update_status($id, ucfirst($newStatus));
        redirect('links/index/all');
    }

}
