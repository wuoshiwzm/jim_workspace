<div class="tab-pane active" id='tab-data'>
	<div class="tab-widget tabbable tabs-left chat-widget" >	
		<ul class="nav nav-tabs" style='width:200px'>
	    <?php if($model == 'sps' || ($model == 'camera' && $groupList)){ $i = 1;?>
	    <?php $index = 0 ; foreach ($groupList as $groupObj){ 
	    	if($model == 'sps'){$group = $groupObj->dev_group;}
	    	else{$group = "视频监控";$dataid = $groupObj->data_id;}
	    	?>    	
    		<li  class="grouplist"  dev_group="<?php echo 'group'.$i;?>"><a
									href="##"  group='<?php echo $group;?>'  class='group'><?php echo $group;?>  </a>
				 <ul class="spslist"  id='ul-<?php echo 'group'.$i; $i++?>' style="list-style-type:none;">
					<?php if($model == 'sps'){ foreach ($dataList as $dataObj){
							if($group == $dataObj->dev_group){ ?>
												<li ><a href="#device-<?php echo $dataObj->data_id;?>" class="group"> <?php echo $dataObj->name;?> </a>
												</li>
												<?php }?>
							                <?php }?>
				    <?php }?>
					<?php if($model == 'camera'){ foreach ($dataList as $dataObj){
							if($dataid == $dataObj->dev_group){ ?>
												<li ><a href="#device-<?php echo $dataObj->data_id;?>" class="group"> <?php echo $dataObj->name;?> </a>
												</li>
												<?php }?>
							                <?php }?>
				    <?php }?>
	           </ul>
			</li>
			<?php } ?>
	    <?php }else{ ?>
    	<?php $index = 0 ; foreach ($dataList as $dataObj){?>
    		<li <?php if($index++ == 0 && empty($active_data_id) ){?> class="active"
				<?php }?>>
				<?php if($model == 'smd_device'){?>
					<a href="#device-<?php echo $dataObj->device_no;?>" class="group"> <?php echo $dataObj->name;?> </a>
				<?php }else if($model == 'battery_32'){?>
				    
				    <?php if(is_int($dataObj->extra_para)){?> 
				       <a href="#device-<?php echo $dataObj->data_id;?>" class="group"> <?php echo $dataObj->dev_group;?> </a>
				    <?php }else{?>
				       <a href="#device-<?php echo $dataObj->data_id;?>" class="group"> <?php echo $dataObj->name;?> </a>
				   <?php }?>
				<?php }else{?>
					<a href="#device-<?php echo $dataObj->data_id;?>" class="group"> <?php echo $dataObj->name;?> </a>
				<?php }?>
			</li>		              
    	<?php }?>
	   <?php } ?>
	   </ul>
		<div class="tab-content" style='height: 800px;'>
    		 <?php $index = 0;foreach ($dataList as $dataObj){?>
    		 <?php if($model == 'smd_device'){?>
    		 	<div id='device-<?php echo $dataObj->device_no;?>'  data_id='<?php echo $dataObj->device_no;?>'
				   class="tab-pane rt-data <?php if($index++ == 0 && empty($active_data_id) ){?>active<?php }?>" data_type="<?php echo $dataObj->model; ?>">
			<div class="tab-widget">
				<ul class="nav nav-tabs">
                	  <li><a class="devDate" data='<?php echo $dataObj->device_no;?>'><i class="icon-tasks"></i>设备数据</a></li>
                	  <li><a class="standard"  data='<?php echo $dataObj->device_no;?>'><i class="icon-tasks"></i>标准化数据</a></li>
				</ul>
			</div>
				   <h3><?php echo $dataObj->name;?></h3> 
				   <h4><?php echo '设备IP：'.$dataObj->ip;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo '设备标号：'.$dataObj->device_no?></h4>
				   <div id="standard-<?php echo $dataObj->device_no;?>" style="display: none;"><?php echo $dataObj->html1;?></div>
				   <div id="devDate-<?php echo $dataObj->device_no;?>"> <?php echo $dataObj->html;?></div>  
                </div>
           <?php }else{?>	 
             <div <?php if(is_int($dataObj->extra_para)){?>id='device-<?php echo $dataObj->data_id;?>' 
               data_id='<?php for($i=1;$i<=count($dataObj->data_id);$i++){
                     	echo $dataObj->data_id[$i].",";}?>' <?php }else{?>id='device-<?php echo $dataObj->data_id;?>' data_id='<?php echo $dataObj->data_id;?>'<?php }?>
				class="tab-pane rt-data <?php if($index++ == 0 && empty($active_data_id) || $active_data_id == $dataObj->data_id){?>active<?php }?>" <?php if ($dataObj->model == 'battery_24'){?> data_type='bat24'
			 <?php }else if($dataObj->model == "battery_32"){?>data_type='bat32' <?php }else{ ?>data_type="<?php echo $dataObj->model; ?>" <?php } ?> >
			 <div class="tab-widget">
				<ul class="nav nav-tabs">
                	  <li><a class="devDate" data='<?php echo $dataObj->data_id;?>'><i class="icon-tasks"></i>设备数据</a></li>
                	  <li><a class="standard"  data='<?php echo $dataObj->data_id;?>'><i class="icon-tasks"></i>标准化数据</a></li>
				</ul>
			</div>
			      <?php if(is_int($dataObj->extra_para)){?> 
			         <h3><?php echo $dataObj->dev_group; ?></h3>
			      <?php }else{?>
				     <h3><?php echo $dataObj->name; ?></h3>
				  <?php }?>
				 <div id="standard-<?php echo $dataObj->data_id;?>" style="display: none;"><?php echo $dataObj->html1;?></div>
				 <div id="devDate-<?php echo $dataObj->data_id;?>"> <?php echo $dataObj->html;?></div>  
             </div>
               <?php }?>
           <?php }?>
    	   </div>
      </div>
</div>
<script type="text/javascript">
	$(function(){
		$('.grouplist').click(function(){
			var thisgroup = $(this).attr('dev_group');
			$('.spslist').hide();
			$('#ul-'+ thisgroup +'').show();
		});
        $('#tab-data a.group').click(function (e) {
            e.preventDefault();
            $(".realtime-video").remove();
            $(this).tab('show');
        });   
    });
	$(".standard").click(function(){
		var data = $(this).attr('data');
	    $("#standard-"+data).show();
	    $("#devDate-"+data).hide();
	});
	$(".devDate").click(function(){
		var data = $(this).attr('data');
	    $("#devDate-"+data).show();
	    $("#standard-"+data).hide();
	});	
</script>