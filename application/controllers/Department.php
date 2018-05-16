<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Department extends WB_Controller {

	
	function __construct()
	{
		parent::__construct();
		$this->load->model('department_model');
	}
	
	/**
	 * 企业部门管理首页
	 */
	public function index()
	{
		
		$data = $this->department_model->get_department_list($this->company_id);
		
		//提示信息初始化
		$data['info'] = "";
		$data['err'] = "";
		$this->render_view('department_list', $data);

	}
	public function create()
	{	
		//表单验证
		$this->load->library('form_validation');
		//验证规则
		$this->form_validation->set_rules('department_name', '部门名称', "required");
	
		//提示信息
		$data['title'] = '创建部门';
		$data['to_list']='department';
		$data['info'] = "";
		$data['err'] = "";
		
		if($this->form_validation->run() == FALSE)
		{
			$this->render_view('department_create',$data);
		}else{
			$d['department_name']=$this->received_data['department_name'];
			$d['company_id']=$this->company_id;
			$d['update_at']=TIME_NOW;
			$result = $this->department_model->insert($d);
			if($result == FALSE)
			{
				$data['err'] = "部门添加失败";
			}else {
				$data['info'] = "部门添加成功";
			}
			$this->render_view('create_or_update_result', $data);
		}
		
	}
	public function delete($id)
	{

		//提示信息初始化
		$data['title'] = '删除部门';
		$data['to_list']='department';
		$data['info'] = "";
		$data['err'] = "";
		
		//获取要删除的用户ID错误的情况
		if(!isset($id) || $id === ""){
			$data['err'] = "获取要删除的部门失败。";
			$this->render_view('create_or_update_result', $data);
		}
		
		//删除
		$this->department_model->delete(array('department_id'=>$id,'company_id'=>$this->company_id));
		//删除成功信息
		$data['info'] = "删除部门成功。";
		
		//加载页面
		$this->render_view('create_or_update_result', $data);
	}
	public function update($id)
	{
		
		//表单验证
		$this->load->library('form_validation');
		//验证规则
		$this->form_validation->set_rules('department_name', '部门名称', "required");
		
		//提示信息
		$data['title'] = '编辑部门';
		$data['to_list']='department';
		$data['info'] = "";
		$data['err'] = "";
		
		if($this->form_validation->run() == FALSE)
		{
			if(empty($this->received_data))
			{
				$department = $this->department_model->get(array('department_id'=>$id,'del'=>0));
			}else{
				$department = $this->received_data;
				$department['department_id']=$id;
			}
			$this->render_view('department_update', $department);
		}else{
			$d['department_name']=$this->received_data['department_name'];
			$d['update_at']=TIME_NOW;
			
			$condition['department_id']=$id;
			$condition['company_id']=$this->company_id;
			$result = $this->department_model->update($d,$condition);
			if($result == FALSE)
			{
				$data['err'] = "部门编辑失败";
			}else {
				$data['info'] = "部门编辑成功";
			}
			$this->render_view('create_or_update_result', $data);
		}
	}
	
	
}
