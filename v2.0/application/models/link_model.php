<?php
class Link_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Add new link into the database
     */
    function add_new_link($data) {
        return $this->db->insert("links", array('url' => $data['url'],
				                                'name' => $data['name'],
								 			    'groups' => $data['groups'],
								 			    'image' => $data['image'],
                                                'description' => $data['description']));
    }

    /**
     * Get all links from the database.
     */
    function get_all_links() {
        $query = $this->db->get('links');
        $data = $query->result_array();
        return $data;
    }

    /**
     * Get all accepted links from the database.
     */
    function get_accepted_links() {
        $query = $this->db->get_where('links',array('status' => 'accepted'));
        $data = $query->result_array();
        return $data;
    }

    /**
     * Get all rejected links from the database.
     */
    function get_rejected_links() {
        $query = $this->db->get_where('links',array('status' => 'rejected'));
        $data = $query->result_array();
        return $data;
    }

    /**
     * Get all pending links from the database.
     */
    function get_pending_links() {
        $query = $this->db->get_where('links',array('status' => 'pending'));
        $data = $query->result_array();
        return $data;
    }

    function delete_link($id) {
        $this->db->delete('links', array('id' => $id));
    }

}
?>
