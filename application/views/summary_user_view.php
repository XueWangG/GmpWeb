
<script type="text/javascript">
$(function () {
	//用户能力模型
    var myChart = echarts.init(document.getElementById('user-graph'));

    // 指定图表的配置项和数据
    var option = {
        title: {
            text: ''
        },
        tooltip: {},
        radar: {
        shape: 'polygon',
        indicator: [
           <?php foreach ($user['cap'] as $key=>$value){?>
           { name: "<?php echo $value['name']?>", max: 100},
           <?php }?>
        ]
        },
        series: [{
            name: '能力',
            type: 'radar',
            data : [
                {
                    value : [
						<?php foreach ($user['cap'] as $key=>$value){?>
						<?php echo $value['value']?>, 
						 <?php }?>],
                    name : '能力'
                }
            ]
        }]
    };

    // 使用刚指定的配置项和数据显示图表。
    myChart.setOption(option);
	
});

</script>

<div class="container">
	
	<div class="container-body">
	<div class="page-header">
		<h3>用户能力模型</h3>
	</div>
	<div>
	<table class="table table-bordered">
		<tbody>
		<tr><td>用户名：<?php echo $user['username']; ?> </td><td>姓名：<?php echo $user['name']; ?></td></tr>
		<tr><td>所属公司：<?php echo $user['company_name']; ?></td><td></td></tr>
		<tr><td>测评次数：<?php echo $user['test_count']; ?></td><td>答题数量：<?php echo $user['question_count']; ?></td></tr>
		<tr></tr>
		</tbody>
	</table>
	</div>
	<div id="user-graph" style="height:280px">
	
	</div>
	<div class="page-header">
		<h3>参与测试明细</h3>
	</div>
	
	<div style="padding:10px 0px 10px 0px">
		<div class="hright">
			<button class="btn btn-success" type="submit" onclick="window.location.href = '<?php echo base_url()?>index.php/summary/list_user'" >返回</button>    			
		</div>
	</div>
	
	<div class="cleanup"></div>
	
	<table class="table table-bordered table-striped">
	<thead>
		<tr>
		<th style="width:15%;">测试名称</th>
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
	<td><span><?php echo $item['test_name']; ?></span></td>
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
