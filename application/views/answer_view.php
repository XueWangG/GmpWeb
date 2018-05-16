<script>
function delete_answer_comment(topic_answer_id,id) { 
	if(confirm("是否将回答评论"+id+" 删除?")){
		<?php echo "var baseurl='".base_url()."';" ;?>
		window.location.href = baseurl+'index.php/topic/delete_answer_comment/'+topic_answer_id+'/'+id;
	}else{
		return false;
	}
}
</script>
<div class="container">
	
	<div class="container-body">
	<div class="page-header">
		<h3>回答详情</h3>
	</div>
	<div>
	<p>问题 <?php echo $answer['topic_id']?><p>
	<p> <?php echo $answer['topic_content']?><p>
	<p>回答<?php echo $answer['topic_answer_id']?><p>
	<p><?php echo $answer['answer_content']?><p>
	<p>关注数：<?php echo $answer['follower_count']?> 评论数：<?php echo $answer['comment_count']?> 点赞数：<?php echo $answer['thumbup_count']?><p>
	</div>

	
	<div class="cleanup"></div>
	
	<table class="table table-bordered table-striped">
	<thead>
		<tr>
		<th >评论ID</th>
		<th style="width:30%;">评论内容</th>
		<th>发布时间</th>
		<th style="width:15%;">操作</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($item_list as $item){ ?>
	<tr>
	<td><span><?php echo $item['answer_comment_id']; ?></span></td>
	<td><span><?php echo $item['comment_content']; ?></span></td>
	<td><span><?php echo $item['create_at']; ?></span></td>
	<td>
	<?php if($this->session->userdata(SESSION_NAME_COMPANY_ID) == PLATFORM_COMPANY){?>
	<button class="btn btn-small btn-danger"  onclick="delete_answer_comment(<?php echo $answer['topic_answer_id'].','.$item['answer_comment_id']; ?>)" type="button">删除</button></td>
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
