<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends WB_Controller {

	
	function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('department_model');
	}
	
	/**
	 * 用户管理首页
	 */
	public function index($search_string='---',$department_id='id0',$cur_page=1)
	{
		$search = urldecode($search_string=='---'?'':$search_string);
		$id = intval(substr($department_id,2));
		
		$data = $this->user_model->get_user_page($this->company_id,$search,$id,$cur_page);
		
		//实现分页
		$this->load->library('pagination');
		
		$this->pagination_config['base_url'] =base_url().'index.php/user/index/'.$search_string.'/'.$department_id.'/';
		$this->pagination_config['total_rows'] = $data['total'];

		$this->pagination->initialize($this->pagination_config);
		
		//提示信息初始化
		$data['info'] = "";
		$data['err'] = "";
		$data['search_string']=$search ;
		$data['department_id']=$id;
		
		$departments = $this->department_model->list_department($this->company_id);
		$data['departments'] = $departments;
		
		$this->render_view('user_list', $data);
	}
	public function create()
	{
		//表单验证
		$this->load->library('form_validation');
		//验证规则

		$this->form_validation->set_rules('username', '用户名', 'required');
		$this->form_validation->set_rules('password', '密码', 'required');
		$this->form_validation->set_rules('passconf', '确认密码', 'required|matches[password]',
				array('matches'=>'密码和确认密码不一致'));
		$this->form_validation->set_rules('name', '真实姓名', 'required');
		$this->form_validation->set_rules('mobile', '手机号码', "required|regex_match[/^\d{11}$/]",
				array('regex_match'=>'手机号码不正确'));
		
		$this->form_validation->set_message('required', '{field} 不能为空！');
	
		//提示信息
		$data['title'] = '创建用户';
		$data['to_list']='user';
		$data['info'] = "";
		$data['err'] = "";
		
		if($this->form_validation->run() == FALSE)
		{
			$departments = $this->department_model->list_department($this->company_id);
			$data['departments'] = $departments;
			
			$this->render_view('user_create', $data);
		}else{
			
			//用户是否存在
			$user =  $this->user_model->get(array('mobile'=>$this->received_data['mobile']));
			if(!empty($user))
			{
				$data['err']='手机号码已存在';
				$this->load->view('header',$this->menu);
				$this->load->view('user_create',$data);
				$this->load->view('footer');
				return  FALSE;
			}
			$user =  $this->user_model->get(array('username'=>$this->received_data['username']));
			if(!empty($user))
			{
				$data['err']='用户名已存在';
				$this->load->view('header',$this->menu);
				$this->load->view('user_create',$data);
				$this->load->view('footer');
				return  FALSE;
			}
			
			//用户注册信息
			$mobile = $this->received_data['mobile'];
			$user_info = array();
			$user_info['username'] = $this->received_data['username'];
			$user_info['name'] = $this->received_data['name'];
			$user_info['sex'] = $this->received_data['sex'];
			$user_info['mobile'] = $mobile;
			$user_info['salt']=md5($mobile.strval(time()).strval(rand(0,999999)));
			$user_info['company_id']=$this->session->userdata(SESSION_NAME_COMPANY_ID);
			$user_info['role_id']=$this->received_data['role_id'];//一般用户
			$user_info['password'] = md5(md5($this->received_data['password']).$user_info['salt']);//密码加密算法
			$user_info['update_at']=TIME_NOW;
			
			$user_id = $this->user_model->insert($user_info);
			if($user_id == FALSE)
			{
				$data['err'] = "用户添加失败";
			}else {
				$data['info'] = "用户添加成功";
			}
			if(!empty($this->received_data['department_id'])){
				$dd = $this->received_data['department_id'];
				foreach ($dd as $value){
					$this->user_model->insert_user_department(array('user_id'=>$user_id,'department_id'=>$value));
				}
				
			}
			$this->render_view('create_or_update_result',$data);
		}
				

		
		
	}
	
	public function delete($id)
	{
		//提示信息初始化
		$data['title'] = '删除用户';
		$data['to_list']='user';
		$data['info'] = "";
		$data['err'] = "";
		
		//获取要删除的用户ID错误的情况
		if(!isset($id) || $id === ""){
			$data['err'] = "获取要删除的用户失败。";
			$this->load->view('header',$this->menu);
			$this->load->view('create_or_update_result',$data);
			$this->load->view('footer');
		}
		
		//删除
		if($this->is_platform_admin()){
			$this->user_model->delete(array('user_id'=>$id));
		}else{
			$this->user_model->delete(array('company_id'=>$this->company_id,'user_id'=>$id));
			
		}
		
		//删除成功信息
		$data['info'] = "删除用户成功。";
		
		//加载页面
		$this->load->view('header',$this->menu);
		$this->load->view('create_or_update_result',$data);
		$this->load->view('footer');
	}
	
	public function update($id)
	{

		//表单验证
		$this->load->library('form_validation');
		//验证规则

		$this->form_validation->set_rules('username', '用户名', 'required');
		if(!empty($this->received_data['password'])){
			$this->form_validation->set_rules('password', '密码', 'required');
			$this->form_validation->set_rules('passconf', '确认密码', 'required|matches[password]',
				array('matches'=>'密码和确认密码不一致'));
		}
		
		$this->form_validation->set_rules('name', '真实姓名', 'required');
		$this->form_validation->set_rules('mobile', '手机号码', "required|regex_match[/^\d{11}$/]",
				array('regex_match'=>'手机号码不正确'));
		$this->form_validation->set_rules('sex', '性别', 'required');
		
		$this->form_validation->set_message('required', '{field} 不能为空！');
	
		//提示信息
		$data['title'] = '编辑用户';
		$data['to_list']='user';
		$data['info'] = "";
		$data['err'] = "";
		
		$data['user_id']=$id;
		
		$this->load->model('company_model');
		$items = $this->company_model->list_company();
		$data['company_list']=$items;
		
		if($this->form_validation->run() == FALSE)
		{
			
			if(empty($this->received_data))
			{
				if($this->is_platform_admin()){
					$user = $this->user_model->get(array('user_id'=>$id,'del'=>0));
					
				}else {
					$user = $this->user_model->get(array('company_id'=>$this->company_id,'user_id'=>$id));
				}
				
			}else{
				$user = $this->received_data;
				
			}
			$departments = $this->department_model->list_department($user['company_id']);
			foreach ($departments as $key =>$value){
				$row = $this->user_model->get_user_department(array('user_id'=>$id,'department_id'=>$value['department_id']));
				if(!empty($row)){
					$departments[$key]['checked']=TRUE;
				}else{
					$departments[$key]['checked']=FALSE;
				}
			}
			$user['departments'] = $departments;
			
			//
			$user['user_id']=$id;
			$user['err'] = "";
			$user['company_list']=$items;
			//
			$this->render_view('user_update',$user);
		}else{
			//用户是否存在
			$user =  $this->user_model->get(array('mobile'=>$this->received_data['mobile']));
			if(!empty($user)&&$user['user_id']!=$id)
			{
				$data['err']='手机号码已存在';
				$this->render_view('user_update',$data);
				return  FALSE;
			}
			$user =  $this->user_model->get(array('username'=>$this->received_data['username']));
			if(!empty($user)&&$user['user_id']!=$id)
			{
				$data['err']='用户名已存在';
				$this->render_view('user_update',$data);
				return  FALSE;
			}
			//
			$mobile = $this->received_data['mobile'];
			$user_info = array();
			$user_info['username'] = $this->received_data['username'];
			$user_info['name'] = $this->received_data['name'];
			$user_info['sex'] = $this->received_data['sex'];
			$user_info['mobile'] = $mobile;
			$user_info['role_id']=$this->received_data['role_id'];//一般用户
			$user_info['company_id']=empty($this->received_data['company_id'])?$this->company_id:$this->received_data['company_id'];
			$user_info['update_at']=TIME_NOW;
			if(!empty($this->received_data['password'])){
				$user_info['salt']=md5($mobile.strval(time()).strval(rand(0,999999)));
				$user_info['password'] = md5(md5($this->received_data['password']).$user_info['salt']);//密码加密算法
			}
			
			//
			if($this->is_platform_admin()){
				$result = $this->user_model->update($user_info,array('user_id'=>$id));
			}else {
				$result = $this->user_model->update($user_info,array('company_id'=>$this->company_id,'user_id'=>$id));
			}
			$this->user_model->delete_user_department(array('user_id'=>$id));
			if(!empty($this->received_data['department_id'])){
				$dd = $this->received_data['department_id'];
				foreach ($dd as $value){
					$this->user_model->insert_user_department(array('user_id'=>$id,'department_id'=>$value));
				}
			
			}
			if($result == FALSE)
			{
				$data['err'] = "用户编辑失败";
			}else {
				$data['info'] = "用户编辑成功";
			}
			$this->render_view('create_or_update_result',$data);
			
		}
	}
	
	function change_password()
	{

		$data['err']='';
		
		//输入参数校验
		$this->load->library('form_validation');
		$this->form_validation->set_rules('old_password', '旧密码', 'trim|required');
		$this->form_validation->set_rules('password', '新密码', 'trim|required|matches[cfmpassword]');
		$this->form_validation->set_rules('cfmpassword', '确认密码', 'trim|required');
		
		if ($this->form_validation->run() === FALSE)
		{
			$this->render_view('password_change',$data);
		}else {
			//
			$user_info =  $this->user_model->get(array('user_id'=>$this->user_id));
			
			$encrypted_old = md5(md5($this->received_data['old_password']).$user_info['salt']);
			if(!($encrypted_old == $user_info['password']))
			{
				$data['err']='旧密码输入错误!';
				$this->render_view('password_change',$data);
				return FALSE;
			}
			//
			$data_update['password'] = md5(md5($this->received_data['password']).$user_info['salt']);//密码加密算法
			$result = $this->user_model->update($data_update,array('company_id'=>$this->company_id,'user_id'=>$user_info['user_id']));
			if($result){
				$data['title'] = '修改密码';
				$data['to_list']='account';
				$data['info'] = "修改密码成功！";
				$data['err'] = "";
				$this->render_view('create_or_update_result',$data);
			}else{
				$this->render_view('password_change');
			}
		}

	}
	function import()
	{
		$this->load->helper('url');
		$this->load->helper('form');
		
		$data['error'] = array();
		$data['info'] = '';
		
		if(isset($_POST['import'])){//文件并不是放在$_POST中，所以要设这个变量来判断，不能直接if($_POST)
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
				$importError = $this->user_import($this->company_id,'./upload_file/excel/'.$config['file_name'].$this->upload->file_ext);
				if($importError != ''){
					$data['error']['importError'] = $importError;
				}else{
					$data['info'] = '导入成功';
				}
			}
		}
		
		$this->render_view('user_import', $data);
		
	}
	
	//试题导入
	private function user_import($company_id,$fileName){
	
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
	
		/** 循环读取每个单元格的数据 */
		for ($row = 2; $row <= $highestRow; $row++){//行数是以第2行开始
			$users[$row-2] = array();
	
			//试题分类
			$department_name = $sheet->getCellByColumnAndRow(5, $row)->getValue();
			if(!empty($department_name)){
				$item = $this->department_model->get(array('department_name'=>$department_name,'company_id'=>$company_id));
				if(empty($item)){
					$error = $error.'第'.($row-1).'条数据错误：所属部门['.$department_name.']不存在，请先创建部门，部门->创建部门<br/>';
						
				}else{
					$users[$row-2]['department_id'] = $item['department_id'];
				}
			}
			

			//手机
			$mobile = $sheet->getCellByColumnAndRow(4, $row)->getValue();
			if( $mobile == ''){
				$error = $error.'第'.($row-1).'条数据错误：手机号码为必填项。<br/>';
			}else{
				$users[$row-2]['mobile'] = $mobile;
			}
	
			//其他内容
			$username = $sheet->getCellByColumnAndRow(1, $row)->getValue();
			$name = $sheet->getCellByColumnAndRow(2, $row)->getValue();
			$sex = $sheet->getCellByColumnAndRow(3, $row)->getValue();

			$users[$row-2]['username'] = $username;
			$users[$row-2]['name'] =  $name;
			$users[$row-2]['sex'] =  $sex=='男'?1:2;
	
		}
		//
		if($error!=''){
			return $error;
		}
		//检查无误后开始导入
		foreach($users as $user){

			$row =  $this->user_model->get(array('username'=>$user['username']));
			if(!empty($row))
			{
				//直接修改下
				$user['username']=$user['username'].$user['mobile'];
			}
			
			//用户注册信息
			$user_info = array();
			$user_info['username'] = $user['username'];
			$user_info['name'] = $user['name'];
			$user_info['sex'] = $user['sex'];
			$user_info['mobile'] = $user['mobile'];
			$user_info['salt']=md5($mobile.strval(time()).strval(rand(0,999999)));
			$user_info['company_id']=$this->company_id;
			$user_info['role_id']=2;//一般用户
			$user_info['type']=4;//导入
			$user_info['password'] = md5(md5('abc123').$user_info['salt']);//密码加密算法
			$user_info['update_at']=TIME_NOW;
				
			$user_id = $this->user_model->insert($user_info);
			
			if(!empty($user['department_id'])){
				$this->user_model->insert_user_department(array('user_id'=>$user_id,'department_id'=>$user['department_id']));
			}
				
		}
	}
	
		
	
}
