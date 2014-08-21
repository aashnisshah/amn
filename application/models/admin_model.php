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
		$propass = MD5(SHA1($password));
		$this->db->from('admin_login');
		$this->db->where('username', $username);
		$this->db->where('password', $propass);
		$this->db->limit(1);

		// process the query response
		$query = $this->db->get();
		if($query->num_rows()==1){
			return $query->result();
		} else {
			return false;
		}
	}

	function create_admin($data) {
		$password = MD5(SHA1($data['password']));
		$this->db->insert("admin_login", array('username' => $data['username'],
														'password' => $password));
		$this->db->insert("admin_info", array('id' => $this->db->insert_id(),
												'name' => $data['name'],
												'email' => $data['email'],
												'website' => $data['website']));
	}

	function admin_exists() {
		$this->db->from('admin_login');

		$query = $this->db->get();
		if($query->num_rows()>=1){
			return true;
		} else {
			return false;
		}
	}

	function table_exists() {
		include "settings.php";
		$exist = $this->db->table_exists('admin_info');
		return $exist;
	}
}
?>
