
<div class="container">
	
	<div class="container-body">
	<div class="page-header">
		<h3>用户统计</h3>
	</div>
	
	<div style="padding:10px 0px 10px 0px">
		<div class="hleft">
			<form id="search_form" class="form-inline">
                  	<input type="text" name="search_string" id="search_string"  value="<?php echo $search_string; ?>" placeholder="用户名/手机号">
                     <button type="button" onclick="search()" class="btn btn-primary">查询</button>
             </form>
		</div>
		<div class="hright">
			<button class="btn btn-success" type="submit" onclick="window.location.href = '<?php echo base_url()?>index.php/summary/export_all_user'" title="导出用户统计结果">导出Excel</button>
			<button class="btn btn-success" type="submit" onclick="window.location.href = '<?php echo base_url()?>index.php/summary/list_test'" >测试统计</button>    			
		</div>
	</div>
	
	<div class="cleanup"></div>
	
	<table class="table table-bordered table-striped">
	<thead>
		<tr>
		<th style="width:15%;">用户名</th>
		<th >手机号</th>
		<?php if($this->session->userdata(SESSION_NAME_COMPANY_ID) == PLATFORM_COMPANY){?>
		<th >公司</th>
		<?php }?>
		<th>测试次数</th>
		<th>通过次数</th>
		<th>通过率</th>
		<th>总题数</th>
		<th>正确率</th>
		<th style="width:15%;">操作</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($item_list as $item){ ?>
	<tr>
	<td><span><?php echo $item['username']; ?></span></td>
	<td><span><?php echo $item['mobile']; ?></span></td>
	<?php if($this->session->userdata(SESSION_NAME_COMPANY_ID) == PLATFORM_COMPANY){?>
	<td><span><?php echo $item['company_name']; ?></span></td>
	<?php }?>
	<td><span><?php echo $item['test_count']; ?></span></td>
	<td><span><?php echo $item['pass_count']; ?></span></td>
	<td><span><?php echo $item['pass_rate']; ?></span></td>
	<td><span><?php echo $item['question_count']; ?></span></td>
	<td><span><?php echo $item['correct_rate']; ?></span></td>
	<td>
	<button class="btn btn-small btn-primary" type="button" onclick="window.location.href = '<?php echo base_url()?>index.php/summary/view_user/<?php echo $item['user_id']?>'">查看明细</button>&nbsp;&nbsp;
	</td>
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