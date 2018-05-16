
<div class="container">
  
  	<div class="container-body">
    	<div class="page-header">
    		<h3>查看测试</h3>
    	</div>
    	
		
		<table class="table">
			<tr>
				<td  class="span2 noborder right_align">测试名称&nbsp;:</td>
				<td  class="span9 noborder"><?php echo $test_name?></td>
			</tr>
			<tr>
				<td  class="span2 noborder right_align">试卷名称&nbsp;:</td>
				<td  class="span9 noborder"><a href="<?php echo base_url()?>index.php/testpaper/view/<?php echo $test_paper_id?>"><?php echo $test_paper_name?></a></td>
			</tr>
			<tr>
				<td  class="span2 noborder right_align">试卷难易程度&nbsp;:</td>
				<td  class="span9 noborder"><?php echo $difficulty?></td>
			</tr>
			<tr>
				<td  class="span2 noborder right_align">测试期间&nbsp;:</td>
				<td  class="span9 noborder">
                    <?php echo $start_time?>~<?php echo $end_time?>
				</td>
			</tr>
			<tr>
				<td  class="span2 noborder right_align">试卷介绍&nbsp;:</td>
				<td  class="span9 noborder"><?php echo $description?></td>
			</tr>
		</table>
		<br/>
		
		
		 <div align="center">
			    <button type="button" class="btn btn-info" onclick="javascript:history.go(-1)">返回</button>	
    	</div> 
	</div>

</div> <!-- /container -->