
<div class="container">
	
	<div class="container-body">
	<div class="page-header">
		<h3><?php echo $test_name; ?> &nbsp;&nbsp;测试明细</h3>
	</div>
	
	<div style="padding:10px 0px 10px 0px">
		<div class="hright">
			<button class="btn btn-success" type="submit" onclick="window.location.href = '<?php echo base_url()?>index.php/summary/export_test/<?php echo $test_id  ?>'" title="导出测试名细">导出Excel</button>
			<button class="btn btn-success" type="submit" onclick="window.location.href = '<?php echo base_url()?>index.php/summary/list_test'" >返回</button>    			
		</div>
	</div>
	
	<div class="cleanup"></div>
	
	<table class="table table-bordered table-striped">
	<thead>
		<tr>
		<th style="width:15%;">用户名</th>
		<th >测试开始时间</th>
		<th >测试完成时间</th>
		<th>用时</th>
		<th>总题数</th>
		<th>正确题数</th>
		<th>是否通过</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($item_list as $item){ ?>
	<tr>
	<td><span><?php echo $item['username']; ?></span></td>
	<td><span><?php echo $item['start_time']; ?></span></td>
	<td><span><?php echo $item['end_time']; ?></span></td>
	<td><span><?php echo $item['minute']; ?></span></td>
	<td><span><?php echo $item['question_count']; ?></span></td>
	<td><span><?php echo $item['correct_count']; ?></span></td>
	<td><span><?php echo $item['passed']; ?></span></td>
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
