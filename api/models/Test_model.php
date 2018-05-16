<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get($condition)
	{
		$query = $this->db->get_where('test',$condition);
		return $query->row_array();
	}
	public function get_test_paper($condition)
	{
		$query = $this->db->get_where('test_paper',$condition);
		return $query->row_array();
	}
	public  function update($data,$condtion)
	{
		return $this->db->update('test', $data, $condtion);
	}
	
	public function  insert($data)
	{
		$this->db->insert('test', $data);
		return $this->db->insert_id();
	}
	
	public function get_test_info($test_id)
	{
		$this->db->select('test_id,test_name,test.test_paper_id,cover_url,question_count,difficulty,description,user_count,pass_count,test.create_at');
		$this->db->from('test');
		$this->db->join('test_paper','test_paper.test_paper_id=test.test_paper_id');
		$this->db->where('test.del',0);
		$this->db->where('test.test_id',$test_id);
		
		$query = $this->db->get();
		$result =  $query->row_array();
		
		return $result;
	}
	
	
	public function search($type,$keyword,$tag_id,$cur_page,$page_size){
		$this->db->select('test_id,test_name,test_paper.cover_url,test_paper.question_count,user_count,pass_count,test.create_at');
		$this->db->from('test');
		$this->db->join('test_paper','test_paper.test_paper_id=test.test_paper_id');
		$this->db->where('test.del',0);
		$this->db->where('test.company_id',1);//1为平台公司
		if(!empty($tag_id)){
			$this->db->where('test.test_paper_id in (select test_paper_id from test_paper_tag where tag_id in ('.$tag_id.'))');//
		}
		if(!empty($keyword)){
			$this->db->like('test_name',$keyword);
		}
		if($type==1){
			$this->db->order_by('user_count', 'DESC');
			$this->db->order_by('test.update_at', 'DESC');
		}else if($type==2){
			$this->db->order_by('test_id', 'DESC');
		}else{
			$this->db->order_by('test.update_at', 'DESC');
		}
		
		$this->db->limit($page_size,($cur_page-1)*$page_size);
		$query = $this->db->get();
		$result =  $query->result_array();
		
		return $result;
	}
	
	public function search_question($keyword,$cur_page,$page_size){
		$this->db->select("question_id,question,case type when 1 then '单选题' when 2 then '多选题' end as type_name,category_name,question.create_at");
		$this->db->from('question');
		$this->db->join('category','question.category_id=category.category_id');
		$this->db->where('question.company_id',1);
		$this->db->where('question.del',0);
		if(!empty($keyword)){
			$this->db->like('question',$keyword);
			
		}
		$this->db->order_by('question_id', 'DESC');
		$this->db->limit($page_size,($cur_page-1)*$page_size);
		$query = $this->db->get();
		$result =  $query->result_array();
	
		return $result;
	}
	
	public function  insert_search_history($data)
	{
		$this->db->insert('search_history', $data);
		return $this->db->insert_id();
	}
	
	public function get_hot_keyword()
	{
		$this->db->select('keyword,count(keyword) as count');
		$this->db->from('search_history');
		$this->db->where('type',3);//试题
		$this->db->group_by('keyword');
		$this->db->order_by('count','DESC');
		$this->db->limit(5,0);
		$query = $this->db->get();
		$result =  $query->result_array();
		$keyword=array();
		foreach ($result as $key=>$value){
			$keyword[]=$value['keyword'];
		}
		return $keyword;
	}
	public function get_daily_question_list($user_id,$test_id,$daily_category='',$daily_count=0)
	{
		$result = array();
		
		
		$result['test_result_id']='';
		$result['test_id']=1;
		$result['user_id']=$user_id;
		$result['test_name']='每日一试';
		$result['start_time']='';
		$result['end_time']='';
		$result['question_count']=$daily_count;
		$result['answered_count']=0;
		$result['is_submit']=0;
		
		$cats = explode(',',$daily_category);//先简单点
		
		$this->db->select('*');
		$this->db->where_in('category_id',$cats);
		$query = $this->db->get('question');
		$rs = $query->result_array();
		
		if(empty($rs)){
			$this->db->select('*');
			$query = $this->db->get('question');
			$rs = $query->result_array();
		}
		if(empty($rs)){
			return (object)array();
		}
		
		shuffle($rs);
		$question_list =  array_slice($rs, 0 , $daily_count);
		

		$no=1;
		foreach ($question_list as $key =>$value){
			$result['question_list'][$key]['question_id']=$value['question_id'];
			$result['question_list'][$key]['question_no']=$no;
			$result['question_list'][$key]['question']=$value['question'];
			$result['question_list'][$key]['category_id']=$value['category_id'];
			$result['question_list'][$key]['type']=$value['type'];
			$result['question_list'][$key]['type_name']=$value['type']==1?'单选':'多选';
			$result['question_list'][$key]['answer']='';
			$result['question_list'][$key]['user_answer']='';
			$choice_list  = $this->_get_choice_list($value['question_id']);
			$result['question_list'][$key]['choice_list']=$choice_list;
			$no++;
		}
		
		//初始化结果表
		$this->_insert_test_result($user_id, $result);
		
		return empty($result)?(object)$result:$result;
	}
	

	public function get_question_list($user_id,$test_id,$test_result_id)
	{
		//
		$result = array();
		//如果没做完
		if(empty($test_result_id)){
			$tr = $this->db->get_where('test_result',array('user_id'=>$user_id, 'test_id'=>$test_id,'is_submit'=>0))->row_array();
			if(!empty($tr)){
				$test_result_id = $tr['test_result_id'];
			}
		}

		if(!empty($test_result_id)){
			$tr = $this->db->get_where('test_result',array('test_result_id'=>$test_result_id))->row_array();
			if(!empty($tr)){
				$test = $this->get(array('test_id'=>$tr['test_id']));
				$result['test_result_id']=$tr['test_result_id'];
				$result['test_id']=$test['test_id'];
				$result['user_id']=$tr['user_id'];
				$result['test_name']=$test['test_name'];
				$result['start_time']=$tr['start_time'];
				$result['end_time']=$tr['end_time'];
				$result['question_count']=$tr['question_count'];
				$result['answered_count']=0;
				$result['is_submit']=$tr['is_submit'];
			
				$question_list = $this->_get_test_result_detail($tr['test_result_id']);
				foreach ($question_list as $key =>$value){
					$result['question_list'][$key]['question_id']=$value['question_id'];
					$result['question_list'][$key]['question_no']=$value['no'];
					$result['question_list'][$key]['question']=$value['question'];
					$result['question_list'][$key]['answer']=$tr['is_submit']?$value['answer']:'';
					$result['question_list'][$key]['user_answer']=$value['user_answer'];
					$result['question_list'][$key]['type']=$value['type'];
					$result['question_list'][$key]['type_name']=$value['type']==1?'单选':'多选';
					$choice_list  = $this->_get_choice_list($value['question_id']);
					$result['question_list'][$key]['choice_list']=$choice_list;
					$result['question_list'][$key]['analysis']=$tr['is_submit']?$value['analysis']:'';
			
					if($value['is_submit']){
						$result['answered_count']++;
					}
				}
			
			}
			
			return empty($result)?(object)$result:$result;
		}
		//

		//如果test_id=1非法,需要使用 get_daily_question_list生成问题
		if($test_id==1){
			return empty($result)?(object)$result:$result;
		}
		//新的
		$test = $this->get(array('test_id'=>$test_id));
		if(!empty($test)){
				
			$result['test_result_id']='';
			$result['test_id']=$test['test_id'];
			$result['user_id']=$user_id;
			$result['test_name']=$test['test_name'];
			$result['start_time']='';
			$result['end_time']='';
			$result['question_count']=0;
			$result['answered_count']=0;
			$result['is_submit']=0;
			
			$test_paper = $this->get_test_paper(array('test_paper_id'=>$test['test_paper_id']));
			if($test_paper['type']==1){//手动添加的固定题目
				$question_list = $this->_get_test_question_list($test_paper['test_paper_id']);
				$no=0;
				foreach ($question_list as $key =>$value){
					$result['question_list'][$key]['question_id']=$value['question_id'];
					$result['question_list'][$key]['question_no']=$no+1;
					$result['question_list'][$key]['question']=$value['question'];
					$result['question_list'][$key]['category_id']=$value['category_id'];
					$result['question_list'][$key]['type']=$value['type'];
					$result['question_list'][$key]['type_name']=$value['type']==1?'单选':'多选';
					$result['question_list'][$key]['answer']='';
					$result['question_list'][$key]['user_answer']='';
					$choice_list  = $this->_get_choice_list($value['question_id']);
					$result['question_list'][$key]['choice_list']=$choice_list;
					$result['question_list'][$key]['analysis']='';
					$no++;
				}
				$result['question_count']=$no;
			}else{//抽题规则抽题
				
				$rule_list = $this->_get_test_paper_rule_list($test_paper['test_paper_id']);
				$no=0;
				foreach ($rule_list as $key=>$value){
					$question_list = $this->_select_question(array('category_id'=>$value['category_id'],'type'=>$value['type'],'del'=>0),$value['count']);
					foreach ($question_list as $key2 =>$value2){
						$result['question_list'][$no]['question_id']=$value2['question_id'];
						$result['question_list'][$no]['question_no']= $no+1;
						$result['question_list'][$no]['question']=$value2['question'];
						$result['question_list'][$no]['category_id']=$value2['category_id'];
						$result['question_list'][$no]['type']=$value2['type'];
						$result['question_list'][$no]['type_name']=$value2['type']==1?'单选':'多选';
						$result['question_list'][$no]['answer']='';
						$result['question_list'][$no]['user_answer']='';
						$choice_list  = $this->_get_choice_list($value2['question_id']);
						$result['question_list'][$no]['choice_list']=$choice_list;
						$result['question_list'][$no]['analysis']='';
						$no++;
					}
				}
				$result['question_count']=$no;
				
			}
			//初始化结果表
			$this->_insert_test_result($user_id, $result);
			//如果是任务测试，则在任务表中记录test_result_id
			$this->_update_test_task($user_id,$test_id,$result['test_result_id']);
			
		}
		
		return empty($result)?(object)$result:$result;
	}
	
	public function update_test_result_detail($data,$condition)
	{
		return $this->db->update('test_result_detail', $data, $condition);
	}
	
	public function get_answer($test_result_id){
		$result = array();
		$tr = $this->db->get_where('test_result',array('test_result_id'=>$test_result_id))->row_array();
		if(!empty($tr)){
			$test = $this->get(array('test_id'=>$tr['test_id']));
			$result['test_result_id']=$tr['test_result_id'];
			$result['test_id']=$test['test_id'];
			$result['user_id']=$tr['user_id'];
			$result['test_name']=$test['test_name'];
			$result['start_time']=$tr['start_time'];
			$result['end_time']=$tr['end_time'];
			$result['question_count']=$tr['question_count'];
			$result['answered_count']=0;
				
			$question_list = $this->_get_test_result_detail($tr['test_result_id']);
			foreach ($question_list as $key =>$value){
				$result['question_list'][$key]['question_id']=$value['question_id'];
				$result['question_list'][$key]['question_no']=$value['no'];
				$result['question_list'][$key]['question']=$value['question'];
				$result['question_list'][$key]['answer']=$tr['is_submit']?$value['answer']:'';
				$result['question_list'][$key]['user_answer']=$value['user_answer'];
				$result['question_list'][$key]['type']=$value['type'];
				$result['question_list'][$key]['type_name']=$value['type']==1?'单选':'多选';
				$choice_list  = $this->_get_choice_list($value['question_id']);
				$result['question_list'][$key]['choice_list']=$choice_list;
				$result['question_list'][$key]['analysis']=$value['analysis'];
				
				if($value['is_submit']){
					$result['answered_count']++;
				}
			}
			
		}
		return empty($result)?(object)$result:$result;
	}
	
	public  function get_test_paper_tag()
	{
		$this->db->select('tag_id,tag_name');
		$this->db->where('type',1);
		$query = $this->db->get('tag');
		return $query->result_array();
	}
	
	public function reset($user_id,$test_id)
	{
		if($test_id==1){
			return;
		}
		//如果已经做过
		$tr = $this->db->get_where('test_result',array('user_id'=>$user_id, 'test_id'=>$test_id))->row_array();
		if(!empty($tr)){
			$this->db->delete('test_result_detail',array('test_result_id'=>$tr['test_result_id']));
			$this->db->delete('test_result',array('test_result_id'=>$tr['test_result_id']));
		}
	}
	public function submit_test($user_id,$test_result_id)
	{
		$result = array();
		//如果已经做过
		$tr = $this->db->get_where('test_result',array('user_id'=>$user_id, 'test_result_id'=>$test_result_id,'is_submit'=>0))->row_array();
		if(!empty($tr)){
			$test = $this->get(array('test_id'=>$tr['test_id']));
			$tp = $this->get_test_paper(array('test_paper_id'=>$test['test_paper_id']));
			$data['is_submit'] = 1;
			$data['end_time']=TIME_NOW;
			$data['update_at']=TIME_NOW;
			//计算得分			
			$score = $this->_get_test_result_score($tr['test_result_id']);
			$data['score']=$score['point'];
			if($tr['test_id']==1){//平台每日一试
				if($data['score']>=$tr['question_count']*0.6){//每日一试，一题一分，60%合格
					$data['passed']=1;
				}else{
					$data['passed']=0;
				}
			}else{
				if($data['score']>=$tp['cutoff']){
					$data['passed']=1;
				}else{
					$data['passed']=0;
				}
			}
			
			$this->db->update('test_result',$data,array('test_result_id'=>$tr['test_result_id']));
			
			$this->db->update('test',array('user_count'=>$test['user_count']+1,
					'pass_count'=>$test['pass_count']+$data['passed'],'update_at'=>TIME_NOW),
					array('test_id'=>$tr['test_id']));
			
			$result['test_result_id']=$tr['test_result_id'];
			$result['test_id']=$test['test_id'];
			$result['test_name']=$test['test_name'];
			$result['test_result']=$data['passed']==1?'合格':'不合格';
			$hour=floor((strtotime($data['end_time'])-strtotime($tr['start_time']))%86400/3600);
			$minute=floor((strtotime($data['end_time'])-strtotime($tr['start_time']))%3600/60);
			$second=floor((strtotime($data['end_time'])-strtotime($tr['start_time']))%60);
			$result['time_used']=$hour.'小时'.$minute.'分'.$second.'秒';
		}
		
		return empty($result)?(object)$result:$result;;
	}
	
	public function get_tag_list($test_paper_id)
	{
		$this->db->select('tag.tag_id,tag_name');
		$this->db->from('test_paper_tag');
		$this->db->join('tag', 'test_paper_tag.tag_id = tag.tag_id');
		$this->db->where('test_paper_tag.test_paper_id',$test_paper_id);
		$this->db->order_by("tag.tag_id");
		$query = $this->db->get();
		$rs = $query->result_array();
		
		return $rs;
	}
	
	public  function get_question($question_id)
	{
		$this->db->select("question_id,question,answer,analysis,type,case type when 1 then '单选题' when 2 then '多选题' end as type_name,category_name,question.create_at");
		$this->db->from('question');
		$this->db->join('category','question.category_id=category.category_id');
		$this->db->where('question.question_id',$question_id);
		$query = $this->db->get();
		$result =  $query->row_array();
		$choice_list  = $this->_get_choice_list($result['question_id']);
		$result['choice_list']=$choice_list;
		
		return $result;
	}
	/**
	 * 获取用户测试相关的统计，测试数，问题数等
	 */
	public function get_user_test_count($user_id)
	{
		$result = array();
		$this->db->select('*');
		$this->db->where('user_id',$user_id);
		$total = $this->db->count_all_results('test_result');
		$result['test_count'] = $total;
	
		$this->db->select('*');
		$this->db->where('user_id',$user_id);
		$total = $this->db->count_all_results('test_result_detail');
		$result['question_count']=$total;
		return $result;
	}
	private function _get_test_question_list($test_paper_id)
	{
	
		$this->db->select('question.*');
		$this->db->from('test_question');
		$this->db->join('question', 'test_question.question_id = question.question_id');
		$this->db->where('test_question.test_paper_id',$test_paper_id);
		$this->db->order_by("question.type");
		$query = $this->db->get();
		$rs = $query->result_array();
	
		return $rs;
	}
	
	private function  _get_choice_list($question_id)
	{

		$this->db->select('choice_id,option_name,content');
		$this->db->from('choice');
		$this->db->where('question_id',$question_id);
		$query = $this->db->get();
		$rs = $query->result_array();
		
		return $rs;
	}
	private function _get_test_paper_rule_list($test_paper_id)
	{
		$this->db->select('*');
		$this->db->where('test_paper_id',$test_paper_id);
		$query = $this->db->get('test_paper_rule');
		$rs = $query->result_array();
		return $rs;
	}
	
	private function _select_question($condition,$count)
	{
		$query = $this->db->get_where('question',$condition);
		$rs = $query->result_array();
		
		shuffle($rs);
		return array_slice($rs, 0 , $count);
	}
	
	private function _get_test_result_detail($test_result_id){
		$this->db->select('question.*,no,is_submit,user_answer');
		$this->db->from('test_result_detail');
		$this->db->join('question', 'test_result_detail.question_id = question.question_id');
		$this->db->where('test_result_detail.test_result_id',$test_result_id);
		$this->db->order_by("test_result_detail.no");
		$query = $this->db->get();
		return $rs = $query->result_array();
	}
	
	private function _get_test_result_score($test_result_id){
		$this->db->select_sum('point');
		$this->db->from('test_result_detail');
		$this->db->where('test_result_id',$test_result_id);
		$this->db->where('is_correct',1);
		$query = $this->db->get();
		return $rs = $query->row_array();
	}
	
	private function _insert_test_result($user_id,&$result)
	{
		$type_point =  $this->_get_test_paper_point($result['test_id']);
		
		$this->db->insert('test_result',array('user_id'=>$user_id,'test_id'=>$result['test_id'],
				'start_time'=>TIME_NOW,'question_count'=>$result['question_count']));
		$id = $this->db->insert_id();
		$result['test_result_id']=$id;
		$result['start_time']=TIME_NOW;
		$result['end_time']='';
		foreach($result['question_list'] as $key=>$value){
			$this->db->insert('test_result_detail',array('test_result_id'=>$id,'user_id'=>$user_id,'test_id'=>$result['test_id'],
				'no'=>$value['question_no'],'question_id'=>$value['question_id'],'category_id'=>$value['category_id'],
					'point'=>isset($type_point[$value['type']])?$type_point[$value['type']]:1
			));
			unset($result['question_list'][$key]['category_id']);
		}
		
	}
	
	private function _get_test_paper_point($test_id)
	{
		$test = $this->get(array('test_id'=>$test_id));
		$tpp = $this->db->get_where('test_paper_point',array('test_paper_id'=>$test['test_paper_id']))->result_array();
		$result = array();
		foreach($tpp as $key=>$value){
			$result[$value['type']]=$value['point'];
		}
		return $result;
	}
	
	private function _update_test_task($user_id,$test_id,$test_result_id)
	{
		$this->db->select('*');
		$this->db->where('user_id',$user_id);
		$this->db->where('test_id',$test_id);
		$this->db->order_by('test_task_id','DESC');
		$this->db->limit(1);
		$row = $this->db->get('test_task')->row_array();
		if(!empty($row)){
			if(empty($row['test_result_id'])){
				$data['test_result_id']=$test_result_id;
				$data['update_at']=TIME_NOW;
				$this->db->update('test_task',$data,array('test_task_id'=>$row['test_task_id']));
			}
		}
	}
	
	public function get_user_summary($user_id)
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
		$this->db->join('category','category.category_id = test_result_detail.category_id','right');
		$this->db->where('user_id',$user_id);
		$this->db->group_by('category_id');
		$this->db->group_by('category_name');
		$this->db->order_by('category_id');
		$this->db->limit(7);
		$rows  = $this->db->get('test_result_detail')->result_array();
		$count=0;
		foreach ($rows as $key=>$value){
			$item['id']=$value['category_id'];
			$item['name']=$value['category_name'];
			$item['value']=$value['question_count']==0?0:round($value['correct_count']*5/$value['question_count'],1);
			$result['cap'][]=$item;
			$count++;
		}
		//
		$this->db->select('category_id,category_name');
		$this->db->order_by('category_id');
		$this->db->limit(7);
		$rows  = $this->db->get('category')->result_array();
		for($i=0;$i<count($rows);$i++){
			$cat_id = $rows[$i]['category_id'];
			$found = FALSE;
			if(!empty($result['cap'])){
				for($j=0;$j<count($result['cap']);$j++){
					if($result['cap'][$j]['id']==$cat_id){
						$found = TRUE;
						break;
					}
				}
			}
			
			if(!$found){
				$item['id']=$rows[$i]['category_id'];
				$item['name']=$rows[$i]['category_name'];
				$item['value']=0;
				$result['cap'][]=$item;
			}
		}
		//
		$result['ranking']=1;
		$result['question_count']=0;
		$result['ranking_change']=0;
		$result['question_change']=0;
		$result['question_change_percent']='0%';
		//
		$this->db->select('user_id,sum(is_submit) as question_count');
		$this->db->where('update_at <',date("Y-m-d 23:59:59",time()));
		$this->db->group_by('user_id');
		$this->db->order_by('question_count','DESC');
		$rows  = $this->db->get('test_result_detail')->result_array();

		foreach ($rows as $key=>$value){
			if($value['user_id']==$user_id){
				$result['ranking']=$key+1;
				$result['question_count']=$value['question_count'];
				break;
			}
		}
		//
		$this->db->select('user_id,sum(is_submit) as question_count');
		$this->db->where('update_at <',date("Y-m-d 23:59:59",time()-24*3600));
		$this->db->group_by('user_id');
		$this->db->order_by('question_count','DESC');
		$rows  = $this->db->get('test_result_detail')->result_array();
		foreach ($rows as $key=>$value){
			if($value['user_id']==$user_id){
				$result['ranking_change']=$result['ranking']-($key+1);
				$result['question_change']=$result['question_count']-$value['question_count'];
				$result['question_change_percent']=round($value['question_count']==0?0:$result['question_change']*100/$value['question_count'],1).'%';
				break;
			}
		}
		return $result;
	}
	
	
}
