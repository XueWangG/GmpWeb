<div class="container">
     
      	<div class="container-body">
		
		
	    		
	    	
		    <div class="cleanup"></div>
		    
         	<div class="page-header">
	    		<h4><?php echo $question['type_name'];?></h4>
				<ul id="cat_preview" class="breadcrumb">
				<?php 
				if($question['category_name'] != '')
				{
				?>
					<li id="show_cat1" class="active"><?php echo $question['category_name'];?><span class="divider">/</span></li>
				<?php	
				} 
				if($question['difficulty_name'] != '')
				{
				?>
					<li id="show_cat1" class="active"><?php echo $question['difficulty_name'];?><span class="divider">/</span></li>
				<?php	
				}
				if($question['sop_name'] != '')
				{
				?>
					<li id="show_cat1" class="active"><?php echo $question['sop_name'];?></li>
				<?php	
				}
				?>
				
			    </ul>
	    	</div>
         	
		        <div class="row">
			    	<div class="span12">		    	
				    	<div class="row">
				    		<div class="span1">
				    			<span class="label label-info">				    				
				    				<i class="icon-white"></i>NO.<?php echo $question['question_id'];?>
				    			</span>
				    		</div>
				    		<div class="span8">
				    			<?php echo nl2br($question['question']);?>
				    		</div>				    				    		
				    	</div>
				    	
				    	<div class="vspace"></div>
						<?php
						$i = 0;
						foreach($choice as $row)
						{
							if(($i%2)==0 )
							{
							?>
								<div class="vspace"></div>
								<div class="row">
					    			<div class="span1"></div>
									<div class="span1">
					    			<span class="badge badge-success">				    			
					    				<?php echo $row['option_name']; ?>
					    			</span>
						    		</div>
						    		<div class="span3">
						    			<?php echo $row['content']; ?>
						    		</div>
								
							<?php
							}
							else
							{
							?>
									<div class="span1">
					    			<span class="badge badge-success">				    			
					    				<?php echo $row['option_name']; ?>
						    		</span>
						    		</div>
						    		<div class="span3">
						    			<?php echo $row['content']; ?>
						    		</div>
								</div>
							<?php	
							}
							$i++;
						}
						if(($i%2)==1)
						{
							?>
								</div>
							<?php
						}
						?>
						
			   
			    	</div>
					 </div>
			    <div class="vspace"></div>
				<div class="vspace"></div>
				<div class="vspace"></div>
				<div class="vspace"></div>
				
				<table class="table table-bordered table-striped">
						      <thead>
						        <tr>			        	
							          	<th>
												<span class="badge badge-success" style="white-space:normal">
											 	<?php
											 	echo $question['answer'];
											 	?>
											 	</span></th></tr>		
						      </thead>
				</table>
				<div class="vspace"></div>
			    <div class="hright">
	    			<div class="control-group">
				    	<button type="button" onclick="javascript:history.go(-1)" class="btn btn-success">返回</button>
					
			    	</div>	    			
	    		</div>
				<div class="vspace"></div>
			
		
			</div><!-- /container -->