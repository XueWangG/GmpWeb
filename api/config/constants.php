<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

/*
|API返回值代码
*/
defined('CODE_OK')                  OR define('CODE_OK', 200); // //操作成功
defined('CODE_UNKNOWN_USER')        OR define('CODE_UNKNOWN_USER', 1001); //用户名或密码错误
defined('CODE_MOBILE_CODE_REPEAT')  OR define('CODE_MOBILE_CODE_REPEAT', 1002); //验证码请求已提交，请稍后再重新获取
defined('CODE_MOBILE_CODE_ERROR')   OR define('CODE_MOBILE_CODE_ERROR', 1003); //验证码错误，请核对后重新输入
defined('CODE_MOBILE_CODE_EXPIRED') OR define('CODE_MOBILE_CODE_EXPIRED', 1004); //验证码已过期，请重新获取
defined('CODE_SMS_ERROR')           OR define('CODE_SMS_ERROR', 1005); //发送短信失败
defined('CODE_USER_EXIST')          OR define('CODE_USER_EXIST', 1006); //用户已存在，请使用其它手机号
defined('CODE_USER_NOT_LOGIN')      OR define('CODE_USER_NOT_LOGIN', 1007); //用户未登录
defined('CODE_USER_NOT_EXIST')      OR define('CODE_USER_NOT_EXIST', 1008); //手机号未注册
defined('CODE_UNKNOWN_OLD_PASSWORD')    OR define('CODE_UNKNOWN_OLD_PASSWORD', 1009); //旧密码不正确

defined('CODE_NO_POST')             OR define('CODE_NO_POST', 2001); //没有POST的数据
defined('CODE_SIGN_ERROR')          OR define('CODE_SIGN_ERROR', 2002); //签名错误
defined('CODE_PARAM_ERROR')          OR define('CODE_PARAM_ERROR', 2003); //参数错误

defined('CODE_UNKNOWN_ERROR')       OR define('CODE_UNKNOWN_ERROR', 9001); //操作错误，未分类的

/**
 * 函数
 */
defined('TIME_NOW')                  OR define('TIME_NOW', date("Y-m-d H:i:s",time())); //用于初始化时间戳
