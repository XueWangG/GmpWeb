<script>
function delete_answer(topic_id,id) { 
	if(confirm("是否将回答"+id+" 删除?")){
		<?php echo "var baseurl='".base_url()."';" ;?>
		window.location.href = baseurl+'index.php/topic/delete_answer/'+topic_id+'/'+id;
	}else{
		return false;
	}
}
</script>
<div class="container">
	
	<div class="container-body">
	<div class="page-header">
		<h3>问答详情</h3>
	</div>
	<div>
	<p>问题ID <?php echo $topic['topic_id']?><p>
	<p><?php echo $topic['topic_content']?><p>
	<p>关注数：<?php echo $topic['follower_count']?> 回答数：<?php echo $topic['answer_count']?><p>
	</div>

	
	<div class="cleanup"></div>
	
	<table class="table table-bordered table-striped">
	<thead>
		<tr>
		<th >回答ID</th>
		<th style="width:30%;">回答内容</th>
		<th >关注</th>
		<th>评论</th>
		<th>点赞</th>
		<th>发布时间</th>
		<th style="width:15%;">操作</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($item_list as $item){ ?>
	<tr>
	<td><span><?php echo $item['topic_answer_id']; ?></span></td>
	<td><span><?php echo $item['content']; ?></span></td>
	<td><span><?php echo $item['follower_count']; ?></span></td>
	<td><span><?php echo $item['comment_count']; ?></span></td>
	<td><span><?php echo $item['thumbup_count']; ?></span></td>
	<td><span><?php echo $item['create_at']; ?></span></td>
	<td><button class="btn btn-small btn-primary" type="button" onclick="window.location.href = '<?php echo base_url()?>index.php/topic/view_answer/<?php echo $item['topic_answer_id']?>'">查看</button>&nbsp;&nbsp;
	<?php if($this->session->userdata(SESSION_NAME_COMPANY_ID) == PLATFORM_COMPANY){?>
	<button class="btn btn-small btn-danger"  onclick="delete_answer(<?php echo $topic['topic_id'].','.$item['topic_answer_id']; ?>)" type="button">删除</button></td>
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
