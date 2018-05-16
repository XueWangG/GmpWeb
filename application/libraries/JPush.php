<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'/libraries/JPush/Client.php');//极光SDK包中的文件
require_once(APPPATH.'/libraries/JPush/Config.php');
require_once(APPPATH.'/libraries/JPush/DevicePayload.php');
require_once(APPPATH.'/libraries/JPush/Http.php');
require_once(APPPATH.'/libraries/JPush/PushPayload.php');
require_once(APPPATH.'/libraries/JPush/ReportPayload.php');
require_once(APPPATH.'/libraries/JPush/SchedulePayload.php');
require_once(APPPATH.'/libraries/JPush/version.php');
require_once(APPPATH.'/libraries/JPush/Exceptions/JPushException.php');
require_once(APPPATH.'/libraries/JPush/Exceptions/APIConnectionException.php');
require_once(APPPATH.'/libraries/JPush/Exceptions/APIRequestException.php');
require_once(APPPATH.'/libraries/JPush/Exceptions/ServiceNotAvaliable.php');


use JPush\Client as Client;

class JPush
{
	
	private $app_key = 'ea9f0400708cadacceec0662';
	private $master_secret ='090b28d9edf9541fbefe02eb';
	private $client;
	
	public function __construct() {
		
		$this->client = new Client($this->app_key, $this->master_secret);
	}
	
	
	/**
	 * 通过极光推送给手机APP发消息
	 * @param unknown $jiguang_id 极光ID数组
	 * @param unknown $title      消息标题
	 * @param unknown $content    消息内容
	 * @param unknown $test_id    关联的测试ID
	 */
	function send($jiguang_id,$title,$content,$test_id)
	{
		try {
			$response = $this->client->push()
			->setPlatform(array('ios', 'android'))
			 ->addRegistrationId($jiguang_id)		
			->androidNotification($content, array(
					'title' => $title,
					// 'build_id' => 2,
					'extras' => array(
							'test_id' => $test_id
					),
			))
			->send();
			print_r($response);
		
		} catch (\JPush\Exceptions\APIConnectionException $e) {
			// try something here
			print $e;
		} catch (\JPush\Exceptions\APIRequestException $e) {
			// try something here
			print $e;
		}
		
	}
}