<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Summary_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	/**
	 * 取得一页数据
	 * @param unknown $cur_page 当前页码
	 * @param unknown $page_size 每页数据条数
	 * @param unknown $search_string 要查找的字符串
	 */
	public function get_test_page($search_string,$company_id,$cur_page,$page_size = 10)
	{
		$result = array();
		
		$this->db->select('test.*,test_paper.question_count');
		$this->db->join('test_paper','test.test_paper_id=test_paper.test_paper_id');
		$this->db->where('test.company_id',$company_id);
		$this->db->where('test.del',0);
		$this->db->where('test.user_count >',0);
		if(!empty($search_string))
		{
			$this->db->where("(test_name LIKE '%$search_string%')");
			
		}
		$this->db->order_by('test_id', 'DESC');
		
		$total = $this->db->count_all_results('test',FALSE);
		$result['total']=$total;
		
		$this->db->limit($page_size,($cur_page-1)*$page_size);
		$query = $this->db->get();
		$result['item_list'] =  $query->result_array();
		
		//不知道为什么这里又不能用case when了
		foreach ($result['item_list'] as $key=>$value){
			$result['item_list'][$key]['pass_rate']=round($result['item_list'][$key]['user_count']==0?0:$result['item_list'][$key]['pass_count']*100.0/$result['item_list'][$key]['user_count']).'%';
			unset($result['item_list'][$key]['pass_count']);
		}
		
		return $result;
	}
	
	public function get_user_page($search_string,$company_id,$cur_page,$page_size = 10)
	{
		$result = array();
	
		$this->db->select('test_result.user_id,username,user.mobile,count(*) as test_count,sum(passed) as pass_count,company_name');
		$this->db->join('user','test_result.user_id=user.user_id');
		$this->db->join('company', 'user.company_id = company.company_id');
		$this->db->where('user.del',0);
		if($company_id!=PLATFORM_COMPANY)
		{
			$this->db->where('user.company_id',$company_id);
		}
		if(!empty($search_string))
		{
			$this->db->where("(username LIKE '%$search_string%' OR user.mobile LIKE '%$search_string%')");
				
		}
		$this->db->group_by(array('user_id','username','user.mobile','company_name'));
		$this->db->order_by('user.company_id,user_id');
		$total = $this->db->count_all_results('test_result',FALSE);
		$result['total']=$total;
	
		$this->db->limit($page_size,($cur_page-1)*$page_size);
		$query = $this->db->get();
		$result['item_list'] =  $query->result_array();
	
		//不知道为什么这里又不能用case when了
		foreach ($result['item_list'] as $key=>$value){
			
			$result['item_list'][$key]['pass_rate']=round($result['item_list'][$key]['test_count']==0?0:$result['item_list'][$key]['pass_count']*100.0/$result['item_list'][$key]['test_count']).'%';
			//
			$this->db->select('user_id,count(*) as question_count,sum(is_correct) as correct_count');
			$this->db->where('user_id',$value['user_id']);
			$this->db->group_by('user_id');
			$row  = $this->db->get('test_result_detail')->row_array();
			$result['item_list'][$key]['question_count'] = $row['question_count'];
			$result['item_list'][$key]['correct_rate']=round($row['question_count']==0?0:$row['correct_count']*100.0/$row['question_count']).'%';
		}
	
		return $result;
	}
	
	public function get_coin_page($search_string,$company_id,$cur_page,$page_size = 10)
	{
		$result = array();
	
		$this->db->select('user_id,username,name,user.mobile,coin,company_name');
		$this->db->join('company', 'user.company_id = company.company_id');
		$this->db->where('user.del',0);
		if($company_id!=PLATFORM_COMPANY)
		{
			$this->db->where('user.company_id',$company_id);
		}
		if(!empty($search_string))
		{
			$this->db->where("(username LIKE '%$search_string%' OR mobile LIKE '%$search_string%')");
	
		}
		$this->db->order_by('coin','DESC');
		$this->db->order_by('user.company_id');
		$total = $this->db->count_all_results('user',FALSE);
		$result['total']=$total;
	
		$this->db->limit($page_size,($cur_page-1)*$page_size);
		$query = $this->db->get();
		$result['item_list'] =  $query->result_array();
	
	
		return $result;
	}
	
	
	public function get_test_detail_page($test_id,$company_id,$cur_page,$page_size = 10)
	{
		$result = array();
		$test = $this->db->get_where('test',array('test_id'=>$test_id))->row_array();
		$result['test_name']=$test['test_name'];
		
		$this->db->select('test_result_id,test_result.user_id,username,mobile,start_time,end_time,passed');
		$this->db->join('user','test_result.user_id=user.user_id');
		$this->db->where('user.company_id',$company_id);
		$this->db->where('test_id',$test_id);
		
		$this->db->order_by('user_id');
		$total = $this->db->count_all_results('test_result',FALSE);
		$result['total']=$total;
	
		$this->db->limit($page_size,($cur_page-1)*$page_size);
		$query = $this->db->get();
		$result['item_list'] =  $query->result_array();
	
		foreach ($result['item_list'] as $key=>$value){
			
			if(empty($value['end_time'])){
				$result['item_list'][$key]['minute'] = '';
			}else{
				$minute=floor((strtotime($value['end_time'])-strtotime($value['start_time']))%86400/60);
				$result['item_list'][$key]['minute'] = $minute.'分钟';
			}
			$result['item_list'][$key]['passed'] = $value['passed']==1?'是':'否';
			//
			$this->db->select('user_id,count(*) as question_count,sum(is_correct) as correct_count');
			$this->db->where('test_result_id',$value['test_result_id']);
			$this->db->where('user_id',$value['user_id']);
			$this->db->group_by('user_id');
			$row  = $this->db->get('test_result_detail')->row_array();
			$result['item_list'][$key]['question_count'] = $row['question_count'];
			$result['item_list'][$key]['correct_count'] = $row['correct_count'];
			$result['item_list'][$key]['correct_rate']=round($row['question_count']==0?0:$row['correct_count']*100.0/$row['question_count']).'%';
		}
	
		return $result;
	}
	
	public function get_user_detail_page($user_id,$company_id,$cur_page,$page_size = 10)
	{
		$result = array();

	
		$this->db->select('test_result_id,test_result.test_id,test_name,test_result.user_id,username,mobile,test_result.start_time,test_result.end_time,passed');
		$this->db->join('user','test_result.user_id=user.user_id');
		$this->db->join('test','test_result.test_id=test.test_id');
		if($company_id!=PLATFORM_COMPANY)
		{
			$this->db->where('user.company_id',$company_id);
		}
		$this->db->where('test_result.user_id',$user_id);
		$this->db->order_by('test_result.start_time','DESC');
	
		$total = $this->db->count_all_results('test_result',FALSE);
		$result['total']=$total;
	
		$this->db->limit($page_size,($cur_page-1)*$page_size);
		$query = $this->db->get();
		$result['item_list'] =  $query->result_array();
	
		foreach ($result['item_list'] as $key=>$value){
			$result['username'] = $value['username'];
			if(empty($value['end_time'])){
				$result['item_list'][$key]['minute'] = '';
			}else{
				$minute=floor((strtotime($value['end_time'])-strtotime($value['start_time']))%86400/60);
				$result['item_list'][$key]['minute'] = $minute.'分钟';
			}
			$result['item_list'][$key]['passed'] = $value['passed']==1?'是':'否';
			//
			$this->db->select('user_id,count(*) as question_count,sum(is_correct) as correct_count');
			$this->db->where('test_result_id',$value['test_result_id']);
			$this->db->where('user_id',$value['user_id']);
			$this->db->group_by('user_id');
			$row  = $this->db->get('test_result_detail')->row_array();
			$result['item_list'][$key]['question_count'] = $row['question_count'];
			$result['item_list'][$key]['correct_count'] = $row['correct_count'];
			$result['item_list'][$key]['correct_rate']=round($row['question_count']==0?0:$row['correct_count']*100.0/$row['question_count']).'%';
		}
		$result['user']=$this->_get_user_summary($user_id);
		return $result;
	}
	
	private function _get_user_summary($user_id)
	{
		$result=array();
		$user = $this->db->get_where('user',array('user_id'=>$user_id))->row_array();
		$result['username']=$user['username'];
		$result['name']=$user['name'];
		$company = $this->db->get_where('company',array('company_id'=>$user['company_id']))->row_array();
		$result['company_name']=$company['company_name'];
		$this->db->select('*');
		$this->db->where('user_id',$user_id);
		$result['test_count'] = $this->db->count_all_results('test_result');
		$this->db->select('*');
		$this->db->where('user_id',$user_id);
		$result['question_count'] = $this->db->count_all_results('test_result_detail');
		
		$this->db->select('category.category_id,category_name,sum(is_submit) as question_count,sum(is_correct) as correct_count');
		$this->db->join('category','category.category_id = test_result_detail.category_id');
		$this->db->where('user_id',$user_id);
		$this->db->group_by('category_id');
		$this->db->group_by('category_name');
		$this->db->limit(7);
		$rows  = $this->db->get('test_result_detail')->result_array();
		foreach ($rows as $key=>$value){
			//if($value['question_count']!=0 && $value['correct_count']!=0){
				$item['id']=$value['category_id'];
				$item['name']=$value['category_name'];
				$item['value']=$value['question_count']==0?0:$value['correct_count']*100/$value['question_count'];
				$result['cap'][]=$item;
			//}
		}
		
		return $result;
	}
	
	
	
	
}
