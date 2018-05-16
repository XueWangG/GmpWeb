<script>
function delete_user(name,id) { 
	if(confirm("是否将 "+name+" 删除?")){
		<?php echo "var baseurl='".base_url()."';" ;?>
		window.location.href = baseurl+'index.php/user/delete/'+id;
	}else{
		return false;
	}
}
</script>
<div class="container">
	
	<div class="container-body">
	<div class="page-header">
		<h3>用户管理</h3>
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
                  	<input type="text" name="search_string" id="search_string"  value="<?php echo $search_string; ?>" placeholder="用户名/真实姓名/手机号">
                  	&nbsp;&nbsp;所属部门：
                  	<select id="department_id" name="department_id">
                  		<option value="id0" >所有部门</option>
						<?php 
							foreach ($departments as $row)
							{
						?>
								<option value="id<?php echo $row['department_id'];?>" <?php if($row['department_id'] ==$department_id){ echo "selected='selected'";} ?>>
								<?php echo $row['department_name'];?></option>			 
						 <?php 
					   		}
					   	?>
					</select>
                     <button  type="button" onclick="search()" class="btn btn-primary">查询</button>
             </form>
		</div>
		<div class="hright">
			<button class="btn btn-success" type="button" onclick="window.location.href = '<?php echo base_url()?>index.php/user/create'" >创建用户</button>
			<button class="btn btn-success" type="button" onclick="window.location.href = '<?php echo base_url()?>index.php/user/import'" >导入用户</button>    			
		</div>
	</div>
	
	<div class="cleanup"></div>
	
	<table class="table table-bordered table-striped">
	<thead>
		<tr>
		<th >权限</th>
		<th style="width:15%;">用户名</th>
		<th >真实姓名</th>
		<th>手机号</th>
		<?php if($this->session->userdata(SESSION_NAME_COMPANY_ID) == PLATFORM_COMPANY){?>
		<th>公司</th>
		<?php }?>
		<th style="width:15%;">操作</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($item_list as $item){ ?>
	<tr>
	<td><span><?php echo $item['role_name']; ?></span></td>
	<td><span><?php echo $item['username']; ?></span></td>
	<td><span><?php echo $item['name']; ?></span></td>
	<td><span><?php echo $item['mobile']; ?></span></td>
	<?php if($this->session->userdata(SESSION_NAME_COMPANY_ID) == PLATFORM_COMPANY){?>
	<td><span><?php echo $item['company_name']; ?></span></td>
	<?php }?>
	<td><button class="btn btn-small btn-primary" type="button" onclick="window.location.href = '<?php echo base_url()?>index.php/user/update/<?php echo $item['user_id']?>'">编辑</button>&nbsp;&nbsp;
	<button class="btn btn-small btn-danger"  onclick="delete_user(<?php echo "'" . $item['username'] . "'" . "," . $item['user_id']; ?>)" type="button">删除</button></td>
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
        search_string=$('#search_string').val();
        if(search_string.length==0){
            search_string='---';
        }
    	window.location.href = '<?php echo base_url()?>index.php/user/index/'+search_string+'/'+$('#department_id').val()+'/';
    }

</script>