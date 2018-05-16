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
		<h3>编辑用户</h3>
	</div>
	<!-- 主界面内容区域 开始 -->
	<!-- 错误信息提示 开始 -->
	<?php if(validation_errors() != ""){?>
	<div class="alert alert-error">							
		<?php echo validation_errors(); ?>
	</div>
	<?php }elseif($err != ""){?>
	<div class="alert alert-error">	
		<?php echo $err ?>
	</div>
	<?php }?>
	<!-- 错误信息提示 结束 -->
	<form class="form-horizontal" id="create_form" action="<?php echo base_url()?>index.php/user/update/<?php echo $user_id?>" method="POST">

	<!-- 姓名输入框 开始 -->
	<div class="control-group">
	<label class="control-label">用户名：</label>
	<div class="controls">
		<input type="text" id="username" name="username" maxlength="50" value="<?php echo $username; ?>" >
	</div>
	</div>
	<!-- 密码输入框 开始 -->
	<div class="control-group">
		<label class="control-label">密码：</label>
		<div class="controls">
			<input type="password" id="password" maxlength="50" name="password" placeholder="不修改密码请不要填写">
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
	<label class="control-label">真实姓名：</label>
	<div class="controls">
		<input type="text" id="name" name="name" maxlength="50" value="<?php echo $name; ?>" >
	</div>
	</div>
	<div class="control-group">
	<label class="control-label">手机号码：</label>
	<div class="controls">
		<input type="text" id="mobile" name="mobile" maxlength="50" value="<?php echo $mobile; ?>" >
	</div>
	</div>
	<div class="control-group">
		<label class="control-label">权限设置：</label>
		<div class="controls">
			<select id="role_id" name="role_id"  class="span2">
				<option value="1" <?php if($role_id == '1'){ echo "selected='selected'";} ?>>管理员</option>
	  			<option value="2" <?php if($role_id == '2'){ echo "selected='selected'";} ?>>用户</option>
			</select>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">性别</label>
		<div class="controls">
			<input type="radio" name="sex" id="sex1" value="1" <?php if($sex === '1'){ echo " checked='checked'"; } ?>>&nbsp;男&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="radio" name="sex" id="sex2" value="2" <?php if($sex === '2'){ echo " checked='checked'"; } ?>>&nbsp;女
		</div>
	</div>
	<?php if($this->session->userdata(SESSION_NAME_COMPANY_ID) == PLATFORM_COMPANY){?>
	<div class="control-group">
		<label class="control-label">所属公司</label>
		<div class="controls">
			<select id="company_id"  name="company_id" class="span2">
				<?php 
					foreach ($company_list as $row)
					{
				?>
						<option value="<?php echo $row['company_id'];?>" <?php if($row['company_id'] ==$company_id){ echo "selected='selected'";} ?>>
						<?php echo $row['company_name'];?></option>			 
				 <?php 
			   		}
			   	?>
			</select>
		</div>
	</div>
	<?php }?>
	<div class="control-group">
		<label class="control-label">所属部门：</label>
		<div class="controls">
			<?php 
					foreach ($departments as $row)
					{
				?>
				<input type="checkbox" name="department_id[]" value="<?php echo $row['department_id'];?>" <?php if($row['checked']){echo 'checked';}?>> <?php echo $row['department_name'];?>	 
				 <?php 
			   		}
			   	?>
		</div>
	</div>
	
	<div class="control-group">
		<div class="controls">			   
			<button type="button" id="button" class="btn btn-info" onclick="commit();">完成</button>&nbsp;&nbsp;
			<button type="button" id="button" onclick="window.location.href='<?php echo base_url();?>index.php/user'" class="btn btn-info">返回</button>
		</div>
	</div>
	</form>
</div>
</div>


