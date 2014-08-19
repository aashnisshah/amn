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
                                                'status' => $data['status'],
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
     * Get a filtered set of links
     */
    function get_status_filtered_links($statusFilter) {
        $query = $this->db->get_where('links',array('status' => $statusFilter));
        $data = $query->result_array();
        return $data;
    }

    /**
     * Delete the link with the provided id
     */
    function delete_link($id) {
        $this->db->delete('links', array('id' => $id));
    }

    /**
     * Update the status of the link with $id to the $newStatus
     */
    function update_status($id, $newStatus) {
        $data = array('status' => $newStatus);
        $this->db->where('id', $id);
        $this->db->update('links', $data);
    }

    /**
     *
     */
    function update_link_information($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('links', $data);
    }

    /**
     * Get link information for the link with $id
     */
    function get_link_details($id){
        $query = $this->db->get_where('links', array('id' => $id));
        $data = $query->result_array();
        return $data;
    }

    /**
     * Get links based on the provided query
     */
    function get_query($query) {
        $queryString = $this->db->query($query);
        $result = $queryString->result_array();
        return $result;
    }

}
?>
