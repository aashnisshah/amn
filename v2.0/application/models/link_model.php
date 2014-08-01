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
								 			    'image' => $data['image']));
    }
}
?>
