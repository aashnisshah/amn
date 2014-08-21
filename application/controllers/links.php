<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Links extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('link_model','',TRUE);
        $this->load->model('categories_model', '', TRUE);
    }

    function index($filter) {
        $this->isLoggedIn();
        $data['allLinks'] = $this->getLinks($filter);
        $data['header'] = $filter;

        $data['categories'] = $this->getCategories();

        if(isset($status)) {
            $data['status'] = $status;
        }

        $this->load->view('layout/header');
        $this->load->view('layout/navbar');
        $this->load->view('admin/addlink', $data);
        $this->load->view('admin/links', $data);
        $this->load->view('admin/linkstable', $data);
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
        $catArray = array();
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
        // validate input
        $this->load->library('form_validation');
        $this->form_validation->set_rules('url', 'URL for the Link', 'trim|required|xss_clean');
        $this->form_validation->set_rules('name', 'Link Name', 'trim|xss_clean');
        $this->form_validation->set_rules('groups', 'Groups Link Belongs To', 'xss_clean');
        $this->form_validation->set_rules('image', 'Image URL', 'trim|xss_clean');
        $this->form_validation->set_rules('description', 'Link Description', 'trim|xss_clean');

        if($this->form_validation->run() == true) {
            $groups = $this->input->post('groups');
            $groupList = $this->stringifyGroups($groups);
            $data['url'] = $this->input->post('url');
            $data['name'] = $this->input->post('name');
            $data['groups'] = $groupList;
            $data['image'] = $this->input->post('image');
            $data['description'] = $this->input->post('description');
            $data['status'] = "Pending";
            $this->link_model->add_new_link($data);
            $data['status'] = "success";

            redirect('links/index/all', $data);
        } else {
            $data['status'] = "error";
            redirect('links/index/all', $data);
        }
    }

    function newExternalLink() {
        if(isset($_POST['vermili']) && $_POST['vermili'] == "external") {
            // validate input
            $this->load->library('form_validation');
            $this->form_validation->set_rules('url', 'URL for the Link', 'trim|required|xss_clean');
            $this->form_validation->set_rules('name', 'Link Name', 'trim|xss_clean');
            $this->form_validation->set_rules('groups', 'Groups Link Belongs To', 'xss_clean');
            $this->form_validation->set_rules('image', 'Image URL', 'trim|xss_clean');
            $this->form_validation->set_rules('description', 'Link Description', 'trim|xss_clean');

            if($this->form_validation->run() == true) {
                $data['url'] = $_POST['url'];
                $data['name'] = $_POST['name'];
                $data['groups'] = "";
                $data['image'] = $_POST['image'];
                $data['description'] = $_POST['description'];
                $data['status'] = "Pending";
                $this->link_model->add_new_link($data);
                $data['status'] = "success";

                echo "<script type=text/javascript>";
                echo "location.href='../success.php'</script>";
            } else {
                echo "<script type=text/javascript>";
                echo "location.href='../error.php'</script>";
            }
        } else {
            echo "<script type=text/javascript>";
            echo "location.href='../error.php'</script>";
        }
    }

    function stringifyGroups($groups){
        $groupList = "";
        if($groups[0] != "") {
            foreach($groups as $group) {
                if(strlen($groupList) == 0) {
                    $groupList = $group . " ";
                } else {
                    $groupList = $groupList . " " . $group;
                }
            }
        }
        return $groupList;
    }

    function updatelink() {
        // validate input
        $this->load->library('form_validation');
        $this->form_validation->set_rules('url', 'URL for the Link', 'trim|xss_clean');
        $this->form_validation->set_rules('name', 'Link Name', 'trim|xss_clean');
        $this->form_validation->set_rules('status', 'Link Status', 'trim|xss_clean');
        $this->form_validation->set_rules('groups', 'Groups Link Belongs To', 'xss_clean');
        $this->form_validation->set_rules('image', 'Image URL', 'trim|xss_clean');
        $this->form_validation->set_rules('description', 'Link Description', 'trim|xss_clean');

        if($this->form_validation->run() == true) {
            $original = $this->input->post('original');
            $groups = $this->input->post('groups');
            $originalGroups = $this->stringifyGroups($groups);

            $updated['url'] = $this->getNewValue($original['url'], $this->input->post('url'));
            $updated['name'] = $this->getNewValue($original['name'], $this->input->post('name'));
            $updated['status'] = $this->getNewValue($original['status'], $this->input->post('status'));
            $updated['groups'] = $this->getNewValue($original['groups'], $originalGroups);
            $updated['image'] = $this->getNewValue($original['image'], $this->input->post('image'));
            $updated['description'] = $this->getNewValue($original['description'], $this->input->post('description'));

            $this->link_model->update_link_information($original['id'], $updated);
            redirect('links/edit/' . $original['id']);
        } else {
            redirect('links/edit/' . $original['id']);
        }
    }

    function getNewValue($orig, $form) {
        if($form !== "") {
            return $form;
        } else {
            return $orig;
        }
    }

    function delete($id) {
        $this->link_model->delete_link($id);
        redirect('links/index/all');
    }

    function updateStatus($id, $newStatus) {
        $this->link_model->update_status($id, ucfirst($newStatus));
        redirect('links/index/all');
    }

    function edit($id) {
        $this->isLoggedIn();
        $links = $this->link_model->get_link_details($id);
        $data['link'] = $links[0];
        $data['categories'] = $this->getCategories();

        $this->load->view('layout/header');
        $this->load->view('layout/navbar');
        $this->load->view('admin/editlink', $data);
        $this->load->view('layout/footer');
    }

}
