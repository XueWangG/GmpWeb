<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sms_log_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get($condition)
	{
		$query = $this->db->get_where('sms_log',$condition);
		return $query->row_array();
	}
	public  function update($data,$condtion)
	{
		return $this->db->update('sms_log', $data, $condtion);
	}
	
	public function  insert($data)
	{
		$this->db->insert('sms_log', $data);
		return $this->db->insert_id();
	}
	
}
