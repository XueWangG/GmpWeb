<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testpaper_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get($condition)
	{
		$query = $this->db->get_where('test_paper',$condition);
		return $query->row_array();
	}
	public function get_list($company_id=1,$num=500,$offset=0)
	{
		$this->db->select('*');
		$this->db->from('test_paper');
		$this->db->where('del',0);//未删除
		$this->db->where('company_id',$company_id);
		$this->db->order_by('test_paper_id', 'DESC');
		
		$this->db->limit($num,$offset);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	
	public function name_exist($name,$cur_test_paper_id=0)
	{
		$query = $this->db->get_where('test_paper',array('test_paper_name'=>$name,'del'=>0));
		if($cur_test_paper_id==0){//新增
			return !empty($query->row_array());
		}else{//更新检查
			$row = $query->row_array();
			if((!empty($row))&& $row['test_paper_id']!=$cur_test_paper_id){
				return TRUE;
			}else {
				return  FALSE;
			}
		}
		
	}
	
	public function get_sop($condition)
	{
		$query = $this->db->get_where('question_sop',$condition);
		return $query->row_array();
	}
	
	public function  insert($data)
	{
		return $this->insert_data('test_paper',$data);
	}
	public function insert_test_paper_point($data)
	{
		return $this->insert_data('test_paper_point',$data);
	}
	public function insert_test_question($data)
	{
		return $this->insert_data('test_question',$data);
	}
	public function insert_test_paper_rule($data)
	{
		return $this->insert_data('test_paper_rule',$data);
	}

	
	public function create_question($question,$choice_content,$choice_no)
	{
		$this->db->trans_start();
		$this->db->insert('test_paper',$question);
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
	
	public function update($data,$condition)
	{
		$this->db->update('test_paper',$data,$condition);
		
	}
	
	
	
	public function get_point_list($test_paper_id)
	{
		$this->db->select('*');
		$this->db->where('test_paper_id',$test_paper_id);
		$query = $this->db->get('test_paper_point');
		$result =  $query->result_array();
		return $result;
	}
	
	public function get_sop_list($count=100)
	{
		$this->db->select('sop_id,sop_name');
		$this->db->from('question_sop');
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
		$this->db->from('test_paper');
		$this->db->join('category', 'question.category_id = category.category_id');
		$this->db->join('question_difficulty', 'question_difficulty.difficulty_id = question.difficulty_id');
		$this->db->join('question_sop', 'question_sop.sop_id = question.sop_id');
		$this->db->where('question_id',$question_id);
		$query = $this->db->get();
		$question =  $query->row_array();
		$result['test_paper'] = $question;
		
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
	
	public function get_testpaper_page($company_id,$cur_page,$page_size = 10)
	{		
		$result = array();
	
		$this->db->select('*');
		$this->db->where('del',0);//未删除
		$this->db->where('company_id',$company_id);
		$this->db->order_by('test_paper_id', 'DESC');
		
		$total = $this->db->count_all_results('test_paper',FALSE);
		$result['total']=$total;
		
		$this->db->limit($page_size,($cur_page-1)*$page_size);
		$query = $this->db->get();
		$result['item_list'] =  $query->result_array();
		
		return $result;
	}
	public function delete($condition)
	{
		return $this->db->update('test_paper', array('del'=>1), $condition);
	}
	
	public function delete_test_question($test_paper_id,$question_id)
	{
		$this->db->where('test_paper_id', $test_paper_id);
		$this->db->where('question_id',$question_id);
		$this->db->delete('test_question');
		
	}
	public function delete_test_paper_rule($rule_id)
	{
		$this->db->where('rule_id',$rule_id);
		$this->db->delete('test_paper_rule');
	}
	/**
	 * 删除所有题型分值
	 * @param unknown $test_paper_id
	 */
	public function delete_point_list($test_paper_id)
	{
		$this->db->where('test_paper_id',$test_paper_id);
		$this->db->delete('test_paper_point');
	}

	function get_question_count($test_paper_id, $type=0)
	{
		$this->db->select('COUNT(*) as cnt');
		$this->db->from('test_question');
		$this->db->join('question', 'question.question_id = test_question.question_id');
		$this->db->where('test_question.test_paper_id',$test_paper_id);
		if($type!=0){
			$this->db->where('question.type',$type);
		}
		
		$query = $this->db->get();
		$rs = $query->result_array();
		return $rs['0']['cnt'];
	}
	
	function get_point($testpaperId, $type)
	{
		$this->db->select('point');
		$this->db->where('test_paper_id',$testpaperId);
		$this->db->where('type',$type);
		$query = $this->db->get('test_paper_point');
		$rs = $query->result_array();
		return $rs?$rs[0]['point']:0;
	}

	function get_question_count_from_rule($testpaperId,$type=0)
	{
		$this->db->select('sum(count) as cnt');
		$this->db->from('test_paper_rule');
		$this->db->where('test_paper_id',$testpaperId);
		if($type!=0){
			$this->db->where('type',$type);
		}
		$query = $this->db->get();
		$rs = $query->result_array();
		return $rs[0]['cnt']?$rs[0]['cnt']:0;
	}
	public function get_test_question_list($test_paper_id)
	{
		
		$this->db->select('question.*,category_name');
		$this->db->from('test_question');
		$this->db->join('question', 'test_question.question_id = question.question_id');
		$this->db->join('category','question.category_id = category.category_id');
		$this->db->where('test_question.test_paper_id',$test_paper_id);
		$this->db->order_by("question.type");
		$this->db->order_by("question.category_id");
		$query = $this->db->get();
		$rs = $query->result_array();
		
		return $rs;
	}
	function get_test_paper_rule_list($test_paper_id)
	{
		$this->db->select('test_paper_rule.*,category_name');
		$this->db->join('category','test_paper_rule.category_id = category.category_id');
		$this->db->where('test_paper_id',$test_paper_id);
		$query = $this->db->get('test_paper_rule');
		$rs = $query->result_array();
		return $rs;
	}
	function rule_exist($testpaperId, $cat,  $type)
	{
		$this->db->where('test_paper_id', $testpaperId);
		$this->db->where('category_id', $cat);
		$this->db->where('type', $type);
		$query = $this->db->get('test_paper_rule');
		$rs = $query->result_array();
		return $rs?TRUE:FALSE;
	}
	public function insert_tag($test_paper_id,$tag_name)
	{
		//先将试卷标签全删除
		$this->db->where('test_paper_id',$test_paper_id);
		$this->db->delete('test_paper_tag');
		//
		
		$tags = explode(',', $tag_name);
		foreach ($tags  as $key=>$value){
			$row = $this->db->get_where('tag',array('tag_name'=>trim($value)))->row_array();
			if(empty($row)){
				$tag_id = $this->insert_data('tag',array('tag_name'=>trim($value),'type'=>1));
				$this->insert_data('test_paper_tag', array('test_paper_id'=>$test_paper_id,'tag_id'=>$tag_id));
			}else{
				$this->insert_data('test_paper_tag', array('test_paper_id'=>$test_paper_id,'tag_id'=>$row['tag_id']));
			}
		}
	}
	public function get_tag($test_paper_id)
	{
		$this->db->select('tag_name');
		$this->db->join('test_paper_tag','tag.tag_id=test_paper_tag.tag_id');
		$this->db->where('test_paper_tag.test_paper_id',$test_paper_id);
		$query = $this->db->get('tag');
		$result = $query->result_array();
		$str ='';
		foreach($result as $key=>$value){
			$str.=','.$value['tag_name'];
		}
		return trim($str,',');
	}
	
}
