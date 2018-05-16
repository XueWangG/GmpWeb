<div class="container">
     
      	<div class="container-body">
		<div class="page-header">
    		<h3>试题导入</h3>
    	</div>
		
	    <div class="cleanup"></div>
	    <!-- 错误信息提示 开始 -->
		<?php if(isset($error) && count($error) > 0){ ?>
			<div id="divErr" class="alert alert-error">	
				<?php foreach($error as $err){ echo $err; }?>
			</div>
		<?php }if(isset($info) && $info != ''){ ?>
			<div id="divInfo" class="alert alert-info" >
				<?php echo $info;?>
			</div>
		<?PHP } ?>
		<!-- 错误信息提示 结束 -->
		<div class="control-group info">
			<div class="controls">
				模板下载 ：<a href="<?php echo base_url();?>upload_file/tpl/GMP测试系统题库导入模板.xlsx">Excel模板文件下载</a>
			</div>
			
		</div>
		
			<div class="control-group info">

				<?php echo form_open_multipart('question/import',array('class'=>'form-horizontal'));?>
				<label class="control-label">试题数据：</label>
				<div class="controls">
					<input type="hidden" id="questionType" name="questionType" value="0"/>
					<input class="input-xlarge" type="text" id="inputInfo">
					<input name="userfile" type="file" title="选择文件" defaultValue='' style="left: -125.5px; top: -3px;">
					<input type="submit" value="上传" title="上传" class="btn">
				</div>
				</form>
				
			</div>
			
			<center>
			<div class="control-group">
				<div class="controls">			   
					<button type="button" id="button" onclick="window.location.href='<?php echo base_url();?>index.php/question'" class="btn btn-info">返回</button>
				</div>
			</div>
			</center>
		
		</div><!-- /container -->