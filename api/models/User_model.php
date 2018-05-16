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
		$query = $this->db->get_where('user_token',array('token'=>$key,'del'=>0));
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
	public function  delete_user_token($condition)
	{
		return  $this->db->update('user_token', array('del'=>1), $condition);
	}
	
	
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
		$user_info['type']=1;//手机注册
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
			$result['photo']='';
			$result['type']=$user_info['type'];
			$result['coin']=0;
			$result['token']=$token;
			return $result;
		}
		
	}
	/**
	 * 微信或者QQ登录注册
	 * @param unknown $input
	 */
	public function create_userx($input)
	{
		$username = $this->_gen_user_name($input['nickname']);
		//用户注册信息
		$user_info = array();
		$user_info['username'] = $username;
		$user_info['salt']=md5($input['openid'].strval(time()).strval(rand(0,999999)));
		$user_info['company_id']=1;//GMP测试平台公司
		$user_info['role_id']=2;//一般用户
		$user_info['password'] = md5(md5($input['openid']).$user_info['salt']);//密码加密算法
		$user_info['photo'] = $input['avatar'];
		$user_info['sex'] = $input['sex'];
		$user_info['type'] = $input['type']+1;//1是手机注册 2-微信 3-QQ
		$user_info['openid'] = $input['openid'];
	
		//生成新的token
		$user_token_info = array();
		$token = md5($input['openid'].strval(time()).strval(rand(0,999999)));
		$user_token_info['mobile'] = $input['openid'];
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
			$result['photo']=$user_info['photo'];
			$result['type']=$user_info['type'];
			$result['coin']=0;
			$result['token']=$token;
			return $result;
		}
	
	}
	
	public function update($data,$condition)
	{
		return  $this->db->update('user', $data, $condition);
	}
	
	public function get_test_list($user_id,$company_id,$cur_page,$page_size) {
		$this->db->select('test_result_id,test.test_id,test_name,cover_url,test_result.question_count,passed,test_result.create_at,is_submit');
		$this->db->from('test');
		$this->db->join('test_paper','test.test_paper_id=test_paper.test_paper_id');
		$this->db->join('test_result', 'test.test_id=test_result.test_id');
		$this->db->where('test_result.user_id',$user_id);
		$this->db->where('test.company_id',$company_id);
		//$this->db->where('test.del',0);被删除的测试用户也能看到结果
		$this->db->order_by('create_at', 'DESC');
		$this->db->limit($page_size,($cur_page-1)*$page_size);
		$query = $this->db->get();
		$result =  $query->result_array();
		
		foreach ($result as $key=>$value){
			$this->db->select_sum('is_submit');
			$this->db->select_sum('is_correct');
			$this->db->from('test_result_detail');
			$this->db->where('test_result_id',$value['test_result_id']);
			$query = $this->db->get();
			$rs = $query->row_array();
			$result[$key]['answered_count']=$rs['is_submit'];
			$result[$key]['correct_count']=$rs['is_correct'];
		}
		
		return $result;
	}
	
	public function get_test($user_id,$test_result_id)
	{
		$this->db->select('test_result_id,test.test_id,test_name,cover_url,test_result.question_count,test_result.create_at,is_submit');
		$this->db->from('test');
		$this->db->join('test_paper','test.test_paper_id=test_paper.test_paper_id');
		$this->db->join('test_result', 'test.test_id=test_result.test_id');
		$this->db->where('test_result.user_id',$user_id);
		$this->db->where('test_result.test_result_id',$test_result_id);
		$query = $this->db->get();
		$result =  $query->row_array();

		$this->db->select_sum('is_submit');
		$this->db->select_sum('is_correct');
		$this->db->from('test_result_detail');
		$this->db->where('test_result_id',$test_result_id);
		$query = $this->db->get();
		$rs = $query->row_array();
		$result['answered_count']=$rs['is_submit'];
		$result['correct_count']=$rs['is_correct'];

		
		return $result;
	}
	
	function add_coin($user_id,$coin)
	{
		$row = $this->db->get_where('user',array('user_id'=>$user_id))->row_array();
		$this->db->update('user',array('coin'=>$row['coin']+$coin),array('user_id'=>$user_id));
	}
	
	public function get_task_list($user_id,$cur_page,$page_size) {
		$this->db->select('test_task_id,send_company_id,test_result_id,test.test_id,test_name,cover_url,question_count,test_task.create_at');
		$this->db->from('test');
		$this->db->join('test_paper','test.test_paper_id=test_paper.test_paper_id');
		$this->db->join('test_task', 'test.test_id=test_task.test_id');
		$this->db->where('test_task.user_id',$user_id);
		$this->db->where('test_task.test_result_id',0);
		$this->db->order_by('test_task.send_company_id','DESC');
		$this->db->order_by('create_at', 'DESC');
		$this->db->limit($page_size,($cur_page-1)*$page_size);
		$query = $this->db->get();
		$result =  $query->result_array();
	
		foreach ($result as $key=>$value){
			if(empty($value['test_result_id'])){
				$result[$key]['test_result_id']='';
				$result[$key]['is_submit']=0;
				$result[$key]['answered_count']=0;
				$result[$key]['correct_count']=0;
			}else{
				$tr = $this->db->get_where('test_result',array('test_result_id'=>$value['test_result_id']))->row_array();
				$result[$key]['test_result_id']=$tr['test_result_id'];
				$result[$key]['is_submit']=$tr['is_submit'];
				
				$this->db->select_sum('is_submit');
				$this->db->select_sum('is_correct');
				$this->db->from('test_result_detail');
				$this->db->where('test_result_id',$tr['test_result_id']);
				$query = $this->db->get();
				$rs = $query->row_array();
				$result[$key]['answered_count']=$rs['is_submit'];
				$result[$key]['correct_count']=$rs['is_correct'];

			}
			
		}
	
		return $result;
	}
	
	private function _gen_user_name($nickname)
	{
		$nickname = empty($nickname)?'新用户':$nickname;
		$no = 11;
		$username = $nickname;
		while(true){
			$row = $this->get(array('username'=>$username));
			if(empty($row)){
				return $username;
			}
			$username = $nickname.$no;
			$no++;
		}	
	}
	
	
}
