<script>
function delete_item(name,id) { 
	if(confirm("是否将 "+name+" 删除?")){
		<?php echo "var baseurl='".base_url()."';" ;?>
		window.location.href = baseurl+'index.php/test/delete/'+id;
	}else{
		return false;
	}
}
</script>
<div class="container">
	
	<div class="container-body">
	<div class="page-header">
		<h3>测试管理</h3>
	</div>

	<?php if($err != ""){?>
	<div class="ui-widget">
		<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">								
			<strong><?php echo $err ?></strong>
		</div>
	</div>
	<?php }elseif($info != ""){?>
	<div class="ui-widget">
		<div class="ui-state-highlight ui-corner-all" style="padding: 0 .7em;">								
			<strong><?php echo $info ?></strong>
		</div>
	</div>
	<?php }?>
	
	<div style="padding:10px 0px 10px 0px">
		<div class="hleft">
			<form id="search_form" class="form-inline">
                  	<input type="text" name="search_string" id="search_string"  value="<?php echo $search_string; ?>" placeholder="测试名称/地址">
                     <button type="button" onclick="search()" class="btn btn-primary">查询</button>
             </form>
		</div>
		<div class="hright">
			<button class="btn btn-success" type="submit" onclick="window.location.href = '<?php echo base_url()?>index.php/test/create'" >创建测试</button>    			
		</div>
	</div>
	
	<div class="cleanup"></div>
	
	<table class="table table-bordered table-striped">
	<thead>
		<tr>
		<th style="width:15%;">测试名称</th>
		<th >开始日期</th>
		<th>结束日期</th>
		<th>试卷名称</th>
		<th style="width:30%;">操作</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($item_list as $item){ ?>
	<tr>
	<td><span><?php echo $item['test_name']; ?></span></td>
	<td><span><?php echo substr($item['start_time'],0,10); ?></span></td>
	<td><span><?php echo substr($item['end_time'],0,10); ?></span></td>
	<td><span><?php echo $item['test_paper_name']; ?></span></td>
	<td>
	<button class="btn btn-small btn-primary" type="button" onclick="window.location.href = '<?php echo base_url()?>index.php/test/view/<?php echo $item['test_id']?>'">查看</button>&nbsp;&nbsp;
	<?php if($item['is_daily_push']==0){?>
	<button class="btn btn-small btn-success" type="button" onclick="window.location.href = '<?php echo base_url()?>index.php/test/push/<?php echo $item['test_id']?>'">推送</button>&nbsp;&nbsp;
	<?php }?>
	<?php if($item['is_daily_push']==1){?>
	<button class="btn btn-small btn-success" type="button" onclick="window.location.href = '<?php echo base_url()?>index.php/test/push_cancel/<?php echo $item['test_id']?>'">取消每天推送</button>&nbsp;&nbsp;
	<?php }?>
	<?php if($item['user_count']==0){?>
	<button class="btn btn-small btn-success" type="button" onclick="window.location.href = '<?php echo base_url()?>index.php/test/update/<?php echo $item['test_id']?>'">编辑</button>&nbsp;&nbsp;
	<?php }?>
	<button class="btn btn-small btn-danger"  onclick="delete_item(<?php echo "'" . $item['test_name'] . "'" . "," . $item['test_id']; ?>)" type="button">删除</button></td>
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
    	window.location.href = '<?php echo base_url()?>index.php/test/index/'+$('#search_string').val();
    }

</script>