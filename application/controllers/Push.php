<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 极光推送，通过linux cron 执行
 * * * * * * cd /alidata1/albert/phpweb/devweb/gmpapi/ && php index.php push run
 * @author Albert_2
 *
 */
class Push extends CI_Controller {

	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function run()
	{
		$this->load->library('JPush');//这里是大写，大用的时候只能全小写
		$this->load->model('test_model');
		
		for($cur_page=1;$cur_page<9999999;$cur_page++){
			$tasks = $this->test_model->get_tasks($cur_page,10000);//一次最多取一万条任务记录
			$prev_test_id=0;
			$test_id=0;
			$title='海螺学院GMP测试';
			$jiguang_id = array();
			$content='';
			$count=0;
			if(empty($tasks)){
				break;
			}
			//
			foreach ($tasks as $key=>$value){
			
				$prev_test_id = $test_id;
				$test_id = $value['test_id'];
				if($count>=200 ||($test_id!=$prev_test_id && $prev_test_id!=0))
				{
					$this->jpush->send($jiguang_id, $title, $content, $prev_test_id);//新的ID，把前一个ID发出去
					if($test_id!=$prev_test_id){
						$this->test_model->update_test_task(array('is_sent'=>1),array('test_id'=>$prev_test_id,'is_sent'=>0));
					}
					$count=0;
					$jiguang_id = array();
				}		
				$content=$value['test_name'];
				$jiguang_id[]=$value['jiguang_id'];
				$count++;
			
			}
			$this->jpush->send($jiguang_id, $title, $content, $test_id);//把剩下的当前ID发出去
			$this->test_model->update_test_task(array('is_sent'=>1),array('test_id'=>$test_id,'is_sent'=>0));
		}
		
	}
	
	public function create_test_task()
	{
		$this->load->library('JPush');
		$this->load->model('test_model');
		$this->load->model('user_model');
	
		$pushes = $this->test_model->get_test_list(array('is_daily_push'=>1));
		if(empty($pushes)){
			return;
		}
		foreach ($pushes as $key=>$value){//对每一个测试进行处理
			if(empty($value['department_id'])){//对所有人推送
				$value['department_id']=array();
			}else{
				$value['department_id']=explode(',', $value['department_id']);
			}
			for($cur_page=1;$cur_page<9999999;$cur_page++){
				$result = $this->user_model->get_push_user_page($value['company_id'],$value['department_id'],$cur_page,10000);
				if(empty($result['item_list'])){
					break;
				}
				foreach ($result['item_list'] as $key2 =>$value2){
					$tt = $this->test_model->get_test_task(array('test_id'=>$value['test_id'],'user_id'=>$value2['user_id'],'test_result_id'=>0));
					if(empty($tt)){
						$result = $this->test_model->insert_test_task(array('test_id'=>$value['test_id'],'user_id'=>$value2['user_id'],'jiguang_id'=>$value2['jiguang_id'],
								'send_company_id'=>$value['company_id']
						));
					}else{
						$result = $this->test_model->update_test_task(array('is_sent'=>0),
								array('test_id'=>$value['test_id'],'user_id'=>$value2['user_id'],'test_result_id'=>0));
					}
						
				}
			}
		}
		
		echo '推送任务生成完成，'.TIME_NOW;
		
		
			
	}
		
	
}
