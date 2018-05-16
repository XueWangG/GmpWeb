<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Topic_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get($condition)
	{
		$query = $this->db->get_where('topic',$condition);
		return $query->row_array();
	}
	
	public function  insert($data)
	{
		return $this->insert_data('topic',$data);
	}
	
	public function  get_compiled_insert($data)
	{
		return  $this->db->set($data)->get_compiled_insert('topic');
	
	}
	
	public function  insert_topic_answer($data)
	{		
		$this->db->trans_start();
		$this->db->insert('topic_answer',$data);
		$topic_follower_id = $this->db->insert_id();
		$topic = $this->db->get_where('topic',array('topic_id'=>$data['topic_id']))->row_array();
		$this->db->where('topic_id', $data['topic_id']);
		$this->db->update('topic', array('answer_count'=>$topic['answer_count']+1,'update_at'=>TIME_NOW));
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === FALSE)
		{
			log_message('debug', 'sql  '.$this->db->set($data)->get_compiled_insert('topic_follower'));
			return FALSE;
		}else
		{
			return $topic_follower_id;
		}
				
	}
	public function insert_answer_comment($data)
	{

		$this->db->trans_start();
		$this->db->insert('answer_comment',$data);
		$id = $this->db->insert_id();
		$dd = $this->db->get_where('topic_answer',array('topic_answer_id'=>$data['topic_answer_id']))->row_array();
		$this->db->where('topic_answer_id', $dd['topic_answer_id']);
		$this->db->update('topic_answer', array('comment_count'=>$dd['comment_count']+1,'update_at'=>TIME_NOW));
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === FALSE)
		{
			log_message('debug', 'sql  '.$this->db->set($data)->get_compiled_insert('answer_comment'));
			return FALSE;
		}else
		{
			return $id;
		}
		
	}
	public function  follow_topic($data)
	{
		$row = $this->db->get_where('topic_follower',$data)->row_array();
		if(!empty($row)){
			return $row['topic_follower_id'];
		}
		
		$this->db->trans_start();
		$this->db->insert('topic_follower',$data);
		$topic_follower_id = $this->db->insert_id();
		$topic = $this->db->get_where('topic',array('topic_id'=>$data['topic_id']))->row_array();
		$this->db->where('topic_id', $data['topic_id']);
		$this->db->update('topic', array('follower_count'=>$topic['follower_count']+1,'update_at'=>TIME_NOW));
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === FALSE)
		{
			log_message('debug', 'sql  '.$this->db->set($data)->get_compiled_insert('topic_follower'));
			return FALSE;
		}else
		{
			return $topic_follower_id;
		}
	}
	public function  unfollow_topic($data)
	{
		$this->db->trans_start();
		$this->db->delete('topic_follower',$data);
		$topic = $this->db->get_where('topic',array('topic_id'=>$data['topic_id']))->row_array();
		$this->db->where('topic_id', $data['topic_id']);
		$this->db->update('topic', array('follower_count'=>$topic['follower_count']-1,'update_at'=>TIME_NOW));
		$this->db->trans_complete();
	
		if ($this->db->trans_status() === FALSE)
		{
			log_message('debug', 'sql  '.$this->db->set($data)->get_compiled_insert('topic_follower'));
			return FALSE;
		}else
		{
			return TRUE;
		}
	}
	/**
	 * 用户是否关注了某问题
	 * @param unknown $user_id
	 * @param unknown $topic_id
	 */
	public function is_followed($user_id,$topic_id)
	{
		$query = $this->db->get_where('topic_follower',array('user_id'=>$user_id,'topic_id'=>$topic_id));
		return !empty($query->row_array());
	}
	
	
	public function is_answer_followed($user_id,$topic_answer_id)
	{
		$query = $this->db->get_where('answer_follower',array('user_id'=>$user_id,'topic_answer_id'=>$topic_answer_id));
		return !empty($query->row_array());
	}
	public function is_answer_thumbup($user_id,$topic_answer_id)
	{
		$query = $this->db->get_where('answer_thumbup',array('user_id'=>$user_id,'topic_answer_id'=>$topic_answer_id));
		return !empty($query->row_array());
	}
	
	public function  insert_answer_thumbup($data)
	{
	
		$row = $this->db->get_where('answer_thumbup',$data)->row_array();
		if(!empty($row)){
			return $row['answer_thumbup_id'];
		}
	
		$this->db->trans_start();
		$this->db->insert('answer_thumbup',$data);
		$id = $this->db->insert_id();
		$dd = $this->db->get_where('topic_answer',array('topic_answer_id'=>$data['topic_answer_id']))->row_array();
		$this->db->where('topic_answer_id', $dd['topic_answer_id']);
		$this->db->update('topic_answer', array('thumbup_count'=>$dd['thumbup_count']+1,'update_at'=>TIME_NOW));
		$this->db->trans_complete();
	
		if ($this->db->trans_status() === FALSE)
		{
			log_message('debug', 'sql  '.$this->db->set($data)->get_compiled_insert('answer_thumbup'));
			return FALSE;
		}else
		{
			return $id;
		}
	}
	
	public function  follow_answer($data)
	{
		$row = $this->db->get_where('answer_follower',$data)->row_array();
		if(!empty($row)){
			return $row['answer_follower_id'];
		}
		
		$this->db->trans_start();
		$this->db->insert('answer_follower',$data);
		$id = $this->db->insert_id();
		$dd = $this->db->get_where('topic_answer',array('topic_answer_id'=>$data['topic_answer_id']))->row_array();
		$this->db->where('topic_answer_id', $dd['topic_answer_id']);
		$this->db->update('topic_answer', array('follower_count'=>$dd['follower_count']+1,'update_at'=>TIME_NOW));
		$this->db->trans_complete();
	
		if ($this->db->trans_status() === FALSE)
		{
			log_message('debug', 'sql  '.$this->db->set($data)->get_compiled_insert('answer_follower'));
			return FALSE;
		}else
		{
			return $id;
		}
	}
	
	public function  unfollow_answer($data)
	{	
		$this->db->trans_start();
		$this->db->delete('answer_follower',$data);
		$dd = $this->db->get_where('topic_answer',array('topic_answer_id'=>$data['topic_answer_id']))->row_array();
		$this->db->where('topic_answer_id', $dd['topic_answer_id']);
		$this->db->update('topic_answer', array('follower_count'=>$dd['follower_count']-1,'update_at'=>TIME_NOW));
		$this->db->trans_complete();
	
		
		if ($this->db->trans_status() === FALSE)
		{
			log_message('debug', 'sql  '.$this->db->set($data)->get_compiled_insert('answer_follower'));
			return FALSE;
		}else
		{
			return TRUE;
		}
	}
	
	public function get_topmost_list($count=3)
	{
		$this->db->select('topic_id,topic_content');
		$this->db->from('topic');
		$this->db->where('status',2);
		$this->db->order_by('update_at', 'DESC');
		$this->db->limit($count,0);
		$query = $this->db->get();
		$result =  $query->result_array();	
		return $result;
	}
	
	public function get_topic_list($keyword,$cur_page,$page_size)
	{
		return $this->_get_topic_list(0, $keyword, $cur_page, $page_size);
	}
	
	public function get_user_topic_list($user_id,$cur_page,$page_size)
	{
		return $this->_get_topic_list($user_id, '', $cur_page, $page_size);
	}
	
	private function _get_topic_list($user_id,$keyword,$cur_page,$page_size)
	{
		$this->db->select('topic_id,topic.user_id,username,photo as avatar,topic_content,topic.update_at,follower_count,answer_count');
		$this->db->from('topic');
		$this->db->join('user', 'topic.user_id = user.user_id');
		if(!empty($keyword)){
			$this->db->like('topic_content',$keyword);
		}
		if($user_id!=0){
			$this->db->where('topic.user_id',$user_id);
		}
		$this->db->where('topic.status !=',1);
		$this->db->order_by('topic_id', 'DESC');
		$this->db->limit($page_size,($cur_page-1)*$page_size);
		$query = $this->db->get();
		$result =  $query->result_array();
		foreach ($result as $key => $value)
		{
			$this->db->where('topic_id',$value['topic_id']);
			$this->db->limit(1);
			$this->db->order_by('topic_answer_id','DESC');
			$topic_answer = $this->db->get('topic_answer')->row_array();
			if(empty($topic_answer))
			{
				$result[$key]['topic_answer'] ='';
			}else{
				$result[$key]['topic_answer'] = $topic_answer['content'];
			}
		
		}
		
		return $result;
	}
	
	public function get_user_following($user_id,$cur_page,$page_size)
	{
		$this->db->select('topic_follower.topic_id,topic_follower.user_id,username,photo as avatar,topic_content,topic.update_at,follower_count,answer_count');
		$this->db->from('topic');
		$this->db->join('topic_follower','topic.topic_id = topic_follower.topic_id');
		$this->db->join('user', 'topic_follower.user_id = user.user_id');
		$this->db->where('topic_follower.user_id',$user_id);
		$this->db->order_by('update_at', 'DESC');
		$this->db->limit($page_size,($cur_page-1)*$page_size);
		$query = $this->db->get();
		$result =  $query->result_array();
		foreach ($result as $key => $value)
		{
			$this->db->where('topic_id',$value['topic_id']);
			$this->db->limit(1);
			$this->db->order_by('topic_answer_id','DESC');
			$topic_answer = $this->db->get('topic_answer')->row_array();
			if(empty($topic_answer))
			{
				$result[$key]['topic_answer'] ='';
			}else{
				$result[$key]['topic_answer'] = $topic_answer['content'];
			}
		
		}
		
		return $result;
	}
	
	public function search_topic_list($keyword,$cur_page,$page_size)
	{
		$this->db->select('topic_id,topic.user_id,username,photo as avatar,topic_content,topic.update_at,follower_count,answer_count');
		$this->db->from('topic');
		$this->db->join('user', 'topic.user_id = user.user_id');
		$this->db->like('topic_content',$keyword);
		$this->db->order_by('topic_id', 'DESC');
		$this->db->limit($page_size,($cur_page-1)*$page_size);
		$query = $this->db->get();
		$result =  $query->result_array();
		foreach ($result as $key => $value)
		{
			$this->db->where('topic_id',$value['topic_id']);
			$this->db->limit(1);
			$this->db->order_by('topic_answer_id','DESC');
			$topic_answer = $this->db->get('topic_answer')->row_array();
			if(empty($topic_answer))
			{
				$result[$key]['topic_answer'] ='';
			}else{
				$result[$key]['topic_answer'] = $topic_answer['content'];
			}
				
		}
	
		return $result;
	}
	
	public function get_topic_detail($topic_id)
	{
		$this->db->select('topic_id,topic.user_id,username,photo as avatar,topic_content,topic.update_at,follower_count,answer_count');
		$this->db->from('topic');
		$this->db->join('user', 'topic.user_id = user.user_id');
		$this->db->where('topic_id',$topic_id);
		$query = $this->db->get();
		$result =  $query->row_array();
		return $result;
	}
	public function get_answer_list($topic_id,$cur_page,$page_size)
	{
		$this->db->select('topic_answer_id,topic_answer.user_id,username,photo as avatar,content as answer_content,topic_answer.update_at,follower_count,comment_count,thumbup_count');
		$this->db->from('topic_answer');
		$this->db->join('user', 'topic_answer.user_id = user.user_id');
		$this->db->where('topic_answer.topic_id',$topic_id);
		$this->db->order_by('topic_answer_id', 'DESC');
		$this->db->limit($page_size,($cur_page-1)*$page_size);
		$query = $this->db->get();
		$result =  $query->result_array();
		foreach ($result as $key => $value)
		{
			$this->db->where('topic_answer_id',$value['topic_answer_id']);
			$this->db->limit(1);
			$this->db->order_by('answer_comment_id','DESC');
			$data = $this->db->get('answer_comment')->row_array();
			if(empty($data))
			{
				$result[$key]['answer_comment'] ='';
			}else{
				$result[$key]['answer_comment'] = $data['content'];
			}
				
		}
		
		return $result;
	}
	public function get_user_answer_list($user_id,$cur_page,$page_size)
	{
		$this->db->select('topic_answer_id,topic_id,topic_answer.user_id,username,photo as avatar,content as answer_content,topic_answer.update_at,follower_count,comment_count,thumbup_count');
		$this->db->from('topic_answer');
		$this->db->join('user', 'topic_answer.user_id = user.user_id');
		$this->db->where('topic_answer.user_id',$user_id);
		$this->db->order_by('topic_answer_id', 'DESC');
		$this->db->limit($page_size,($cur_page-1)*$page_size);
		$query = $this->db->get();
		$result =  $query->result_array();
		
		foreach ($result as $key => $value)
		{
			$this->db->where('topic_id',$value['topic_id']);
			$this->db->limit(1);
			$data = $this->db->get('topic')->row_array();
			$result[$key]['topic_content'] = $data['topic_content'];
			
		}

	
		return $result;
	}
	/**
	 * 获取用户关注的回答
	 * @param unknown $user_id
	 * @param unknown $cur_page
	 * @param unknown $page_size
	 * @return string|unknown
	 */
	public function get_user_answer_following($user_id,$cur_page,$page_size)
	{
		$this->db->select('answer_follower.topic_answer_id,topic_id,answer_follower.user_id,username,photo as avatar,content as answer_content,topic_answer.update_at,follower_count,comment_count,thumbup_count');
		$this->db->from('topic_answer');
		$this->db->join('answer_follower','topic_answer.topic_answer_id =answer_follower.topic_answer_id');
		$this->db->join('user', 'answer_follower.user_id = user.user_id');
		$this->db->where('answer_follower.user_id',$user_id);
		$this->db->order_by('update_at', 'DESC');
		$this->db->limit($page_size,($cur_page-1)*$page_size);
		$query = $this->db->get();
		$result =  $query->result_array();
		foreach ($result as $key => $value)
		{
			$this->db->where('topic_id',$value['topic_id']);
			$this->db->limit(1);
			$data = $this->db->get('topic')->row_array();
			$result[$key]['topic_content'] = $data['topic_content'];

	
		}
	
		return $result;
	}
	
	public function get_latest_answer_list($cur_page,$page_size)
	{
		$this->db->select('topic_answer_id,topic_answer.topic_id,topic_content,topic_answer.user_id,username,photo as avatar,content as answer_content,topic_answer.update_at,topic_answer.follower_count,comment_count,thumbup_count');
		$this->db->from('topic_answer');
		$this->db->join('topic','topic.topic_id = topic_answer.topic_id');
		$this->db->join('user', 'topic_answer.user_id = user.user_id');
		$this->db->where('topic_answer.del',0);
		$this->db->where('topic.status !=',1);
		$this->db->order_by('topic_answer_id', 'DESC');
		$this->db->limit($page_size,($cur_page-1)*$page_size);
		$query = $this->db->get();
		$result =  $query->result_array();
		/*foreach ($result as $key => $value)
		{
			$this->db->where('topic_id',$value['topic_id']);
			$this->db->limit(1);
			$data = $this->db->get('topic')->row_array();
			$result[$key]['topic_content'] = $data['topic_content'];
		}*/
	
		return $result;
	}
	
	public function get_answer_comment_list($topic_answer_id,$cur_page,$page_size)
	{
		$this->db->select('answer_comment_id,topic_answer_id,answer_comment.user_id,username,photo as avatar,content as comment_content,answer_comment.update_at');
		$this->db->from('answer_comment');
		$this->db->join('user', 'answer_comment.user_id = user.user_id');
		$this->db->where('topic_answer_id',$topic_answer_id);
		$this->db->order_by('answer_comment_id', 'DESC');
		$this->db->limit($page_size,($cur_page-1)*$page_size);
		$query = $this->db->get();
		$result =  $query->result_array();
		
		return $result;
	}
	public function get_answer_detail($topic_answer_id)
	{
		$this->db->select('topic_answer_id,topic_answer.topic_id,topic_answer.user_id,username,photo as avatar,topic_content,content as answer_content,topic_answer.update_at,topic_answer.follower_count,comment_count,thumbup_count');
		$this->db->from('topic_answer');
		$this->db->join('user', 'topic_answer.user_id = user.user_id');
		$this->db->join('topic','topic_answer.topic_id = topic.topic_id');
		$this->db->where('topic_answer_id',$topic_answer_id);
		$query = $this->db->get();
		$result =  $query->row_array();
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
	/**
	 * 获取用户问答广场相关的统计，问题数，回答数等
	 */
	public function get_user_topic_count($user_id)
	{
		$result = array();
		$this->db->select('*');
		$this->db->where('status !=',1);
		$this->db->where('user_id',$user_id);
		$total = $this->db->count_all_results('topic');
		$result['topic_count'] = $total;
		
		$this->db->select('*');
		$this->db->where('del',0);
		$this->db->where('user_id',$user_id);
		$total = $this->db->count_all_results('topic_answer');
		$result['topic_answer_count']=$total;
		return $result;
	}
	public function get_hot_keyword()
	{
		$this->db->select('keyword,count(keyword) as count');
		$this->db->from('search_history');
		$this->db->where('type',2);
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
	public function  insert_search_history($data)
	{
		$this->db->insert('search_history', $data);
		return $this->db->insert_id();
	}
}
