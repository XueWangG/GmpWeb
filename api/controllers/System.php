<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('system_model');
		$this->load->helper('url');
		
	}
	
	public function update_app()
	{
		$data['need_update']=FALSE;
		
		$app = $this->system_model->get_latest_app();
		if(!empty($app)&&$app['version']!=$this->received_data['version']){
			$data['need_update']=TRUE;
			$data['version']=$app['version'];
			$data['url']=base_url().'upload_file/app/'.$app['file_name'];
			$data['descreption']=$app['description'];
			$data['create_at']=$app['create_at'];
		}
		
		
		$this->output_ok($data);
	}
	
	public function get_user_agreement()
	{
		$this->output_ok(array('url'=>base_url().'agreement.html'));
	}
	
	public function get_aboutus()
	{
		$this->output_ok(array('url'=>base_url().'aboutus.html'));
	}
	
}
