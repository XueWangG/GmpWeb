<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get($condition)
	{
		$query = $this->db->get_where('company',$condition);
		return $query->row_array();
	}
	/**
	 * 取得一页公司数据
	 * @param unknown $cur_page 当前页码
	 * @param unknown $page_size 每页数据条数
	 * @param unknown $search_string 要查找的字符串
	 */
	public function get_company_page($search_string,$cur_page,$page_size = 10)
	{
		$result = array();
		
		$this->db->select('*');
		$this->db->where('del',0);
		if(!empty($search_string))
		{
			$this->db->where("(company_name LIKE '%$search_string%' OR address LIKE '%$search_string%' OR mobile LIKE '%$search_string%')");
			
		}
		$this->db->order_by('company_id', 'DESC');
		
		$total = $this->db->count_all_results('company',FALSE);
		$result['total']=$total;
		
		$this->db->limit($page_size,($cur_page-1)*$page_size);
		$query = $this->db->get();
		$result['company_list'] =  $query->result_array();
		
		
		return $result;
	}
	
	
	public function  insert($data)
	{
		$flag = $this->db->insert('company', $data);
		if($flag)
		{
			return $this->db->insert_id();
		}else{
			return $flag;
		}
		
	}
	
	

	
	public function create_company($input)
	{
		//企业注册信息
		$mobile = $input['mobile'];
		$company_info = array();
		$company_info['company_name']=$input['company_name'];
		$company_info['contact_name']=$input['contact_name'];
		$company_info['mobile']=$input['mobile'];
		$company_info['city']=$input['city'];
		$company_info['address']=$input['address'];
		
		$user_info = array();
		$user_info['username'] = $input['username'];
		$user_info['mobile'] = $mobile;
		$user_info['salt']=md5($mobile.strval(time()).strval(rand(0,999999)));
		$user_info['role_id']=1;//企业管理员
		$user_info['password'] = md5(md5($input['password']).$user_info['salt']);//密码加密算法
		$user_info['name']=$input['contact_name'];
		
		
		$this->db->trans_start();
		$this->db->insert('company', $company_info);
		$company_id = $this->db->insert_id();
		$user_info['company_id']=$company_id;
		$this->db->insert('user', $user_info);
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === FALSE)
		{
			log_message('debug', 'sql  '.$this->db->set($company_info)->get_compiled_insert('company'));
			log_message('debug', 'sql  '.$this->db->set($user_info)->get_compiled_insert('user'));
			return FALSE;
		}else
		{
			return TRUE;
		}
		
	}
	public function delete($id)
	{
		return $this->db->update('company', array('del'=>1), array('company_id' => $id));
	}
	
	public function update($data,$id)
	{
		return  $this->db->update('company', $data, array('company_id' => $id));
	}
	
	public function list_company($count=100)
	{
		$this->db->select('company_id,company_name');
		$this->db->from('company');
		$this->db->where('del',0);
		$this->db->limit($count,0);
		$query = $this->db->get();
		$result =  $query->result_array();
		return $result;
	}
	
	
}
