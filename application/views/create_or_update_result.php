
<div class="container">
<div class="container-body">
	<div class="page-header">
		<h3><?php echo $title; ?></h3>
	</div>
	<!-- 主界面内容区域 开始 -->
	<!-- 错误信息提示 开始 -->
	<?php if(isset($err) && $err != ""){?>
	<div class="alert alert-error">							
		<?php echo $err; ?>
	</div>
	<?php }elseif(isset($info) && $info != ""){?>
	<div class="alert alert-info">	
		<?php echo $info; ?>
	</div>
	<?php }?>
	<center>
	<div class="control-group">
		<div class="controls">			   
			<a class="btn btn-small btn-info" type="button" href="<?php echo base_url()?>index.php/<?php echo $to_list?>/">完成(<span id="num">3</span>)</a>
		</div>
	</div>
	</center>
</div>
</div>
<script>
$(document).ready(function() {    
    function jump(count) {    
        window.setTimeout(function(){    
            count--;    
            if(count > 0) {    
                $('#num').text(count);    
                jump(count);    
            } else {    
                location.href="<?php echo base_url()?>index.php/<?php echo $to_list?>/";    
            }    
        }, 1000);    
    }    
    jump(3);    
});    
</script>