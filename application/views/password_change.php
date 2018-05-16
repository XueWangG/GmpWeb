<div class="container">      
	<div class="container-body">
		<form id="chage_password_form" class="form-signin" action="<?php echo base_url();?>index.php/<?php echo $this->uri->segment(1);?>/change_password" method="POST">	      	
	      	<div class="vspace"></div>
			
			<?php if(validation_errors() != ""){?>
			<div class="alert alert-error">							
				<?php echo validation_errors(); ?>
			</div>
			<?php }elseif($err != ""){?>
			<div class="alert alert-error">	
				<?php echo $err ?>
			</div>
			<?php }?>
	      	<label class="control-label">旧密码：</label>     
	        <input type="password" name="old_password" class="input-block-level" placeholder="旧密码：">       
	        <label class="control-label">新密码：</label>
	        <input type="password" name="password" class="input-block-level" placeholder="新密码：">       
			<label class="control-label">确认密码：</label>
	        <input type="password" name="cfmpassword" class="input-block-level" placeholder="密码"> 
	        <button class="btn btn-large btn-primary" type="button" onclick="do_change();">确定</button>
			<input id="usertype" type="hidden" name="usertype" value="" />
		</form>		
	</div> 
</div>	
	
<script type="text/javascript" charset="utf-8">
	
	function do_change() {			
		$('#chage_password_form').submit();
	}
</script>