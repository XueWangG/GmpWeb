<script>
function delete_company(name,id) { 
	if(confirm("是否将 "+name+" 删除?")){
		<?php echo "var baseurl='".base_url()."';" ;?>
		window.location.href = baseurl+'index.php/company/delete/'+id;
	}else{
		return false;
	}
}
</script>
<div class="container">
	
	<div class="container-body">
	<div class="page-header">
		<h3>企业管理</h3>
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
                  	<input type="text" name="search_string" id="search_string"  value="<?php echo $search_string; ?>" placeholder="公司名称/地址">
                     <button type="button" onclick="search()" class="btn btn-primary">查询</button>
             </form>
		</div>
		<div class="hright">
			<button class="btn btn-success" type="submit" onclick="window.location.href = '<?php echo base_url()?>index.php/company/create'" >创建企业</button>    			
		</div>
	</div>
	
	<div class="cleanup"></div>
	
	<table class="table table-bordered table-striped">
	<thead>
		<tr>
		<th style="width:15%;">公司名称</th>
		<th >联系人</th>
		<th>手机号</th>
		<th>所在地</th>
		<th style="width:25%;">详细地址</th>
		<th style="width:15%;">操作</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($company_list as $company){ ?>
	<tr>
	<td><span><?php echo $company['company_name']; ?></span></td>
	<td><span><?php echo $company['contact_name']; ?></span></td>
	<td><span><?php echo $company['mobile']; ?></span></td>
	<td><span><?php echo $company['city']; ?></span></td>
	<td><span><?php echo $company['address']; ?></span></td>
	<td><button class="btn btn-small btn-primary" type="button" onclick="window.location.href = '<?php echo base_url()?>index.php/company/update/<?php echo $company['company_id']?>'">编辑</button>&nbsp;&nbsp;
	<button class="btn btn-small btn-danger"  onclick="delete_company(<?php echo "'" . $company['company_name'] . "'" . "," . $company['company_id']; ?>)" type="button">删除</button></td>
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
    	window.location.href = '<?php echo base_url()?>index.php/company/index/'+$('#search_string').val();
    }

</script>