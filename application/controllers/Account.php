<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
	}
	
	public function index()
	{
		$this->load->view('login');
	}
	
	public function login()
	{
		//
		$this->form_validation->set_rules('username', '用户名', 'trim|required');
		$this->form_validation->set_rules('password', '密码', 'trim|required');
		
		$this->form_validation->set_message('required', '{field}不能为空！');
		
		if($this->form_validation->run() == FALSE){
		
			$this->load->view('login');
					
		}else
		{
			//不知道为什么自定义校验函数不能串连
			$this->form_validation->reset_validation();
			$this->form_validation->set_rules('password', '密码', 'callback_user_exist');
			if($this->form_validation->run() == FALSE){
				$this->load->view('login');
			}else
			{
				redirect(base_url()."index.php/test");
			}
			
		}
	}
	
	/**
	 * 检查用户输入的用户名和密码是否匹配
	 */
	public function user_exist()
	{
		$this->load->model('user_model');
		$username=$this->input->post('username');
		$password=$this->input->post('password');

		$userinfo = $this->user_model->get_login_info($username,$password);
		
		if(!empty($userinfo))
		{
			if($userinfo['role_id']!=1)
			{
				$this->form_validation->set_message('user_exist', '普通用户请使用APP!');
				return FALSE;
			}
			$this->session->set_userdata(SESSION_NAME_USER_ID,$userinfo['user_id']);
			$this->session->set_userdata(SESSION_NAME_USERNAME,$userinfo['username']);
			$this->session->set_userdata(SESSION_NAME_COMPANY_ID,$userinfo['company_id']);
			$this->session->set_userdata(SESSION_NAME_ROLE_ID,$userinfo['role_id']);

			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('user_exist', '用户名或密码输入错误!');
			return FALSE;
		}
	}
	
	public  function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url()."index.php/account");
	}
	
	
}
