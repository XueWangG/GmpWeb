<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Topic extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('topic_model');
		$this->load->model('user_model');
	}

	public function add()
	{
		//登录校验并取得用户信息
		$user_info = $this->get_user_info();
		
	    //输入参数校验
		$this->load->library('form_validation');
		$this->form_validation->set_rules('topic_content', 'TopicContent', 'required',
				array('required'=>'必须输入问题内容'));
		
		if ($this->form_validation->run() === FALSE)
		{
			$this->output_error(CODE_PARAM_ERROR,$this->form_validation-> error_array());
		
		}
		
		$data = array();
		$data['user_id']=$user_info['user_id'];
		$data['topic_content']=$this->received_data['topic_content'];
		$data['topic_tips']=$this->received_data['topic_tips'];
		$data['update_at']=TIME_NOW;
		
		$result = $this->topic_model->insert($data);
		if($result == FALSE)
		{
			log_message('error', '添加问题出错');
			$this->output_error(CODE_UNKNOWN_ERROR);
			
		}else
		{
			$this->user_model->add_coin($user_info['user_id'],2);
			$this->output_ok(array('topic_id'=>$result));
		}
			
	
	}
	
	public function follow()
	{
		//登录校验并取得用户信息
		$user_info = $this->get_user_info();
		//输入参数校验
		$this->load->library('form_validation');
		$this->form_validation->set_rules('topic_id', 'TopicId', 'required',
				array('required'=>'必须输入问题ID'));
		
		if ($this->form_validation->run() === FALSE)
		{
			$this->output_error(CODE_PARAM_ERROR,$this->form_validation-> error_array());
		
		}
		
		$data = array();
		$data['user_id']=$user_info['user_id'];
		$data['topic_id']=$this->received_data['topic_id'];
		$result = $this->topic_model->follow_topic($data);
		if($result == FALSE)
		{
			log_message('error', '关注问题出错');
			$this->output_error(CODE_UNKNOWN_ERROR);
				
		}else
		{
			$this->user_model->add_coin($user_info['user_id'],1);
			$this->output_ok(array('topic_follower_id'=>$result));
		}
		
	}
	public function unfollow()
	{
		//登录校验并取得用户信息
		$user_info = $this->get_user_info();
		//输入参数校验
		$this->load->library('form_validation');
		$this->form_validation->set_rules('topic_id', '问题ID', 'required');
	
		if ($this->form_validation->run() === FALSE)
		{
			$this->output_error(CODE_PARAM_ERROR,$this->form_validation-> error_array());
	
		}
	
		$data = array();
		$data['user_id']=$user_info['user_id'];
		$data['topic_id']=$this->received_data['topic_id'];
		$result = $this->topic_model->unfollow_topic($data);
		if($result == FALSE)
		{
			log_message('error', '取消关注问题出错');
			$this->output_error(CODE_UNKNOWN_ERROR);
	
		}else
		{
			$this->output_ok(NULL);
		}
	
	}
	public function add_answer()
	{
		//登录校验并取得用户信息
		$user_info = $this->get_user_info();
		//输入参数校验
		$this->load->library('form_validation');
		$this->form_validation->set_rules('topic_id', 'TopicId', 'required',
				array('required'=>'必须输入问题ID'));
		$this->form_validation->set_rules('answer', 'Answer', 'required',
				array('required'=>'必须输入回答'));
		
		if ($this->form_validation->run() === FALSE)
		{
			$this->output_error(CODE_PARAM_ERROR,$this->form_validation-> error_array());
		
		}
		
		$data = array();
		$data['topic_id']=$this->received_data['topic_id'];
		$data['user_id']=$user_info['user_id'];
		$data['content']=$this->received_data['answer'];
		$data['update_at']=TIME_NOW;
		$result = $this->topic_model->insert_topic_answer($data);
		if($result == FALSE)
		{
			log_message('error', '添加回答出错');
			$this->output_error(CODE_UNKNOWN_ERROR);
				
		}else
		{
			$this->user_model->add_coin($user_info['user_id'],1);
			$this->output_ok(array('topic_answer_id'=>$result));
		}
	}
	
	/**
	 * 回答问题时如果已经有问答要返回我的问答
	 */
	public function get_my_answer()
	{
		
	}
	
	public function list_topic()
	{
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
		
		$keyword = empty($this->received_data['keyword'])?'':$this->received_data['keyword'];
		$cur_page = empty($this->received_data['cur_page'])?1:$this->received_data['cur_page'];
		$page_size = empty($this->received_data['page_size'])?6:$this->received_data['page_size'];
		$data = $this->topic_model->get_topic_list($keyword,$cur_page,$page_size);
		
		//
		if(!empty($keyword)){
			$his['keyword']=$keyword;
			$his['type']=2;
			if(!empty($this->received_data['key'])){
				$user_info = $this->get_user_info();
				$his['user_id']=$user_info['user_id'];
				$his['company_id']=$user_info['company_id'];
			}
			$this->topic_model->insert_search_history($his);
		}
		//
		
		$this->output_ok(array('topic_list'=>$data,'more'=>(count($data)==$page_size)));
	}
	
	public function search()
	{
		
		
		
	
		$this->output_ok('已合并到list_topic');
	}
	
	/**
	 * 获得问题详情
	 */
	public function get_detail()
	{
		//如果key不为空时
		//登录校验并取得用户信息
		if(!empty($this->received_data['key']))
		{
			$user_info = $this->get_user_info();
		}
		
		//输入参数校验
		$this->load->library('form_validation');
		$this->form_validation->set_rules('topic_id', 'TopicId', 'required',
				array('required'=>'必须输入问题ID'));
		$this->form_validation->set_rules('cur_page', 'CurPage', 'regex_match[/^\d+$/]',
				array('regex_match'=>'必须是数字'));
		$this->form_validation->set_rules('page_size', 'PageSize', 'regex_match[/^\d+$/]',
				array('regex_match'=>'必须是数字'));
		
		if ($this->form_validation->run() === FALSE)
		{
			$this->output_error(CODE_PARAM_ERROR,$this->form_validation-> error_array());
		
		}
		$topic = $this->topic_model->get_topic_detail($this->received_data['topic_id']);
		if(!empty($topic))
		{
			$topic['followed'] = empty($user_info)?FALSE:$this->topic_model->is_followed($user_info['user_id'],$topic['topic_id']);
			//
			$cur_page = empty($this->received_data['cur_page'])?1:$this->received_data['cur_page'];
			$page_size = empty($this->received_data['page_size'])?6:$this->received_data['page_size'];
			$data = $this->topic_model->get_answer_list($topic['topic_id'],$cur_page,$page_size);
			$topic['answer_list']=$data;
			$topic['more']=(count($data)==$page_size);
		}

		$this->output_ok($topic);
	}
	
	public function get_answer_detail()
	{
		//如果key不为空时
		//登录校验并取得用户信息
		if(!empty($this->received_data['key']))
		{
			$user_info = $this->get_user_info();
		}
		
		//输入参数校验
		$this->load->library('form_validation');
		$this->form_validation->set_rules('topic_answer_id', 'AnswerId', 'required',
				array('required'=>'必须输入问题ID'));
		
		if ($this->form_validation->run() === FALSE)
		{
			$this->output_error(CODE_PARAM_ERROR,$this->form_validation-> error_array());
		
		}
		
		$data = $this->topic_model->get_answer_detail($this->received_data['topic_answer_id']);
		if(!empty($data))
		{
			$data['topic_followed'] = empty($user_info)?FALSE:$this->topic_model->is_followed($user_info['user_id'],$data['topic_id']);
			$data['answer_followed'] = empty($user_info)?FALSE:$this->topic_model->is_answer_followed($user_info['user_id'],$data['topic_answer_id']);
			$data['answer_thumbup'] = empty($user_info)?FALSE:$this->topic_model->is_answer_thumbup($user_info['user_id'],$data['topic_answer_id']);			
		}
		$this->output_ok($data);
	}
	
	public function list_answer_comment()
	{
		//输入参数校验
		$this->load->library('form_validation');
		$this->form_validation->set_rules('topic_answer_id', 'AnswerId', 'required',
				array('required'=>'必须输入问题ID'));
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
		$data = $this->topic_model->get_answer_comment_list($this->received_data['topic_answer_id'],$cur_page,$page_size);
		
		$this->output_ok(array('answer_comment_list'=>$data, 'more'=>(count($data)==$page_size)));
	}
	
	public function add_answer_comment()
	{
		//登录校验并取得用户信息
		$user_info = $this->get_user_info();
		//输入参数校验
		$this->load->library('form_validation');
		$this->form_validation->set_rules('topic_answer_id', 'TopicAnswerId', 'required',
				array('required'=>'必须输入回答ID'));
		$this->form_validation->set_rules('comment_content', 'CommentContent', 'required',
				array('required'=>'必须输入回答的评论内容'));
		
		if ($this->form_validation->run() === FALSE)
		{
			$this->output_error(CODE_PARAM_ERROR,$this->form_validation-> error_array());
		
		}
		$data = array();
		$data['topic_answer_id']=$this->received_data['topic_answer_id'];
		$data['user_id']=$user_info['user_id'];
		$data['content']=$this->received_data['comment_content'];
		$data['update_at']=TIME_NOW;
		$result = $this->topic_model->insert_answer_comment($data);
		if($result == FALSE)
		{
			log_message('error', '添加回答出错');
			$this->output_error(CODE_UNKNOWN_ERROR);
		
		}else
		{
			$this->output_ok(array('answer_comment_id'=>$result));
		}
	}
	
	public function add_answer_thumbup()
	{
		//登录校验并取得用户信息
		$user_info = $this->get_user_info();
		//输入参数校验
		$this->load->library('form_validation');
		$this->form_validation->set_rules('topic_answer_id', 'TopicAnswerId', 'required',
				array('required'=>'必须输入回答ID'));
		
		if ($this->form_validation->run() === FALSE)
		{
			$this->output_error(CODE_PARAM_ERROR,$this->form_validation-> error_array());
		
		}
		$data = array();
		$data['user_id']=$user_info['user_id'];
		$data['topic_answer_id']=$this->received_data['topic_answer_id'];
		$result = $this->topic_model->insert_answer_thumbup($data);
		if($result == FALSE)
		{
			log_message('error', '回答点赞出错');
			$this->output_error(CODE_UNKNOWN_ERROR);
		
		}else
		{
			$this->user_model->add_coin($user_info['user_id'],1);
			$this->output_ok(array('answer_thumbup_id'=>$result));
		}

	}
	public function follow_answer()
	{
		//登录校验并取得用户信息
		$user_info = $this->get_user_info();
		//输入参数校验
		$this->load->library('form_validation');
		$this->form_validation->set_rules('topic_answer_id', 'TopicAnswerId', 'required',
				array('required'=>'必须输入回答ID'));
		
		if ($this->form_validation->run() === FALSE)
		{
			$this->output_error(CODE_PARAM_ERROR,$this->form_validation-> error_array());
		
		}
		$data = array();
		$data['user_id']=$user_info['user_id'];
		$data['topic_answer_id']=$this->received_data['topic_answer_id'];
		$result = $this->topic_model->follow_answer($data);
		if($result == FALSE)
		{
			log_message('error', '关注回答出错');
			$this->output_error(CODE_UNKNOWN_ERROR);
		
		}else
		{
			$this->output_ok(array('answer_follower_id'=>$result));
		}
	}
	public function unfollow_answer()
	{
		//登录校验并取得用户信息
		$user_info = $this->get_user_info();
		//输入参数校验
		$this->load->library('form_validation');
		$this->form_validation->set_rules('topic_answer_id', '回答ID', 'required');
	
		if ($this->form_validation->run() === FALSE)
		{
			$this->output_error(CODE_PARAM_ERROR,$this->form_validation-> error_array());
	
		}
		$data = array();
		$data['user_id']=$user_info['user_id'];
		$data['topic_answer_id']=$this->received_data['topic_answer_id'];
		$result = $this->topic_model->unfollow_answer($data);
		if($result == FALSE)
		{
			log_message('error', '取消关注回答出错');
			$this->output_error(CODE_UNKNOWN_ERROR);
	
		}else
		{
			$this->output_ok(NULL);
		}
	}
	/**
	 * 广场首页
	 */
	public function get_home()
	{
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
		$data = $this->topic_model->get_latest_answer_list($cur_page,$page_size);
		
		if($cur_page==1){
			$this->output_ok(array('topmost_list'=>$this->topic_model->get_topmost_list(),
					'answer_list'=>$data,'more'=>(count($data)==$page_size)));
		}else{
			$this->output_ok(array(
					'answer_list'=>$data,'more'=>(count($data)==$page_size)));
		}
		
	}
	
	public function  get_hot_keyword()
	{
		$data = $this->topic_model->get_hot_keyword();
		$this->output_ok($data);
	}
}
