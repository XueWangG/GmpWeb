<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="cn">
	<head>    
	    <title>GMP测试系统平台</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta name="description" content="">
	    <meta name="author" content="">

	    <!-- styles -->
		<link href="<?php echo base_url();?>css/blue-glass/sidebar.css" rel="stylesheet">
	    <link href="<?php echo base_url();?>css/bootstrap.css" rel="stylesheet">
		<link href="<?php echo base_url();?>css/index.css" rel="stylesheet">
	    <link href="<?php echo base_url();?>css/smoothness/jquery-ui-1.9.2.custom.css" rel="stylesheet">
	     <link href="<?php echo base_url();?>js/webuploader/webuploader.css" rel="stylesheet">

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
		<script type="text/javascript" src="<?php echo base_url();?>js/jquery.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/jquery-ui.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/jquery.ui.datepicker-zh-CN.js" ></script>
		
	    <script type="text/javascript" src="<?php echo base_url();?>js/bootstrap-transition.js"></script>
	    <script type="text/javascript" src="<?php echo base_url();?>js/bootstrap-alert.js"></script>
	    <script type="text/javascript" src="<?php echo base_url();?>js/bootstrap-modal.js"></script>
	    <script type="text/javascript" src="<?php echo base_url();?>js/bootstrap-dropdown.js"></script>
	    <script type="text/javascript" src="<?php echo base_url();?>js/bootstrap-scrollspy.js"></script>
	    <script type="text/javascript" src="<?php echo base_url();?>js/bootstrap-tab.js"></script>
	    <script type="text/javascript" src="<?php echo base_url();?>js/bootstrap-tooltip.js"></script>
	    <script type="text/javascript" src="<?php echo base_url();?>js/bootstrap-popover.js"></script>
	    <script type="text/javascript" src="<?php echo base_url();?>js/bootstrap-button.js"></script>
	    <script type="text/javascript" src="<?php echo base_url();?>js/bootstrap-collapse.js"></script>
	    <script type="text/javascript" src="<?php echo base_url();?>js/bootstrap-carousel.js"></script>
	    <script type="text/javascript" src="<?php echo base_url();?>js/bootstrap-typeahead.js"></script>	
		<script type="text/javascript" src="<?php echo base_url();?>js/bootstrap.file-input.js"></script>
		
		<script type="text/javascript" src="<?php echo base_url();?>js/jquery.sidebar.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/jquery.timer.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/webuploader/webuploader.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/echarts.min.js"></script>
	</head>
	<body>
<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
    		<div class="nav-collapse collapse">            			
      			<ul class="nav">
      				<li><img style="margin-right: 20px;" alt="" src="<?php echo base_url()?>img/logo2.png"></li>
        			<li class="<?php echo isset($cur_menu['test'])?$cur_menu['test']:"";?>"><a href="<?php echo base_url()?>index.php/test">测试</a></li>
	                <li class="<?php echo isset($cur_menu['testpaper'])?$cur_menu['testpaper']:"";?>"><a href="<?php echo base_url()?>index.php/testpaper">试卷</a></li>
					<li class="<?php echo isset($cur_menu['question'])?$cur_menu['question']:"";?>"><a href="<?php echo base_url()?>index.php/question">题库</a></li>
					<li class="<?php echo isset($cur_menu['summary'])?$cur_menu['summary']:"";?>"><a href="<?php echo base_url()?>index.php/summary">统计</a></li>
					
					<?php if($this->session->userdata(SESSION_NAME_COMPANY_ID) == PLATFORM_COMPANY){?>
					<li class="<?php echo isset($cur_menu['topic'])?$cur_menu['topic']:"";?>"><a href="<?php echo base_url()?>index.php/topic">问答</a></li>
					<li class="<?php echo isset($cur_menu['company'])?$cur_menu['company']:"";?>"><a href="<?php echo base_url()?>index.php/company">企业</a></li>	
					<?php }?>
					<li class="<?php echo isset($cur_menu['department'])?$cur_menu['department']:"";?>"><a href="<?php echo base_url()?>index.php/department">部门</a></li>               
					<li class="<?php echo isset($cur_menu['user'])?$cur_menu['user']:"";?>"><a href="<?php echo base_url()?>index.php/user">用户</a></li>
					<li class="<?php echo isset($cur_menu['setting'])?$cur_menu['setting']:"";?>"><a href="<?php echo base_url()?>index.php/setting">设置</a></li>
      			</ul>
      			<div class="hright">
					<button class="btn btn-small btn-primary" type="button" onclick="javascript:window.location.href = '<?php echo base_url();?>index.php/user/change_password'">管理员-<?php echo $name;?></button>
	            	<button class="btn btn-small btn btn-success" type="button" onclick="javascript:window.location.href = '<?php echo base_url();?>index.php/account/logout'">安全退出</button>
			    </div>
    		</div><!--/.nav-collapse -->
  		</div>
	</div>
</div>