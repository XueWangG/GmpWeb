
<div class="container">
	
	<div class="container-body">
	<div class="page-header">
		<h3>测试统计</h3>
	</div>
	
	<div style="padding:10px 0px 10px 0px">
		<div class="hleft">
			<form id="search_form" class="form-inline">
                  	<input type="text" name="search_string" id="search_string"  value="<?php echo $search_string; ?>" placeholder="测试名称">
                     <button type="button" onclick="search()" class="btn btn-primary">查询</button>
             </form>
		</div>
		<div class="hright">
			<button class="btn btn-success" type="submit" onclick="window.location.href = '<?php echo base_url()?>index.php/summary/export_all_test'" title="导出测试统计">导出Excel</button>
			<button class="btn btn-success" type="submit" onclick="window.location.href = '<?php echo base_url()?>index.php/summary/list_user'" >用户统计</button>
			<button class="btn btn-success" type="button" onclick="window.location.href = '<?php echo base_url()?>index.php/summary/list_coin'" >G币排行</button>    			
		</div>
	</div>
	
	<div class="cleanup"></div>
	
	<table class="table table-bordered table-striped">
	<thead>
		<tr>
		<th style="width:15%;">测试名称</th>
		<th >开始时间</th>
		<th>结束时间</th>
		<th>题目数量</th>
		<th>参与人数</th>
		<th>通过率</th>
		<th style="width:20%;">操作</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($item_list as $item){ ?>
	<tr>
	<td><span><?php echo $item['test_name']; ?></span></td>
	<td><span><?php echo substr($item['start_time'],0,10); ?></span></td>
	<td><span><?php echo substr($item['end_time'],0,10); ?></span></td>
	<td><span><?php echo $item['question_count']; ?></span></td>
	<td><span><?php echo $item['user_count']; ?></span></td>
	<td><span><?php echo $item['pass_rate']; ?></span></td>
	<td>
	<button class="btn btn-small btn-primary" type="button" onclick="window.location.href = '<?php echo base_url()?>index.php/summary/view_test/<?php echo $item['test_id']?>'">查看明细</button>&nbsp;&nbsp;
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
    	window.location.href = '<?php echo base_url()?>index.php/summary/list_test/'+$('#search_string').val();
    }

</script>