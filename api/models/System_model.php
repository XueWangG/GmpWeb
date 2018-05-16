<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get_latest_app()
	{
		$this->db->select('*');
		$this->db->order_by('app_version_id','DESC');
		$this->db->limit(1);
		$query = $this->db->get('app_version');
		return $query->row_array();
	}
	
	
}
