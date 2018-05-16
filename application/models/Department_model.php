<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Department_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get($condition)
	{
		$query = $this->db->get_where('department',$condition);
		return $query->row_array();
	}

	public function get_department_list($company_id)
	{
		$result = array();
		
		$this->db->select('*');
		$this->db->where('del',0);
		$this->db->where('company_id',$company_id);
		$query = $this->db->get('department');
		$result['department_list'] =  $query->result_array();
		
		return $result;
	}
	
	
	public function  insert($data)
	{
		$flag = $this->db->insert('department', $data);
		if($flag)
		{
			return $this->db->insert_id();
		}else{
			return $flag;
		}
		
	}

	public function delete($condition)
	{
		return $this->db->update('department', array('del'=>1), $condition);
	}
	
	public function update($data,$condition)
	{
		return  $this->db->update('department', $data, $condition);
	}
	
	public function list_department($company_id)
	{
		$this->db->select('department_id,department_name');
		$this->db->from('department');
		$this->db->where('del',0);
		$this->db->where('company_id',$company_id);
		$query = $this->db->get();
		$result =  $query->result_array();
		return $result;
	}
	
	
}
