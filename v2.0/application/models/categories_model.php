<?php
class Categories_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Add new link into the database
     */
    function add_new_category($data) {
        return $this->db->insert("categories", array('name' => $data['name'],
                                                'description' => $data['description']));
    }

    /**
     * Get all information about all categories.
     */
    function get_all_categories() {
        $query = $this->db->get('categories');
		$data = $query->result_array();
        return $data;
    }
}
?>
