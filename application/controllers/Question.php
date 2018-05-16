<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Question extends WB_Controller {

	
	function __construct()
	{
		parent::__construct();
		$this->load->model('question_model');
	}
	
	/**
	 * 题库首页
	 */
	public function index($type='t0',$category_id='c0',$cur_page=1)
	{
		
		//
		$t = intval(substr($type,1));
		$c = intval(substr($category_id,1));
		
		$data = $this->question_model->get_question_page($this->company_id,$t,$c,$cur_page);
		$cats = $this->question_model->get_category_list();
		$data['cats']=$cats;
		//实现分页
		$this->load->library('pagination');
		
		$this->pagination_config['base_url'] =base_url().'index.php/question/index/'.$type.'/'.$category_id.'/';
		$this->pagination_config['total_rows'] = $data['total'];

		$this->pagination->initialize($this->pagination_config);
		
		$data['category_id']=$c;
		$data['type']=$t;
		$this->render_view('question_list', $data);
		
	}
	public function create()
	{
		
		// 取得表单提交内容
		
		if($_POST)
		{
		
			$ques_type = $this->input->post('ques_type');
			$ques_cat = $this->input->post('ques_cat');
			$ques_difficulty = $this->input->post('ques_difficulty');
			$ques_sop = $this->input->post('ques_sop');
				
			//获取题目
			$question_content = $this->input->post('question_content');

			//取选项的内容
			$answer_tmp = '';

			$choice_array=array('choice_content_a','choice_content_b','choice_content_c','choice_content_d','choice_content_e','choice_content_f','choice_content_g','choice_content_h','choice_content_i','choice_content_j');
			$choice_no=array('A','B','C','D','E','F','G','H','I','J');
			$i=0;
	
			for($i=0;$i<10;$i++)
			{
				if($_POST[$choice_array[$i]]!='')
				{
					$choice_option[$i] = $choice_no[$i];
					$choice_content[$i] = $_POST[$choice_array[$i]];
					$choice_content[$i] = $choice_content[$i];
				}
			}
				
			//取answer的值
			if($ques_type == 2)
			{
				$ans_name = 'ans_check';
				foreach($_POST[$ans_name] as $var)//通过foreach循环取出多选框中的值  $_POST["choice"]
				{
					$answer_tmp=$answer_tmp.$var;
				}
			}
			else
			{
				$ans_name = 'ans_radio';
				$answer_tmp=$_POST[$ans_name];
			}
				
			$question = array();
			$question['category_id']=$ques_cat;
			$question['company_id']=$this->company_id;
			$question['type']=$ques_type;
			$question['difficulty_id']=$ques_difficulty;
			$question['sop_id']=$ques_sop;
			$question['question']=$question_content;
			$question['answer']=$answer_tmp;
			
			$this->question_model->create_question($question,$choice_content,$choice_no);
			

				
			//跳转到试题列表
			redirect(base_url()."index.php/question/index");
		}
		$cats = $this->question_model->get_category_list();
		$data['cats']=$cats;
		
		$difs = $this->question_model->get_difficulty_list();
		$data['difs']=$difs;
		
		$sops = $this->question_model->get_sop_list($this->company_id);
		$data['sops']=$sops;
		
		$this->render_view('question_create', $data);
	}
	
	
	public function delete($id)
	{
		//提示信息初始化
		$data['title'] = '删除试题';
		$data['to_list']='question';
		$data['info'] = "";
		$data['err'] = "";
		
		//获取要删除的用户ID错误的情况
		if(!isset($id) || $id === ""){
			$data['err'] = "获取要删除的试题失败。";
			$this->render_view('create_or_update_result',$data);
		}

		$this->question_model->delete(array('question_id'=>$id,'company_id'=>$this->company_id));
		
		//删除成功信息
		$data['info'] = "删除试题成功。";
		
		//加载页面
		$this->render_view('create_or_update_result',$data);
	}
	
	public function delete_all($ids)
	{
		//提示信息初始化
		$data['title'] = '删除试题';
		$data['to_list']='question';
		$data['info'] = "";
		$data['err'] = "";
	
		//获取要删除的用户ID错误的情况
		if(!isset($ids) || $ids === ""){
			$data['err'] = "获取要删除的试题失败。";
			$this->render_view('create_or_update_result',$data);
		}
	
		$this->question_model->delete_all($this->company_id,$ids);
	
		//删除成功信息
		$data['info'] = "删除试题成功。";
	
		//加载页面
		$this->render_view('create_or_update_result',$data);
	}
	
	/**
	 * 查看问题
	 * @param unknown $id问题ID
	 */
	public function view($id)
	{

		$question_detail = $this->question_model->get_question_detail($id);
				
		$this->render_view('question_view', $question_detail);
		
	}
	
	public function update($id)
	{
		// 取得表单提交内容
	
		if($_POST)
		{
	
			$ques_type = $this->input->post('ques_type');
			$ques_cat = $this->input->post('ques_cat');
			$ques_difficulty = $this->input->post('ques_difficulty');
			$ques_sop = $this->input->post('ques_sop');
	
			//获取题目
			$question_content = $this->input->post('question_content');
	
			//取选项的内容
			$answer_tmp = '';
	
			$choice_array=array('choice_content_a','choice_content_b','choice_content_c','choice_content_d','choice_content_e','choice_content_f','choice_content_g','choice_content_h','choice_content_i','choice_content_j');
			$choice_no=array('A','B','C','D','E','F','G','H','I','J');
			$i=0;
	
			for($i=0;$i<10;$i++)
			{
				if($_POST[$choice_array[$i]]!='')
				{
					$choice_option[$i] = $choice_no[$i];
					$choice_content[$i] = $_POST[$choice_array[$i]];
					$choice_content[$i] = $choice_content[$i];
				}
			}
	
			//取answer的值
			if($ques_type == 2)
			{
				$ans_name = 'ans_check';
				foreach($_POST[$ans_name] as $var)//通过foreach循环取出多选框中的值  $_POST["choice"]
				{
					$answer_tmp=$answer_tmp.$var;
				}
			}
			else
			{
				$ans_name = 'ans_radio';
				$answer_tmp=$_POST[$ans_name];
			}
	
			$question = array();
			$question['category_id']=$ques_cat;
			$question['type']=$ques_type;
			$question['difficulty_id']=$ques_difficulty;
			$question['sop_id']=$ques_sop;
			$question['question']=$question_content;
			$question['answer']=$answer_tmp;
				
			$this->question_model->update_question($id,$this->company_id,$question,$choice_content,$choice_no);
				
	
	
			//跳转到试题列表
			redirect(base_url()."index.php/question/index");
		}
		$cats = $this->question_model->get_category_list();
		$data['cats']=$cats;
	
		$difs = $this->question_model->get_difficulty_list();
		$data['difs']=$difs;
	
		$sops = $this->question_model->get_sop_list($this->company_id);
		$data['sops']=$sops;
		
		//初始化
		$question_detail = $this->question_model->get_question_detail($id);
		$data['question']=$question_detail['question'];
		$data['choice']=$question_detail['choice'];
		$data['s_type'] = $question_detail['question']['type'];
		$data['s_cat1'] = $question_detail['question']['category_id'];
		$data['s_cat2'] = $question_detail['question']['difficulty_id'];
		$data['s_cat3'] = $question_detail['question']['sop_id'];
		
	
		$this->render_view('question_update', $data);
	}
	
	//试题excel文件上传
	public function import(){

		$this->load->helper('url');
		$this->load->helper('form');
	
		$data['error'] = array();
		$data['info'] = '';
	
		if(isset($_POST['questionType'])){//文件并不是放在$_POST中，所以要设这个变量来判断，不能直接if($_POST)
			$config['upload_path'] = './upload_file/excel/';//此路径相对跟目录下的文件
			$config['allowed_types'] = 'xls|xlsx';
			$config['file_name'] = $this->user_id.'_'.date('YmdHis', time());
			$config['max_size'] = '10240';
	
			$this->load->library('upload', $config);//加载自带的上传类库
	
			if (!$this->upload->do_upload())
			{
				$data['error'] = array('error' => $this->upload->display_errors());
			}
			else
			{
				log_message('info', '公司'.$this->company_id.'导入文件'.'./upload_file/excel/'.$config['file_name'].$this->upload->file_ext);
				$importError = $this->question_import($this->company_id,'./upload_file/excel/'.$config['file_name'].$this->upload->file_ext);
				if($importError != ''){
					$data['error']['importError'] = $importError;
				}else{
					$data['info'] = '导入成功';
				}
			}
		}
	
		$this->render_view('question_import', $data);
	}
	
	//试题导入
	private function question_import($company_id,$fileName){

		//错误信息初始化
		$error = '';
		//待导入的所有的试题集合
		$questions = array();
	
		//初始化excel工具类
		$this->load->library('PHPExcel');
		//创建excel导入类
		//$objExcel = new PHPExcel_IOFactory();
		//创建excel读工具类
		$excelReader = PHPExcel_IOFactory::createReaderForFile($fileName);
		$excelFile = $excelReader->load($fileName);

		// 读取第一個工作表
		$sheet = $excelFile->getSheet(0);
		// 取得总行数
		$highestRow = $sheet->getHighestRow();
		// 取得总列数
		$highestColumm = $sheet->getHighestColumn();
		//字母列转换为数字列 如:AA变为27
		$highestColumm= PHPExcel_Cell::columnIndexFromString($highestColumm);
	
	
		//取选项的内容初始化
		$choice_array=array('choice_content_a','choice_content_b','choice_content_c','choice_content_d','choice_content_e','choice_content_f','choice_content_g','choice_content_h','choice_content_i','choice_content_j');
		$choice_no=array('A','B','C','D','E','F','G','H','I','J');
		/** 循环读取每个单元格的数据 */
		for ($row = 2; $row <= $highestRow; $row++){//行数是以第2行开始
			$questions[$row-2] = array();

			//试题分类
			$category_name = $sheet->getCellByColumnAndRow(1, $row)->getValue();
			
			if( $category_name == ''){
				$error = $error.'第'.($row-1).'条数据错误：试题分类为必填项。<br/>';
			}else{
				$item = $this->question_model->get_category(array('category_name'=>$category_name));
				if(empty($item)){
					$error = $error.'第'.($row-1).'条数据错误：试题分类['.$category_name.']不存在，请先在题库->管理分类创建分类<br/>';
					
				}else{
					$questions[$row-2]['category_id'] = $item['category_id'];
				}
			}
			//难度
			$dif_name = $sheet->getCellByColumnAndRow(13, $row)->getValue();
			if( $category_name == ''){
				$error = $error.'第'.($row-1).'条数据错误：试题难度为必填项。<br/>';
			}else{
				$item = $this->question_model->get_difficulty(array('difficulty_name'=>$dif_name));
				if(empty($item)){
					$error = $error.'第'.($row-1).'条数据错误：试题难度['.$dif_name.']不存在，请先在题库->管理分类创建难度<br/>';
						
				}else{
					$questions[$row-2]['difficulty_id'] = $item['difficulty_id'];
				}
			}
			//SOP
			$sop_name = $sheet->getCellByColumnAndRow(14, $row)->getValue();
			if( $sop_name == ''){
				
			}else{
				$item = $this->question_model->get_sop(array('sop_name'=>$sop_name,'company_id'=>$company_id));
				if(empty($item)){
					//$error = $error.'第'.($row-1).'条数据错误：试题SOP['.$sop_name.']不存在，请先在题库->管理分类创建SOP<br/>';
					$sop_id = $this->question_model->insert_attribute(3,array('sop_name'=>$sop_name,'company_id'=>$company_id));
					if($sop_id){
						$questions[$row-2]['sop_id'] = $sop_id;
					}
						
				}else{
					$questions[$row-2]['sop_id'] = $item['sop_id'];
				}
			}
			//试题内容
			$question_content = $sheet->getCellByColumnAndRow(2, $row)->getValue();
			if( $question_content == ''){
				$error = $error.'第'.($row-1).'条数据错误：考试试题内容为必填项。<br/>';
			}else{
				$questions[$row-2]['question'] = $question_content;
			}
	
			$choice_content = array();
	
			//试题选项
			for($i=0;$i<10;$i++)
			{
				if($sheet->getCellByColumnAndRow(3+$i, $row)->getValue() != '')
				{
					$choice_option[$i] = $choice_no[$i];
					$choice_content[$i] = $sheet->getCellByColumnAndRow(3+$i, $row)->getValue();
				}
			}
			$questions[$row-2]['choice_option'] = $choice_option;
			$questions[$row-2]['choice_content'] = $choice_content;
				
			unset($choice_content);
	
			//正确答案
			if(!preg_match("/^[A-Ja-j,]{1,10}$/",$sheet->getCellByColumnAndRow($highestColumm-1, $row)->getValue())){
				$error = $error.'第'.($row-1).'条数据错误：考试试题正确答案必须为A-J的字母。'.$sheet->getCellByColumnAndRow($highestColumm-1, $row)->getValue().'<br/>';
			}else{
				$questions[$row-2]['answer'] = strtoupper($sheet->getCellByColumnAndRow($highestColumm-1, $row)->getValue());
				$questions[$row-2]['answer'] = str_replace(',','',$questions[$row-2]['answer']);
				if(strlen($questions[$row-2]['answer'])>1){
					$questions[$row-2]['type']=2;//多选
				}else{
					$questions[$row-2]['type']=1;
				}
			}
		}
		//
		if($error!=''){
			return $error;
		}
		//检查无误后开始导入
		foreach($questions as $question){
			//题目和答案存入DB
			$question_info = array();//$question里有多余的choice_content
			$question_info['category_id']=$question['category_id'];
			$question_info['company_id']=$company_id;
			$question_info['type']=$question['type'];
			$question_info['difficulty_id']=$question['difficulty_id'];
			if(!empty($question['sop_id'])){
				$question_info['sop_id']=$question['sop_id'];
			}
			$question_info['question']=$question['question'];
			$question_info['answer']=$question['answer'];
			$insert_ques_id = $this->question_model->insert($question_info);

			//选项存入DB
			for($i=0;$i<count($question['choice_content']);$i++)
			{
				$choice = array();
				$choice['question_id']=$insert_ques_id;
				$choice['content']=$question['choice_content'][$i];
				$choice['option_name']=$question['choice_option'][$i];
				
				$this->question_model->insert_choice($choice);
			}
			
		}
	}
	
	public function list_attribute()
	{
		$cats = $this->question_model->get_category_list();
		$data['cats']=$cats;
		
		$difs = $this->question_model->get_difficulty_list();
		$data['difs']=$difs;
		
		$sops = $this->question_model->get_sop_list($this->company_id);
		$data['sops']=$sops;
		
		$this->render_view('question_attribute_list', $data);
	}
	public function create_attribute($type)
	{
		if($type!=3 && (!$this->is_platform_admin())){
			show_404();
		}
		if($type==1){
			$type_name="分类";
			$type_field_name='category_name';
		}else if($type==2){
			$type_field_name='difficulty_name';
			$type_name="难度";
		}else if($type==3)
		{
			$type_field_name='sop_name';
			$type_name="SOP";
		}else{
			show_404();
		}
		//表单验证
		$this->load->library('form_validation');
		//验证规则
		$this->form_validation->set_rules('attr_name', $type_name, "required|max_length[10]");

		
		if($this->form_validation->run() == FALSE)
		{
			$data['type']=$type;
			$data['type_name']=$type_name;
			$data['attr_name']=isset($this->received_data['attr_name'])?$this->received_data['attr_name']:'';
			$this->render_view('question_attribute_create',$data);
		}else{
			$attr = $this->question_model->get_attribute($type, array($type_field_name=>$this->received_data['attr_name'],
					'company_id'=>$this->company_id));
			if(!empty($attr)){
				$this->question_model->update_attribute($type, $attr['id'],$this->company_id,
						array('del'=>0,'update_at'=>TIME_NOW));
			}else{
				$this->question_model->insert_attribute($type, array($type_field_name=>$this->received_data['attr_name'],
						'company_id'=>$this->company_id));
			}
			
			redirect(base_url().'index.php/question/list_attribute');
		}
	
	}
	public function update_attribute($type,$attr_id)
	{
		if($type!=3 && (!$this->is_platform_admin())){
			show_404();
		}
		if($type==1){
			$type_name="分类";
			$type_field_name='category_name';
		}else if($type==2){
			$type_field_name='difficulty_name';
			$type_name="难度";
		}else if($type==3)
		{
			$type_field_name='sop_name';
			$type_name="SOP";
		}else{
			show_404();
		}
		//表单验证
		$this->load->library('form_validation');
		//验证规则
		$this->form_validation->set_rules('attr_name', $type_name, "required|max_length[10]");

		
		if($this->form_validation->run() == FALSE)
		{
			$data['type']=$type;
			$data['type_name']=$type_name;
			$data['attr_id'] = $attr_id;
			$data['attr_name']= $this->question_model->get_attribute_name($type,$attr_id);
			$this->render_view('question_attribute_update',$data);
		}else{
			$this->question_model->update_attribute($type, $attr_id,$this->company_id,array($type_field_name=>$this->received_data['attr_name'],'update_at'=>TIME_NOW));
			redirect(base_url().'index.php/question/list_attribute');
		}
	}
	public function delete_attribute($type,$attr_id)
	{
		if($type!=3 && (!$this->is_platform_admin())){
			show_404();
		}
		
		if($type==1){
			$type_name="分类";
			$type_field_name='category_name';
		}else if($type==2){
			$type_field_name='difficulty_name';
			$type_name="难度";
		}else if($type==3)
		{
			$type_field_name='sop_name';
			$type_name="SOP";
		}else{
			show_404();
		}
		
		$this->question_model->delete_attribute($type, $attr_id,$this->company_id);
		redirect(base_url().'index.php/question/list_attribute');
	}
	
	
}
