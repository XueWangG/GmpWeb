<script>
function delete_topic(id) { 
	if(confirm("是否将问答"+id+" 删除?")){
		<?php echo "var baseurl='".base_url()."';" ;?>
		window.location.href = baseurl+'index.php/topic/delete/'+id;
	}else{
		return false;
	}
}
</script>
<div class="container">
	
	<div class="container-body">
	<div class="page-header">
		<h3>问答广场</h3>
	</div>
	
	<div style="padding:10px 0px 10px 0px">
		<div class="hleft">
			<form id="search_form" class="form-inline">
                  	<input type="text" name="search_string" id="search_string"  value="<?php echo $search_string; ?>" placeholder="关键词">
                     <button  type="button" onclick="search()" class="btn btn-primary">查询</button>
             </form>
		</div>
	</div>
	
	<div class="cleanup"></div>
	
	<table class="table table-bordered table-striped">
	<thead>
		<tr>
		<th >问题ID</th>
		<th style="width:30%;">问题内容</th>
		<th >关注</th>
		<th>回答</th>
		<th>发布时间</th>
		<th style="width:25%;">操作</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($item_list as $item){ ?>
	<tr>
	<td><span><?php if($item['status']==2){echo '<strong>'.$item['topic_id'].'</strong>';}else{echo $item['topic_id'];} ?></span></td>
	<td><span><?php if($item['status']==2){echo '<strong>'.$item['topic_content'].'</strong>';}else{echo $item['topic_content'];} ?></span></td>
	<td><span><?php echo $item['follower_count']; ?></span></td>
	<td><span><?php echo $item['answer_count']; ?></span></td>
	<td><span><?php echo $item['create_at']; ?></span></td>
	<td><button class="btn btn-small btn-primary" type="button" onclick="window.location.href = '<?php echo base_url()?>index.php/topic/view/<?php echo $item['topic_id']?>'">查看</button>&nbsp;&nbsp;
	<?php if($item['status']!=2){?>
	<button class="btn btn-small btn-success" type="button" onclick="window.location.href = '<?php echo base_url()?>index.php/topic/topmost/<?php echo $item['topic_id']?>'">置顶</button>&nbsp;&nbsp;
	<?php }?>
	<?php if($item['status']==2){?>
	<button class="btn btn-small btn-success" type="button" onclick="window.location.href = '<?php echo base_url()?>index.php/topic/cancel_topmost/<?php echo $item['topic_id']?>'">取消置顶</button>&nbsp;&nbsp;
	<?php }?>
	<?php if($this->session->userdata(SESSION_NAME_COMPANY_ID) == PLATFORM_COMPANY){?>
	<button class="btn btn-small btn-danger"  onclick="delete_topic(<?php echo $item['topic_id']; ?>)" type="button">删除</button></td>
	<?php }?>
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

</script>