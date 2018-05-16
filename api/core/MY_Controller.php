<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * API controller的基类
 * 参考文档：http://codeigniter.org.cn/user_guide/libraries/output.html
 * 
 */
class MY_Controller extends CI_Controller {

	//code=>msg
	private $code_msg =array(CODE_OK=>'操作成功',CODE_UNKNOWN_USER=>'用户名或密码错误',
			CODE_MOBILE_CODE_REPEAT=>'验证码请求已提交，请稍后再重新获取',
			CODE_MOBILE_CODE_ERROR=>'验证码错误，请核对后重新输入',
			CODE_MOBILE_CODE_EXPIRED=>'验证码已过期，请重新获取',
			CODE_USER_EXIST=>'用户名（昵称）或手机号已存在',
			CODE_USER_NOT_EXIST=>'手机号未注册',
			CODE_UNKNOWN_OLD_PASSWORD=>'旧密码不正确',
			CODE_USER_NOT_LOGIN=>'请先登录',
			CODE_SMS_ERROR=>'发送短信失败',
			CODE_NO_POST=>'没有POST的数据',CODE_SIGN_ERROR=>'签名错误',
			CODE_PARAM_ERROR=>'参数错误，请核对后再提交',
			CODE_UNKNOWN_ERROR=>'操作错误,请检查输入参数');
	//app_key=>app_secret
	protected $app_secret = array('mobff53f46250568693'=>'011e577f45d4135003dd30b402cb0bfd');
	
	protected $received_data = array();
	
	function __construct()
	{
		parent::__construct();
		//
		if(empty($_POST))
		{
			$this->output_error(CODE_NO_POST);
		}
		//用CI的方法是为了安全过滤参数
		$input=array();
		foreach ($_POST as $key => $value)
		{
			$input[$key]=$this->input->post($key);
		}
		//签名校验
		$sign= isset($input['sign'])?$input['sign']:'';
		$input = $this->filter_parameter($input);
		if(empty($input)||(!isset($input['app_key']))){
			$this->output_error(CODE_UNKNOWN_ERROR);
		}
		$mysign = $this->build_mysign($input, $this->app_secret[$input['app_key']]);
		//$this->output_data($mysign);
		if($mysign!=$sign){
			$this->output_error(CODE_SIGN_ERROR);
		}
		//取得业务数据
		$this->received_data = $input;
		
	}
	protected function get_user_info()
	{
		//根据key取得用户信息，如果没有则需要重新登录
		if(empty($this->received_data['key']))
		{
			$this->output_error(CODE_USER_NOT_LOGIN);
		}
		$this->load->model('user_model');
		

		$user_token = $this->user_model->get_user_token($this->received_data['key']);
		if(empty($user_token)) {
			$this->output_error(CODE_USER_NOT_LOGIN);
		}
		
		return $this->user_model->get(array('user_id'=>$user_token['user_id']));
	}
	/**
	 * 输出JSON格式的正常响应数据，含消息代码
	 * @param array $data
	 */
	protected function output_ok($data)
	{
		$output = array();
		$output['code'] = CODE_OK;
		$output['msg']=$this->code_msg[CODE_OK];
		$output['data']=$data;
		
		$this->output_data($output);
						
	}
	/**
	 * 输出JSON格式的出错信息
	 * @param int $code 错误代码
	 * @param array $msg_validation 表单数据验证错误消息的数组
	 */
	protected function output_error($code,$msg_validation = NULL)
	{
		$output = array();
		$output['code'] = $code;
		$output['msg']=$this->code_msg[$code];
		$output['data']=$msg_validation;
		
		$this->output_data($output);
	}
	/**
	 * 输出JSON格式的正常响应数据
	 * @param array $data
	 */
	private function output_data($data)
	{
		$this->output->set_header('Access-Control-Allow-Origin: *');
		$this->output->set_content_type('application/json','utf-8')
		->set_output($this->json_encode_ex($data))
		->_display();
		exit;
	}
	private function json_encode_ex($data)
	{
		return json_encode($data,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
	}
	/**
	 * 生成签名
	 * @param $array要签名的数组
	 * @param $app_secret 密钥
	 * @param return 签名结果字符串
	 */
	private function build_mysign($array,$app_secret) {
		//数组元素按字典排序
		ksort($array);
		reset($array);
		 
		//把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
		$arg  = "";
		while (list ($key, $val) = each ($array)) {
			$arg.=$key."=".$val;
		}
		$prestr = $arg.$app_secret;		//把拼接后的字符串再与安全校验码直接连接起来
		$mysgin = md5($prestr);			    //把最终的字符串加密，获得签名结果
		return $mysgin;
	}
	/**
	 * 返回过滤后用于计算签名的参数
	 * @param $parameter 全部收到的参数
	 */
	private function filter_parameter($parameter)
	{
		$para = array();
		foreach ($parameter as $key => $value)
		{
			if ('sign' == $key||'image_file'==$key) continue;
			else $para[$key] = $value;
		}
		return $para;
	}
}
