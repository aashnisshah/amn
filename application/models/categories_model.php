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

    /**
     * Delete the category with the provided id
     */
    function delete_category($id) {
        $this->db->delete('categories', array('id' => $id));
    }

    /**
     *
     */
    function update_category($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('categories', $data);
    }

    /**
     * Get category information for the link with $id
     */
    function get_category_details($id){
        $query = $this->db->get_where('categories', array('id' => $id));
        $data = $query->result_array();
        return $data;
    }
}
?>
