<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="cn">
	<head>    
	    <title>GMP测试系统平台</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta name="description" content="">
	    <meta name="author" content="">

	    <!-- styles -->
	    <link href="<?php echo base_url();?>css/bootstrap.css" rel="stylesheet">
	    <link href="<?php echo base_url();?>css/index.css" rel="stylesheet">
	    
	    <link href="<?php echo base_url();?>css/init.css" rel="stylesheet"/>
		<link href="<?php echo base_url();?>css/common.css" rel="stylesheet"/>
		<link href="<?php echo base_url();?>css/login.css" rel="stylesheet"/>

	    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
	    <!--[if lt IE 9]>
	      <script src="./js/html5shiv.js"></script>
	    <![endif]-->

	    <!-- Fav and touch icons -->
	    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="./ico/apple-touch-icon-144-precomposed.png">
	    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="./ico/apple-touch-icon-114-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="./ico/apple-touch-icon-72-precomposed.png">
	    <link rel="apple-touch-icon-precomposed" href="./ico/apple-touch-icon-57-precomposed.png">
	    <link rel="shortcut icon" href="./ico/favicon.png">
		
		<!-- javascript -->	
		<script src="<?php echo base_url();?>js/jquery.js"></script>
	    <script src="<?php echo base_url();?>js/bootstrap-transition.js"></script>
	    <script src="<?php echo base_url();?>js/bootstrap-alert.js"></script>
	    <script src="<?php echo base_url();?>js/bootstrap-modal.js"></script>
	    <script src="<?php echo base_url();?>js/bootstrap-dropdown.js"></script>
	    <script src="<?php echo base_url();?>js/bootstrap-scrollspy.js"></script>
	    <script src="<?php echo base_url();?>js/bootstrap-tab.js"></script>
	    <script src="<?php echo base_url();?>js/bootstrap-tooltip.js"></script>
	    <script src="<?php echo base_url();?>js/bootstrap-popover.js"></script>
	    <script src="<?php echo base_url();?>js/bootstrap-button.js"></script>
	    <script src="<?php echo base_url();?>js/bootstrap-collapse.js"></script>
	    <script src="<?php echo base_url();?>js/bootstrap-carousel.js"></script>
	    <script src="<?php echo base_url();?>js/bootstrap-typeahead.js"></script>
	</head>
	
	<body>

<div class="wrapper">
	<div class="container cf">
		<h1><a><img src="<?php echo base_url();?>img/login-logo.png" title="GMP在线测试平台" alt="GMP在线测试平台"/></a></h1>
		<div class="form-wrap">
			<h2>GMP测试系统</h2>
			<form id="login_form" action="<?php echo base_url();?>index.php/account/login" method="POST">
				<div>
					<?php if(validation_errors() != ""){?>
                        <div class="alert alert-error" style="width:124px;">
                            <?php echo validation_errors(); ?>
                        </div>
                    <?php } ?>
					<label for="username">用户名</label>
					<input type="text" name="username" id="username" value="<?php echo set_value('username'); ?>" placeholder="用户名">
				</div>
				<div>
					<label for="password">密码</label>
					<input type="password" name="password" id="password" value="<?php echo set_value('password'); ?>" placeholder="密码">
				</div>
				<div>
                    <button onclick="login()">登录</button>
				</div>
			</form>
			<span class="form-wrap-before"></span>
			<span class="form-wrap-after"></span>
		</div>
		<div class="edition">
            <p>浏览器下载地址：<a href="http://windows.microsoft.com/zh-cn/internet-explorer/download-ie">IE</a><a href="http://firefox.com.cn/download/">火狐浏览器</a></p>
            <P><img style="width:100px;height:100px" src="<?php echo base_url();?>img/gmpapk.png"/><br/>扫描下载APP</P>
		</div>
	</div>
</div>

<script type="text/javascript" charset="utf-8">
    function login() {
        $('#login_form').submit();
    }

</script>
	</body>
</html>