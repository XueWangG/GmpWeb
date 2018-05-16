<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testpaper extends WB_Controller {

	
	function __construct()
	{
		parent::__construct();
		$this->load->model('testpaper_model');
		$this->load->model('question_model');
		$this->load->model('test_model');
		
		$this->load->library('form_validation');
		$this->load->library('pagination');
		
	}
	
	public function index($cur_page=1)
	{
		//
		$data = $this->testpaper_model->get_testpaper_page($this->company_id,$cur_page);
		
		//实现分页
		$this->pagination_config['base_url'] =base_url().'index.php/testpaper/index/';
		$this->pagination_config['total_rows'] = $data['total'];
		
		$this->pagination->initialize($this->pagination_config);

					
		// 取得题型一览
		$typeList = $this->get_type_list();
		
		$data_testpaper['testpapers']=array();
		
		foreach($data['item_list'] as $row)
		{
			// 取得一览中所需要的信息
			$tmp = array();
			$tmp['id'] = $row['test_paper_id'];
			$tmp['name'] = $this->cutstr($row['test_paper_name']);
			$tmp['cutoff'] = $row['cutoff'];
				
				
			$pointList = array();
			$tmp['question_cnt']=0;
			$tmp['total_point']=0;
		
			$paperType = $row['type'];
			$testpaperId = $row['test_paper_id'];
		
			if( $paperType  == 1){//手动出题
		
				foreach($typeList as $key => $value)
				{
					$pointList[$key] = array();

					$pointList[$key]['qcnt'] = $this->testpaper_model->get_question_count($testpaperId, $key);
					$pointList[$key]['point'] = $this->testpaper_model->get_point($testpaperId, $key);
					$tmp['question_cnt'] += $pointList[$key]['qcnt'];
					$tmp['total_point'] += ($pointList[$key]['qcnt'] * $pointList[$key]['point']);

				}
					
			}else{//随机出题
		
				foreach($typeList as $key => $value)
				{
					$pointList[$key] = array();
					$pointList[$key]['qcnt'] = $this->testpaper_model->get_question_count_from_rule($testpaperId, $key);
					$pointList[$key]['point'] = $this->testpaper_model->get_point($testpaperId, $key);
					$tmp['question_cnt'] += $pointList[$key]['qcnt'];
					$tmp['total_point'] += ($pointList[$key]['qcnt'] * $pointList[$key]['point']);

				}
			}//END
		
			$tmp['point_list'] = $pointList;
			// 检查是否可以编辑或者删除
			$tmp['update_flg'] = $this->check_can_update($row['test_paper_id']);
			$tmp['delete_flg'] = $this->check_can_delete($row['test_paper_id']);
			$data_testpaper['testpapers'] []= $tmp;
		}
		$data_testpaper['typeList'] = $typeList;
		$this->render_view('testpaper_list', $data_testpaper);
	}
	
	// 检查试卷是否可以编辑或删除
	private function check_can_update($testpaperId)
	{
		// 如果该试卷存在且未被删除
		$row = $this->testpaper_model->get(array('test_paper_id'=>$testpaperId,'del'=>0));
		if(!empty($row)){
			// 如果该试卷未被任何一次考试使用过
			if(empty($this->test_model->get(array('test_paper_id'=>$testpaperId))))
			{
				// 则可以编辑或删除
				return TRUE;
			}
		}	
		return FALSE;
	}
	
	// 检查试卷是否可以编辑或删除
	private function check_can_delete($testpaperId)
	{
		// 如果该试卷存在且未被删除
		$row = $this->testpaper_model->get(array('test_paper_id'=>$testpaperId,'del'=>0));
		if(!empty($row)){
			// 如果该试卷未被任何一次考试使用过
			if(empty($this->test_model->get(array('test_paper_id'=>$testpaperId,'del'=>0))))
			{
				// 则可以编辑或删除
				return TRUE;
			}
		}
		return FALSE;
	}
	
	// 取得题型一览，形如：array('1'=>'单选题','2'=>'多选题');
	private function get_type_list()
	{
		return array('1'=>'单选题','2'=>'多选题');
	}
	
	// UTF-8字符串截取
	private function cutstr($str, $len = 16, $from = 0)
	{
	
		if($this->abslength($str) > $len)
		{
			return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$from.'}'.
					'((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s',
					'$1'.'…',$str);
		}
		else
		{
			return $str;
		}
	}
	
	//  UTF-8字符串长度判断
	private function abslength($str)
	{
		if(empty($str)){
			return 0;
		}
		if(function_exists('mb_strlen')){
			return mb_strlen($str,'utf-8');
		}
		else {
			preg_match_all("/./u", $str, $ar);
			return count($ar[0]);
		}
	}
	
	//////////////////////////////////////////////////
	// ACTION
	// 创建试卷第一步
	//////////////////////////////////////////////////
	function create_step1()
	{
		// 把编辑/创建状态放入session中
		$this->session->set_userdata('SESSION_NAME_PAPER_CREATE', 1);	// 1表示创建中，0表示编辑中
		
		// 取得题型一览
		$typeList = $this->get_type_list();
	
		// 取得表单提交内容
		// 试卷名称
		$paperName = $this->input->post('papername');
		$cover_url = $this->input->post('cover_url');
		$paperType = $this->input->post('papertype');
		$cutoff = $this->input->post('cutoff');
		$difficulty =$this->input->post('difficulty');
		$description = $this->input->post('description');
		$tag_name = $this->input->post('tag_name');
	
		if($_POST){
			//$this->output_data($_POST);
		}
		
		// 每题分值
		$this->point_set_flg = 0;
		$pointList = array();
		foreach($typeList as $key => $value){
			$pointTmp = $this->input->post('point_'.$key);
			if($pointTmp)
			{
				$this->point_set_flg = 1;
				$pointList[$key] = $pointTmp;
			}
			else
			{
				$pointList[$key] = '';
			}
		}
	
		// 设置表单提交规则
		$this->form_validation->set_rules('papername', '试卷名称', 'required|callback_check_name_add');
	
		//added by linwd 2015/05/31
		$this->form_validation->set_rules('papertype', '试卷类型', 'required');
	
		//added by linwd 2015/05/31
		$this->form_validation->set_rules('cutoff', '通过分数线', 'required');
	
		$this->set_rules_step1($typeList);
	
		if ($this->form_validation->run() == FALSE)
		{	// 不是提交表单或提交表单不成功
			// 设置上一次表单提交的内容
			$data_testpaper['paperName'] = $paperName;
			$data_testpaper['cover_url'] = $cover_url;
			$data_testpaper['typeList'] = $typeList;
			$data_testpaper['pointList'] = $pointList;
			$data_testpaper['cutoff'] = $cutoff;
			$data_testpaper['paperType'] = -1;
			$data_testpaper['difficulty']=$difficulty;
			$data_testpaper['description']=$description;
			$data_testpaper['tag_name']=$tag_name;
	
			$data_testpaper['difs']=$this->get_difficulty_list();
			
			// 载入画面
			$this->render_view('testpaper_step1',$data_testpaper);
		}
		else
		{
			// 创建考试，并取得试卷id
			$testpaper_info = array();
			$testpaper_info['test_paper_name']=$paperName;
			if(!empty($cover_url)){
				$testpaper_info['cover_url'] = $cover_url;
			}
			$testpaper_info['company_id']=$this->company_id;
			$testpaper_info['type']=$paperType;
			$testpaper_info['cutoff']=$cutoff;
			$testpaper_info['difficulty']=$difficulty;
			$testpaper_info['description']=$description;
			$testpaper_info['update_at']=TIME_NOW;
			
			$testpaperId = $this->testpaper_model->insert($testpaper_info);
				
			// 逐行插入该试卷每种题型的每题分值
			foreach($pointList as $key => $value)
			{
				if($value)
				{
					$this->testpaper_model->insert_test_paper_point(array('test_paper_id'=>$testpaperId,'type'=>$key,'point'=>$value));
				}
			}
			
			if(!empty($tag_name)){//保存标签
				$this->testpaper_model->insert_tag($testpaperId,$tag_name);
			}
				
			// 把正在编辑或创建的试卷ID放入session中
			$this->session->set_userdata('SESSION_NAME_UPDATING_PAPERID', $testpaperId);
				
			if( $paperType == 1){
				// 进入第二步，手动添加试题
				redirect(base_url()."index.php/testpaper/step2_1/");
			}else{
				// 进入第二步，添加抽题规则
				redirect(base_url()."index.php/testpaper/step2_2/");
			}
	
		}
	
	}
	
	function update_step1()
	{
		// 取得题型一览
		$typeList = $this->get_type_list();
	
		// 取得试卷ID
		if(!$_POST)
		{
			if(!$this->uri->segment(3)){
				// 如果参数不足，则回到试卷一览
				redirect(base_url()."index.php/testpaper/index/");
				return;
			}
			$testpaperId = $this->uri->segment(3);
		}
		else
		{
			$testpaperId = $this->session->userdata('SESSION_NAME_UPDATING_PAPERID');
		}
	
		// 检查是否可编辑状态
		if(!$this->check_can_update($testpaperId)){
			// 如果不可编辑
			print("error:不可编辑");
			return;
		}
	
		// 把编辑/创建状态放入session中
		$this->session->set_userdata('SESSION_NAME_PAPER_CREATE', 0);	// 1表示创建中，0表示编辑中
		// 把正在编辑的试卷ID放入session中
		$this->session->set_userdata('SESSION_NAME_UPDATING_PAPERID', $testpaperId);
	
	
		// 取得表单提交内容
		// 试卷名称
		$paperName = $this->input->post('papername');
		$cover_url = $this->input->post('cover_url');
		$paperType = $this->input->post('papertype');
		$cutoff = $this->input->post('cutoff');
		$difficulty =$this->input->post('difficulty');
		$description = $this->input->post('description');
		$tag_name = $this->input->post('tag_name');
	
		// 每题分值
		$this->point_set_flg = 0;
		$pointList = array();
		foreach($typeList as $key => $value){
			$pointTmp = $this->input->post('point_'.$key);
			if($pointTmp)
			{
				$this->point_set_flg = 1;
				$pointList[$key] = $pointTmp;
			}
			else
			{
				$pointList[$key] = '';
			}
		}
	
		// 设置表单提交规则
		$this->form_validation->set_rules('papername', '试卷名称', 'required|callback_check_name_update');
		$this->set_rules_step1($typeList);
	
		$this->form_validation->set_rules('papertype', '试卷类型', 'required');	
		$this->form_validation->set_rules('cutoff', '通过分数线', 'required');
	
		if ($this->form_validation->run() == FALSE)
		{	// 不是提交表单或提交表单不成功
			if($_POST)
			{
				// 设置上一次表单提交的内容
				$data_testpaper['paperName'] = $paperName;
				$data_testpaper['cover_url'] = $cover_url;
				$data_testpaper['pointList'] = $pointList;
				$data_testpaper['paperType'] = $paperType;
				$data_testpaper['cutoff'] = $cutoff;
				$data_testpaper['difficulty']=$difficulty;
				$data_testpaper['description']=$description;
				$data_testpaper['tag_name']=$tag_name;
	
			}
			else
			{
				// 从数据库中读出该试卷内容
				$rs = $this->testpaper_model->get(array('test_paper_id'=>$testpaperId));
	
				$data_testpaper['paperName'] = $rs['test_paper_name'];
				$data_testpaper['cover_url'] = $rs['cover_url'];
				$data_testpaper['paperType'] = $rs['type'];
				$data_testpaper['cutoff'] = $rs['cutoff'];
				$data_testpaper['difficulty']=$rs['difficulty'];
				$data_testpaper['description']=$rs['description'];
				
				$data_testpaper['tag_name'] =  $this->testpaper_model->get_tag($testpaperId);
	
				$pointList = array();
				foreach($typeList as $key => $value)
				{
					$tmp = $this->testpaper_model->get_point($testpaperId, $key);
					$pointList[$key] = $tmp?$tmp:'';
				}
				$data_testpaper['pointList'] = $pointList;
			}
			$data_testpaper['difs']=$this->get_difficulty_list();
			$data_testpaper['typeList'] = $typeList;
				
			// 载入画面
			$this->render_view('testpaper_step1', $data_testpaper);
		}
		else
		{
			$data['test_paper_name']=$paperName;
			$data['cutoff']=$cutoff;
			$data['cover_url']=$cover_url;
			$data['difficulty']=$difficulty;
			$data['description']=$description;
			$data['update_at']=TIME_NOW;
			
			$condition['test_paper_id']=$testpaperId;
			$condition['company_id']=$this->company_id;
			
			// 更新试卷
			$this->testpaper_model->update($data,$condition);
				
			// 先删除，再逐行重新插入该试卷每种题型的每题分值
			$this->testpaper_model->delete_point_list($testpaperId);
			foreach($pointList as $key => $value)
			{
				if($value)
				{
					$this->testpaper_model->insert_test_paper_point(array('test_paper_id'=>$testpaperId,'type'=>$key,'point'=>$value));
				}
			}
			
			if(!empty($tag_name)){//保存标签
				$this->testpaper_model->insert_tag($testpaperId,$tag_name);
			}
			
				
	
			if($paperType == 1){
				// 进入第二步
				redirect(base_url()."index.php/testpaper/step2_1/");
			}else{
				// 进入第二步
				redirect(base_url()."index.php/testpaper/step2_2/");
			}
	
		}
	
	}
	
	// 设置表单提交规则
	private function set_rules_step1($typelist)
	{
		$cnt = 0;
		foreach($typelist as $key => $value)
		{
			if($cnt==0)
			{
				$this->form_validation->set_rules('point_'.$key, '分值', 'greater_than[0]|callback_check_atleastone');
			}
			else
			{
				$this->form_validation->set_rules('point_'.$key, '分值', 'greater_than[0]');
			}
			$cnt++;
		}
	}
	// 检查是否有至少一个题型被设置了分值
	public function check_atleastone($str)
	{
		if($this->point_set_flg)
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('check_atleastone', '请至少设置一个题型的分值');
			return FALSE;
		}
	
	}
	// 创建或复制试卷时检查所更新的试卷名是否已经被其他考试占用
	public function check_name_add($str)
	{
		$exist = $this->testpaper_model->name_exist($str);
		if( !$exist ){
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('check_name_add', '该试卷名称已经被使用');
			return FALSE;
		}
	}
	
	//////////////////////////////////////////////////
	// ACTION
	// 添加/编辑/复制试卷第二步
	//////////////////////////////////////////////////
	function step2_1()
	{

		// 取得题型一览
		$typeList = $this->get_type_list();
	
		// 从session中取得考试id
		$testpaperId = $this->session->userdata('SESSION_NAME_UPDATING_PAPERID');
		if(!$testpaperId)
		{
			// 如果试卷id为空，则回到一览画面
			redirect(base_url()."index.php/testpaper/index/");
		}
	
		// 取得该试卷已经设置分值的题型一览
		$rs = $this->testpaper_model->get_point_list($testpaperId);
		$setTypeList = Array();
		$firstType = -1;
		foreach($rs as $row)
		{
			if($row['point'])
			{
				$setTypeList[$row['type']] = $typeList[$row['type']];
				$firstType = ($firstType==-1)?$row['type']:$firstType;
			}
		}
		$data_testpaper['setTypeList'] = $setTypeList;
	
		// 取得上一次表单提交内容
		$type = $this->input->post('type');
		$cat1 = $this->input->post('cat1');
		$sop = $this->input->post('sop');
		$offset = $this->input->post('offset');
	
		$random = 0;
		$selectedQuestions = $this->input->post('selected_questions');
		if(isset($_POST['mode']) && $_POST['mode'] != ''){
			if($_POST['mode'] == 'add'){
				$this->form_validation->set_rules('selected_questions[]', '选择试题', 'required');
				$this->form_validation->set_rules('deleted_questions[]', '删除试题', '');
			}elseif($_POST['mode'] == 'del'){
				$this->form_validation->set_rules('selected_questions[]', '选择试题', '');
				$this->form_validation->set_rules('deleted_questions[]', '删除试题', 'required');
			}
		}else{
			$this->form_validation->set_rules('selected_questions[]', '选择试题', '');
			$this->form_validation->set_rules('deleted_questions[]', '删除试题', '');
		}
	
	
		if ($this->form_validation->run() == FALSE)
		{
			// 初次进入本画面或切换题型分类时
			if(!$_POST){
				$type = $this->uri->segment(3);
				$cat1 = $this->uri->segment(4);
				$sop = $this->uri->segment(5);
				$random = $this->uri->segment(6);
				$offset = $this->uri->segment(7);
			}
		}
		else
		{
			// 点击“添加试题到本试卷”时
			if(isset($_POST['mode']) && $_POST['mode'] == 'add'){
				$selectedQuestions = $this->input->post('selected_questions');
				// 插入数据
				if(isset($selectedQuestions) && is_array($selectedQuestions) && count($selectedQuestions) > 0){
					foreach($selectedQuestions as $qId){
						$this->testpaper_model->insert_test_question(array('test_paper_id'=>$testpaperId, 'question_id'=>$qId));
					}
				}
			}
				
				
			// 点击“删除已选试题”时
			if(isset($_POST['mode']) && $_POST['mode'] == 'del'){
				$deletedQuestions = $this->input->post('deleted_questions');
					
				// 删除数据
				if(isset($deletedQuestions) && is_array($deletedQuestions) && count($deletedQuestions) > 0){
					foreach($deletedQuestions as $qId){
						$this->testpaper_model->delete_test_question($testpaperId, $qId);
					}
				}
			}
	
		}
	
		// 保证当前的题型是步骤一所设定过的
		if(!array_key_exists($type.'', $setTypeList))
		{
			$type = $firstType;
		}
		// 取得分类一列表
		$data_testpaper['cat1_list'] = $this->question_model->get_category_list();
		$data_testpaper['sop_list'] = $this->question_model->get_sop_list($this->company_id);
	
		$data_testpaper['findZeroFlg']=0;
		$data_testpaper['questions'] = NULL;

		if($random > 0)
		{
			// 随机生成题
			$rs = $this->question_model->get_ready_for_testpaper($type, $cat1, $sop,$testpaperId);
			shuffle($rs);
			$data_testpaper['questions'] = array_slice($rs, 0 , $random);

			$random = 0;
		}
		else
		{
			// 设置分页
			$this->pagination_config['base_url'] =base_url().'index.php/testpaper/step2_1/'.$type.'/'.$cat1.'/'.$sop.'/0/';

			$totalRows = $this->question_model->get_ready_for_testpaper($type, $cat1,$sop, $testpaperId);
			$this->pagination_config['total_rows'] = count($totalRows);
			//$config['uri_segment'] = 8;
			$this->pagination->initialize($this->pagination_config);	

			// 根据分类显示的题目一览
			if($_POST && $this->input->post('select_all')=='on')
			{
				// 当某一页被全选并添加，则跳回第一页
				$data_testpaper['questions'] = $this->question_model->get_ready_for_testpaper($type, $cat1,$sop, $testpaperId, $this->pagination_config['per_page'], 0);
			}
			else
			{
				$data_testpaper['questions'] = $this->question_model->get_ready_for_testpaper($type, $cat1,$sop, $testpaperId, $this->pagination_config['per_page'], $offset);
			}
		}

		// 当结果件数为0，则显示提示信息。
		if(count($data_testpaper['questions'])==0){
			$data_testpaper['findZeroFlg'] = 1;
		}

		for($i=0; $i<count($data_testpaper['questions']); $i++)
		{
			$data_testpaper['questions'][$i]['question'] =  $this->cutstr($data_testpaper['questions'][$i]['question']);
		}
	
		// 已添加的试题
		$data_testpaper['added_questions'] = array();
		$rs = $this->testpaper_model->get_test_question_list($testpaperId);
		foreach($rs as $row)
		{
			$tmpArray = array();
			$tmpArray['type'] = $typeList[$row['type']];
			$tmpArray['question'] = $this->cutstr($row['question']);
			$tmpArray['id'] = $row['question_id'];
			$tmpArray['cat1'] = $this->cutstr($row['category_name'], 7);
			$data_testpaper['added_questions'] []= $tmpArray;
		}
	
		// 试卷摘要
		$pointList = array();
		$rs = $this->testpaper_model->get(array('test_paper_id'=>$testpaperId));
		$tmp['name'] = $rs['test_paper_name'];
		$tmp['question_cnt'] = 0;
		$tmp['total_point'] = 0;
		foreach($setTypeList as $key => $value)
		{
			$pointList[$key] = array();
	
				$pointList[$key]['qcnt'] = $this->testpaper_model->get_question_count($testpaperId, $key);
				$pointList[$key]['point'] = $this->testpaper_model->get_point($testpaperId, $key);
				$tmp['question_cnt'] += $pointList[$key]['qcnt'];
				$tmp['total_point'] += ($pointList[$key]['qcnt'] * $pointList[$key]['point']);
		}
		$tmp['point_list'] = $pointList;
		$data_testpaper['testpaper'] = $tmp;
	
		// 更新试题数
		$data['question_count']=$tmp['question_cnt'];
		$data['update_at']=TIME_NOW;
		$condition['test_paper_id']=$testpaperId;
		$condition['company_id']=$this->company_id;
			
		$this->testpaper_model->update($data,$condition);
		
		// 参数设置
		$data_testpaper['type'] = $type?$type:0;
		$data_testpaper['cat1'] = $cat1?$cat1:0;
		$data_testpaper['sop'] = $sop?$sop:0;
		$data_testpaper['random'] = $random?$random:0;
		$data_testpaper['offset'] = $offset?$offset:0;
	
		// 载入画面
		$this->render_view('testpaper_step2_1', $data_testpaper);
	}
	
	//////////////////////////////////////////////////
	// ACTION
	// 添加/编辑试题抽题规则
	//////////////////////////////////////////////////
	function step2_2()
	{
		// 取得题型一览
		$typeList = $this->get_type_list();
	
		// 从session中取得考试id
		$testpaperId = $this->session->userdata('SESSION_NAME_UPDATING_PAPERID');
		if(!$testpaperId)
		{
			// 如果试卷id为空，则回到一览画面
			redirect(base_url()."index.php/testpaper/index/");
		}
	
		// 取得该试卷已经设置分值的题型一览
		$rs = $this->testpaper_model->get_point_list($testpaperId);
		$setTypeList = Array();
		$firstType = -1;
		foreach($rs as $row)
		{
			if($row['point'])
			{
				$setTypeList[$row['type']] = $typeList[$row['type']];
				$firstType = ($firstType==-1)?$row['type']:$firstType;
			}
		}
		$data_testpaper['setTypeList'] = $setTypeList;
	
		// 取得上一次表单提交内容
		$type = $this->input->post('type');
		$cat1 = $this->input->post('cat1');
		$offset = $this->input->post('offset');
		$num = $this->input->post('number');
	
		if(isset($_POST['mode']) && $_POST['mode'] != ''){
			if($_POST['mode'] == 'add'){
				$this->form_validation->set_rules('number', '试题个数', 'required');
			}elseif($_POST['mode'] == 'del'){
				$this->form_validation->set_rules('deleted_rules[]', '删除规则', 'required');
			}
		}else{
			//$this->form_validation->set_rules('deleted_rules[]', '删除规则', '');
		}
	
		$data_testpaper['rules_existed'] = 0;
		$data_testpaper['info']='';
		if ($this->form_validation->run() == FALSE)
		{
			// 初次进入本画面或切换题型分类时
			if(!$_POST){
				$type = $this->uri->segment(3);
				$cat1 = $this->uri->segment(4);
				$num = $this->uri->segment(5);
				$offset = $this->uri->segment(6);
			}
		}
		else
		{
			// 点击“添加抽题规则”时
			if(isset($_POST['mode']) && $_POST['mode'] == 'add'){
				// 插入规则数据，该分类下已有规则不能重复添加
				if(!$this->testpaper_model->rule_exist($testpaperId, $cat1, $type)){
					$rule = array();
					$rule['test_paper_id']=$testpaperId;
					$rule['category_id']=$cat1;
					$rule['type']=$type;
					$rule['count']=$num;
					$this->testpaper_model->insert_test_paper_rule($rule);
				}else{
					$data_testpaper['rules_existed'] = 1;
				}
			}
	
			// 点击“删除已选规则”时
			if(isset($_POST['mode']) && $_POST['mode'] == 'del'){
				$deletedRules = $this->input->post('deleted_rules');
					
				// 删除数据
				if(isset($deletedRules) && is_array($deletedRules) && count($deletedRules) > 0){
					foreach($deletedRules as $rId){
						$this->testpaper_model->delete_test_paper_rule($rId);
					}
				}
			}
	
		}
	
		// 保证当前的题型是步骤一所设定过的
		if(!array_key_exists($type.'', $setTypeList))
		{
			$type = $firstType;
		}
		// 取得分类一列表
		$data_testpaper['cat1_list'] = $this->question_model->get_category_list();
	
		if($cat1)
		{
			$totalRows = $this->question_model->get_random_for_testpaper($type, $cat1);
			$data_testpaper['total'] = count($totalRows);
	
		}
		else{
			$data_testpaper['total'] = 0;
		}
	
		// 已添加的规则
		$data_testpaper['added_rules'] = array();
		$rs = $this->testpaper_model->get_test_paper_rule_list($testpaperId);
		foreach($rs as $row)
		{
			$tmpArray = array();
			$tmpArray['type'] = $typeList[$row['type']];
			$tmpArray['num'] = $row['count'];
			$tmpArray['id'] = $row['rule_id'];
			$tmpArray['cat1'] = $this->cutstr($row['category_name'], 15);
			$data_testpaper['added_rules'] []= $tmpArray;
		}
	
		// 试卷摘要
		$pointList = array();
		$rs = $this->testpaper_model->get(array('test_paper_id'=>$testpaperId));
		$tmp['name'] = $rs['test_paper_name'];
		$tmp['question_cnt'] = 0;
		$tmp['total_point'] = 0;
		foreach($setTypeList as $key => $value)
		{
			$pointList[$key] = array();
	
			$pointList[$key]['qcnt'] = $this->testpaper_model->get_question_count_from_rule($testpaperId, $key);
			$pointList[$key]['point'] = $this->testpaper_model->get_point($testpaperId, $key);
			$tmp['question_cnt'] += $pointList[$key]['qcnt'];
			$tmp['total_point'] += ($pointList[$key]['qcnt'] * $pointList[$key]['point']);
		}
		$tmp['point_list'] = $pointList;
		$data_testpaper['testpaper'] = $tmp;
		//
		$data['question_count']=$tmp['question_cnt'];
		$data['update_at']=TIME_NOW;
		$condition['test_paper_id']=$testpaperId;
		$condition['company_id']=$this->company_id;
			
		// 更新试卷
		$this->testpaper_model->update($data,$condition);
		//
	
		// 参数设置
		$data_testpaper['type'] = $type?$type:0;
		$data_testpaper['cat1'] = $cat1?$cat1:0;
		$data_testpaper['num'] = $num?$num:0;
		$data_testpaper['offset'] = $offset?$offset:0;
	
		// 载入画面
		$this->render_view('testpaper_step2_2', $data_testpaper);

	}
	
	//////////////////////////////////////////////////
	// ACTION
	// 去除已添加的题目
	//////////////////////////////////////////////////
	function step2_2_delete_rule($rId, $type, $cat1, $num, $offset)
	{
		// 删除该规则
		$this->testpaper_model->delete_test_paper_rule($rId);
	
		redirect(base_url()."index.php/testpaper/step2_2/".$type."/".$cat1."/".$num."/".$offset."#delete_rule");
	}
	
	//////////////////////////////////////////////////
	// ACTION
	// 去除已添加的题目
	//////////////////////////////////////////////////
	function step2_1_delete_question($qId, $type, $cat1,$sop,  $random, $offset)
	{
	
		// 删除该试题
		$this->testpaper_model->delete_test_question($this->session->userdata('SESSION_NAME_UPDATING_PAPERID'), $qId);
	
		redirect(base_url()."index.php/testpaper/step2_1/".$type."/".$cat1."/".$sop."/".$random."/".$offset."#delete_question");
	}
	
	//////////////////////////////////////////////////
	// ACTION
	// 查看试卷
	//////////////////////////////////////////////////
	function view($testpaperId)
	{
		// 取得该考试信息
		$rs = $this->testpaper_model->get(array('test_paper_id'=>$testpaperId));
		// 检查是否存在
		if(!$rs){
			print("error:not exist");
			return;
		}
	
		$data_testpaper['paperName'] = $rs['test_paper_name'];
		$data_testpaper['cover_url'] = $rs['cover_url'];
		$data_testpaper['papertype'] = $rs['type'];
		$data_testpaper['difficulty'] = $this->get_difficulty($rs['difficulty']);
		$data_testpaper['description'] = $rs['description'];
		$data_testpaper['cutoff'] = $rs['cutoff'];
	
		$typeList = $this->get_type_list(); // 取得题型一览
		$pointList = array();
		// 取得每种题型分值
		foreach($typeList as $key => $value)
		{
			$tmpPoint = $this->testpaper_model->get_point($testpaperId, $key);
			$pointList[$key] = $tmpPoint?$tmpPoint.'分':'未设置';
		}
		$data_testpaper['pointList'] = $pointList;
	
		if( $data_testpaper['papertype']  == 1){
			// 已添加的试题
			$data_testpaper['added_questions'] = array();
			$rs = $this->testpaper_model->get_test_question_list($testpaperId);
			foreach($rs as $row)
			{
				$tmpArray = array();
				$tmpArray['type'] = $typeList[$row['type']];
				$tmpArray['question'] = $this->cutstr($row['question']);
				$tmpArray['id'] = $row['question_id'];
				$tmpArray['cat1'] = $this->cutstr($row['category_name'], 7);
				$data_testpaper['added_questions'] []= $tmpArray;
			}
		}else{
			// 已添加的规则
			$data_testpaper['added_rules'] = array();
			$rs = $this->testpaper_model->get_test_paper_rule_list($testpaperId);
			foreach($rs as $row)
			{
				$tmpArray = array();
				$tmpArray['type'] = $typeList[$row['type']];
				$tmpArray['num'] = $row['count'];
				$tmpArray['id'] = $row['rule_id'];
				$tmpArray['cat1'] = $this->cutstr($row['category_name'], 15);
				$data_testpaper['added_rules'] []= $tmpArray;
			}
		}
	
		// 取得该试卷已经设置分值的题型一览
		$rs = $this->testpaper_model->get_point_list($testpaperId);
		$setTypeList = Array();
		foreach($rs as $row)
		{
			if($row['point'])
			{
				$setTypeList[$row['type']] = $typeList[$row['type']];
			}
		}
		$data_testpaper['setTypeList'] = $setTypeList;
		// 试卷摘要
		$pointList = array();
		$rs = $this->testpaper_model->get(array('test_paper_id'=>$testpaperId));
		$tmp['name'] = $rs['test_paper_name'];
		$tmp['question_cnt'] = 0;
		$tmp['total_point'] = 0;
	
		//var_dump($setTypeList);
	
		if( $data_testpaper['papertype']  == 1){//手动出题
	
			foreach($setTypeList as $key => $value)
			{
				$pointList[$key] = array();

				$pointList[$key]['qcnt'] = $this->testpaper_model->get_question_count($testpaperId, $key);
				$pointList[$key]['point'] = $this->testpaper_model->get_point($testpaperId, $key);
				$tmp['question_cnt'] += $pointList[$key]['qcnt'];
				$tmp['total_point'] += ($pointList[$key]['qcnt'] * $pointList[$key]['point']);
			}
	
		}else{//随机出题
	
			foreach($setTypeList as $key => $value)
			{
				$pointList[$key] = array();

				$pointList[$key]['qcnt'] = $this->testpaper_model->get_question_count_from_rule($testpaperId, $key);
				$pointList[$key]['point'] = $this->testpaper_model->get_point($testpaperId, $key);
				$tmp['question_cnt'] += $pointList[$key]['qcnt'];
				$tmp['total_point'] += ($pointList[$key]['qcnt'] * $pointList[$key]['point']);

			}
		}//END
	
	
		//var_dump($pointList);
	
		$tmp['point_list'] = $pointList;
		$data_testpaper['testpaper'] = $tmp;
	
		$data_testpaper['typeList'] = $typeList;
	
		// 载入画面
		$this->render_view('testpaper_view', $data_testpaper);
	
	}
	
	// 编辑试卷时检查所更新的试卷名是否已经被其他考试占用
	public function check_name_update($str)
	{
		$exist = $this->testpaper_model->name_exist($str,$this->session->userdata('SESSION_NAME_UPDATING_PAPERID'));
		if( !$exist ){
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('check_name_update', '该试卷名称已经被使用');
			return FALSE;
		}
	}
	
	//////////////////////////////////////////////////
	// ACTION
	// 删除试卷
	//////////////////////////////////////////////////
	function delete($testpaperId)
	{
		// 检查该试卷是否可删除
		if(!$this->check_can_delete($testpaperId))
		{
			// error!
			print("error:该试卷不可删除");
			return;
		}
	
		// 删除
		$this->testpaper_model->delete(array('test_paper_id'=>$testpaperId,'company_id'=>$this->company_id));
		redirect(base_url()."index.php/testpaper/");
	
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
	
	public function upload_cover()
	{
		log_message('info', 'upload_cover');
		$config['upload_path'] = './upload_file/cover/';//此路径相对跟目录下的文件
		$config['allowed_types'] = 'gif|jpg|jpeg|bmp|png';
		$config['file_name'] = $this->user_id.'_'.date('YmdHis', time());
		$config['max_size'] = '1024';
		
		$this->load->library('upload', $config);//加载自带的上传类库
		
		$data['jsonrpc']='2.0';
		$data['id']=$this->received_data['id'];
		if (!$this->upload->do_upload('file'))
		{
			$data['error']= array('code'=>102,'message'=>'保存失败','extra'=>$this->upload->display_errors());
		}
		else
		{	
			$data['image_name']= 'upload_file/cover/'.$config['file_name'].$this->upload->file_ext;
		}
		$this->output_data($data);
	}
	

}
