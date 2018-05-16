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
		<h3>推送</h3>
	</div>
	<form class="form-horizontal" id="create_form" action="<?php echo base_url()?>index.php/test/push/<?php echo $test_id; ?>" method="POST">
	<div class="control-group">
		<label class="control-label">推送给：</label>
		<div class="controls">
				<input type="checkbox" name="all" value="1" checked>所有人
				<?php 
					foreach ($departments as $row)
					{
				?>
				<input type="checkbox" name="department_id[]" value="<?php echo $row['department_id'];?>"> <?php echo $row['department_name'];?>	 
				 <?php 
			   		}
			   	?>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">推送类型：</label>
    	<div class="controls">
			<input type="radio" name="push_type" id="push_type1" value="1" checked>&nbsp;直接推送&nbsp;&nbsp;&nbsp;&nbsp;
			<?php if($daily_push){?>
			<input type="radio" name="push_type" id="push_type2" value="2" >&nbsp;每天定时推送
			<?php }?>
    	</div>
    </div>

		
	<div class="control-group">
		<div class="controls">			   
			<button type="submit" id="button" class="btn btn-info" >完成</button>&nbsp;&nbsp;
			<button type="button" id="button" onclick="window.location.href='<?php echo base_url();?>index.php/test'" class="btn btn-info">返回</button>
		</div>
	</div>
	</form>
</div>
</div>


