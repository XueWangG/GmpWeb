<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends WB_Controller {

	
	function __construct()
	{
		parent::__construct();
		$this->load->model('company_model');
	}
	
	/**
	 * 企业管理首页
	 */
	public function index($search_string='---',$cur_page=1)
	{
		if(!$this->is_platform_admin()){
			show_404();
		}

		$search = urldecode($search_string=='---'?'':$search_string);
		$data = $this->company_model->get_company_page($search,$cur_page);
		
		//实现分页
		$this->load->library('pagination');
		
		$this->pagination_config['base_url'] =base_url().'index.php/company/index/'.$search_string.'/';
		$this->pagination_config['total_rows'] = $data['total'];

		$this->pagination->initialize($this->pagination_config);
		
		//提示信息初始化
		$data['info'] = "";
		$data['err'] = "";
		$data['search_string']=$search;
		$this->load->view('header',$this->menu);
		$this->load->view('company_list',$data);
		$this->load->view('footer');
	}
	public function create()
	{
		if(!$this->is_platform_admin()){
			show_404();
		}
		
		//表单验证
		$this->load->library('form_validation');
		//验证规则
		$this->form_validation->set_rules('company_name', '公司名称', "required");
		$this->form_validation->set_rules('contact_name', '联系人', "required");
		$this->form_validation->set_rules('mobile', '手机号码', "required|regex_match[/^\d{11}$/]",
				array('regex_match'=>'手机号码不正确'));

		$this->form_validation->set_rules('username', '用户名', 'required');
		$this->form_validation->set_rules('password', '密码', 'required');
		$this->form_validation->set_rules('passconf', '确认密码', 'required|matches[password]',
				array('matches'=>'密码和确认密码不一致'));
		
		$this->form_validation->set_message('required', '{field} 不能为空！');
	
		//提示信息
		$data['title'] = '创建企业';
		$data['to_list']='company';
		$data['info'] = "";
		$data['err'] = "";
		
		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('header',$this->menu);
			$this->load->view('company_create');
			$this->load->view('footer');
		}else{
			//TODO check unique mobile and username	
			$result = $this->company_model->create_company($this->received_data);
			if($result == FALSE)
			{
				$data['err'] = "企业添加失败";
			}else {
				$data['info'] = "企业添加成功";
			}
			$this->load->view('header',$this->menu);
			$this->load->view('create_or_update_result',$data);
			$this->load->view('footer');
		}
				
		
	}
	public function delete($id)
	{
		if(!$this->is_platform_admin()){
			show_404();
		}
		
		//提示信息初始化
		$data['title'] = '删除企业';
		$data['to_list']='company';
		$data['info'] = "";
		$data['err'] = "";
		
		//获取要删除的用户ID错误的情况
		if(!isset($id) || $id === ""){
			$data['err'] = "获取要删除的企业失败。";
			$this->load->view('header',$this->menu);
			$this->load->view('create_or_update_result',$data);
			$this->load->view('footer');
		}
		
		//删除
		$this->company_model->delete($id);
		//删除成功信息
		$data['info'] = "删除企业成功。";
		
		//加载页面
		$this->load->view('header',$this->menu);
		$this->load->view('create_or_update_result',$data);
		$this->load->view('footer');
	}
	public function update($id)
	{
		if(!$this->is_platform_admin()){
			show_404();
		}
		
		//表单验证
		$this->load->library('form_validation');
		//验证规则
		$this->form_validation->set_rules('company_name', '公司名称', "required");
		$this->form_validation->set_rules('contact_name', '联系人', "required");
		$this->form_validation->set_rules('mobile', '手机号码', "required|regex_match[/^\d{11}$/]",
				array('regex_match'=>'手机号码不正确'));
		
		$this->form_validation->set_message('required', '{field} 不能为空！');
		
		//提示信息
		$data['title'] = '编辑企业';
		$data['to_list']='company';
		$data['info'] = "";
		$data['err'] = "";
		
		if($this->form_validation->run() == FALSE)
		{
			if(empty($this->received_data))
			{
				$company = $this->company_model->get(array('company_id'=>$id,'del'=>0));
			}else{
				$company = $this->received_data;
				$company['company_id']=$id;
			}
			$this->load->view('header',$this->menu);
			$this->load->view('company_update',$company);
			$this->load->view('footer');
		}else{
			//TODO check unique mobile and username
				
			$result = $this->company_model->update($this->received_data,$id);
			if($result == FALSE)
			{
				$data['err'] = "企业编辑失败";
			}else {
				$data['info'] = "企业编辑成功";
			}
			$this->load->view('header',$this->menu);
			$this->load->view('create_or_update_result',$data);
			$this->load->view('footer');
		}
	}
	
	
}
