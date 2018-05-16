<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends WB_Controller {

	
	function __construct()
	{
		parent::__construct();
		$this->load->model('company_model');
	}
	
	public function index()
	{
	//表单验证
		$this->load->library('form_validation');
		//验证规则
		$this->form_validation->set_rules('company_name', '公司名称', "required");
		$this->form_validation->set_rules('contact_name', '联系人', "required");
		$this->form_validation->set_rules('mobile', '手机号码', "required|regex_match[/^\d{11}$/]",
				array('regex_match'=>'手机号码不正确'));
		
		//提示信息
		$data['title'] = '设置企业信息';
		$data['to_list']='test';
		$data['info'] = "";
		$data['err'] = "";
		
		if($this->form_validation->run() == FALSE)
		{
			if(empty($this->received_data))
			{
				$company = $this->company_model->get(array('company_id'=>$this->company_id,'del'=>0));
			}else{
				$company = $this->received_data;
				$company['company_id']=$id;
			}
			$this->render_view('setting',$company);
		}else{
			
				
			$result = $this->company_model->update($this->received_data,$this->company_id);
			if($result == FALSE)
			{
				$data['err'] = "企业信息设置失败";
			}else {
				$data['info'] = "企业信息设置成功";
			}
			$this->render_view('create_or_update_result',$data);
		}
	}

	
	
	
}
