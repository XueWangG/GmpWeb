<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Question_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get($condition)
	{
		$query = $this->db->get_where('question',$condition);
		return $query->row_array();
	}
	
	public function get_category($condition)
	{
		$query = $this->db->get_where('category',$condition);
		return $query->row_array();
	}
	public function get_difficulty($condition)
	{
		$query = $this->db->get_where('question_difficulty',$condition);
		return $query->row_array();
	}
	public function get_sop($condition)
	{
		$query = $this->db->get_where('question_sop',$condition);
		return $query->row_array();
	}
	
	public function get_attribute_name($type,$id)
	{
		if($type==1){
			$query = $this->db->get_where('category',array('category_id'=>$id));
			$rs =  $query->row_array();
			return !empty($rs)?$rs['category_name']:'';
		}else if($type==2){
			$query = $this->db->get_where('question_difficulty', array('difficulty_id'=>$id));
			$rs = $query->row_array();
			return !empty($rs)?$rs['difficulty_name']:'';
		}else if($type==3){
			$query = $this->db->get_where('question_sop', array('sop_id'=>$id));
			$rs =  $query->row_array();
			return !empty($rs)?$rs['sop_name']:'';
		}
	}
	
	public function  insert($data)
	{
		return $this->insert_data('question',$data);
	}
	public function insert_choice($data)
	{
		return $this->insert_data('choice',$data);
	}
	
	public function  insert_attribute($type,$data)
	{
		if($type==1){
			return $this->insert_data('category',$data);
		}else if($type==2){
			return $this->insert_data('question_difficulty',$data);
		}else if($type==3){
			return $this->insert_data('question_sop',$data);
		}
		
	}
	
	public function  update_attribute($type,$id,$data)
	{
		if($type==1){
			return $this->db->update('category',$data, array('category_id'=>$id));
		}else if($type==2){
			return $this->db->update('question_difficulty',$data, array('difficulty_id'=>$id));
		}else if($type==3){
			return $this->db->update('question_sop',$data, array('sop_id'=>$id));
		}
	
	}
	public function  delete_attribute($type,$id)
	{
		if($type==1){
			return $this->db->update('category',array('del'=>1), array('category_id'=>$id));
		}else if($type==2){
			return $this->db->update('question_difficulty', array('del'=>1), array('difficulty_id'=>$id));
		}else if($type==3){
			return $this->db->update('question_sop', array('del'=>1), array('sop_id'=>$id));
		}
	
	}

	
	public function create_question($question,$choice_content,$choice_no)
	{
		$this->db->trans_start();
		$this->db->insert('question',$question);
		$question_id = $this->db->insert_id();
		for($i=0;$i<count($choice_content);$i++)
		{
			$choice = array();
			$choice['question_id']=$question_id;
			$choice['content']=$choice_content[$i];
			$choice['option_name']=$choice_no[$i];
			$this->insert_choice($choice);
		}
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === FALSE)
		{
			log_message('error', 'create_question 插入试题数据出错');
			return FALSE;
		}else
		{
			return $question_id;
		}
	}
	
	public function update_question($question_id,$question_data,$choice_content,$choice_no)
	{
		$this->db->trans_start();
		$this->db->update('question',$question_data,array('question_id'=>$question_id));
		$this->db->delete('choice',array('question_id'=>$question_id));
		
		for($i=0;$i<count($choice_content);$i++)
		{
			$choice = array();
			$choice['question_id']=$question_id;
			$choice['content']=$choice_content[$i];
			$choice['option_name']=$choice_no[$i];
			$this->insert_choice($choice);
		}
		$this->db->trans_complete();
	
		if ($this->db->trans_status() === FALSE)
		{
			log_message('error', 'update_question 更新试题数据出错');
			return FALSE;
		}else
		{
			return $question_id;
		}
	}
	
	
	public function get_category_list($company_id=1,$count=100)
	{
		$this->db->select('category_id,category_name');
		$this->db->from('category');
		$this->db->where('company_id',$company_id);
		$this->db->where('del',0);
		$this->db->limit($count,0);
		$query = $this->db->get();
		$result =  $query->result_array();	
		return $result;
	}
	
	public function get_difficulty_list($company_id=1,$count=100)
	{
		$this->db->select('difficulty_id,difficulty_name');
		$this->db->from('question_difficulty');
		$this->db->where('company_id',$company_id);
		$this->db->where('del',0);
		$this->db->limit($count,0);
		$query = $this->db->get();
		$result =  $query->result_array();
		return $result;
	}
	
	public function get_sop_list($company_id=1,$count=100)
	{
		$this->db->select('sop_id,sop_name');
		$this->db->from('question_sop');
		$this->db->where('company_id',$company_id);
		$this->db->where('del',0);
		$this->db->limit($count,0);
		$query = $this->db->get();
		$result =  $query->result_array();
		return $result;
	}

	public function get_question_detail($question_id)
	{
		$this->db->select("question.*,case question.type when 1 then '单选题' when 2 then '多选题' else '未知题型' end as type_name,
				category_name,difficulty_name,sop_name");
		$this->db->from('question');
		$this->db->join('category', 'question.category_id = category.category_id');
		$this->db->join('question_difficulty', 'question_difficulty.difficulty_id = question.difficulty_id');
		$this->db->join('question_sop', 'question_sop.sop_id = question.sop_id');
		$this->db->where('question_id',$question_id);
		$query = $this->db->get();
		$question =  $query->row_array();
		$result['question'] = $question;
		
		$query = $this->db->get_where('choice',array('question_id'=>$question_id));
		$result['choice'] =$query->result_array();
		return $result;
	}

	private function insert_data($table,$data)
	{
		$flag = $this->db->insert($table, $data);
		if($flag)
		{
			return $this->db->insert_id();
		}else{
			return $flag;
		}
	}
	
	public function get_question_page($type,$category_id,$cur_page,$page_size = 10)
	{		
		$result = array();
	
		$this->db->select("question_id,question.category_id,category_name,case type when 1 then '单选题' when 2 then '多选题' end as type,
				difficulty_name,sop_name,question,question.create_at,question.update_at");
		$this->db->join('category', 'question.category_id = category.category_id');
		$this->db->join('question_difficulty', 'question_difficulty.difficulty_id = question.difficulty_id');
		$this->db->join('question_sop', 'question_sop.sop_id = question.sop_id');
		$this->db->where('question.del',0);//未删除
		if($category_id!=0)
		{
			$this->db->where('question.category_id', $category_id);
		}
		if($type!=0)
		{
			$this->db->where('type', $type);
		}
		$this->db->order_by('question_id', 'DESC');
		
		$total = $this->db->count_all_results('question',FALSE);
		$result['total']=$total;
		
		$this->db->limit($page_size,($cur_page-1)*$page_size);
		$query = $this->db->get();
		$result['item_list'] =  $query->result_array();
		
		return $result;
	}
	public function delete($condition)
	{
		return $this->db->update('question', array('del'=>1), $condition);
	}

	public function get_ready_for_testpaper($qtype, $cat,$testpaperId, $num=0, $offset=0)
	{
		$this->db->where('type',$qtype);
		if($cat)
		{
			$this->db->where('category_id',$cat);
		}

		$this->db->where('del',0);
		$this->db->where('question_id NOT IN (SELECT question_id FROM test_question WHERE test_paper_id='.$testpaperId.')');
		if($num)
		{
			$this->db->limit($num, $offset);
		}
		$query = $this->db->get('question');
		$rs = $query->result_array();
		return $rs;
	}
	
	function get_random_for_testpaper($qtype, $cat)
	{
		$this->db->where('type',$qtype);
		if($cat)
		{
			$this->db->where('category_id',$cat);
		}

		$this->db->where('del',0);
	
		$query = $this->db->get('question');
		$rs = $query->result_array();
		return $rs;
	}

	
		
}
