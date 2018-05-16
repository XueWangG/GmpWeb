<script type="text/javascript" charset="utf-8">
	function checkAll(e, itemName)
    {    
		var aa = document.getElementsByName(itemName);
		for (var i=0; i<aa.length; i++){
			aa[i].checked = e.checked;
		}
    }

    function checkItem(e, allName)
    {
        var all = document.getElementsByName(allName)[0];
        if(!e.checked){
            all.checked = false;
        } else {
            var aa = document.getElementsByName(e.name);
            for (var i=0; i<aa.length; i++)
                
            if(!aa[i].checked) return;    
            all.checked = true;
        }
    }

	function selectChange(type,cat1,sop)
	{
		<?php echo "var baseurl='".base_url()."';" ;?>
		window.location.href = baseurl+'index.php/testpaper/step2_1/'+type+'/'+cat1+'/'+sop+'/0';
	}
	
	function randomCreate(type,cat1,sop)
	{
		<?php echo "var baseurl='".base_url()."';" ;?>
		randomNum = document.getElementById("random").value;
		var re = /^[1-9]+[0-9]*]*$/;
		if(!re.test(randomNum))
		{
			alert("请输入正整数");
			return;
		}
		window.location.href = baseurl+'index.php/testpaper/step2_1/'+type+'/'+cat1+'/'+sop+'/'+randomNum;
		
	}
	
	function go(type,cat1,sop,offset){
		<?php echo "var baseurl='".base_url()."';" ;?>
		url = baseurl+'index.php/testpaper/step2_1/'+type+'/'+cat1+'/'+sop+'/0/';
		if(document.getElementsByName("select_all")[0].checked){
			document.add_form.action = url;
		}else{
			document.add_form.action = url+'/'+offset;
		}
		$('#mode').val('add');
		document.add_form.submit();
	}
	
	function del(type,cat1,sop,offset){
		<?php echo "var baseurl='".base_url()."';" ;?>
		url = baseurl+'index.php/testpaper/step2_1/'+type+'/'+cat1+'/'+sop+'/0/';
		if(document.getElementsByName("delete_all")[0].checked){
			document.add_form.action = url;
		}else{
			document.add_form.action = url+'/'+offset;
		}
		$('#mode').val('del');
		document.add_form.submit();
	}
	
	window.history.forward(1); 

</script>
<script language="JavaScript"> 

    

         

</script>


<div class="container">
  
  	<div class="container-body">
    	<div class="page-header">
    		<h3><?php  if($this->session->userdata('SESSION_NAME_PAPER_CREATE')==2)
			 			{
							echo "复制";
						} else if($this->session->userdata('SESSION_NAME_PAPER_CREATE')==1) {
							 echo "创建";
						} else {
							echo "编辑";
						} ?>试卷（添加试题）</h3>
    	</div>
    	
		<form class="form-inline" name="add_form" action="" method="POST">
		    <div class="control-group">
		    	<!-- label class="control-label">选择参考部门：</label-->
		    	<div class="controls">
		    		题型选择&nbsp;&nbsp;&nbsp;
					<select name="type" class="span2" onchange="selectChange(this.value,<?php echo $cat1?>,<?php echo $sop?>);">
						<?php foreach($setTypeList as $key => $typename){?>
						<option value=<?php echo $key?> <?php if($key==$type) echo 'selected'?>><?php echo $typename?> </option>
						<?php } ?>
					</select>
					<div class="vspace"></div>
		    		试题分类&nbsp;&nbsp;&nbsp;
					<select name="cat1" class="span2" onchange="selectChange(<?php echo $type?>,this.value,<?php echo $sop?>);">
						<option value="0">--全部--</option>
						<?php foreach($cat1_list as $row){?>
						<option value=<?php echo $row['category_id']?> <?php if($row['category_id']==$cat1) echo 'selected'?>><?php echo $row['category_name']?></option>
						<?php } ?>
					</select>
					<div class="vspace"></div>
		    		SOP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<select name="sop" class="span2" onchange="selectChange(<?php echo $type?>,<?php echo $cat1?>,this.value);">
						<option value="0">--全部--</option>
						<?php foreach($sop_list as $row){?>
						<option value=<?php echo $row['sop_id']?> <?php if($row['sop_id']==$sop) echo 'selected'?>><?php echo $row['sop_name']?></option>
						<?php } ?>
					</select>
		    	</div>
		    </div>
			
			<?php echo validation_errors('<div class="alert alert-error">', '</div>'); ?>
		    
			<?php if($findZeroFlg) {?>
			<div align="center"><br/>您所选择的试题分类下尚未添加过试题，或已经全部添加到试卷中了。<br/><br/> </div>
			<?php }else if($questions) { ?>
			    
	     		<button class="btn btn-small btn-primary" type="button" onclick="randomCreate(<?php echo $type?>,<?php echo $cat1?>,<?php echo $sop?>);">随机生成</button>
				<input type="text" name="random" id="random" style="width:30px;" value="<?php echo $random?$random:''?>">道题
			    <div class="span10"></div>
				<table class="table table-bordered table-striped">
			      <thead>
			        <tr>
			          <th width="20px"><input type="checkbox" name="select_all" onclick="checkAll(this, 'selected_questions[]')" checked="checked"></th>
			          <th>试题摘要</th>
			          <th width="49px">操作</th>			                          
			        </tr>
			      </thead>
			      <tbody>
				  	<?php foreach($questions as $question) { ?>
			        <tr>
			          <td>
			            <span><input type="checkbox" name="selected_questions[]" value="<?php echo $question['question_id']?>" onclick="checkItem(this, 'select_all')" checked="checked"></span>
			          </td>
			          <td>
			            <span><?php echo $question['question']?></span>
			          </td>
			          <td>
			            <span><a class="btn btn-small btn-primary" href="<?php echo base_url() ?>index.php/question/view/<?php echo $question['question_id'] ?>" target="_blank">详细</a></span>
			          </td>
			        </tr>
			        <?php } ?>
			      </tbody>
			    </table>			    

				<input type="hidden" name="offset" value="<?php echo $offset?>">
			    <button class="btn btn-small btn-primary" type="botton" onclick="go(<?php echo $type?>,<?php echo $cat1?>,<?php echo $sop?>,<?php echo $offset?$offset:0?>);">添加试题到本试卷</button>
				<?php if($this->uri->segment(5)==0) { ?>
					<?php echo  $this->pagination->create_links();?>
				<?php } ?>
			<?php } ?>

		    <div class="page-header">
	    		<h5>已添加的试题（<?php echo  count($added_questions)?>题）</h5>
	    	</div>
			<a id="delete_question"></a>
			<?php if($added_questions) { ?>
		    	<table class="table table-bordered table-striped">
			      <thead>
			        <tr>
						<th width="20px"><input type="checkbox" name="delete_all" onclick="checkAll(this, 'deleted_questions[]')" checked="checked"></th>
			        	<th width="45px">题型</th>
			          	<th width="290px">试题摘要</th>
			          	<th>试题分类</th>
			          	<th width="100px">操作</th>          
			        </tr>
			      </thead>
			      <tbody>
				  	<?php foreach($added_questions as $row) { ?>
			        <tr>
						<td>
			            <span><input type="checkbox" name="deleted_questions[]" value="<?php echo $row['id']?>" onclick="checkItem(this, 'delete_all')" checked="checked"></span>
			          </td>
			        	<td>
			            	<span><?php echo $row['type']?></span>
			          	</td>			          
						<td>
				           <span><?php echo $row['question']?></span>
				        </td>
			          	<td>
			            	<span><?php echo $row['cat1']?></span>
			          	</td>
			          	<td>
			          		<a class="btn btn-small btn-primary" href="<?php echo base_url() ?>index.php/question/view/<?php echo $row['id'] ?>" target="_blank">详细</a>
			          		<button class="btn btn-small btn-danger" type="button" onclick="window.location.href='<?php echo base_url() ?>index.php/testpaper/step2_1_delete_question/<?php echo $row['id'].'/'.$type.'/'.$cat1.'/'.$sop.'/'.'/'.$random.'/'.$offset ?>'">去除</button>
			          	</td>
			        </tr>
					<?php } ?>
			       </tbody>
			     </table>
				 <button class="btn btn-small btn-primary" type="botton" onclick="del(<?php echo $type?>,<?php echo $cat1?>,<?php echo $sop?>,<?php echo $offset?$offset:0?>);">去除所选试题</button>
			 <?php }else{ ?>
			 	<div align="center">请选择分类并添加试题。<br/><br/> </div>
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
					<?php 
					$i=0;
					foreach($testpaper['point_list'] as $value) { ?>          
					<td>
						<span><?php echo $value['qcnt']; echo "题（每题".$value['point'];?>分）</span>
			        </td>
		       		<?php 
					$i++;
					} ?>
		          	<td>
		          		<span><?php echo $testpaper['total_point']?>分</span>
		          	</td>
		        </tr>
		       </tbody>
		     </table>
		  <input type="hidden" name="mode" id="mode" value=""/>
		</form>
		 <div align="center">
			    <button class="btn btn-info" type="button" onclick="window.location.href = '<?php echo base_url() ?>index.php/testpaper/index'">回到试卷一览</button>	
    	</div> 
	</div>
</div> <!-- /container -->
