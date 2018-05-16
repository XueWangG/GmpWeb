<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends MY_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->model('test_model');
		$this->load->model('question_model');
		$this->load->model('user_model');
	}
	
	public function get_home()
	{
		//如果有登录则取用户信息
		//登录校验并取得用户信息
		if(!empty($this->received_data['key']))
		{
			$user_info = $this->get_user_info();
			
			$my = $this->test_model->get_user_summary($user_info['user_id']);
			
			$my_ranking=array();
			$my_ranking['ranking']=$my['ranking'];
			$my_ranking['question_count']=$my['question_count'];
			$my_ranking['ranking_change']=$my['ranking_change'];
			$my_ranking['question_change']=$my['question_change'];
			$my_ranking['question_change_percent']=$my['question_change_percent'];
			
			$my_category = array();
			foreach ($my['cap'] as $key=>$value){
				$my_category[$key] = array('category_id'=>$value['id'],'category_name'=>$value['name'],'category_score'=>$value['value']);
			}
			
			$data = $this->user_model->get_task_list($user_info['user_id'], 1, 10);
			
			//不知道为什么这里又不能用case when了
			foreach ($data as $key=>$value){
				$data[$key]['correct_rate']=round($data[$key]['question_count']==0?0:$data[$key]['correct_count']*100.0/$data[$key]['question_count']).'%';
			
				$data[$key]['progress']=round($data[$key]['question_count']==0?0:$data[$key]['answered_count']*100.0/$data[$key]['question_count']);
				$data[$key]['from']=$value['send_company_id']==1?"学院":"公司";
				unset($data[$key]['answered_count']);
				unset($data[$key]['send_company_id']);
			}
			
			$my_task = $data;
			
			
		}else{
			$my_ranking=array();
			$my_ranking['ranking']=1;
			$my_ranking['question_count']=0;
			$my_ranking['ranking_change']=0;
			$my_ranking['question_change']=0;
			$my_ranking['question_change_percent']=0;
			
			$my_category = array();
			//$my_category[0] = array('category_id'=>2,'category_name'=>'能力分类1','category_score'=>2);
			//$my_category[1] = array('category_id'=>2,'category_name'=>'能力分类2','category_score'=>3);
			//$my_category[2] = array('category_id'=>3,'category_name'=>'能力分类3','category_score'=>4);
			//$my_category[3] = array('category_id'=>4,'category_name'=>'能力分类4','category_score'=>3);
			//$my_category[4] = array('category_id'=>5,'category_name'=>'能力分类5','category_score'=>3.5);
			//$my_category[5] = array('category_id'=>6,'category_name'=>'能力分类6','category_score'=>3);
			//$my_category[6] = array('category_id'=>7,'category_name'=>'能力分类7','category_score'=>4.5);
			
			$my_task = array();
		}
		
		
		$hot_test = $this->test_model->search(1,'', '', 1,3);
		//不知道为什么这里又不能用case when了
		foreach ($hot_test as $key=>$value){
			$hot_test[$key]['pass_rate']=round($hot_test[$key]['user_count']==0?0:$hot_test[$key]['pass_count']*100.0/$hot_test[$key]['user_count']).'%';
			unset($hot_test[$key]['pass_count']);
			unset($hot_test[$key]['cover_url']);
			unset($hot_test[$key]['create_at']);
		}
		
				
		$this->output_ok(array('my_ranking'=>$my_ranking,'my_category'=>$my_category,'hot_test'=>$hot_test,'my_task'=>$my_task));
		
		
	}
	public function get_daily_question()
	{
		//登录校验并取得用户信息
		$user_info = $this->get_user_info();
		//输入参数校验
		$this->load->library('form_validation');
		$this->form_validation->set_rules('category_id', 'CategoryId', 'required',
				array('required'=>'必须输入分类ID'));
		$this->form_validation->set_rules('question_count', 'QuestionCount', 'required|regex_match[/^\d+$/]',
				array('required'=>'必须输入试题数','regex_match'=>'试题数必须是数字'));
		
		if ($this->form_validation->run() === FALSE)
		{
			$this->output_error(CODE_PARAM_ERROR,$this->form_validation-> error_array());
		
		}
		
		$this->user_model->add_coin($user_info['user_id'],3);
		$result = $this->test_model->get_daily_question_list($user_info['user_id'],1,$this->received_data['category_id'],$this->received_data['question_count']);
		$this->output_ok($result);
	}
	
	public function get_test_info()
	{
		//输入参数校验
		$this->load->library('form_validation');
		$this->form_validation->set_rules('test_id', 'TestId', 'required|regex_match[/^\d+$/]',
				array('required'=>'必须输入试卷ID','regex_match'=>'试卷ID必须是数字'));
		
		if ($this->form_validation->run() === FALSE)
		{
			$this->output_error(CODE_PARAM_ERROR,$this->form_validation-> error_array());
		
		}
		
		$data = array();
		$test_info = $this->test_model->get_test_info($this->received_data['test_id']);
		if(!empty($test_info)){
			$data['test_id']=$test_info['test_id'];
			$data['test_name']=$test_info['test_name'];
			$data['cover_url']=$test_info['cover_url'];
			$data['description']=$test_info['description'];
			$data['question_count']=$test_info['question_count'];
			$data['user_count']=$test_info['user_count'];
			$data['pass_rate']=round($test_info['user_count']==0?0:$test_info['pass_count']*100.0/$test_info['user_count']).'%';
			$data['difficulty']=$test_info['difficulty']==1?'容易':($test_info['difficulty']==2?'适中':($test_info['difficulty']==3?'较难':'未知'));
			$data['tag_list'] = $this->test_model->get_tag_list($test_info['test_paper_id']);
		}
		
		$this->output_ok($data);
	}
	
	public function get_question_list()
	{
		//登录校验并取得用户信息
		$user_info = $this->get_user_info();
		//输入参数校验
		$this->load->library('form_validation');
		$this->form_validation->set_rules('test_id', 'TestId', 'required|regex_match[/^\d+$/]',
				array('required'=>'必须输入试卷ID','regex_match'=>'试卷ID必须是数字'));
		$this->form_validation->set_rules('test_result_id', 'TestResultId', 'regex_match[/^\d+$/]',
				array('required'=>'必须输入试卷ID','regex_match'=>'试卷ID必须是数字'));
		
		if ($this->form_validation->run() === FALSE)
		{
			$this->output_error(CODE_PARAM_ERROR,$this->form_validation-> error_array());
		
		}
		
		$this->user_model->add_coin($user_info['user_id'],3);
		
		$result = $this->test_model->get_question_list($user_info['user_id'],$this->received_data['test_id'],$this->received_data['test_result_id']);
		$this->output_ok($result);
		
	}
	public function submit_question(){
		//登录校验并取得用户信息
		$user_info = $this->get_user_info();
		//输入参数校验
		$this->load->library('form_validation');
		$this->form_validation->set_rules('test_result_id', 'TestResultId', 'required|regex_match[/^\d+$/]',
				array('required'=>'必须输入试卷ID','regex_match'=>'试卷ID必须是数字'));
		$this->form_validation->set_rules('question_id', 'QuestionId', 'required|regex_match[/^\d+$/]',
				array('required'=>'必须输入试题ID','regex_match'=>'试题ID必须是数字'));
		$this->form_validation->set_rules('user_answer', 'UserAnswer', 'required',
				array('required'=>'必须输入答案'));
		
		if ($this->form_validation->run() === FALSE)
		{
			$this->output_error(CODE_PARAM_ERROR,$this->form_validation-> error_array());
			
		}
		$question = $this->question_model->get(array('question_id'=>$this->received_data['question_id']));
		$data['user_answer']=$this->received_data['user_answer'];
		$data['is_submit']=1;
		$data['is_correct']=$question['answer']==$this->received_data['user_answer']?1:0;
		$data['update_at']=TIME_NOW;
		$condition['user_id']=$user_info['user_id'];
		$condition['test_result_id']=$this->received_data['test_result_id'];
		$condition['question_id']=$this->received_data['question_id'];
		$this->test_model->update_test_result_detail($data,$condition);
		
		$this->output_ok(NULL);
	}
	
	public function submit()
	{
		//登录校验并取得用户信息
		$user_info = $this->get_user_info();
		//输入参数校验
		$this->load->library('form_validation');
		$this->form_validation->set_rules('test_result_id', 'TestResultId', 'required|regex_match[/^\d+$/]',
				array('required'=>'必须输入试卷ID','regex_match'=>'试卷ID必须是数字'));
		
		if ($this->form_validation->run() === FALSE)
		{
			$this->output_error(CODE_PARAM_ERROR,$this->form_validation-> error_array());
		
		}
		$result = $this->test_model->submit_test($user_info['user_id'],$this->received_data['test_result_id']);
		
		
		$this->output_ok($result);

	}
	
	public function get_answer()
	{
		//登录校验并取得用户信息
		$user_info = $this->get_user_info();
		//输入参数校验
		$this->load->library('form_validation');
		$this->form_validation->set_rules('test_result_id', 'TestId', 'required',
				array('required'=>'必须输入测试结果ID'));
	
		if ($this->form_validation->run() === FALSE)
		{
			$this->output_error(CODE_PARAM_ERROR,$this->form_validation-> error_array());
	
		}
		$result = $this->test_model->get_answer($this->received_data['test_result_id']);
		
	
		$this->output_ok($result);
	
	}
	
	public function  get_hot_keyword()
	{
		$data = $this->test_model->get_hot_keyword();
		$this->output_ok($data);
	}
	public function get_hot()
	{
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
		$data = $this->test_model->get_hot($cur_page,$page_size);
		//不知道为什么这里又不能用case when了
		foreach ($data as $key=>$value){
			$data[$key]['pass_rate']=round($data[$key]['user_count']==0?0:$data[$key]['pass_count']*100.0/$data[$key]['user_count']).'%';
			unset($data[$key]['pass_count']);
		}
		
		$this->output_ok(array('test_list'=>$data,'more'=>(count($data)==$page_size)));
	}
	
	public function search()
	{
		//输入参数校验
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('type', 'Type', 'regex_match[/^\d+$/]',
				array('regex_match'=>'必须是数字'));
		$this->form_validation->set_rules('cur_page', 'CurPage', 'regex_match[/^\d+$/]',
				array('regex_match'=>'必须是数字'));
		$this->form_validation->set_rules('page_size', 'Answer', 'regex_match[/^\d+$/]',
				array('regex_match'=>'必须是数字'));
	
		if ($this->form_validation->run() === FALSE)
		{
			$this->output_error(CODE_PARAM_ERROR,$this->form_validation-> error_array());
	
		}
		
		$type = empty($this->received_data['type'])?2:$this->received_data['type'];
		$keyword = $this->received_data['keyword'];
		$tag_id = $this->received_data['tag_id'];
		$cur_page = empty($this->received_data['cur_page'])?1:$this->received_data['cur_page'];
		$page_size = empty($this->received_data['page_size'])?6:$this->received_data['page_size'];
		$data = $this->test_model->search($type,$keyword, $tag_id, $cur_page,$page_size);
		//不知道为什么这里又不能用case when了
		foreach ($data as $key=>$value){
			$data[$key]['pass_rate']=round($data[$key]['user_count']==0?0:$data[$key]['pass_count']*100.0/$data[$key]['user_count']).'%';
			unset($data[$key]['pass_count']);
		}
		
		
		$this->output_ok(array('test_list'=>$data,'more'=>(count($data)==$page_size)));
	}
	
	public function  get_test_paper_tag()
	{
		$data = $this->test_model->get_test_paper_tag();
		$this->output_ok($data);
	}
	
	public function  get_daily_category()
	{
		$data = $this->question_model->get_category_list(1);
		$this->output_ok($data);
	}
	public function reset(){
		//登录校验并取得用户信息
		$user_info = $this->get_user_info();
		//输入参数校验
		$this->load->library('form_validation');
		$this->form_validation->set_rules('test_id', 'TestId', 'required|regex_match[/^\d+$/]',
				array('required'=>'必须输入试卷ID','regex_match'=>'试卷ID必须是数字'));
		
		if ($this->form_validation->run() === FALSE)
		{
			$this->output_error(CODE_PARAM_ERROR,$this->form_validation-> error_array());
		
		}
		//一个测试已经可以做多次，不需要reset了
		//$result = $this->test_model->reset($user_info['user_id'],$this->received_data['test_id']);
		
		
		$this->output_ok(NULL);
	}
	
	public function search_question()
	{
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
	
		$keyword = $this->received_data['keyword'];
		$cur_page = empty($this->received_data['cur_page'])?1:$this->received_data['cur_page'];
		$page_size = empty($this->received_data['page_size'])?6:$this->received_data['page_size'];
		$data = $this->test_model->search_question($keyword,$cur_page,$page_size);
		
		//
		if(!empty($keyword)){
			$his['keyword']=$keyword;
			$his['type']=3;
			if(!empty($this->received_data['key'])){
				$user_info = $this->get_user_info();
				$his['user_id']=$user_info['user_id'];
				$his['company_id']=$user_info['company_id'];
			}
			$this->test_model->insert_search_history($his);
		}
		//
	
		$this->output_ok(array('test_list'=>$data,'more'=>(count($data)==$page_size)));
	}
	
	
	public function get_question()
	{
		//输入参数校验
		$this->load->library('form_validation');
		$this->form_validation->set_rules('question_id', '试题ID', 'required');
	
		if ($this->form_validation->run() === FALSE)
		{
			$this->output_error(CODE_PARAM_ERROR,$this->form_validation-> error_array());
	
		}
	
		$data = $this->test_model->get_question($this->received_data['question_id']);
	
		$this->output_ok($data);
	}
	
}
