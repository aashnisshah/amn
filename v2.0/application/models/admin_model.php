<?php
class Admin_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	function get_name($id) {

		$this->db->select('name');
		$this->db->from('admin_info');
		$this->db->where('id', $id);

		$query = $this->db->get();
		if($query->num_rows() > 0) {
			$results = $query->result_array();
			return $results['0']['name'];
		} else {
			return "Unknown";
		}
	}

	function get_password($id) {

		$this->db->select('password');
		$this->db->from('admin_login');
		$this->db->where('id', $id);

		$query = $this->db->get();
		if($query->num_rows() > 0) {
			$results = $query->result_array();
			return $results['0']['password'];
		} else {
			return FALSE;
		}
	}

	function get_all_admin_info($id) {

		$this->db->from('admin_info');
		$this->db->where('id', $id);

		$query = $this->db->get();
		if($query->num_rows() > 0) {
			$results = $query->result_array();
			return $results['0'];
		} else {
			return "Unknown";
		}
	}

	/**
	 * Update admin information in the database
	 */
	function update_admin_info($data) {
		$this->db->where('id', $this->session->userdata['id']);
		return $this->db->update('admin_info', array('name' => $data['name'],
				                                  	 'email' => $data['email'],
												 	 'website' => $data['website']));
	}

	/**
	 * Update login information for the admin
	 */
	function update_login_info($data) {
		$this->db->where('id', $this->session->userdata['id']);
		return $this->db->update('admin_login', array('username' => $data['username'],
													'password' => $data['password']));
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
