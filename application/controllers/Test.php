<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends WB_Controller {

	
	function __construct()
	{
		parent::__construct();
		$this->load->model('test_model');
		$this->load->model('testpaper_model');
		$this->load->model('department_model');
		$this->load->model('user_model');
	}
	
	public function index($search_string='---',$cur_page=1)
	{


		$search = urldecode($search_string=='---'?'':$search_string);
		$data = $this->test_model->get_test_page($this->company_id,$search,$cur_page);
		
		//实现分页
		$this->load->library('pagination');
		
		$this->pagination_config['base_url'] =base_url().'index.php/test/index/'.$search_string.'/';
		$this->pagination_config['total_rows'] = $data['total'];

		$this->pagination->initialize($this->pagination_config);
		
		//提示信息初始化
		$data['info'] = "";
		$data['err'] = "";
		$data['search_string']=$search;
		$this->render_view('test_list',$data);
	}
	public function create()
	{
	
		//表单验证
		$this->load->library('form_validation');
		//验证规则
		$this->form_validation->set_rules('test_name', '测试名称', "required");
		$this->form_validation->set_rules('start_time', '起始时间', "required");
		$this->form_validation->set_rules('end_time', '结束时间', "required");
	
	
		//提示信息
		$data['title'] = '创建测试';
		$data['to_list']='test';
		$data['info'] = "";
		$data['err'] = "";
	
		if($this->form_validation->run() == FALSE)
		{
			$papers = $this->testpaper_model->get_list($this->company_id);
			$data['papers'] = $papers;
			//$data['difs']=$this->get_difficulty_list();
			$this->render_view('test_create', $data);
		}else{
			$test_info['test_name']=$this->received_data['test_name'];
			$test_info['company_id']=$this->company_id;
			$test_info['test_paper_id']=$this->received_data['test_paper_id'];
			$test_info['start_time']=$this->received_data['start_time'];
			$test_info['end_time']=$this->received_data['end_time'];
			//$test_info['difficulty']=$this->received_data['difficulty'];
			//$test_info['description']=$this->received_data['description'];
			$test_info['update_at']=TIME_NOW;
					
			$result = $this->test_model->insert($test_info);
			if($result == FALSE)
			{
				$data['err'] = "测试添加失败";
			}else {
				$data['info'] = "测试添加成功";
			}
			$this->render_view('create_or_update_result',$data);
		}
	
	
	
	
	}
	public function update($id)
	{
	
		//表单验证
		$this->load->library('form_validation');
		//验证规则
		$this->form_validation->set_rules('test_name', '测试名称', "required");
		$this->form_validation->set_rules('start_time', '起始时间', "required");
		$this->form_validation->set_rules('end_time', '结束时间', "required");
	
	
		//提示信息
		$data['title'] = '编辑测试';
		$data['to_list']='test';
		$data['info'] = "";
		$data['err'] = "";
	
		if($this->form_validation->run() == FALSE)
		{
			$papers = $this->testpaper_model->get_list($this->company_id);
			$data['papers'] = $papers;
			$data['difs'] = $this->get_difficulty_list();
			
			if(empty($this->received_data))
			{
				$test_info = $this->test_model->get(array('test_id'=>$id,'del'=>0));
			}else{
				$test_info = $this->received_data;
				$test_info['test_id']=$id;
			}
			$data['test_info']=$test_info;
			$this->render_view('test_update', $data);
		}else{
			$test_info['test_name']=$this->received_data['test_name'];
			$test_info['test_paper_id']=$this->received_data['test_paper_id'];
			$test_info['start_time']=$this->received_data['start_time'];
			$test_info['end_time']=$this->received_data['end_time'];
			//$test_info['difficulty']=$this->received_data['difficulty'];
			//$test_info['description']=$this->received_data['description'];
			$test_info['update_at']=TIME_NOW;
			
			
			$condition = array('test_id' => $id,'company_id'=>$this->company_id,'user_count'=>0);
			$result = $this->test_model->update($test_info,$condition);
			
			if($result == FALSE)
			{
				$data['err'] = "测试编辑失败";
			}else {
				$data['info'] = "测试编辑成功";
			}
			$this->render_view('create_or_update_result',$data);
		}
	
	
	
	
	}
	
	public function delete($id)
	{

	
		//提示信息初始化
		$data['title'] = '删除测试';
		$data['to_list']='test';
		$data['info'] = "";
		$data['err'] = "";
	
		//获取要删除的用户ID错误的情况
		if(!isset($id) || $id === ""){
			$data['err'] = "获取要删除的测试失败。";
			$this->render_view('create_or_update_result',$data);
		}
	
		//删除
		$condition = array('test_id' => $id,'company_id'=>$this->company_id);
		$this->test_model->delete($condition);
		//删除成功信息
		$data['info'] = "删除测试成功。";
	
		//加载页面
		$this->render_view('create_or_update_result',$data);
	}
	
	public function view($id)
	{
		$test_info = $this->test_model->get(array('test_id'=>$id,'del'=>0));
		$test_paper = $this->testpaper_model->get(array('test_paper_id'=>$test_info['test_paper_id']));
		$test_info['test_paper_name']=$test_paper['test_paper_name'];
		
		$test_info['difficulty']= $this->get_difficulty($test_paper['difficulty']);
		$test_info['description']= $this->get_difficulty($test_paper['description']);
		$this->render_view('test_view',$test_info);
	}
	public function push($id)
	{
	
		if(empty($this->received_data))
		{
			$departments = $this->department_model->list_department($this->company_id);
			$data['departments'] = $departments;
			
			$test_info = $this->test_model->get(array('test_id'=>$id,'del'=>0));
			$paper_info = $this->testpaper_model->get(array('test_paper_id'=>$test_info['test_paper_id'],'del'=>0));
			$data['daily_push']=($paper_info['type']==2);
			$data['test_id']=$id;
			
			$this->render_view('test_push', $data);
		}else{
			if(!empty($this->received_data['all'])){//对所有人推送
				$this->received_data['department_id']=array();
			}
			for($cur_page=1;$cur_page<9999999;$cur_page++){
				$result = $this->user_model->get_push_user_page($this->company_id,$this->received_data['department_id'],$cur_page,10000);
				
				if(empty($result['item_list'])){
					break;
				}
				foreach ($result['item_list'] as $key =>$value){
					$tt = $this->test_model->get_test_task(array('test_id'=>$id,'user_id'=>$value['user_id'],'test_result_id'=>0));
					if(empty($tt)){
						$result = $this->test_model->insert_test_task(array('test_id'=>$id,'user_id'=>$value['user_id'],'jiguang_id'=>$value['jiguang_id'],
								'send_user_id'=>$this->user_id,'send_company_id'=>$this->company_id
						));
					}else{
						$result = $this->test_model->update_test_task(array('is_sent'=>0),
								array('test_id'=>$id,'user_id'=>$value['user_id'],'test_result_id'=>0));
					}
					
				}
			}
			if(!empty($this->received_data['push_type']) && $this->received_data['push_type']==2){//对所有人推送
				$department_id='';
				if(!empty($this->received_data['department_id'])){
					$department_id = implode(',',$this->received_data['department_id']);
				}
				$this->test_model->update(array('is_daily_push'=>1,'department_id'=>$department_id),array('test_id'=>$id,'company_id'=>$this->company_id));
			}
			
			//提示信息
			$data['title'] = '推送消息';
			$data['to_list']='test';
			$data['info'] = "";
			$data['err'] = "";
			
			if($result == FALSE)
			{
				$data['err'] = "推送消息失败";
			}else {
				$data['info'] = "推送消息成功";
			}
			$this->render_view('create_or_update_result',$data);
		}
	}
	
	public function push_cancel($id)
	{
		$this->test_model->update(array('is_daily_push'=>0),array('test_id'=>$id,'company_id'=>$this->company_id));
		redirect(base_url()."index.php/test/index/");
	}
	private function get_difficulty($difficulty_id)
	{
		$items = $this->get_difficulty_list();
		foreach ($items as $key => $value)
		{
			if($value['difficulty_id']==$difficulty_id){
				return  $value['difficulty_name'];
			}
		}
		return '';
	}
	private  function get_difficulty_list()
	{
		$data[]=array('difficulty_id'=>1,'difficulty_name'=>'容易');
		$data[]=array('difficulty_id'=>2,'difficulty_name'=>'适中');
		$data[]=array('difficulty_id'=>3,'difficulty_name'=>'较难');
		return $data;
	}
	
	
}
