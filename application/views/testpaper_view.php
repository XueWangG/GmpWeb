
<div class="container">

  	<div class="container-body">
    	<div class="page-header">
    		<h3>查看试卷</h3>
    	</div>
		
		<table class="table">
			<tr>
				<td  class="span2 noborder right_align">试卷名称&nbsp;&nbsp;:</td>
				<td  class="span9 noborder"><?php echo $paperName?></td>
			</tr>
			<tr>
				<td colspan="2"><div id="oldImage">
                         <img style="max-height:150px;" src="<?php echo base_url().$cover_url?>" />
                    </div>
            	</td>
			</tr>
			<?php foreach($typeList as $key => $type) { ?>
			<tr>
				<td  class="span2 noborder right_align"><?php echo $type?>分值&nbsp;&nbsp;:</td>
				<td  class="span9 noborder"><?php echo $pointList[$key] ?></td>
			</tr>
			<?php } ?>
			<tr>
				<td  class="span2 noborder right_align">总分&nbsp;&nbsp;:</td>
				<td  class="span9 noborder"><?php echo $testpaper['total_point']?>分</td>
			</tr>
			<tr>
				<td  class="span2 noborder right_align">通过分数线&nbsp;&nbsp;:</td>
				<td  class="span9 noborder"><?php echo $cutoff ?>分</td>
			</tr>
			<tr>
				<td  class="span2 noborder right_align">试卷难度&nbsp;&nbsp;:</td>
				<td  class="span9 noborder"><?php echo $difficulty?></td>
			</tr>
			<tr>
				<td  class="span2 noborder right_align">试卷介绍&nbsp;&nbsp;:</td>
				<td  class="span9 noborder"><?php echo $description?></td>
			</tr>
		</table>
		<br/>
		
	<?php if($papertype == 1) { ?>

	    <div class="page-header">
    		<h5>已添加的试题（<?php echo  count($added_questions)?>题）</h5>
    	</div>
		<a id="delete_question"></a>
		<?php if($added_questions) { ?>
	    	<table class="table table-bordered table-striped">
		      <thead>
		        <tr>
		        	<th width="45px">题型</th>
		          	<th width="300px">试题摘要</th>
		          	<th>试题分类</th>
		          	<th width="50px">操作</th> 
		        </tr>
		      </thead>
		      <tbody>
			  	<?php foreach($added_questions as $row) { ?>
		        <tr>
		        	<td>
		            	<span><?php echo $row['type']?></span>
		          	</td>			          
					<td>
			           <span><?php echo $row['question']?></span>
			        </td>
		          	<td>
		            	<span><?php echo $row['cat1']?></span>
		          	</td>
		          	</td>
		          	<td>
		          		<button class="btn btn-small btn-primary" type="button" onclick="window.location.href='<?php echo base_url() ?>index.php/question/view/<?php echo $row['id'] ?>'">详细</button>
		          	</td>
		        </tr>
				<?php } ?>
		       </tbody>
		     </table>
		 <?php } ?>
	  
	  <?php }else{ ?>

		    <div class="page-header">
	    		<h5>已添加的规则（<?php echo  count($added_rules)?>个）</h5>
	    	</div>
			<a id="delete_question"></a>
			<?php if($added_rules) { ?>
		    	<table class="table table-bordered table-striped">
			      <thead>
			        <tr>
			        	<th width="45px">题型</th>
			          	<th>试题分类</th>
			          	<th width="100px">抽取个数</th>
			        </tr>
			      </thead>
			      <tbody>
				  	<?php foreach($added_rules as $row) { ?>
			        <tr>
			        	<td>
			            	<span><?php echo $row['type']?></span>
			          	</td>			          
			          	<td>
			            	<span><?php echo $row['cat1']?></span>
			          	</td>
			          	</td>
						<td>
				           <span><?php echo $row['num']?></span>
				        </td>
			        </tr>
					<?php } ?>
			       </tbody>
			     </table>
			 <?php } ?>

		 <?php } ?>

		<div class="page-header">
    		<h5>试卷摘要</h5>
    	</div>
    	
    	<table class="table table-bordered table-striped">
	      <thead>
	        <tr>
	        	<th>名称</th>
				 <?php foreach($setTypeList as $type) { ?>
	          	<th><?php echo $type?></th>
				 <?php } ?>
	          	<th>总分</th>                
	        </tr>
	      </thead>
	      <tbody>
		  	<tr>
	        	<td>
	            	<span><?php echo $testpaper['name']?></span>
	          	</td>
				<?php foreach($testpaper['point_list'] as $value) { ?>          
				<td>
					<span><?php echo $value['qcnt']?>题（每题<?php echo $value['point']?>分）</span>
		        </td>
	       		<?php } ?>
	          	<td>
	          		<span><?php echo $testpaper['total_point']?>分</span>
	          	</td>
	        </tr>
	       </tbody>
	     </table>
	    <div align="center">
	    	<button type="button" class="btn btn-info" onclick="javascript:history.go(-1)">返回</button>
	    </div>
	</div>

</div> <!-- /container -->