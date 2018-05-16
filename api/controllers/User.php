<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('sms_log_model');
		$this->load->model('topic_model');
		$this->load->model('test_model');
		
		$this->load->library('smsapi');
		$this->load->helper('url');
	}
	
	public function get_mobile_code()
	{
		//
		$this->load->library('form_validation');
		$this->form_validation->set_rules('mobile', 'Mobile', 'required|regex_match[/^\d{11}$/]',
				array('required'=>'必须输入手机号','regex_match'=>'请输入正确的手机号'));
		
		
		if ($this->form_validation->run() === FALSE)
		{
			$this->output_error(CODE_PARAM_ERROR,$this->form_validation-> error_array());
		
		}
		$type = isset($this->received_data['type'])?$this->received_data['type']:2;
	
		 
		$check_member_mobile	= $this->user_model->get(array('mobile'=>$this->received_data['mobile']));
		if($type==1){// $type=1新注册， 验证手机号码是否重复
			if(!empty($check_member_mobile)) {
				$this->output_error(CODE_USER_EXIST);
			}
		}else{//要确保手机号码已经存在
			if(empty($check_member_mobile)) {
				$this->output_error(CODE_USER_NOT_EXIST);
			}
		}

		//
		$this->_send_sms($this->received_data['mobile']);
		
	}
	public function register()
	{
		log_message('info', '开始用户注册 user register');
	    //输入参数校验
		$this->load->library('form_validation');
		$this->form_validation->set_rules('mobile', 'Mobile', 'required|regex_match[/^\d{11}$/]',
				array('required'=>'必须输入手机号','regex_match'=>'请输入正确的手机号'));
		$this->form_validation->set_rules('code', 'Code', 'required|regex_match[/^\d{6}$/]',
				array('required'=>'必须输入验证码','regex_match'=>'请输入正确的验证码'));
		$this->form_validation->set_rules('username', 'Username', 'required',
				array('required'=>'必须输入用户名'));
		$this->form_validation->set_rules('password', 'Password', 'required',
				array('required'=>'必须输入密码'));
		
		if ($this->form_validation->run() === FALSE)
		{
			$this->output_error(CODE_PARAM_ERROR,$this->form_validation-> error_array());
		
		}
		//用户是否存在
		$user =  $this->user_model->get(array('mobile'=>$this->received_data['mobile']));
		if(!empty($user))
		{
			$this->output_error(CODE_USER_EXIST);
		}
		$user =  $this->user_model->get(array('username'=>$this->received_data['username']));
		if(!empty($user))
		{
			//不提示了，直接修改下
			$this->received_data['username']=$this->received_data['username'].$this->received_data['mobile'];
		}
		//验证码校验
		$mobile = $this->received_data['mobile'];
		$log  = $this->sms_log_model->get(array('mobile'=>$mobile,'is_checked'=>0));
		if(empty($log))
		{
			$this->output_error(CODE_MOBILE_CODE_ERROR);
		}else if($log['send_time']+600<time())
		{
			$this->output_error(CODE_MOBILE_CODE_EXPIRED);
		}else
		{
			$result = $this->sms_log_model->update(array('is_checked'=>1),array('mobile'=>$mobile,'is_checked'=>0));
			
			$result = $this->user_model->create_user($this->received_data);
			
			if($result == FALSE)
			{
				$this->output_error(CODE_UNKNOWN_ERROR);
			}else {
				log_message('info', '注册用户成功');
				
				$this->user_model->add_coin($result['user_id'],10);
				
				//返回个人中心首页一样的信息
				$ui = array();
				$ui['user_id'] = $result['user_id'];
				$ui['username'] = $result['username'];
				$ui['avatar'] = '';
				$ui['test_count'] = 0;
				$ui['question_count'] = 0;
				$ui['topic_count'] = 0;
				$ui['topic_answer_count'] = 0;
				
				$this->output_ok(array('key' => $result['token'], 'user_info' => $ui));
			}
			
		}
	
	}
	public function login()
	{
		log_message('info', '用户登录  user login');
		//输入参数校验
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'required',
				array('required'=>'必须输入用户名'));
		$this->form_validation->set_rules('password', 'Password', 'required',
				array('required'=>'必须输入密码'));
		
		if ($this->form_validation->run() === FALSE)
		{
			$this->output_error(CODE_PARAM_ERROR,$this->form_validation-> error_array());
		
		}
		//用户是否存在
		$user =  $this->user_model->get_login_info($this->received_data['username'],$this->received_data['password']);
		if(empty($user))
		{
			$this->output_error(CODE_UNKNOWN_USER);
		}else
		{
			log_message('info', '用户登录成功');
			$token = $this->_get_token($user['user_id'], empty($user['mobile'])?$user['username']:$user['mobile'], $this->received_data['client']);
			if($token == FALSE)
			{
				log_message('error', '获取token失败');
				$this->output_error(CODE_UNKNOWN_ERROR);
			}
			//
			log_message('info', 'jiguang_id'.$this->received_data['jiguang_id']);
			if(!empty($this->received_data['jiguang_id'])){
				$data = array();
				$data['jiguang_id'] = $this->received_data['jiguang_id'];
				$this->user_model->update($data,array('user_id'=>$user['user_id']));
			}
			//
			$this->user_model->add_coin($user['user_id'],1);
			$ui = $this->_get_user_info($user);
			
			$this->output_ok(array('key' => $token, 'user_info' => $ui));
		}
	}
	
	private function _send_sms($mobile){
		//是否已经获取验证码
		$log  = $this->sms_log_model->get(array('mobile'=>$mobile,'is_checked'=>0));

		if(!empty($log) && $log['send_time']+60>time()){
			$this->output_error(CODE_MOBILE_CODE_REPEAT);
		}
		//作废过期的验证码
		$result = $this->sms_log_model->update(array('is_checked'=>1),array('mobile'=>$mobile,'is_checked'=>0));
	
		//生成验证码
		$sms_code = rand(100000,999999);
		//发送验证码
		$valid_time = 10;//分钟
		$templateId = 50442;//yuntongxun.com短信模板ID
		$result = $this->smsapi->send_template_sms($mobile, array($sms_code,$valid_time), $templateId);
		if(!$result){
			$this->output_error(CODE_SMS_ERROR);
		}else{
			//保存到数据库以便校验
			$data = array();
			$data['mobile'] = $mobile;
			$data['send_time'] = time();
			$data['type']=1;//注册校验
			$data['mobile_code']=$sms_code;
			$data['content']='yuntongxun template '.$templateId;
			$data['valid_time']=$valid_time*60;
			$data['is_checked']=0;
			$this->sms_log_model->insert($data);
			$this->output_ok(array('mobile' => $mobile));
		}
	}
	/**
	 * 个人中心首页
	 */
	public function get_home()
	{
		
		//登录校验并取得用户信息
		$user_info = $this->get_user_info();
		
		$ui = $this->_get_user_info($user_info);
			
		
		$this->output_ok($ui);
	}
	
	public function get_test()
	{
		//登录校验并取得用户信息
		$user_info = $this->get_user_info();
		
		//输入参数校验
		$this->load->library('form_validation');
		$this->form_validation->set_rules('cur_page', 'CurPage', 'regex_match[/^\d+$/]',
				array('regex_match'=>'必须是数字'));
		$this->form_validation->set_rules('page_size', 'Answer', 'regex_match[/^\d+$/]',
				array('regex_match'=>'必须是数字'));
		
		if ($this->form_validation->run() === FALSE)
		{
			$this->output_error(CODE_PARAM_ERROR,$this->form_validation-> error_array());
		
		}
		
		$cur_page = empty($this->received_data['cur_page'])?1:$this->received_data['cur_page'];
		$page_size = empty($this->received_data['page_size'])?6:$this->received_data['page_size'];
		
		$data = $this->user_model->get_test_list($user_info['user_id'],1, $cur_page, $page_size);
		
		//不知道为什么这里又不能用case when了
		foreach ($data as $key=>$value){
			$data[$key]['correct_rate']=round($data[$key]['question_count']==0?0:$data[$key]['correct_count']*100.0/$data[$key]['question_count']).'%';
			
			$data[$key]['progress']=round($data[$key]['question_count']==0?0:$data[$key]['answered_count']*100.0/$data[$key]['question_count']);
			unset($data[$key]['answered_count']);
		}
		
		$this->output_ok(array('test_list'=>$data,'more'=>(count($data)==$page_size)));
		
	}
	
	public function get_task()
	{
		//登录校验并取得用户信息
		$user_info = $this->get_user_info();
	
		//输入参数校验
		$this->load->library('form_validation');
		$this->form_validation->set_rules('cur_page', 'CurPage', 'regex_match[/^\d+$/]',
				array('regex_match'=>'必须是数字'));
		$this->form_validation->set_rules('page_size', 'Answer', 'regex_match[/^\d+$/]',
				array('regex_match'=>'必须是数字'));
	
		if ($this->form_validation->run() === FALSE)
		{
			$this->output_error(CODE_PARAM_ERROR,$this->form_validation-> error_array());
	
		}
	
		$cur_page = empty($this->received_data['cur_page'])?1:$this->received_data['cur_page'];
		$page_size = empty($this->received_data['page_size'])?6:$this->received_data['page_size'];
	
		$data = $this->user_model->get_test_list($user_info['user_id'],$user_info['company_id'], $cur_page, $page_size);
	
		//不知道为什么这里又不能用case when了
		foreach ($data as $key=>$value){
			$data[$key]['correct_rate']=round($data[$key]['question_count']==0?0:$data[$key]['correct_count']*100.0/$data[$key]['question_count']).'%';
				
			$data[$key]['progress']=round($data[$key]['question_count']==0?0:$data[$key]['answered_count']*100.0/$data[$key]['question_count']);
			unset($data[$key]['answered_count']);
		}
	
		$this->output_ok(array('test_list'=>$data,'more'=>(count($data)==$page_size)));
	
	
	
	}
	
	public function get_answer_following()
	{
		//登录校验并取得用户信息
		$user_info = $this->get_user_info();
		
		//输入参数校验
		$this->load->library('form_validation');
		$this->form_validation->set_rules('cur_page', 'CurPage', 'regex_match[/^\d+$/]',
				array('regex_match'=>'必须是数字'));
		$this->form_validation->set_rules('page_size', 'PageSize', 'regex_match[/^\d+$/]',
				array('regex_match'=>'必须是数字'));
		
		if ($this->form_validation->run() === FALSE)
		{
			$this->output_error(CODE_PARAM_ERROR,$this->form_validation-> error_array());
		
		}
		
		$cur_page = empty($this->received_data['cur_page'])?1:$this->received_data['cur_page'];
		$page_size = empty($this->received_data['page_size'])?6:$this->received_data['page_size'];
		$data = $this->topic_model->get_user_answer_following($user_info['user_id'],$cur_page,$page_size);
		
		$this->output_ok(array('answer_list'=>$data,'more'=>(count($data)==$page_size)));
	}
	public function get_topic_following()
	{
		//登录校验并取得用户信息
		$user_info = $this->get_user_info();
		
		//输入参数校验
		$this->load->library('form_validation');
		$this->form_validation->set_rules('cur_page', 'CurPage', 'regex_match[/^\d+$/]',
				array('regex_match'=>'必须是数字'));
		$this->form_validation->set_rules('page_size', 'PageSize', 'regex_match[/^\d+$/]',
				array('regex_match'=>'必须是数字'));
		
		if ($this->form_validation->run() === FALSE)
		{
			$this->output_error(CODE_PARAM_ERROR,$this->form_validation-> error_array());
		
		}
		
		$cur_page = empty($this->received_data['cur_page'])?1:$this->received_data['cur_page'];
		$page_size = empty($this->received_data['page_size'])?6:$this->received_data['page_size'];
		$data = $this->topic_model->get_user_following($user_info['user_id'],$cur_page,$page_size);
		
		$this->output_ok(array('topic_list'=>$data,'more'=>(count($data)==$page_size)));
	}
	
	public function list_answer()
	{
		//登录校验并取得用户信息
		$user_info = $this->get_user_info();
	
		
		//输入参数校验
		$this->load->library('form_validation');
		$this->form_validation->set_rules('cur_page', 'CurPage', 'regex_match[/^\d+$/]',
				array('regex_match'=>'必须是数字'));
		$this->form_validation->set_rules('page_size', 'PageSize', 'regex_match[/^\d+$/]',
				array('regex_match'=>'必须是数字'));
		
		if ($this->form_validation->run() === FALSE)
		{
			$this->output_error(CODE_PARAM_ERROR,$this->form_validation-> error_array());
		
		}
		
		$cur_page = empty($this->received_data['cur_page'])?1:$this->received_data['cur_page'];
		$page_size = empty($this->received_data['page_size'])?6:$this->received_data['page_size'];
		$data = $this->topic_model->get_user_answer_list($user_info['user_id'],$cur_page,$page_size);
		
		$this->output_ok(array('answer_list'=>$data,'more'=>(count($data)==$page_size)));
	}
	
	
	public function list_topic()
	{
		//登录校验并取得用户信息
		$user_info = $this->get_user_info();
		
		//输入参数校验
		$this->load->library('form_validation');
		$this->form_validation->set_rules('cur_page', 'CurPage', 'regex_match[/^\d+$/]',
				array('regex_match'=>'必须是数字'));
		$this->form_validation->set_rules('page_size', 'PageSize', 'regex_match[/^\d+$/]',
				array('regex_match'=>'必须是数字'));
		
		if ($this->form_validation->run() === FALSE)
		{
			$this->output_error(CODE_PARAM_ERROR,$this->form_validation-> error_array());
		
		}
		
		$cur_page = empty($this->received_data['cur_page'])?1:$this->received_data['cur_page'];
		$page_size = empty($this->received_data['page_size'])?6:$this->received_data['page_size'];
		$data = $this->topic_model->get_user_topic_list($user_info['user_id'],$cur_page,$page_size);
		
		$this->output_ok(array('topic_list'=>$data,'more'=>(count($data)==$page_size)));
	}
	public function change_password()
	{
		//登录校验并取得用户信息
		$user_info = $this->get_user_info();
		
		//输入参数校验
		$this->load->library('form_validation');
		$this->form_validation->set_rules('old_password', 'OldPassword', 'required',
				array('required'=>'必须输入旧密码'));
		$this->form_validation->set_rules('password', 'Password', 'required',
				array('required'=>'必须输入新密码'));
		
		if ($this->form_validation->run() === FALSE)
		{
			$this->output_error(CODE_PARAM_ERROR,$this->form_validation-> error_array());
		
		}
		$old_password = $this->received_data['old_password'];
		$encrypted_old = md5(md5($old_password).$user_info['salt']);
		if(!($encrypted_old == $user_info['password']))
		{
			$this->output_error(CODE_UNKNOWN_OLD_PASSWORD);
		}
		
		$data = array();
		$data['password'] = md5(md5($this->received_data['password']).$user_info['salt']);//密码加密算法
		$result = $this->user_model->update($data,array('user_id'=>$user_info['user_id']));
		if($result){
			$this->output_ok(NULL);
		}else{
			$this->output_error(CODE_UNKNOWN_ERROR);
		}
		
		
	}
	public function reset_password()
	{
		//输入参数校验
		$this->load->library('form_validation');
		$this->form_validation->set_rules('mobile', 'Mobile', 'required|regex_match[/^\d{11}$/]',
				array('required'=>'必须输入手机号','regex_match'=>'请输入正确的手机号'));
		$this->form_validation->set_rules('code', 'Code', 'required|regex_match[/^\d{6}$/]',
				array('required'=>'必须输入验证码','regex_match'=>'请输入正确的验证码'));
		$this->form_validation->set_rules('password', 'Password', 'required',
				array('required'=>'必须输入密码'));
		
		if ($this->form_validation->run() === FALSE)
		{
			$this->output_error(CODE_PARAM_ERROR,$this->form_validation-> error_array());
		
		}
		//用户是否存在
		$user_info =  $this->user_model->get(array('mobile'=>$this->received_data['mobile']));
		if(empty($user_info))
		{
			$this->output_error(CODE_USER_NOT_EXIST);
		}
		//验证码校验
		$mobile = $this->received_data['mobile'];
		$log  = $this->sms_log_model->get(array('mobile'=>$mobile,'is_checked'=>0));
		if(empty($log))
		{
			$this->output_error(CODE_MOBILE_CODE_ERROR);
		}else if($log['send_time']+600<time())
		{
			$this->output_error(CODE_MOBILE_CODE_EXPIRED);
		}else
		{
			$result = $this->sms_log_model->update(array('is_checked'=>1),array('mobile'=>$mobile,'is_checked'=>0));
			
			$data = array();
			$data['password'] = md5(md5($this->received_data['password']).$user_info['salt']);//密码加密算法
			$result = $this->user_model->update($data,array('user_id'=>$user_info['user_id']));
			if($result){
				$this->output_ok(NULL);
			}else{
				$this->output_error(CODE_UNKNOWN_ERROR);
			}
				
		}
	}
	public function delete_for_test()
	{
		//输入参数校验
		$this->load->library('form_validation');
		$this->form_validation->set_rules('mobile', 'Mobile', 'required|regex_match[/^\d{11}$/]',
				array('required'=>'必须输入手机号','regex_match'=>'请输入正确的手机号'));
		
		if ($this->form_validation->run() === FALSE)
		{
			$this->output_error(CODE_PARAM_ERROR,$this->form_validation-> error_array());
		
		}
		//用户是否存在
		$user_info =  $this->user_model->get(array('mobile'=>$this->received_data['mobile']));
		if(empty($user_info))
		{
			$this->output_error(CODE_USER_NOT_EXIST);
		}
		$data = array();
		$data['mobile'] = $user_info['mobile'].'_'.$user_info['user_id'];
		$data['del']=1;
		$result = $this->user_model->update($data,array('user_id'=>$user_info['user_id']));
		if($result){
			$this->output_ok(NULL);
		}else{
			$this->output_error(CODE_UNKNOWN_ERROR);
		}
	}
	
	public function update()
	{
		//登录校验并取得用户信息
		$user_info = $this->get_user_info();
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'required',
				array('required'=>'必须输入昵称'));
		if ($this->form_validation->run() === FALSE)
		{
			$this->output_error(CODE_PARAM_ERROR,$this->form_validation-> error_array());
		
		}

		$data = array();
		$data['username'] = $this->received_data['username'];
		//
		$config['upload_path'] = './upload_file/photo/';//此路径相对跟目录下的文件
		$config['allowed_types'] = 'jpg|png|jpeg';
		$config['file_name'] = $user_info['user_id'].'_'.date('YmdHis', time());
		$config['max_size'] = '10240';
		
		$this->load->library('upload', $config);//加载自带的上传类库
		
		if (!$this->upload->do_upload('image_file'))
		{
			$file_name = 'upload_file/photo/'.$config['file_name'].$this->upload->file_ext;
			log_message('info', '用户'.$user_info['user_id'].'上传头像'.$file_name.'失败');
			//$this->output_error(CODE_UNKNOWN_ERROR,$this->upload->display_errors());
		}
		else
		{
			$file_name = 'upload_file/photo/'.$config['file_name'].$this->upload->file_ext;
			log_message('info', '用户'.$user_info['user_id'].'上传头像'.$file_name.'成功');
			$data['photo'] = $file_name;	
		}
		
		$this->user_model->update($data,array('user_id'=>$user_info['user_id']));
		$this->output_ok(NULL);
		
	}
	
	public function loginx()
	{
		log_message('info', 'loginx开始用户注册 user register');
		//输入参数校验
		$this->load->library('form_validation');
		$this->form_validation->set_rules('type', 'Type', 'required|regex_match[/^\d{1}$/]',
				array('required'=>'必须输入类型','regex_match'=>'请输入正确的类型'));
		$this->form_validation->set_rules('openid', 'Openid', 'required',
				array('required'=>'必须输入openid'));
	
		if ($this->form_validation->run() === FALSE)
		{
			$this->output_error(CODE_PARAM_ERROR,$this->form_validation-> error_array());
	
		}
		//用户是否存在
		$user =  $this->user_model->get(array('openid'=>$this->received_data['openid']));
		if(!empty($user))//已存在，登录
		{
			$token = $this->_get_token($user['user_id'], $user['openid'], $this->received_data['client']);
			if($token == FALSE)
			{
				log_message('error', '获取token失败');
				$this->output_error(CODE_UNKNOWN_ERROR);
			}
			$user['token']=$token;
			
		}else{
			$user = $this->user_model->create_userx($this->received_data);
			
			if($user == FALSE)
			{
				$this->output_error(CODE_UNKNOWN_ERROR);
			}else {
				log_message('info', '注册用户成功');
		
			}
		}
		log_message('info', 'loginx用户登录成功');
		//
		log_message('info', 'jiguang_id'.$this->received_data['jiguang_id']);
		$data = array();
		$data['photo'] = $this->received_data['avatar'];
		if(!empty($this->received_data['jiguang_id'])){
			$data['jiguang_id'] = $this->received_data['jiguang_id'];
		}
		$this->user_model->update($data,array('user_id'=>$user['user_id']));
		
		$this->user_model->add_coin($user['user_id'],1);
		
		$ui = $this->_get_user_info($user);
		$this->output_ok(array('key' => $user['token'], 'user_info' => $ui));
	
	}
	
	public function logout()
	{
		//登录校验并取得用户信息
		$user_info = $this->get_user_info();
		//$data = array();
		//$data['jiguang_id'] = '';

		//$this->user_model->update($data,array('user_id'=>$user_info['user_id']));
		$this->user_model->delete_user_token(array('user_id'=>$user_info['user_id'],'token'=>$this->received_data['key']));
		
		$this->output_ok(NULL);
	}
	
	public function get_test_item()
	{
		//登录校验并取得用户信息
		$user_info = $this->get_user_info();
		
		//输入参数校验
		$this->load->library('form_validation');
		$this->form_validation->set_rules('test_result_id', 'TestResultId', 'required|regex_match[/^\d+$/]',
				array('required'=>'必须输入测试结果ID','regex_match'=>'必须是数字'));
		
		if ($this->form_validation->run() === FALSE)
		{
			$this->output_error(CODE_PARAM_ERROR,$this->form_validation-> error_array());
		
		}
		
		$data = $this->user_model->get_test($user_info['user_id'],$this->received_data['test_result_id']);
		
		if(!empty($data)){
			$data['correct_rate']=round($data['question_count']==0?0:$data['correct_count']*100.0/$data['question_count']).'%';
			$data['progress']=round($data['question_count']==0?0:$data['answered_count']*100.0/$data['question_count']);
			unset($data['answered_count']);
		}
		
		$this->output_ok($data);
	}
	
	private function _get_user_info($user)
	{
		$topic_count = $this->topic_model->get_user_topic_count($user['user_id']);
		$test_count = $this->test_model->get_user_test_count($user['user_id']);

		$ui = array();
		$ui['user_id'] = $user['user_id'];
		$ui['company_id']=$user['company_id'];
		$ui['username'] = $user['username'];
		$ui['avatar'] = $user['type']==1?base_url().$user['photo']:$user['photo'];
		$ui['test_count'] = $test_count['test_count'];
		$ui['question_count'] = $test_count['question_count'];
		$ui['topic_count'] = $topic_count['topic_count'];
		$ui['topic_answer_count'] = $topic_count['topic_answer_count'];
		$ui['g_coin']=$user['coin'];
		
		return $ui;
	}
	
	
	/**
	 * 登陆生成token
	 */
	private function _get_token($user_id, $mobile, $client) {
		
		//生成新的token
		$user_token_info = array();
		$token = md5($mobile.strval(time()).strval(rand(0,999999)));
		$user_token_info['user_id'] = $user_id;
		$user_token_info['mobile'] = $mobile;
		$user_token_info['token'] = $token;
		$user_token_info['login_time'] = time();
		$user_token_info['client_type'] = $client;
	
		 $flag =   $this->user_model->insert_user_token($user_token_info);
		 if($flag==FALSE)
		 {
		 	return FALSE;
		 }else
		 {
		 	return $token;
		 }
		
	}
}
