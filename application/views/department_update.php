
<div class="container">
<div class="container-body">
	<div class="page-header">
		<h3>编辑部门</h3>
	</div>
	<!-- 主界面内容区域 开始 -->
	<!-- 错误信息提示 开始 -->
	<?php if(validation_errors() != ""){?>
	<div class="alert alert-error">							
		<?php echo validation_errors(); ?>
	</div>
	<?php }?>
	<!-- 错误信息提示 结束 -->
	<form class="form-horizontal" id="create_form" action="<?php echo base_url()?>index.php/department/update/<?php echo $department_id?>" method="POST">
	<div class="control-group">
	<label class="control-label">部门名称：</label>
	<div class="controls">
		<input type="text" id="department_name" name="department_name" maxlength="50" value="<?php echo $department_name; ?>">
	</div>
	</div>
	
	<div class="control-group">
		<div class="controls">			   
			<button type="submit" id="button" class="btn btn-info">完成</button>&nbsp;&nbsp;
			<button type="button" id="button" onclick="window.location.href='<?php echo base_url();?>index.php/department'" class="btn btn-info">返回</button>
		</div>
	</div>
	</form>
</div>
</div>


