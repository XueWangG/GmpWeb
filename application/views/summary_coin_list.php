
<div class="container">
	
	<div class="container-body">
	<div class="page-header">
		<h3>G币排行</h3>
	</div>
	
	<div style="padding:10px 0px 10px 0px">
		<div class="hright">
			<button class="btn btn-success" type="submit" onclick="window.location.href = '<?php echo base_url()?>index.php/summary/list_test'" >返回</button>    			
		</div>
	</div>
	
	<div class="cleanup"></div>
	
	<table class="table table-bordered table-striped">
	<thead>
		<tr>
		<th style="width:15%;">用户名</th>
		<th >G币</th>
		<th >真实姓名</th>
		<th >手机号</th>
		<?php if($this->session->userdata(SESSION_NAME_COMPANY_ID) == PLATFORM_COMPANY){?>
		<th >公司</th>
		<?php }?>
		</tr>
	</thead>
	<tbody>
	<?php foreach($item_list as $item){ ?>
	<tr>
	<td><span><?php echo $item['username']; ?></span></td>
	<td><span><?php echo $item['coin']; ?></span></td>
	<td><span><?php echo $item['name']; ?></span></td>
	<td><span><?php echo $item['mobile']; ?></span></td>
	<?php if($this->session->userdata(SESSION_NAME_COMPANY_ID) == PLATFORM_COMPANY){?>
	<td><span><?php echo $item['company_name']; ?></span></td>
	<?php }?>
	
	</tr>
	<?php } ?>
	<tbody>
	</table>
	
	<!-- 主界面内容区域 结束 -->
	<div class="pagination pagination-centered">
	<?php echo $this->pagination->create_links();?><br><br><br>
	</div>
	</div>
	<div class="footer">
    </div>
	
</div>

<script type="text/javascript" charset="utf-8">
    function search() {
    	window.location.href = '<?php echo base_url()?>index.php/summary/list_user/'+$('#search_string').val();
    }

</script>