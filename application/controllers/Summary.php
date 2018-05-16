<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Summary extends WB_Controller {

	
	function __construct()
	{
		parent::__construct();
		$this->load->model('summary_model');
		
		$this->load->library('pagination');
	}
	
	public function index()
	{

		redirect(base_url().'index.php/summary/list_test');
		
	}
	
	public function list_test($search_string='---',$cur_page=1)
	{
		$search = urldecode($search_string=='---'?'':$search_string);
		$company_id = $this->company_id;
		$data = $this->summary_model->get_test_page($search,$company_id,$cur_page);
		
		//实现分页
		$this->pagination_config['base_url'] =base_url().'index.php/summary/list_test/'.$search_string.'/';
		$this->pagination_config['total_rows'] = $data['total'];
		$this->pagination->initialize($this->pagination_config);
		
		//提示信息初始化
		$data['search_string']=$search;
		$this->render_view('summary_test_list',$data);
	}
	public function export_all_test($search_string='---',$cur_page=1)
	{
		$search = urldecode($search_string=='---'?'':$search_string);
		$company_id = $this->company_id;
		$data = $this->summary_model->get_test_page($search,$company_id,$cur_page,10000);

		//导出Excel
		$fileName = '测试统计-'.date('Y-m-d',time());
		
		//初始化excel工具类
		$this->load->library('PHPExcel');
		
		$PHPExcel = new PHPExcel();
		
		//设置基本信息
		$PHPExcel->getProperties()->setCreator("KuaiyuIT")
		->setLastModifiedBy("KuaiyuIT")
		->setTitle("海螺学院GMP测评中心")
		->setSubject("测试统计")
		->setDescription("")
		->setKeywords("测试统计")
		->setCategory("");
		$PHPExcel->setActiveSheetIndex(0);
		$PHPExcel->getActiveSheet()->setTitle('测试测试-'.date('Y-m-d',time()));
		
		//填入表头
		$PHPExcel->getActiveSheet()->setCellValue('A1', '测试名称');
		$PHPExcel->getActiveSheet()->setCellValue('B1', '开始时间');
		$PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
		$PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
		$PHPExcel->getActiveSheet()->setCellValue('C1', '结束时间');
		$PHPExcel->getActiveSheet()->setCellValue('D1', '题目数量');
		$PHPExcel->getActiveSheet()->setCellValue('E1', '参与人数');
		$PHPExcel->getActiveSheet()->setCellValue('F1', '通过率');
		$PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
		$PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
		$PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
		$PHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
		
		
		$PHPExcel->getActiveSheet()->getStyle('A1:F1')->getFont()->setName('黑体');
		$PHPExcel->getActiveSheet()->getStyle('A1:F1')->getFont()->setSize(12);
		$PHPExcel->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);
		
		
		//填入列表
		$k = 1;
		foreach ($data['item_list'] as $key => $value){
			$k++;
		
			$PHPExcel->getActiveSheet()->setCellValue('A'.$k, $value['test_name']);
			$PHPExcel->getActiveSheet()->setCellValue('B'.$k, substr($value['start_time'],0,10));
			$PHPExcel->getActiveSheet()->setCellValue('C'.$k, substr($value['end_time'],0,10));
			$PHPExcel->getActiveSheet()->setCellValue('D'.$k, $value['question_count']);
			$PHPExcel->getActiveSheet()->setCellValue('E'.$k, $value['user_count']);
			$PHPExcel->getActiveSheet()->setCellValue('F'.$k, $value['pass_rate']);
		}
		$PHPExcel->getActiveSheet()->freezePane("A2");
		$PHPExcel->getActiveSheet()->getProtection()->setSheet(true);
		$PHPExcel->getActiveSheet()->protectCells('A1:F'.$k, time());
		
		
		
		//保存为2003格式
		$objWriter = new PHPExcel_Writer_Excel5($PHPExcel);
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
		header("Content-Type:application/force-download");
		header("Content-Type:application/vnd.ms-execl");
		header("Content-Type:application/octet-stream");
		header("Content-Type:application/download");
		
		//多浏览器下兼容中文标题
		$encoded_filename = urlencode($fileName);
		$ua = $_SERVER["HTTP_USER_AGENT"];
		if (preg_match("/MSIE/", $ua)) {
			header('Content-Disposition: attachment; filename="' . $encoded_filename . '.xls"');
		} else if (preg_match("/Firefox/", $ua)) {
			header('Content-Disposition: attachment; filename*="utf8\'\'' . $fileName . '.xls"');
		} else {
			header('Content-Disposition: attachment; filename="' . $fileName . '.xls"');
		}
		
		header("Content-Transfer-Encoding:binary");
		$objWriter->save('php://output');
		
	}
	
	
	public function list_user($search_string='---',$cur_page=1)
	{
		$search = urldecode($search_string=='---'?'':$search_string);
		$company_id =  $this->company_id;
		$data = $this->summary_model->get_user_page($search,$company_id,$cur_page);
	
		//实现分页
		$this->pagination_config['base_url'] =base_url().'index.php/summary/list_user/'.$search_string.'/';
		$this->pagination_config['total_rows'] = $data['total'];
		$this->pagination->initialize($this->pagination_config);
	
		//提示信息初始化
		$data['search_string']=$search;
		$this->render_view('summary_user_list',$data);
	}
	public function export_all_user($search_string='---',$cur_page=1)
	{
		$search = urldecode($search_string=='---'?'':$search_string);
		$company_id =  $this->company_id;
		$data = $this->summary_model->get_user_page($search,$company_id,$cur_page,10000);
	

		//导出Excel
		$fileName = '用户统计-'.date('Y-m-d',time());
		
		//初始化excel工具类
		$this->load->library('PHPExcel');
		
		$PHPExcel = new PHPExcel();
		
		//设置基本信息
		$PHPExcel->getProperties()->setCreator("KuaiyuIT")
		->setLastModifiedBy("KuaiyuIT")
		->setTitle("海螺学院GMP测评中心")
		->setSubject("用户统计")
		->setDescription("")
		->setKeywords("用户统计")
		->setCategory("");
		$PHPExcel->setActiveSheetIndex(0);
		$PHPExcel->getActiveSheet()->setTitle($fileName);
		
		//填入表头
		$PHPExcel->getActiveSheet()->setCellValue('A1', '用户名');
		$PHPExcel->getActiveSheet()->setCellValue('B1', '手机号');
		$PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
		$PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		if($this->is_platform_admin()){
			$PHPExcel->getActiveSheet()->setCellValue('C1', '公司');
			$PHPExcel->getActiveSheet()->setCellValue('D1', '测试次数');
			$PHPExcel->getActiveSheet()->setCellValue('E1', '通过次数');
			$PHPExcel->getActiveSheet()->setCellValue('F1', '通过率');
			$PHPExcel->getActiveSheet()->setCellValue('G1', '总题数');
			$PHPExcel->getActiveSheet()->setCellValue('H1', '正确率');
			$PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
			$PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
			$PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
			$PHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
			$PHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
			$PHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
		}else{
			$PHPExcel->getActiveSheet()->setCellValue('C1', '测试次数');
			$PHPExcel->getActiveSheet()->setCellValue('D1', '通过次数');
			$PHPExcel->getActiveSheet()->setCellValue('E1', '通过率');
			$PHPExcel->getActiveSheet()->setCellValue('F1', '总题数');
			$PHPExcel->getActiveSheet()->setCellValue('G1', '正确率');
			$PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
			$PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
			$PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
			$PHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
			$PHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
		}
		
		$PHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->setName('黑体');
		$PHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->setSize(12);
		$PHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);
		
		
		//填入列表
		$k = 1;
		foreach ($data['item_list'] as $key => $value){
			$k++;
		
			$PHPExcel->getActiveSheet()->setCellValue('A'.$k, $value['username']);
			$PHPExcel->getActiveSheet()->setCellValue('B'.$k, $value['mobile']);
			if($this->is_platform_admin()){
				$PHPExcel->getActiveSheet()->setCellValue('C'.$k, $value['company_name']);
				$PHPExcel->getActiveSheet()->setCellValue('D'.$k, $value['test_count']);
				$PHPExcel->getActiveSheet()->setCellValue('E'.$k, $value['pass_count']);
				$PHPExcel->getActiveSheet()->setCellValue('F'.$k, $value['pass_rate']);
				$PHPExcel->getActiveSheet()->setCellValue('G'.$k, $value['question_count']);
				$PHPExcel->getActiveSheet()->setCellValue('H'.$k, $value['correct_rate']);
			}else{
				$PHPExcel->getActiveSheet()->setCellValue('C'.$k, $value['test_count']);
				$PHPExcel->getActiveSheet()->setCellValue('D'.$k, $value['pass_count']);
				$PHPExcel->getActiveSheet()->setCellValue('E'.$k, $value['pass_rate']);
				$PHPExcel->getActiveSheet()->setCellValue('F'.$k, $value['question_count']);
				$PHPExcel->getActiveSheet()->setCellValue('G'.$k, $value['correct_rate']);
			}
			
		}
		$PHPExcel->getActiveSheet()->freezePane("A2");
		$PHPExcel->getActiveSheet()->getProtection()->setSheet(true); 
		$PHPExcel->getActiveSheet()->protectCells('A1:H'.$k, time());
		
		
		
		//保存为2003格式
		$objWriter = new PHPExcel_Writer_Excel5($PHPExcel);
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
		header("Content-Type:application/force-download");
		header("Content-Type:application/vnd.ms-execl");
		header("Content-Type:application/octet-stream");
		header("Content-Type:application/download");
		
		//多浏览器下兼容中文标题
		$encoded_filename = urlencode($fileName);
		$ua = $_SERVER["HTTP_USER_AGENT"];
		if (preg_match("/MSIE/", $ua)) {
			header('Content-Disposition: attachment; filename="' . $encoded_filename . '.xls"');
		} else if (preg_match("/Firefox/", $ua)) {
			header('Content-Disposition: attachment; filename*="utf8\'\'' . $fileName . '.xls"');
		} else {
			header('Content-Disposition: attachment; filename="' . $fileName . '.xls"');
		}
		
		header("Content-Transfer-Encoding:binary");
		$objWriter->save('php://output');
		
	}
	
	public function list_coin($search_string='---',$cur_page=1)
	{
		$search = urldecode($search_string=='---'?'':$search_string);
		$company_id =  $this->company_id;
		$data = $this->summary_model->get_coin_page($search,$company_id,$cur_page);
	
		//实现分页
		$this->pagination_config['base_url'] =base_url().'index.php/summary/list_coin/'.$search_string.'/';
		$this->pagination_config['total_rows'] = $data['total'];
		$this->pagination->initialize($this->pagination_config);
	
		//提示信息初始化
		$data['search_string']=$search;
		$this->render_view('summary_coin_list',$data);
	}
	public function view_test($test_id,$cur_page=1)
	{
		$company_id = $this->company_id;
		$data = $this->summary_model->get_test_detail_page($test_id,$company_id,$cur_page);
		$data['test_id']=$test_id;
	
		//实现分页
		$this->pagination_config['base_url'] =base_url().'index.php/summary/view_test/'.$test_id.'/';
		$this->pagination_config['total_rows'] = $data['total'];
		$this->pagination->initialize($this->pagination_config);

		$this->render_view('summary_test_view',$data);
	}
	public function export_test($test_id,$cur_page=1)
	{
		$company_id = $this->company_id;
		$data = $this->summary_model->get_test_detail_page($test_id,$company_id,$cur_page,10000);
	
		//导出Excel
		$fileName = $data['test_name'].'测试名细-'.date('Y-m-d',time());
		
		//初始化excel工具类
		$this->load->library('PHPExcel');
		
		$PHPExcel = new PHPExcel();
		
		//设置基本信息
		$PHPExcel->getProperties()->setCreator("KuaiyuIT")
		->setLastModifiedBy("KuaiyuIT")
		->setTitle("海螺学院GMP测评中心")
		->setSubject("测试名细")
		->setDescription("")
		->setKeywords("测试名细")
		->setCategory("");
		$PHPExcel->setActiveSheetIndex(0);
		$PHPExcel->getActiveSheet()->setTitle('测试名细-'.date('Y-m-d',time()));
		
		//填入表头
		$PHPExcel->getActiveSheet()->setCellValue('A1', '用户名');
		$PHPExcel->getActiveSheet()->setCellValue('B1', '测试开始时间');
		$PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
		$PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
		$PHPExcel->getActiveSheet()->setCellValue('C1', '测试完成时间');
		$PHPExcel->getActiveSheet()->setCellValue('D1', '用时');
		$PHPExcel->getActiveSheet()->setCellValue('E1', '总题数');
		$PHPExcel->getActiveSheet()->setCellValue('F1', '正确题数');
		$PHPExcel->getActiveSheet()->setCellValue('G1', '是否通过');
		$PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
		$PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
		$PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
		$PHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
		$PHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);

		
		$PHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->setName('黑体');
		$PHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->setSize(12);
		$PHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);
		
		
		//填入列表
		$k = 1;
		foreach ($data['item_list'] as $key => $value){
			$k++;
		
			$PHPExcel->getActiveSheet()->setCellValue('A'.$k, $value['username']);
			$PHPExcel->getActiveSheet()->setCellValue('B'.$k, $value['start_time']);
			$PHPExcel->getActiveSheet()->setCellValue('C'.$k, $value['end_time']);
			$PHPExcel->getActiveSheet()->setCellValue('D'.$k, $value['minute']);
			$PHPExcel->getActiveSheet()->setCellValue('E'.$k, $value['question_count']);
			$PHPExcel->getActiveSheet()->setCellValue('F'.$k, $value['correct_count']);
			$PHPExcel->getActiveSheet()->setCellValue('G'.$k, $value['passed']);
		}
		$PHPExcel->getActiveSheet()->freezePane("A2");
		$PHPExcel->getActiveSheet()->getProtection()->setSheet(true);
		$PHPExcel->getActiveSheet()->protectCells('A1:G'.$k, time());
		
		
		
		//保存为2003格式
		$objWriter = new PHPExcel_Writer_Excel5($PHPExcel);
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
		header("Content-Type:application/force-download");
		header("Content-Type:application/vnd.ms-execl");
		header("Content-Type:application/octet-stream");
		header("Content-Type:application/download");
		
		//多浏览器下兼容中文标题
		$encoded_filename = urlencode($fileName);
		$ua = $_SERVER["HTTP_USER_AGENT"];
		if (preg_match("/MSIE/", $ua)) {
			header('Content-Disposition: attachment; filename="' . $encoded_filename . '.xls"');
		} else if (preg_match("/Firefox/", $ua)) {
			header('Content-Disposition: attachment; filename*="utf8\'\'' . $fileName . '.xls"');
		} else {
			header('Content-Disposition: attachment; filename="' . $fileName . '.xls"');
		}
		
		header("Content-Transfer-Encoding:binary");
		$objWriter->save('php://output');
	}
	
	public function view_user($user_id=0,$cur_page=1)
	{
		$company_id =  $this->company_id;
		$data = $this->summary_model->get_user_detail_page($user_id,$company_id,$cur_page);
	
		//实现分页
		$this->pagination_config['base_url'] =base_url().'index.php/summary/view_user/'.$user_id.'/';
		$this->pagination_config['total_rows'] = $data['total'];
		$this->pagination->initialize($this->pagination_config);

		$this->render_view('summary_user_view',$data);
	}
	
	

	
}
