<script>
<?php echo "var baseurl='".base_url()."';" ;?>
<?php echo "var category_id='".$category_id."';" ;?>
function delete_question(id) { 
	if(confirm("是否将试题"+id+" 删除?")){
		window.location.href = baseurl+'index.php/question/delete/'+id;
	}else{
		return false;
	}
}

function delete_all() {
	var arrChk=$("input[name='check_list']:checked");
	ids=new Array();
    $(arrChk).each(function(){
       ids.push(this.value);                       
    });
    if(ids.length==0){
	    alert("请先选择试题！");
	    return false;
    }
	if(confirm("是否删除列表中选择的试题?")){
		window.location.href = baseurl+'index.php/question/delete_all/'+ids.join("_");
	}else{
		return false;
	}
}

function type_select_callback()
{
	window.location.href=baseurl+"index.php/question/index/"+$('#type_select').val()+"/"+$('#cat_select').val()+"/";
}

function cat_select_callback()
{
	window.location.href=baseurl+"index.php/question/index/"+$('#type_select').val()+"/"+$('#cat_select').val()+"/";
}


</script>
<div class="container">
	
	<div class="container-body">
	<div class="page-header">
		<h3>试题列表</h3>
	</div>
	
	<div style="padding:10px 0px 10px 0px">
		<div class="hleft">
			<form id="search_form" class="form-inline">
                  	试题题型&nbsp;
						<select id="type_select" onchange="type_select_callback()" class="span2">
							<option value="t0" selected="selected">全部题型</option>
							<option value="t1" <?php if($type == 1){?> selected="selected"<?php ;}?>>单选题</option>
							<option value="t2" <?php if($type == 2){?> selected="selected"<?php ;}?>>多选题</option>						
						</select>
						&nbsp;试题分类&nbsp;
						<select id="cat_select" onchange="cat_select_callback()" class="span2">
							<option value="c0" selected="selected">全部分类</option>
							<?php 
						  
								foreach ($cats as $row_one)
								{
									?>
									<option value="<?php echo 'c'.$row_one['category_id'];?>" <?php if($row_one['category_id'] == $category_id)
									{
										?> selected="selected"<?php ;
									}
									?>
										>
									<?php echo $row_one['category_name'];?></option>			 
							 <?php 
						   		}
						   ?>
						</select>
             </form>
		</div>
		<div class="hright">
			<button class="btn btn-success" type="button" onclick="window.location.href = '<?php echo base_url()?>index.php/question/create'" >创建试题</button>   
			<button class="btn btn-success" type="button" onclick="window.location.href = '<?php echo base_url()?>index.php/question/import'" >导入试题</button>
			<button class="btn btn-success" type="button" onclick="window.location.href = '<?php echo base_url()?>index.php/question/list_attribute'" >管理分类</button>	
			<button class="btn btn-danger" type="button" onclick="delete_all()" >批量删除</button>			
		</div>
	</div>
	
	<div class="cleanup"></div>
	
	<table class="table table-bordered table-striped">
	<thead>
		<tr>
		<th><input type="checkbox" name="check_all" id="check_all" /></th>
		<th >题型</th>
		<th style="width:30%;">试题摘要</th>
		<th >试题分类</th>
		<th >难度</th>
		<th >SOP</th>
		<th >创建时间</th>
		<th style="width:20%;">操作</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($item_list as $item){ ?>
	<tr>
	<td><input type="checkbox" name="check_list" value="<?php echo $item['question_id']; ?>" /></td>
	<td><span><?php echo $item['type']; ?></span></td>
	<td><span><?php echo $item['question']; ?></span></td>
	<td><span><?php echo $item['category_name']; ?></span></td>
	<td><span><?php echo $item['difficulty_name']; ?></span></td>
	<td><span><?php echo $item['sop_name']; ?></span></td>
	<td><span><?php echo $item['create_at']; ?></span></td>
	<td><button class="btn btn-small btn-primary" type="button" onclick="window.location.href = '<?php echo base_url()?>index.php/question/view/<?php echo $item['question_id']?>'">查看</button>&nbsp;&nbsp;
	<button class="btn btn-small btn-success"   type="button" onclick="window.location.href = '<?php echo base_url()?>index.php/question/update/<?php echo $item['question_id']?>'">编辑</button>
	<button class="btn btn-small btn-danger"  onclick="delete_question(<?php echo $item['question_id']; ?>)" type="button">删除</button>
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
    	window.location.href = '<?php echo base_url()?>index.php/topic/index/'+ $('#search_string').val();
    }
    $("#check_all").click(function(){
        $("input[name='check_list']").prop("checked",this.checked);
    });

</script>