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

	function selectChange(type,cat1)
	{
		<?php echo "var baseurl='".base_url()."';" ;?>
		window.location.href = baseurl+'index.php/testpaper/step2_2/'+type+'/'+cat1+'/0';
	}
		
	function go(type,cat1,offset){
		<?php echo "var baseurl='".base_url()."';" ;?>
		url = baseurl+'index.php/testpaper/step2_2/'+type+'/'+cat1+'/0/';
		if(document.getElementsByName("select_all")[0].checked){
			document.add_form.action = url;
		}else{
			document.add_form.action = url+'/'+offset;
		}
		$('#mode').val('add');
		document.add_form.submit();
	}
	
	function del(type,cat1,offset){
		<?php echo "var baseurl='".base_url()."';" ;?>
		url = baseurl+'index.php/testpaper/step2_2/'+type+'/'+cat1+'/0/';
		if(document.getElementsByName("delete_all")[0].checked){
			document.add_form.action = url;
		}else{
			document.add_form.action = url+'/'+offset;
		}
		$('#mode').val('del');
		document.add_form.submit();
	}
	
	function createRule(type,cat1)
	{
		<?php echo "var baseurl='".base_url()."';" ;?>
	
		var randomNum = $("#number").val();
		var total = $("#total").val();

		var cat1 = $("#cat1Id").val();

		if(cat1 == 0){
			alert("请选择一级分类");
			return;
		}

		var re = /^[1-9]+[0-9]*]*$/;
		if(!re.test(randomNum))
		{
			alert("请输入正整数");
			return;
		}

		//if(randomNum > total){
        if(parseInt(randomNum) > parseInt(total)){
			alert("抽取个数不能多于可选题数");
			return;
		}


		url = baseurl+'index.php/testpaper/step2_2/'+type+'/'+cat1+'/'+randomNum;
		$('#mode').val('add');

       $("#add_form").attr("action", url);
       $("#add_form").attr("method","POST");
       $("#add_form").submit();
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
						} ?>试卷（添加规则）</h3>
    	</div>

    	<?php if($rules_existed == 1) { ?>
        <div class="alert alert-error">相同分类下规则不能重复添加，若要添加先删除原规则</div>
		<?php } ?>
		<?php if($info !='') { //for testing ?>
		<div class="alert alert-error"><?php echo $info?></div>
		<?php } ?>
		<form class="form-inline" id="add_form" name="add_form" action="" method="POST">
		    <div class="control-group">
		    	<!-- label class="control-label">选择参考部门：</label-->
		    	<div class="controls">
		    		题型选择&nbsp;&nbsp;&nbsp;
					<select name="type" class="span2" onchange="selectChange(this.value,<?php echo $cat1?>);">
						<?php foreach($setTypeList as $key => $typename){?>
						<option value=<?php echo $key?> <?php if($key==$type) echo 'selected'?>><?php echo $typename?> </option>
						<?php } ?>
					</select>
					<div class="vspace"></div>
		    		试题分类&nbsp;&nbsp;&nbsp;
					<select name="cat1" id="cat1Id" class="span2" onchange="selectChange(<?php echo $type?>,this.value);">
						<?php foreach($cat1_list as $row){?>
						<option value=<?php echo $row['category_id']?> <?php if($row['category_id']==$cat1) echo 'selected'?>><?php echo $row['category_name']?></option>
						<?php } ?>
					</select>
		    	</div>
		    </div>
		    <div class="control-group">
		    	<!--<label class="control-label">试题个数：</label> -->
		    	<div class="controls">
				试题个数&nbsp;&nbsp;&nbsp;
		    		<input type="text" class="span1" id="number" name="number"  placeholder="输入整数"><span style="color:#FF0000;">*当前可选试题<?php echo $total ?>个</span>
		    	</div>
		    </div>

		    <div align="center">
	     		    <button class="btn btn-primary" type="button" onclick="createRule(<?php echo $type?>,<?php echo $cat1?>);">添加规则</button>
    	   </div> 
			
			<?php echo validation_errors('<div class="alert alert-error">', '</div>'); ?>
		    
		    <div class="page-header">
	    		<h5>已添加的规则（<?php echo  count($added_rules)?>个）</h5>
	    	</div>
			<a id="delete_question"></a>
			<?php if($added_rules) { ?>
		    	<table class="table table-bordered table-striped">
			      <thead>
			        <tr>
						<th width="20px"><input type="checkbox" name="delete_all" onclick="checkAll(this, 'deleted_rules[]')" checked="checked"></th>
			        	<th width="45px">题型</th>
			          	<th>试题分类</th>
			          	<th width="100px">抽取个数</th>
			          	<th width="100px">操作</th>          
			        </tr>
			      </thead>
			      <tbody>
				  	<?php foreach($added_rules as $row) { ?>
			        <tr>
						<td>
			            <span><input type="checkbox" name="deleted_rules[]" value="<?php echo $row['id']?>" onclick="checkItem(this, 'delete_all')" checked="checked"></span>
			          </td>
			        	<td>
			            	<span><?php echo $row['type']?></span>
			          	</td>			          
			          	<td>
			            	<span><?php echo $row['cat1']?></span>
			          	</td>
						<td>
				           <span><?php echo $row['num']?></span>
				        </td>
			          	<td>
			          		<button class="btn btn-small btn-danger" type="button" onclick="window.location.href='<?php echo base_url() ?>index.php/testpaper/step2_2_delete_rule/<?php echo $row['id'].'/'.$type.'/'.$cat1.'/'.$num.'/'.$offset ?>'">去除</button>
			          	</td>
			        </tr>
					<?php } ?>
			       </tbody>
			     </table>
				 <button class="btn btn-small btn-primary" type="botton" onclick="del(<?php echo $type?>,<?php echo $cat1?>,<?php echo $offset?$offset:0?>);">去除所选规则</button>
			 <?php }else{ ?>
			 	<div align="center">请选择分类并添加规则。<br/><br/> </div>
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
						<span><?php echo $value['qcnt'];  echo "题（每题".$value['point'];?>分）</span>
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
		  <input type="hidden" name="total" id="total" value="<?php echo $total ?>"/>
		</form>
		 <div align="center">
			    <button class="btn btn-info" type="button" onclick="window.location.href = '<?php echo base_url() ?>index.php/testpaper/index'">回到试卷一览</button>	
    	</div> 
	</div>
</div> <!-- /container -->
