<script>
function delete_item(name,type,id) { 
	if(confirm("是否将 "+name+" 删除?")){
		<?php echo "var baseurl='".base_url()."';" ;?>
		window.location.href = baseurl+'index.php/question/delete_attribute/'+type+'/'+id;
	}else{
		return false;
	}
}
</script>
<div class="container">
	
	<div class="container-body">
		<div id='category'>
			<div class="page-header">
				<h3>分类列表</h3>
			</div>
			<?php if($this->session->userdata(SESSION_NAME_COMPANY_ID) == PLATFORM_COMPANY){?>
			<div style="padding:10px 0px 40px 0px">
				<div class="hright">
					<a class="btn btn-success btn-add"  href="<?php echo base_url()?>index.php/question/create_attribute/1" >创建分类</a>			
				</div>
			</div>
			<?php }?>
		
			<table class="table table-bordered table-striped">
			<thead>
				<tr>
				<th >分类</th>
				<th style="width:20%;">操作</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($cats as $item){ ?>
			<tr>
			<td><span><?php echo $item['category_name']; ?></span></td>
			<td>
			<?php if($this->session->userdata(SESSION_NAME_COMPANY_ID) == PLATFORM_COMPANY){?>
			<a class="btn btn-small btn-success" href="<?php echo base_url()?>index.php/question/update_attribute/1/<?php echo $item['category_id']?>">编辑</a>
			<a class="btn btn-small btn-danger"  href="javascript:delete_item('<?php echo $item['category_name']?>',1,'<?php echo $item['category_id']?>')">删除</button>
			<?php }?>
			</td>
			</tr>
			<?php } ?>
			<tbody>
			</table>
		</div>
		
		<div id='difficulty'>
			<div class="page-header">
				<h3>难度列表</h3>
			</div>
			<?php if($this->session->userdata(SESSION_NAME_COMPANY_ID) == PLATFORM_COMPANY){?>
			<div style="padding:10px 0px 40px 0px">
				<div class="hright">
					<a class="btn btn-success btn-add"  href="<?php echo base_url()?>index.php/question/create_attribute/2" >创建难度</a>			
				</div>
			</div>
			<?php }?>
		
			<table class="table table-bordered table-striped">
			<thead>
				<tr>
				<th >难度</th>
				<th style="width:20%;">操作</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($difs as $item){ ?>
			<tr>
			<td><span><?php echo $item['difficulty_name']; ?></span></td>
			<td>
			<?php if($this->session->userdata(SESSION_NAME_COMPANY_ID) == PLATFORM_COMPANY){?>
			<a class="btn btn-small btn-success" href="<?php echo base_url()?>index.php/question/update_attribute/2/<?php echo $item['difficulty_id']?>">编辑</a>
			<a class="btn btn-small btn-danger"  href="javascript:delete_item('<?php echo $item['difficulty_name']?>',2,'<?php echo $item['difficulty_id']?>')">删除</button>
			<?php }?>
			</td>
			</tr>
			<?php } ?>
			<tbody>
			</table>
		</div>
		<div id='sop'>
			<div class="page-header">
				<h3>SOP列表</h3>
			</div>
			
			<div style="padding:10px 0px 40px 0px">
				<div class="hright">
					<a class="btn btn-success btn-add"  href="<?php echo base_url()?>index.php/question/create_attribute/3" >创建SOP</a>			
				</div>
			</div>
			
		
			<table class="table table-bordered table-striped">
			<thead>
				<tr>
				<th >分类</th>
				<th style="width:20%;">操作</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($sops as $item){ ?>
			<tr>
			<td><span><?php echo $item['sop_name']; ?></span></td>
			<td>
			<a class="btn btn-small btn-success" href="<?php echo base_url()?>index.php/question/update_attribute/3/<?php echo $item['sop_id']?>">编辑</a>
			<a class="btn btn-small btn-danger"  href="javascript:delete_item('<?php echo $item['sop_name']?>',3,'<?php echo $item['sop_id']?>')">删除</button>
			</td>
			</tr>
			<?php } ?>
			<tbody>
			</table>
		</div>
	
    </div>
 
</div>
