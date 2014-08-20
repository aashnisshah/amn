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
        $this->load->view('admin/displayCode');
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

        $code = '&lt;?php ';
        $code .= '$show="' . $show . '"; ';
        $code .= '$cat="' . $cat . '"; ';
        $code .= '$order="' . $order . '"; ';
        $code .= '$number="' . $number . '"; ';
        $code .= 'include \'' . site_url() . 'display.php\';';
        $code .= ' ?&gt;';

        $data['code'] = $code;

        $data['categories'] = $this->getCategories();
        $this->load->view('layout/header');
        $this->load->view('layout/navbar');
        $this->load->view('admin/displayInstructions');
        $this->load->view('admin/displayCode', $data);
        $this->load->view('admin/display', $data);
        $this->load->view('layout/footer');

    }

}
