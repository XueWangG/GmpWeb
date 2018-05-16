<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get($condition)
	{
		$query = $this->db->get_where('user',$condition);
		return $query->row_array();
	}
	public function get_user_department($condition)
	{
		$query = $this->db->get_where('user_department',$condition);
		return $query->row_array();
	}
	
	public function get_login_info($username,$password)
	{
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where('del',0);
		$this->db->where("(mobile = '$username' OR username = '$username' OR email = '$username')");
		$query = $this->db->get();
		$user = $query->row_array();
		if(empty($user))
		{
			return array();
		}
		$encrypted = md5(md5($password).$user['salt']);
		if(!($encrypted == $user['password']))
		{
			return array();
		}else
		{
			return $user;
		}
		
		
	}
	
	public function get_user_token($key)
	{
		$query = $this->db->get_where('user_token',array('token'=>$key));
		return $query->row_array();
	}
	
	public function  insert($data)
	{
		$flag = $this->db->insert('user', $data);
		if($flag)
		{
			return $this->db->insert_id();
		}else{
			return $flag;
		}
		
	}
	
	public function  insert_user_department($data)
	{
		$flag = $this->db->insert('user_department', $data);
		if($flag)
		{
			return $this->db->insert_id();
		}else{
			return $flag;
		}
	
	}
	public function delete_user_department($condition)
	{
		return $this->db->delete('user_department', $condition);
	}
	
	public function  get_compiled_insert($data)
	{
		return  $this->db->set($data)->get_compiled_insert('user');
	
	}
	
	public function  insert_user_token($data)
	{
		$flag = $this->db->insert('user_token', $data);
		if($flag)
		{
			return $this->db->insert_id();
		}else{
			return $flag;
		}
	
	}
	
	/**
	 * 创建用户同时登录，API中
	 * @param unknown $input
	 */
	public function create_user($input)
	{
		//用户注册信息
		$mobile = $input['mobile'];
		$user_info = array();
		$user_info['username'] = $input['username'];
		$user_info['mobile'] = $mobile;
		$user_info['salt']=md5($mobile.strval(time()).strval(rand(0,999999)));
		$user_info['company_id']=1;//GMP测试平台公司
		$user_info['role_id']=2;//一般用户
		$user_info['password'] = md5(md5($input['password']).$user_info['salt']);//密码加密算法
		
		//生成新的token
		$user_token_info = array();
		$token = md5($mobile.strval(time()).strval(rand(0,999999)));
		$user_token_info['mobile'] = $mobile;
		$user_token_info['token'] = $token;
		$user_token_info['login_time'] = time();
		$user_token_info['client_type'] = $input['client'];
		
		$this->db->trans_start();
		$this->db->insert('user', $user_info);
		$user_id = $this->db->insert_id();
		$user_token_info['user_id'] = $user_id;
		$this->db->insert('user_token', $user_token_info);
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === FALSE)
		{
			log_message('debug', 'sql  '.$this->db->set($user_info)->get_compiled_insert('user'));
			log_message('debug', 'sql  '.$this->db->set($user_token_info)->get_compiled_insert('user_token'));
			return false;
		}else
		{
			$result = array();
			$result['user_id']=$user_id;
			$result['username']=$user_info['username'];
			$result['token']=$token;
			return $result;
		}
		
	}

	
	/**
	 * 取得一页用户数据
	 * @param unknown $cur_page 当前页码
	 * @param unknown $page_size 每页数据条数
	 * @param unknown $search_string 要查找的字符串
	 */
	public function get_user_page($company_id,$search_string,$department_id,$cur_page,$page_size = 10)
	{
		$result = array();
		
		$this->db->select("user.user_id,company.company_id,role_id,case role_id when 1 then '管理员' else '一般用户' end as role_name, username,name,user.mobile,company_name");
		$this->db->join('company', 'user.company_id = company.company_id');
		$this->db->join('user_department', 'user.user_id = user_department.user_id','left');
		$this->db->where('user.del',0);
		if($company_id!=PLATFORM_COMPANY)
		{
			$this->db->where('user.company_id',$company_id);
		}
		if(!empty($search_string))
		{
			$this->db->where("(username LIKE '%$search_string%' OR name LIKE '%$search_string%' OR user.mobile LIKE '%$search_string%')");
		
		}
		if($department_id!=0)
		{
			$this->db->where('user_department.department_id',$department_id);
		}
		$this->db->order_by('company_id');
		$this->db->order_by('user.update_at','DESC');
		
		$total = $this->db->count_all_results('user',FALSE);
		$result['total']=$total;
		
		$this->db->limit($page_size,($cur_page-1)*$page_size);
		$query = $this->db->get();
		$result['item_list'] =  $query->result_array();
	
	
		return $result;
	}
	
	
	public function get_push_user_page($company_id,$department_id,$cur_page,$page_size = 10)
	{
		$result = array();
	
		$this->db->select("user.user_id,company.company_id,username,name,user.mobile,company_name,jiguang_id");
		$this->db->join('company', 'user.company_id = company.company_id');
		$this->db->join('user_department', 'user.user_id = user_department.user_id','left');
		$this->db->where('user.del',0);
		$this->db->where('user.jiguang_id is not null');
		$this->db->where("user.jiguang_id !=''");
		if($company_id!=PLATFORM_COMPANY)
		{
			$this->db->where('user.company_id',$company_id);
		}
		if(!empty($search_string))
		{
			$this->db->where("(username LIKE '%$search_string%' OR name LIKE '%$search_string%' OR user.mobile LIKE '%$search_string%')");
	
		}
		if(!empty($department_id))
		{
			$this->db->where_in('user_department.department_id',$department_id);
		}
		$this->db->order_by('company_id');
		$this->db->order_by('user.update_at','DESC');
	
		$total = $this->db->count_all_results('user',FALSE);
		$result['total']=$total;
	
		$this->db->limit($page_size,($cur_page-1)*$page_size);
		$query = $this->db->get();
		$result['item_list'] =  $query->result_array();
	
	
		return $result;
	}
	
	
	public function delete($condition)
	{
		return $this->db->update('user', array('del'=>1), $condition);
	}
	
	public function update($data,$condition)
	{
		return  $this->db->update('user', $data, $condition);
	}
	
	
}
