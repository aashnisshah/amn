<?php
class Admin_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	/* creating a query to connect to the database */
	function login($username, $password) {
		$this->db->from('admin_login');
		$this->db->where('username', $username);
		$this->db->where('password', MD5($password));
		$this->db->limit(1);

		// process the query response
		$query = $this->db->get();
		if($query->num_rows()==1){
			return $query->result();
		} else {
			return false;
		}
	}
}
?>
