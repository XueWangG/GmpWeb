<script>
function delete_department(name,id) { 
	if(confirm("是否将 "+name+" 删除?")){
		<?php echo "var baseurl='".base_url()."';" ;?>
		window.location.href = baseurl+'index.php/department/delete/'+id;
	}else{
		return false;
	}
}
</script>
<div class="container">
	
	<div class="container-body">
	<div class="page-header">
		<h3>部门管理</h3>
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
	
	<div style="padding:10px 0px 30px 0px">
		<div class="hright">
			<button class="btn btn-success" type="submit" onclick="window.location.href = '<?php echo base_url()?>index.php/department/create'" >创建部门</button>    			
		</div>
	</div>
	
	<div class="cleanup"></div>
	
	<table class="table table-bordered table-striped">
	<thead>
		<tr>
		<th style="width:15%;">部门名称</th>
		<th style="width:15%;">操作</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($department_list as $item){ ?>
	<tr>
	<td><span><?php echo $item['department_name']; ?></span></td>
	<td><button class="btn btn-small btn-primary" type="button" onclick="window.location.href = '<?php echo base_url()?>index.php/department/update/<?php echo $item['department_id']?>'">编辑</button>&nbsp;&nbsp;
	<button class="btn btn-small btn-danger"  onclick="delete_department(<?php echo "'" . $item['department_name'] . "'" . "," . $item['department_id']; ?>)" type="button">删除</button></td>
	</tr>
	<?php } ?>
	<tbody>
	</table>
	
	</div>
	<div class="footer">
    </div>
	
</div>
