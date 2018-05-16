<script type="text/javascript" charset="utf-8">

function yesno(name,id) { 
	if(confirm("是否将《"+name+"》删除?")){
		<?php echo "var baseurl='".base_url()."';" ;?>
		window.location.href = baseurl+'index.php/testpaper/delete/'+id;
	}else{
		return false;
	}
}

</script>

<div class="container">
  
  	<div class="container-body">
    	<div class="page-header">
    		<h3>试卷列表</h3>
    	</div>
    	
    	<form action="<?php echo base_url()?>index.php/testpaper/create_step1">
    		<div class="hright">
    			<div class="control-group">
			    	<button class="btn btn-success" type="submit">创建试卷</button>
		    	</div>	    			
    		</div>
	    </form>
	    
     	<div class="span10"></div>
     	
		<?php if($testpapers) { ?>
		<table class="table table-bordered table-striped">
		      <thead>
		        <tr>
		          <th style="width:190px;">试卷名称</th>
				  <?php foreach($typeList as $type) { ?>
		          <th><?php echo $type?></th>
		          <th><?php echo $type?>分值</th>
				  <?php } ?>
		          <th>总分</th>
		          <th>合格</th>
		          <th style="width:150px;">操作</th>                
		        </tr>
		      </thead>
		      <tbody>
			  	<?php foreach($testpapers as $row) { ?>
		        <tr>
		          <td>
		            <span><?php echo $row['name']?></span>
		          </td>
				  <?php foreach($row['point_list'] as $value) { ?>
		          <td>
		            <span><?php echo $value['qcnt']?>题</span>
		          </td>
		          <td>
		            <span><?php echo $value['point']?$value['point'].'分':'未设置'?></span>
		          </td>
				  <?php } ?>
		          <td>
		            <span><?php echo $row['total_point']?>分</span>
		          </td>
		          <td>
		            <span><?php echo $row['cutoff']?>分</span>
		          </td>
		          <td>
		          	<button class="btn btn-small btn-primary" type="button" onclick="window.location.href='<?php echo base_url()?>index.php/testpaper/view/<?php echo $row['id']?>'">查看</button>
					<?php if($row['update_flg']){?>
			          	<button class="btn btn-small btn-success" type="button" onclick="window.location.href='<?php echo base_url()?>index.php/testpaper/update_step1/<?php echo $row['id']?>'">编辑</button>
					<?php } ?>
					
					<?php if($row['delete_flg']){?>
			            <button class="btn btn-small btn-danger" type="button" onclick="yesno('<?php echo $row['name']?>', <?php echo $row['id']?>)">删除</button>
					<?php } ?>
					
					<!--  button class="btn btn-small btn-info" type="button" onclick="window.location.href='<?php echo base_url()?>index.php/testpaper/step1_copy/<?php echo $row['id']?>'">复制</button-->
		          </td>
		        </tr>
		        <?php } ?>        
		        
		      </tbody>
		    </table>    
		    <?php echo  $this->pagination->create_links();?>
		    <?php } else { ?> 
			目前没有试卷信息。
		    <?php } ?>      
		</div>
  		

</div> <!-- /container -->
