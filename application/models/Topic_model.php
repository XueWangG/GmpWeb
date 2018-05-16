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
		$topic_answer_id = $this->db->insert_id();
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
			return $topic_answer_id;
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
		$query = $this->db->get_where('answer_follower',array('user_id'=>$user_id,'answer_id'=>$topic_answer_id));
		return !empty($query->row_array());
	}
	
	public function  insert_answer_thumbup($data)
	{
	
	
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
	
	public function get_topmost_list($count=3)
	{
		$this->db->select('topic_id,topic_content');
		$this->db->from('topic');
		$this->db->where('status',1);
		$this->db->order_by('update_at', 'DESC');
		$this->db->limit($count,0);
		$query = $this->db->get();
		$result =  $query->result_array();	
		return $result;
	}
	
	public function get_topic_list($cur_page,$page_size)
	{
		$this->db->select('topic_id,topic.user_id,username,photo as avatar,topic_content,topic.update_at,follower_count,answer_count');
		$this->db->from('topic');
		$this->db->join('user', 'topic.user_id = user.user_id');
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
		$this->db->select('topic_answer_id,topic_answer.user_id,username,photo as avatar,content,topic_answer.update_at,follower_count,comment_count,thumbup_count');
		$this->db->from('topic_answer');
		$this->db->join('user', 'topic_answer.user_id = user.user_id');
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
	public function get_answer_comment_list($topic_answer_id,$cur_page,$page_size)
	{
		$this->db->select('answer_comment_id,answer_comment.user_id,username,photo as avatar,content as comment_content,answer_comment.update_at');
		$this->db->from('answer_comment');
		$this->db->join('user', 'answer_comment.user_id = user.user_id');
		$this->db->order_by('answer_comment_id', 'DESC');
		$this->db->limit($page_size,($cur_page-1)*$page_size);
		$query = $this->db->get();
		$result =  $query->result_array();
		
		return $result;
	}
	public function get_answer_detail($topic_answer_id)
	{
		$this->db->select('topic_answer_id,topic_answer.user_id,username,photo as avatar,topic_content,content as answer_content,topic_answer.update_at,topic_answer.follower_count,comment_count,thumbup_count');
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
	 * 取得一页问答数据
	 * @param unknown $cur_page 当前页码
	 * @param unknown $page_size 每页数据条数
	 * @param unknown $search_string 要查找的字符串
	 */
	public function get_topic_page($search_string,$cur_page,$page_size = 10)
	{
		$result = array();
	
		$this->db->select('topic_id,topic.user_id,username,photo as avatar,topic_content,status,topic.create_at,topic.update_at,follower_count,answer_count');
		$this->db->join('user', 'topic.user_id = user.user_id');
		$this->db->where('topic.status !=',1);//未删除
		if(!empty($search_string))
		{
			$this->db->like('topic_content',$search_string);
		
		}
		$this->db->order_by('status', 'DESC');
		$this->db->order_by('update_at', 'DESC');
		
		$total = $this->db->count_all_results('topic',FALSE);
		$result['total']=$total;
		
		$this->db->limit($page_size,($cur_page-1)*$page_size);
		$query = $this->db->get();
		$result['item_list'] =  $query->result_array();
		
		return $result;
	}
	public function delete($condition)
	{
		return $this->db->update('topic', array('status'=>1), $condition);
	}
	public function delete_answer($condition)
	{
		$this->db->trans_start();
		$this->db->update('topic_answer', array('del'=>1), $condition);

		$topic = $this->db->get_where('topic',array('topic_id'=>$condition['topic_id']))->row_array();
		$this->db->where('topic_id', $condition['topic_id']);
		$this->db->update('topic', array('answer_count'=>$topic['answer_count']-1,'update_at'=>TIME_NOW));
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === FALSE)
		{
			return FALSE;
		}else
		{
			return TRUE;
		}
		
	}
	public function delete_answer_comment($condition)
	{
		$this->db->trans_start();
		$this->db->update('answer_comment', array('del'=>1), $condition);
		
		$dd = $this->db->get_where('topic_answer',array('topic_answer_id'=>$condition['topic_answer_id']))->row_array();
		$this->db->where('topic_answer_id', $dd['topic_answer_id']);
		$this->db->update('topic_answer', array('comment_count'=>$dd['comment_count']-1,'update_at'=>TIME_NOW));
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === FALSE)
		{
			return FALSE;
		}else
		{
			return TRUE;
		}
		
	}
	
	public function get_topic_view($topic_id,$cur_page,$page_size = 10)
	{
		$result = array();
		
		$this->db->select('topic_id,topic.user_id,username,photo as avatar,topic_content,topic.update_at,follower_count,answer_count');
		$this->db->from('topic');
		$this->db->join('user', 'topic.user_id = user.user_id');
		$this->db->where('topic_id',$topic_id);
		$query = $this->db->get();
		$topic =  $query->row_array();
		$result['topic']=$topic;
		
		$this->db->select('topic_answer_id,topic_answer.user_id,username,photo as avatar,content,topic_answer.create_at,topic_answer.update_at,follower_count,comment_count,thumbup_count');
		$this->db->join('user', 'topic_answer.user_id = user.user_id');
		$this->db->where('topic_answer.del',0);//未删除
		$this->db->where('topic_answer.topic_id',$topic_id);
		$this->db->order_by('topic_answer_id', 'DESC');
		
		$total = $this->db->count_all_results('topic_answer',FALSE);
		$result['total']=$total;
		
		$this->db->limit($page_size,($cur_page-1)*$page_size);
		$query = $this->db->get();
		$result['item_list'] =  $query->result_array();
				
		return $result;
		
	}
	
	public function get_answer_view($topic_answer_id,$cur_page,$page_size = 10)
	{
		$result = array();
	
		$this->db->select('topic_answer_id,topic_answer.topic_id,topic_answer.user_id,username,photo as avatar,topic_content,content as answer_content,topic_answer.update_at,topic_answer.follower_count,comment_count,thumbup_count');
		$this->db->from('topic_answer');
		$this->db->join('user', 'topic_answer.user_id = user.user_id');
		$this->db->join('topic','topic_answer.topic_id = topic.topic_id');
		$this->db->where('topic_answer_id',$topic_answer_id);
		$query = $this->db->get();
		$answer =  $query->row_array();
		$result['answer']=$answer;
	
		$this->db->select('answer_comment_id,answer_comment.user_id,username,photo as avatar,content as comment_content,answer_comment.create_at,answer_comment.update_at');
		$this->db->join('user', 'answer_comment.user_id = user.user_id');
		$this->db->where('answer_comment.del',0);//未删除
		$this->db->where('answer_comment.topic_answer_id',$topic_answer_id);
		$this->db->order_by('answer_comment_id', 'DESC');
		
		$total = $this->db->count_all_results('answer_comment',FALSE);
		$result['total']=$total;
		
		$this->db->limit($page_size,($cur_page-1)*$page_size);
		$query = $this->db->get();
		$result['item_list'] =  $query->result_array();
	
		return $result;
	
	}
	public function update($data,$id)
	{
		return  $this->db->update('topic', $data, array('topic_id' => $id));
	}
	
		
}
