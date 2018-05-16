<script>
<?php echo "var baseurl='".base_url()."';" ;?>

	function commit(){
		var myReg = /[\u4e00-\u9fa5]+/;
        if (myReg.test($('#password').val()) || myReg.test($('#passconf').val()) ){
            alert("用户名和密码不能为中文。");
        } else {
           $('#create_form').submit();
        }
	}
	
</script>
<div class="container">
<div class="container-body">
	<div class="page-header">
		<h3>创建企业</h3>
	</div>
	<!-- 主界面内容区域 开始 -->
	<!-- 错误信息提示 开始 -->
	<?php if(validation_errors() != ""){?>
	<div class="alert alert-error">							
		<?php echo validation_errors(); ?>
	</div>
	<?php }?>
	<!-- 错误信息提示 结束 -->
	<form class="form-horizontal" id="create_form" action="<?php echo base_url()?>index.php/company/create" method="POST">
	<div class="control-group">
	<label class="control-label">企业名称：</label>
	<div class="controls">
		<input type="text" id="company_name" name="company_name" maxlength="50" value="<?php echo set_value('company_name'); ?>">
	</div>
	</div>
	<div class="control-group">
	<label class="control-label">联系人姓名：</label>
	<div class="controls">
		<input type="text" id="contact_name" name="contact_name" maxlength="50" value="<?php echo set_value('contact_name'); ?>" >
	</div>
	</div>
	<div class="control-group">
	<label class="control-label">联系人手机：</label>
	<div class="controls">
		<input type="text" id="mobile" name="mobile" maxlength="50" value="<?php echo set_value('mobile'); ?>" >
	</div>
	</div>
	<div class="control-group">
	<label class="control-label">企业所在城市：</label>
	<div class="controls">
		<input type="text" id="city" name="city" maxlength="50" value="<?php echo set_value('city'); ?>" >
	</div>
	</div>
	<div class="control-group">
	<label class="control-label">详细地址：</label>
	<div class="controls">
		<input type="text" id="address" name="address" maxlength="50" value="<?php echo set_value('address'); ?>" >
	</div>
	</div>	
	<!-- 姓名输入框 开始 -->
	<div class="control-group">
	<label class="control-label">用户名：</label>
	<div class="controls">
		<input type="text" id="username" name="username" maxlength="50" value="<?php echo set_value('username'); ?>" >
	</div>
	</div>
	<!-- 密码输入框 开始 -->
	<div class="control-group">
		<label class="control-label">密码：</label>
		<div class="controls">
			<input type="password" id="password" maxlength="50" name="password">
		</div>
	</div>
	<!-- 密码输入框 结束 -->
	<!-- 密码输入框 开始 -->
	<div class="control-group">
	<label class="control-label">确认密码：</label>
	<div class="controls">
		<input type="password" id="passconf" maxlength="50" name="passconf" >
	</div>
	</div>
	<!-- 密码输入框 结束 -->
	
	<div class="control-group">
		<div class="controls">			   
			<button type="button" id="button" class="btn btn-info" onclick="commit();">完成</button>&nbsp;&nbsp;
			<button type="button" id="button" onclick="window.location.href='<?php echo base_url();?>index.php/company'" class="btn btn-info">返回</button>
		</div>
	</div>
	</form>
</div>
</div>


