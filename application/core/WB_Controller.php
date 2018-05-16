<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WB_Controller extends CI_Controller {

	protected $menu;
	protected $user_id;
	protected $company_id;
	protected $role_id;
	
	protected $pagination_config=array(
			'base_url' =>'',
			'total_rows' => 0,
			'num_links' => 10,
			'per_page' => 10,
			'full_tag_open' => '<div class="pagination pagination-centered"><ul>',
			'full_tag_close' => '</ul></div>',
			'next_tag_open' => '<li>',
			'next_tag_close' => '</li>',
			'prev_tag_open' => '<li>',
			'prev_tag_close' => '</li>',
			'last_tag_open' => '<li>',
			'last_tag_close' => '</li>',
			'first_tag_open' => '<li>',
			'first_tag_close' => '</li>',
			'num_tag_open' => '<li>',
			'num_tag_close' => '</li>',
			'cur_tag_open' => '<li class="active"><a href="#">',
			'cur_tag_close' => '</a></li>',
			'prev_link'=>'上一页',
			'next_link'=>'下一页',
			'last_link'=>'末页',
			'first_link'=>'首页',
			'use_page_numbers' => TRUE,
			'display_pages' => TRUE
	);
	
	protected $received_data = array();
	
	function __construct()
	{
		parent::__construct();
		
		$this->user_id = $this->session->userdata(SESSION_NAME_USER_ID);
		$this->role_id = $this->session->userdata(SESSION_NAME_ROLE_ID);
		$this->company_id = $this->session->userdata(SESSION_NAME_COMPANY_ID);
		
		if (empty($this->user_id)||$this->role_id!=1)
		{
			redirect(base_url()."index.php/account");
		}
		$class_name = $this->uri->segment(1);
	
		$this->menu['cur_menu'] = array($class_name => "active");
		$this->menu['name'] = $this->session->userdata(SESSION_NAME_USERNAME);
		//
		if(!empty($_POST))
		{
			//用CI的方法是为了安全过滤参数
			$input=array();
			foreach ($_POST as $key => $value)
			{
				$input[$key]=$this->input->post($key);
			}
			//取得业务数据
			$this->received_data = $input;
		}
		
	}
	/**
	 * 是否是平台管理员
	 */
	public function  is_platform_admin()
	{
		return ($this->company_id == PLATFORM_COMPANY)&&($this->role_id==1);
	}
	
	protected function render_view($content_view,$data)
	{
		$this->load->view('header',$this->menu);
		$this->load->view($content_view,$data);
		$this->load->view('footer');
	}
	
	/**
	 * 输出JSON格式的正常响应数据
	 * @param array $data
	 */
	protected function output_data($data)
	{
		$this->output->set_content_type('application/json','utf-8')
		->set_output($this->json_encode_ex($data))
		->_display();
		exit;
	}
	private function json_encode_ex($data)
	{
		return json_encode($data,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
	}

}
