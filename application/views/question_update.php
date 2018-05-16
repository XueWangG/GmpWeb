<script type="text/javascript" language="javascript">  
	<?php echo "var baseurl='".base_url()."';" ;?>	

	//check_box_name Array
	var check_box_name = new Array("[name='choice_1[]']","[name='choice_2[]']","[name='choice_3[]']","[name='choice_4[]']","[name='choice_5[]']","[name='choice_6[]']","[name='choice_7[]']","[name='choice_8[]']","[name='choice_9[]']","[name='choice_10[]']");
	var choice_type = new Array('chk_box_a','chk_box_b','chk_box_c','chk_box_d','chk_box_e','chk_box_f','chk_box_g','chk_box_h','chk_box_i','chk_box_j');
	var choice_box_class = new Array('.choice_1','.choice_2','.choice_3','.choice_4','.choice_5','.choice_6','.choice_7','.choice_8','.choice_9','.choice_10');
	var choice_array=new Array('div_choice_a','div_choice_b','div_choice_c','div_choice_d','div_choice_e','div_choice_f','div_choice_g','div_choice_h','div_choice_i','div_choice_j');
	var editer_array=new Array('choice_content_a','choice_content_b','choice_content_c','choice_content_d','choice_content_e','choice_content_f','choice_content_g','choice_content_h','choice_content_i','choice_content_j');
	var blank_num = 0;
	
	function get_anser_name()
	{
		if($("#s_type").val() == 2)
		{
			return 'ans_check[]';
		}
		else
		{
			return 'ans_radio';
		}
	}
	//init
	$(function () {
		var ans_name = get_anser_name();
		
		//init choice
		<?php echo "var choice_num='".count($choice)."';" ;?>
		var i = 0;
		if(choice_num && choice_num != ''){
			for(i=0;i<choice_num;i++)
			{
				$("#"+choice_array[i]).css('display','block');
			}
		
		}
		//init select type
		$("#s_type").val(<?php echo $s_type;?>);

		//init check
		var chk_tag = 0;
		
		if(<?php echo $s_type;?> == 2)
		{
			$("input[type='radio']").hide();
			$("input[type='checkbox']").show();
			
			<?php
			$ans_arr = str_split($question['answer']);
			foreach($ans_arr as $row)
			{
				echo "chk_tag='".(ord($row)-65)."';" ;
			?>

				$('#'+choice_type[chk_tag]).attr('checked','checked');
			<?php
			}		
			?>
		}
		else if(<?php echo $s_type;?> == 1 )
		{
			change_to_radio();
			var obj = document.getElementsByName(ans_name);
			<?php echo "chk_tag='".(ord($question['answer'])-65)."';" ;?>
			// 获取对象		
				obj[chk_tag].checked=true;		 
		}
		else 
		{
			alert('不支持的题型');
		}
		
		//init select cat
		$("#s_cat1").val(<?php echo $s_cat1;?>);		
		$("#s_cat2").val(<?php echo $s_cat2;?>);
		$("#s_cat3").val(<?php echo $s_cat3;?>);		
		
	});

	
		
	function change_to_radio()
	{
		$("input[type='checkbox']").removeAttr("checked");
		$("input[type='radio']").removeAttr("checked");
		$("input[type='checkbox']").hide();
		$("input[type='radio']").show();
	}
	
	function change_to_check()
	{
		$("input[type='checkbox']").removeAttr("checked");
		$("input[type='radio']").removeAttr("checked");
		$("input[type='radio']").hide();
		$("input[type='checkbox']").show();
	}

	function decrease_choice_num(choice_num, ans_name)
	{
		for(i=9;i>=choice_num;i--)//clear text
		{
			var choice=$("#"+choice_array[i]);
			if(choice.css('display')=="block")
			{
				$("#"+editer_array[i]).val('');
				choice.css('display','none');
				
				
				var obj = document.getElementsByName(ans_name); // 获取对象	
				if (obj[i].checked==true)
				{
					obj[i].checked = false;	
				}
			}
		}
	}

	function display_choice(choice_num)
	{
		for(i=0;i < choice_num;i++)
		{
			var choice=$("#"+choice_array[i]);
			if(choice.css('display')=="none")
			{
				
				choice.css('display','block');
			}
		}
	}
	
	function type_callback()
	{
		var ans_name = get_anser_name();
		var i = 0;
		if($("#s_type").val() == 2)
		{
			remove_blank();
			$("#choice_num_change").css('display','block');
			change_to_check();
			//$("#choice_content_a").val('');
			//$("#choice_content_b").val('');
			
			//去掉多余选项
			decrease_choice_num(5, ans_name);
			//显示5个选项
			display_choice(5);
			
		}
		else if($("#s_type").val() == 1)
		{
			remove_blank();
			$("#choice_num_change").css('display','block');
			change_to_radio();
			//$("#choice_content_a").val('');
			//$("#choice_content_b").val('');
			//去掉多余选项
			decrease_choice_num(4, ans_name);
			//显示4个选项
			display_choice(4);
		}
		
		else
		{
			alert('不支持的题型');

		}
		
	}

	function remove_blank()
	{
		blank_num = 0;
		$("#answer_result").css('display','none');
		$("#blank").children().remove();
		$("#question_answer").val('');
	}

	function increase_blank_btn()
	{
		blank_num++;
		var appandString = "<span id=\"blank_" + blank_num + "\"><span>" + blank_num + "</span><span><input id=\"blank_answer\" name=\"blank_answer[]\" type=\"text\"><span><br><br></span>";
		$("#blank").append(appandString);
		if(blank_num == 1)
		{
			//$("#decrease_blank_btn").removeAttr("disabled");
			$("#decrease_blank_btn").show();
		}
	}

	function decrease_blank_btn()
	{
		$("#blank_" + blank_num).remove();
		blank_num--;
		if(blank_num == 0)
		{
			//$("#decrease_blank_btn").attr("disabled","");
			$("#decrease_blank_btn").hide();
		}		
	}
	
	function increase_choice()
	{

		var i=0;
		var inflag="N";
		
		for(i=2;i<10;i++)
		{
			if(inflag=="N")
			{
				var choice=$("#"+choice_array[i]);
				
				if(choice.css('display')=="none")
				{
					//alert(editer_array[i+2]);
					choice.css('display','block');
					$("#"+editer_array[i]).val('');
					inflag="Y";
				}
			}
		}	

						
	}
	
	

	function decrease_choice()
	{
		var ans_name = get_anser_name();
		var i=0;
			var j=0;
			var deflag="N";
			//clear choice
			for(i=9;i>=2;i--)//clear text
			{
				if(deflag=="N")
				{
					var choice=$("#"+choice_array[i]);
					if(choice.css('display')=="block")
					{
						$("#"+editer_array[i]).val('');
						choice.css('display','none');
						
						deflag="Y";
						var obj = document.getElementsByName(ans_name); // 获取对象	
						if (obj[i].checked==true)
						{
							obj[i].checked = false;	
						}
						break;
					}
				}
			}
	
	} 
	function decrease_choice_btn()
	{
		if($("#"+choice_array[2]).css('display')=="none")
		{
			alert('选项不能少于2个！');
		}
		else
		{
			decrease_choice();
		}
	}  
	
	function increase_choice_btn()
	{
		if($("#"+choice_array[9]).css('display')=="block")
		{
			alert('选项不能多于10个！');
		}
		else
		{
			increase_choice();
		}
	}   
	
	
	function check()
	{
		var ans_name = get_anser_name();
		if($("#question_content").val() == '')
		{
			alert('题目不能为空！');
			return false;
		}
		
		if(!($("#s_type").val()>=0))
		{
			alert('请选择题型！');
			return false;
		}
		if(!($("#s_cat1").val()>=1))
		{
			alert('请选择分类！');
			return false;
		}
		var choice_content_flag = "Y";


		for(i=0;i<10;i++)
		{
			var choice=$("#"+choice_array[i]);
		
			if((choice.css('display')!="none")&&($("#"+editer_array[i]).val()==''))
			{
				choice_content_flag="N";
			}
		}		
		if(choice_content_flag == 'N')
		{
			alert('不能有选项为空！');
			return false;
		}

		//check choice box
		if($("#s_type").val()==2)
		{
			var obj = document.getElementsByName(ans_name);
			var check_flag = 'N';
			for(i=0;i<10;i++)
			{
				if(obj[i].checked == true)
				{
					check_flag = 'Y';
				}
			}
			if(check_flag == 'N')
			{
				alert('请至少选择一项答案！');
				return false;
			}
		}
		else
		{
			var radio = $('input[name="ans_radio"]').filter(':checked');
			if(!(radio.length))
			{
				alert('请至少选择一项答案！');
				return false;
			}
		}
		
		return true;
	}
	
	function reset_form()
	{
		if(confirm("确定要还原吗？"))
		{
			$('#reset').click();	
		}
	}

</script>

<div class="container">
		
      	<div class="container-body">
        	<div class="page-header">
	    		<h3>修改试题</h3>
	    	</div>
	    	
			<form class="form-inline" onsubmit="return check()" action="<?php echo base_url()?>index.php/question/update/<?php echo $question['question_id']?>" method="POST">
			
				<div class="control-group">
			    	<div class="controls">
			    		题型选择&nbsp;&nbsp;&nbsp;
						<select id="s_type" onchange="type_callback()" name="ques_type"  class="span2">
							<option value="1">单选题</option>
							<option value="2">多选题</option>
						</select>
						
						<div class="vspace"></div>
						
			    		试题分类&nbsp;&nbsp;&nbsp;
						<select id="s_cat1"  name="ques_cat" class="span2">
							<?php 
								foreach ($cats as $row_one)
								{
							?>
									<option value="<?php echo $row_one['category_id'];?>">
									<?php echo $row_one['category_name'];?></option>			 
							 <?php 
						   		}
						   	?>
						</select>
			    		难度
			    		<select id="s_cat2"  name="ques_difficulty" class="span2">
							<?php 
								foreach ($difs as $row_one)
								{
							?>
									<option value="<?php echo $row_one['difficulty_id'];?>">
									<?php echo $row_one['difficulty_name'];?></option>			 
							 <?php 
						   		}
						   	?>
						</select>
						SOP
						<select id="s_cat3"  name="ques_sop" class="span2">
							<?php 
								foreach ($sops as $row_one)
								{
							?>
									<option value="<?php echo $row_one['sop_id'];?>">
									<?php echo $row_one['sop_name'];?></option>			 
							 <?php 
						   		}
						   	?>
						</select>
			    	</div>
			    </div>
			
    
			   <div class="control-group">
			    	<label class="control-label">试题内容：</label>
			    	<div class="controls">
			    		<textarea id="question_content" name="question_content" rows="10" class="span5"> <?php echo $question['question'];?></textarea>
			    	</div>
			    </div>
			    <!-- A -->
			    <div id="div_choice_a" class="control-group span4">
			    	<label class="control-label">
			    		选项A：
			    		<span class="label label-success">
			    			<input id="chk_radio_a" name="ans_radio" type="radio" value="A">
							<input id="chk_box_a" name="ans_check[]" type="checkbox" value="A">
							正确答案
			    		</span>
			    	</label>
			    	<div class="controls">
			    		<textarea id="choice_content_a" name="choice_content_a" rows="5" class="span3"><?php if(count($choice) && count($choice)>=1){echo $choice[0]['content'];}?></textarea>
			    	</div>
			    </div>
			    <!-- B -->
			    <div id="div_choice_b" class="control-group span4">
			    	<label class="control-label">
			    		选项B：
			    		<span class="label label-success">
			    			<input id="chk_radio_b" name="ans_radio" type="radio" value="B">
							<input id="chk_box_b" name="ans_check[]" type="checkbox" value="B">
							正确答案
			    		</span>
					</label>
			    	<div class="controls">
			    		<textarea id="choice_content_b" name="choice_content_b" rows="5" class="span3"><?php if(count($choice) && count($choice)>=2){echo $choice[1]['content'];}?></textarea>
			    	</div>
			    </div>
			    <!-- C -->
			    <div id="div_choice_c" class="control-group span4" style="display:none;">
			    	<label class="control-label">
			    		选项C：
			    		<span class="label label-success">
			    			<input id="chk_radio_c" name="ans_radio" type="radio" value="C">
							<input id="chk_box_c" name="ans_check[]" type="checkbox" value="C">
							正确答案
			    		</span>
					</label>
			    	<div class="controls">
			    		<textarea id="choice_content_c" name="choice_content_c" rows="5" class="span3"><?php if(count($choice) && count($choice)>=3){echo $choice[2]['content'];}?></textarea>
			    	</div>
			    </div>	
			    <!-- D -->
			    <div id="div_choice_d" class="control-group span4" style="display:none;">
			    	<label class="control-label">
			    		选项D：
			    		<span class="label label-success">
			    			<input id="chk_radio_d" name="ans_radio" type="radio" value="D">
							<input id="chk_box_d" name="ans_check[]" type="checkbox" value="D">
							正确答案
			    		</span>
					</label>
			    	<div class="controls">
			    		<textarea id="choice_content_d" name="choice_content_d" rows="5" class="span3"><?php if(count($choice) && count($choice)>=4){echo $choice[3]['content'];}?></textarea>
			    	</div>
			    </div>			    
			    <!-- E -->
				<div id="div_choice_e" class="control-group span4" style="display:none;">
			    	<label class="control-label">
			    		选项E：
			    		<span class="label label-success">
			    			<input id="chk_radio_e" name="ans_radio" type="radio" value="E">
							<input id="chk_box_e" name="ans_check[]" type="checkbox" value="E">
							正确答案
			    		</span>
					</label>
			    	<div class="controls">
			    		<textarea id="choice_content_e" name="choice_content_e" rows="5" class="span3"><?php if(count($choice) && count($choice)>=5){echo $choice[4]['content'];}?></textarea>
			    	</div>
			    </div>
				<!-- F -->
				<div id="div_choice_f" class="control-group span4" style="display:none;">
			    	<label class="control-label">
			    		选项F：
			    		<span class="label label-success">
			    			<input id="chk_radio_f" name="ans_radio" type="radio" value="F">
							<input id="chk_box_f" name="ans_check[]" type="checkbox" value="F">
							正确答案
			    		</span>
					</label>
			    	<div class="controls">
			    		<textarea id="choice_content_f" name="choice_content_f" rows="5" class="span3"><?php if(count($choice) && count($choice)>=6){echo $choice[5]['content'];}?></textarea>
			    	</div>
			    </div>
				<!-- G -->
				<div id="div_choice_g" class="control-group span4" style="display:none;">
			    	<label class="control-label">
			    		选项G：
			    		<span class="label label-success">
			    			<input id="chk_radio_g" name="ans_radio" type="radio" value="G">
							<input id="chk_box_g" name="ans_check[]" type="checkbox" value="G">
							正确答案
			    		</span>
					</label>
			    	<div class="controls">
			    		<textarea id="choice_content_g" name="choice_content_g" rows="5" class="span3"><?php if(count($choice) && count($choice)>=7){echo $choice[6]['content'];}?></textarea>
			    	</div>
			    </div>
				<!-- H -->
				<div id="div_choice_h" class="control-group span4" style="display:none;">
			    	<label class="control-label">
			    		选项H：
			    		<span class="label label-success">
			    			<input id="chk_radio_h" name="ans_radio" type="radio" value="H">
							<input id="chk_box_h" name="ans_check[]" type="checkbox" value="H">
							正确答案
			    		</span>
					</label>
			    	<div class="controls">
			    		<textarea id="choice_content_h" name="choice_content_h" rows="5" class="span3"><?php if(count($choice) && count($choice)>=8){echo $choice[7]['content'];}?></textarea>
			    	</div>
			    </div>
				<!-- I -->
				<div id="div_choice_i" class="control-group span4" style="display:none;">
			    	<label class="control-label">
			    		选项I：
			    		<span class="label label-success">
			    			<input id="chk_radio_i" name="ans_radio" type="radio" value="I">
							<input id="chk_box_i" name="ans_check[]" type="checkbox" value="I">
							正确答案
			    		</span>
					</label>
			    	<div class="controls">
			    		<textarea id="choice_content_i" name="choice_content_i" rows="5" class="span3"><?php if(count($choice) && count($choice)>=9){echo $choice[8]['content'];}?></textarea>
			    	</div>
			    </div>
				<!-- J -->
				<div id="div_choice_j" class="control-group span4" style="display:none;">
			    	<label class="control-label">
			    		选项J：
			    		<span class="label label-success">
			    			<input id="chk_radio_j" name="ans_radio" type="radio" value="J">
							<input id="chk_box_j" name="ans_check[]" type="checkbox" value="J">
							正确答案
			    		</span>
					</label>
			    	<div class="controls">
			    		<textarea id="choice_content_j" name="choice_content_j" rows="5" class="span3"><?php if(count($choice) && count($choice)>=10){echo $choice[9]['content'];}?></textarea>
			    	</div>
			    </div>
			    
			    <div id="answer_result" class="control-group" style="display:none;">
			    	<label class="control-label">参考答案：</label>
			    	<div id="QA" class="controls" style="display:none;">
			    		<textarea id="question_answer" name="question_answer" rows="10" class="span5"></textarea>
			    	</div>
			    	<div id="blank_btn" class="controls" style="display:none;">
			    			<button class="btn" onclick="increase_blank_btn()" type="button">+添加答案</button>
					<span id="decrease_blank_btn" hidden="true">
						<button class="btn" onclick="decrease_blank_btn()" type="button">-删除答案</button>
					</span> <span style="color:#FF0000;">*请根据试题内容中留空的数量添加删除答案，删除时从最后开始删除</span>
					</div>
					<br>
			    	<div id="blank" class="controls"></div>
			    </div>
				
				<div class="vspace"></div>
				<div class="cleanup"></div>
			    <div id="choice_num_change" class="control-group" style="display:none;">
			    	<div class="controls">
			    		    <div class="btn-group">
							    <button class="btn" onclick="increase_choice_btn()" type="button">+添加选项</button>
							    <button class="btn" onclick="decrease_choice_btn()" type="button">-减少选项</button>							    
						    </div>		   
			    		
			    	</div>
			    </div>
			    
			    <div class="control-group">
			    	<div class="controls">			    		   	   
			    		<button type="submit" class="btn btn-info">完成</button>
						<button type="button" onclick="reset_form()" class="btn btn-info">重置</button>
						<button id="reset" type="reset" style="display:none;" class="btn btn-info">reset</button>
						<button type="button" onclick="javascript:history.go(-1)" class="btn btn-success">返回</button>
					
			    	</div>
			    </div>
			</form>
		</div>
      		
      		<div class="footer">
        		
      		</div>
    	</div> <!-- /container -->