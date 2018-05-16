<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Topic extends WB_Controller {

	
	function __construct()
	{
		parent::__construct();
		$this->load->model('topic_model');
	}
	
	/**
	 * 问题广场首页
	 */
	public function index($search_string='---',$cur_page=1)
	{
		$search = urldecode($search_string=='---'?'':$search_string);
		$data = $this->topic_model->get_topic_page($search,$cur_page);
		
		//实现分页
		$this->load->library('pagination');
		
		$this->pagination_config['base_url'] =base_url().'index.php/topic/index/'.$search_string.'/';
		$this->pagination_config['total_rows'] = $data['total'];

		$this->pagination->initialize($this->pagination_config);
		

		$data['search_string']=$search;
		
		$this->render_view('topic_list', $data);
		
	}
	
	
	public function delete($id)
	{
		//提示信息初始化
		$data['title'] = '删除问答';
		$data['to_list']='topic';
		$data['info'] = "";
		$data['err'] = "";
		
		//获取要删除的用户ID错误的情况
		if(!isset($id) || $id === ""){
			$data['err'] = "获取要删除的问答失败。";
			$this->render_view('create_or_update_result',$data);
		}
		
		//删除
		if($this->is_platform_admin()){
			$this->topic_model->delete(array('topic_id'=>$id));
		}
		
		//删除成功信息
		$data['info'] = "删除问答成功。";
		
		//加载页面
		$this->render_view('create_or_update_result',$data);
	}
	
	/**
	 * 查看问题
	 * @param unknown $id问题ID
	 * @param number $cur_page 回答的页数
	 */
	public function view($id,$cur_page=1)
	{

		$data = $this->topic_model->get_topic_view($id,$cur_page);
		
		 //实现分页
		$this->load->library('pagination');
		
		$this->pagination_config['base_url'] =base_url().'index.php/topic/view/'.$id.'/';
		$this->pagination_config['total_rows'] = $data['total'];

		$this->pagination->initialize($this->pagination_config);
		
		$this->render_view('topic_view', $data);
	}
	
	/**
	 * 查看回答明细
	 * @param unknown $id回答ID
	 * @param number $cur_page 评论的页数
	 */
	public function view_answer($id,$cur_page=1)
	{
	
		$data = $this->topic_model->get_answer_view($id,$cur_page);
	
		//实现分页
		$this->load->library('pagination');
	
		$this->pagination_config['base_url'] =base_url().'index.php/topic/view_answer/'.$id.'/';
		$this->pagination_config['total_rows'] = $data['total'];
	
		$this->pagination->initialize($this->pagination_config);
	
		$this->render_view('answer_view', $data);
	}
	
	public function delete_answer($topic_id,$id)
	{
		//提示信息初始化
		$data['title'] = '删除回答';
		$data['to_list']='topic/view/'.$topic_id;
		$data['info'] = "";
		$data['err'] = "";
	
		//获取要删除的用户ID错误的情况
		if(!isset($id) || $id === ""){
			$data['err'] = "获取要删除的回答失败。";
			$this->render_view('create_or_update_result',$data);
		}
	
		//删除
		if($this->is_platform_admin()){
			$this->topic_model->delete_answer(array('topic_id'=>$topic_id,'topic_answer_id'=>$id));
		}
	
		//删除成功信息
		$data['info'] = "删除回答成功。";
	
		//加载页面
		$this->render_view('create_or_update_result',$data);
	}
	
	public function delete_answer_comment($topic_answer_id,$id)
	{
		//提示信息初始化
		$data['title'] = '删除回答评论';
		$data['to_list']='topic/view_answer/'.$topic_answer_id;
		$data['info'] = "";
		$data['err'] = "";
	
		//获取要删除的用户ID错误的情况
		if(!isset($id) || $id === ""){
			$data['err'] = "获取要删除的回答评论失败。";
			$this->render_view('create_or_update_result',$data);
		}
	
		//删除
		if($this->is_platform_admin()){
			$this->topic_model->delete_answer_comment(array('topic_answer_id'=>$topic_answer_id,'answer_comment_id'=>$id));
		}
	
		//删除成功信息
		$data['info'] = "删除回答评论成功。";
	
		//加载页面
		$this->render_view('create_or_update_result',$data);
	}
	public function topmost($id)
	{
	
		$data['status']=2;
		$data['update_at']=TIME_NOW;
		$this->topic_model->update($data,$id);
			
		redirect(base_url()."index.php/topic/");
	}
	
	public function cancel_topmost($id)
	{
	
		$data['status']=0;
		$data['update_at']=TIME_NOW;
		$this->topic_model->update($data,$id);
			
		redirect(base_url()."index.php/topic/");
	}
	
}
