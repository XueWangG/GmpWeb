<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get($condition)
	{
		$query = $this->db->get_where('test',$condition);
		return $query->row_array();
	}
	public function get_test_list($condition)
	{
		$query = $this->db->get_where('test',$condition);
		return $query->result_array();
	}
	/**
	 * 取得一页数据
	 * @param unknown $cur_page 当前页码
	 * @param unknown $page_size 每页数据条数
	 * @param unknown $search_string 要查找的字符串
	 */
	public function get_test_page($company_id,$search_string,$cur_page,$page_size = 10)
	{
		$result = array();
		
		$this->db->select('test.*,test_paper_name');
		$this->db->join('test_paper','test.test_paper_id=test_paper.test_paper_id');
		$this->db->where('test.del',0);
		$this->db->where('test.company_id',$company_id);
		if(!empty($search_string))
		{
			$this->db->where("(test_name LIKE '%$search_string%')");
			
		}
		$this->db->order_by('test_id', 'DESC');
		
		$total = $this->db->count_all_results('test',FALSE);
		$result['total']=$total;
		
		$this->db->limit($page_size,($cur_page-1)*$page_size);
		$query = $this->db->get();
		$result['item_list'] =  $query->result_array();
		
		
		return $result;
	}
	
	
	public function  insert($data)
	{
		$flag = $this->db->insert('test', $data);
		if($flag)
		{
			return $this->db->insert_id();
		}else{
			return $flag;
		}
		
	}


	public function delete($condition)
	{
		return $this->db->update('test', array('del'=>1), $condition);
	}
	
	public function update($data,$condition)
	{
		return  $this->db->update('test', $data, $condition);
	}
	
	public function  get_tasks($cur_page=1,$page_size=10)
	{
		$this->db->select('test_task.*,test_name');
		$this->db->join('test','test_task.test_id=test.test_id');
		$this->db->where('is_sent',0);
		$this->db->order_by('test_task.test_id');
		$this->db->limit($page_size,($cur_page-1)*$page_size);
		$query = $this->db->get('test_task');
		return $query->result_array();
	}
	
	public function update_test_task($data,$condition)
	{
		return  $this->db->update('test_task', $data, $condition);
	}
	public function get_test_task($condition)
	{
		$query = $this->db->get_where('test_task',$condition);
		return $query->row_array();
	}
	public function  insert_test_task($data)
	{
		$flag = $this->db->insert('test_task', $data);
		if($flag)
		{
			return $this->db->insert_id();
		}else{
			return $flag;
		}
	
	}
	
	
}
