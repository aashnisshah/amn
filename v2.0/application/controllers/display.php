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

    function generateCode() {
        $show = $this->input->post('show');
        $cat = $this->input->post('cat');
        $order = $this->input->post('order');
        $number = $this->input->post('number');

        $query = "";

        if($show == "all") {
            $query = "SELECT * FROM links WHERE status=\"Accepted\"";
        } else {
            // TODO: Figure out how to search for categories specifically
            // $query = "SELECT * FROM links WHERE status=\"Accepted\" AND WHERE `groups` LIKE '%$cat%'";
        }

        if($order == "alph") {
            $query .= ' ORDER BY name';
        } else if ($order == "rand") {
            $query .= ' ORDER BY RAND()';
        }

        if($number != 0) {
            $query .= ' LIMIT '.$number.'';
        }

        $links = $this->link_model->get_query($query);

        $linksOutput = "<ul>";

        foreach($links as $link) {
            $linksOutput .= "<li class=\"missinglink\" id=" . $link['id'] . ">";
            $linksOutput .= "<a href=\"" . $link['url'] . "\">";
            $linksOutput .= $link['name'] . "</a></li>";
        }

        $linksOutput .= "</ul>";

        echo $linksOutput;
    }

}
