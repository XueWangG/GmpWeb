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
	 $(function () {
		 $("#datepicker" ).datepicker({
	            changeMonth: true,
	            changeYear: true,
	            dateFormat:"yy-mm-dd",
	            minDate: 0,
	            onClose: function( selectedDate ) {
	                $(this).next(".hasDatepicker").datepicker( "option", "minDate", selectedDate );
	            }

	        });

        $("#datepicker_end" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat:"yy-mm-dd",
            minDate: 0,
            onClose: function( selectedDate ) {
                $(this).prev(".hasDatepicker").datepicker( "option", "maxDate", selectedDate );
            }
        });
        $("#test_paper_id").val(<?php echo set_value('test_paper_id'); ?>);
        $("#difficulty").val(<?php echo set_value('difficulty'); ?>);
        
	});
</script>
<div class="container">
<div class="container-body">
	<div class="page-header">
		<h3>创建测试</h3>
	</div>
	<!-- 主界面内容区域 开始 -->
	<!-- 错误信息提示 开始 -->
	<?php if(validation_errors() != ""){?>
	<div class="alert alert-error">							
		<?php echo validation_errors(); ?>
	</div>
	<?php }?>
	<!-- 错误信息提示 结束 -->
	<form class="form-horizontal" id="create_form" action="<?php echo base_url()?>index.php/test/create" method="POST">
	<div class="control-group">
	<label class="control-label">测试名称：</label>
	<div class="controls">
		<input type="text" id="test_name" name="test_name" maxlength="50" value="<?php echo set_value('test_name'); ?>">
	</div>
	</div>
	<div class="control-group">
		<label class="control-label">试卷选择：</label>
    	<div class="controls">
			<select id="test_paper_id" name="test_paper_id">
				<?php 
					foreach ($papers as $row)
					{
				?>
						<option value="<?php echo $row['test_paper_id'];?>">
						<?php echo $row['test_paper_name'];?></option>			 
				 <?php 
			   		}
			   	?>
			</select>
    	</div>
    </div>
	<div class="control-group">
	<label class="control-label">测试有效期间：</label>
	<div class="controls">
          <input class="span2" type="text" id="datepicker" name="start_time"  value="<?php echo set_value('start_time'); ?>" placeholder="开始日期" onfocus="this.blur()">
          ~
          <input class="span2" type="text" id="datepicker_end" name="end_time" value="<?php echo set_value('end_time'); ?>" placeholder="结束日期" onfocus="this.blur()">

	</div>
	</div>
	
	<div class="control-group">
		<div class="controls">			   
			<button type="button" id="button" class="btn btn-info" onclick="commit();">完成</button>&nbsp;&nbsp;
			<button type="button" id="button" onclick="window.location.href='<?php echo base_url();?>index.php/test'" class="btn btn-info">返回</button>
		</div>
	</div>
	</form>
</div>
</div>


