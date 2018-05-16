<script type="text/javascript">
$(function () {

	$list = $('#filelist');
	// 优化retina, 在retina下这个值是2
	var ratio = window.devicePixelRatio || 1;
	// 缩略图大小
	var thumbnailWidth = 90 * ratio;
	var thumbnailHeight = 90 * ratio;
	var uploader = WebUploader.create({

	    // swf文件路径
	    swf: '<?php echo base_url()?>js/webuploader/Uploader.swf',

	    // 文件接收服务端。
	    server: '<?php echo base_url()?>index.php/testpaper/upload_cover',

	    // 选择文件的按钮。可选。
	    // 内部根据当前运行是创建，可能是input元素，也可能是flash.
	    pick: '#picker',
	    accept: {
	        title: 'Images',
	        extensions: 'gif,jpg,jpeg,bmp,png',
	        mimeTypes: 'image/*'
	    },

	    // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
	    resize: false,
	    fileNumLimit: 1,
	    fileSingleSizeLimit:1024000
	});
	// 当有文件添加进来的时候
	uploader.on('fileQueued', function (file) {
	    var $li = $(
	            '<div id="' + file.id + '" class="file-item thumbnail">' +
	                '<img>' +
	                '<div class="info"><span>' + file.name + '</span><span class="del-item" style="color:red;float:right;display:none;">&times;</span></div>' +
	            '</div>'
	            ),
	        $img = $li.find('img');


	    // $list为容器jQuery实例
	    $list.append($li);

	    // 创建缩略图
	    // 如果为非图片文件，可以不用调用此方法。
	    // thumbnailWidth x thumbnailHeight 为 100 x 100
	    uploader.makeThumb(file, function (error, src) {
	        if (error) {
	            $img.replaceWith('<span>不能预览</span>');
	            return;
	        }

	        $img.attr('src', src);
	    }, thumbnailWidth, thumbnailHeight);
	});

	// 文件上传过程中创建进度条实时显示。
	uploader.on('uploadProgress', function (file, percentage) {
	    var $li = $('#' + file.id),
	        $percent = $li.find('.progress span');

	    // 避免重复创建
	    if (!$percent.length) {
	        $percent = $('<p class="progress"><span></span></p>')
	                .appendTo($li)
	                .find('span');
	    }

	    $percent.css('width', percentage * 100 + '%');
	});
	// 文件上传成功，给item添加成功class, 用样式标记上传成功。
	uploader.on('uploadSuccess', function (file,response) {
	    $('#' + file.id).addClass('upload-state-done');
	    $('#cover_url').val(response.image_name);

	});

	// 文件上传失败，显示上传出错。
	uploader.on('uploadError', function (file) {
	    var $li = $('#' + file.id),
	        $error = $li.find('div.error');

	    // 避免重复创建
	    if (!$error.length) {
	        $error = $('<div class="error"></div>').appendTo($li);
	    }

	    $error.text('上传失败');
	});

	// 完成上传完了，成功或者失败，先删除进度条。
	uploader.on('uploadComplete', function (file) {
	    $('#' + file.id).find('.progress').remove();
	});

	$('#upload-button').click(function () {
	  
	    uploader.upload();
	});
	//显示删除按钮
	$list.on('mouseover', '.file-item', function () {
	    $(this).find('.del-item').css('display', 'block');
	});
	//隐藏删除按钮
	$list.on('mouseout', '.file-item', function () {
	    $(this).find('.del-item').css('display', 'none');
	});
	//执行删除方法
	$list.on('click', '.del-item', function () {
	    var Id = $(this).parent().parent().attr("id");
	    uploader.removeFile(uploader.getFile(Id, true));
	    $(this).parent().parent().remove();
	});
	
});

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
						} ?>试卷</h3>
    	</div>
		
    	<?php echo validation_errors('<div class="alert alert-error">', '</div>'); ?>
		
		<form class="form-horizontal"  action="<?php echo base_url()?>index.php/testpaper/<?php if($this->session->userdata('SESSION_NAME_PAPER_CREATE')==2){	echo 'copy'.$fromTestpaperId;} else if($this->session->userdata('SESSION_NAME_PAPER_CREATE')==1) { echo 'create';} else {echo 'update';}?>_step1" method="POST">
			
	 	
		   <div class="control-group">
		    	<label class="control-label">试卷名称：</label>
		    	<div class="controls">
		    		<input type="text" name="papername"  value="<?php echo $paperName?>"  maxlength="20" placeholder="试卷名称(最多20字)" style ="width: 300px;">
		    	</div>
		    </div>
		    <div class="control-group">
		    	<label class="control-label">试卷封面图片：</label>
		    	<div class="controls">
		    		<?php if($this->session->userdata('SESSION_NAME_PAPER_CREATE')!=1 && !empty($cover_url)) {?>
		    		<div id="oldImage">
                         <img style="max-height:150px;" src="<?php echo base_url()?>/<?php echo $cover_url?>" />
                    </div>
                    <?php }?>
		    		<input type="hidden" name="cover_url" id="cover_url" value="<?php echo $cover_url?>"/>
		    		<div id="uploader" class="uploader">
                            <div id="filelist" class="uploader-list"></div>
                            <div class="btns">
                                <div id="picker">选择文件</div>
                                <a id="upload-button" class="btn btn-default">开始上传</a>
                            </div>
                    </div>
		    	</div>
		    </div>
			<div class="control-group">
				<label class="control-label">选择试卷类型：</label>
				<div class="controls">

	                 <select id="papertype" name="papertype"  <?php if($this->session->userdata('SESSION_NAME_PAPER_CREATE')==0 || $this->session->userdata('SESSION_NAME_PAPER_CREATE')== 2){ ?>onfocus="this.defaultIndex=this.selectedIndex;" onchange="this.selectedIndex=this.defaultIndex;"<?php } ?>>
						<option value="1" <?php if($paperType == 1){?> selected="selected"<?php ;}?>>手动添加</option>
						<option value="2" <?php if($paperType == 2){?> selected="selected"<?php ;}?>>随机抽题</option>
					</select>					
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">难易程度：</label>
				<div class="controls">

	                 <select id="difficulty" name="difficulty">
						<?php 
							foreach ($difs as $row)
							{
						?>
								<option value="<?php echo $row['difficulty_id'];?>" <?php if($difficulty == $row['difficulty_id']){?> selected="selected"<?php ;}?>>
								<?php echo $row['difficulty_name'];?></option>			 
						 <?php 
					   		}
					   	?>
					</select>				
				</div>
			</div>
			

			<?php foreach($typeList as $key => $type) { ?>
		    <div class="control-group">
		    	<label class="control-label"><?php echo $type?>分值：</label>
		    	<div class="controls">
		    		<input type="text" class="span1" name="point_<?php echo $key ?>" value="<?php echo $pointList[$key] ?>"  maxlength="5" placeholder="<?php echo $type?>分值">
		    		<?php 
		    			if($key == 3)
		    			{
		    				?>
		    				<span style="color:#FF0000;">*填空题分值为每空分值</span>
		    				<?php 
		    			}
		    		?>
		    	</div>
		    </div>
		    <?php } ?>
		    
		   <div class="control-group">
		    	<label class="control-label">通过分数线：</label>
		    	<div class="controls">
		    		<input type="text" class="span1" name="cutoff"  value="<?php echo $cutoff?>"  maxlength="5">
		    	</div>
		    </div>
		    
		    <div class="control-group">
		    	<label class="control-label">试卷标签：</label>
		    	<div class="controls">
		    		<input type="text" name="tag_name"  value="<?php echo $tag_name?>"  maxlength="20" placeholder="最多5个, 半角逗号分隔" style ="width: 300px;">
		    	</div>
		    </div>
		    
				<div class="control-group">
					<label class="control-label">试卷介绍：</label>
					<div class="controls">
						<textarea id="description" name="description" rows="5" class="span3"><?php echo $description; ?></textarea>
					</div>
				</div>

		    <div class="control-group">
		    	<div class="controls">			   
		    		<button type="submit" class="btn btn-info">完成并前往下一步</button>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<button type="button" class="btn btn-info" onclick="window.location.href = '<?php echo base_url() ?>index.php/testpaper/index'">返回</button>
		    	</div>
		    </div>
		</form>
	</div>

</div> <!-- /container -->