<div id="page-wrapper">
<?php 
	echo $this->Session->flash();
?>
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Generate Reports </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-file-text fa-icon"></i> Generate Reports
                            </li>
                        </ol>
                    </div>
                </div>
                
                <div class="row">
                	<div class="col-md-12">
                		<div class="col-md-4">
                			<h2 class="text-center">Sticker Report</h2>
                			<?php echo $this->Form->create('Stickers',array('action'=>'stickerexport','class'=>'form-horizontal'));?>
                				<div class="form-group">
	                				<label class="col-md-3">Type: </label>
									<div class="col-md-9">
										<?php $option=array('1'=>'Full Report','2'=>'Created','3'=>'Modified');?>
										<?php echo $this->Form->input('type',array('options'=>$option,'id'=>'type','class'=>'form-control','label'=>false,'div'=>false,'required'));?>
									</div>
	                			</div>
	                			<div id="dp1" class="form-group">
	                				<label class="col-md-3">From:</label>
	                				<div class="col-md-9">
	                					<?php echo $this->Form->input('from',array('id'=>'datepicker-example1','class'=>'form-control','div'=>false,'label'=>false)); ?>
	                				</div>
	                			</div>
	                			<div id="dp2" class="form-group">
	                				<label class="col-md-3">To:</label>
	                				<div class="col-md-9">
	                					<?php echo $this->Form->input('to',array('id'=>'datepicker-example2','class'=>'form-control','div'=>false,'label'=>false)); ?>
									</div>
								</div>
								<div class="form-group">
	                				<label class="col-md-3">Sort By: </label>
									<div class="col-md-9">
										<?php $option=array('1'=>'Name','2'=>'Category','3'=>'Type','4'=>'Status','5'=>'Times Used','6'=>'Created','7'=>'Modified');?>
										<?php echo $this->Form->input('sort',array('options'=>$option,'id'=>'category','class'=>'form-control','label'=>false,'div'=>false,'required'));?>
									</div>
                				</div>
                				<div class="form-group">
	                				<label class="col-md-3">Order: </label>
									<div class="col-md-9">
										<?php $option=array('1'=>'Ascending','2'=>'Descending');?>
										<?php echo $this->Form->input('sorttype',array('options'=>$option,'id'=>'category','class'=>'form-control','label'=>false,'div'=>false,'required'));?>
									</div>
	                			</div>
	                			<div class="form-group">
	                				<label class="col-md-3">Status: </label>
									<div class="col-md-9">
										<?php $option=array('1'=>'Active','2'=>'Deactive','3'=>'All');?>
										<?php echo $this->Form->input('status',array('options'=>$option,'id'=>'category','class'=>'form-control','label'=>false,'div'=>false,'required'));?>
									</div>
	                			</div>
	                			<div class="form-group">
	                				<label class="col-md-3"></label>
	                				<div class="col-md-9">
	                					<input type="submit" class="btn btn-primary" value="Generate Sticker Report" />
                					</div>
                				</div>
                			<?php echo $this->Form->end();?>
                		</div>
                		<div class="col-md-4 col-md-offset-3">
                			<h2 class="text-center">Category Report</h2>
                			<?php echo $this->Form->create('Categories',array('action'=>'categoryexport','class'=>'form-horizontal'));?>
                				<div class="form-group">
	                				<label class="col-md-3">Type: </label>
									<div class="col-md-9">
										<?php $option=array('1'=>'Full Report','2'=>'Created','3'=>'Modified');?>
										<?php echo $this->Form->input('type',array('options'=>$option,'id'=>'ctype','class'=>'form-control','label'=>false,'div'=>false,'required'));?>
									</div>
	                			</div>
	                			<div id="dp3" class="form-group">
	                				<label class="col-md-3">From:</label>
	                				<div class="col-md-9">
	                					<?php echo $this->Form->input('from',array('id'=>'datepicker-example3','class'=>'form-control','div'=>false,'label'=>false)); ?>
	                				</div>
	                			</div>
	                			<div id="dp4" class="form-group">
	                				<label class="col-md-3">To:</label>
	                				<div class="col-md-9">
	                					<?php echo $this->Form->input('to',array('id'=>'datepicker-example4','class'=>'form-control','div'=>false,'label'=>false)); ?>
									</div>
								</div>
								<div class="form-group">
	                				<label class="col-md-3">Sort By: </label>
									<div class="col-md-9">
										<?php $option=array('1'=>'Name','4'=>'Status','5'=>'Total Stickers','6'=>'Created','7'=>'Modified');?>
										<?php echo $this->Form->input('sort',array('options'=>$option,'id'=>'category','class'=>'form-control','label'=>false,'div'=>false,'required'));?>
									</div>
                				</div>
                				<div class="form-group">
	                				<label class="col-md-3">Order: </label>
									<div class="col-md-9">
										<?php $option=array('1'=>'Ascending','2'=>'Descending');?>
										<?php echo $this->Form->input('sorttype',array('options'=>$option,'id'=>'category','class'=>'form-control','label'=>false,'div'=>false,'required'));?>
									</div>
	                			</div>
	                			<div class="form-group">
	                				<label class="col-md-3">Status: </label>
									<div class="col-md-9">
										<?php $option=array('1'=>'Active','2'=>'Deactive','3'=>'All');?>
										<?php echo $this->Form->input('status',array('options'=>$option,'id'=>'category','class'=>'form-control','label'=>false,'div'=>false,'required'));?>
									</div>
	                			</div>
	                			<div class="form-group">
	                				<label class="col-md-3"></label>
	                				<div class="col-md-9">
	                					<input type="submit" class="btn btn-primary" value="Generate Category Report" />
                					</div>
                				</div>
                			<?php echo $this->Form->end();?>
                		</div>
                	</div>
                </div>
                <br/>
				<div class="row">
                	<div class="col-md-12">
                		<div class="col-md-4">
                			<h2 class="text-center">Purchased Stickers Report</h2>
                			<?php echo $this->Form->create('Stickers',array('action'=>'purchasedexport','class'=>'form-horizontal'));?>
                				<div class="form-group">
	                				<label class="col-md-3">Type: </label>
									<div class="col-md-9">
										<?php $option=array('1'=>'Full Report','2'=>'By Date');?>
										<?php echo $this->Form->input('type',array('options'=>$option,'id'=>'ptype','class'=>'form-control','label'=>false,'div'=>false,'required'));?>
									</div>
	                			</div>
	                			<div id="dp7" class="form-group">
	                				<label class="col-md-3">From:</label>
	                				<div class="col-md-9">
	                					<?php echo $this->Form->input('from',array('id'=>'datepicker-example7','class'=>'form-control','div'=>false,'label'=>false)); ?>
	                				</div>
	                			</div>
	                			<div id="dp8" class="form-group">
	                				<label class="col-md-3">To:</label>
	                				<div class="col-md-9">
	                					<?php echo $this->Form->input('to',array('id'=>'datepicker-example8','class'=>'form-control','div'=>false,'label'=>false)); ?>
									</div>
								</div>
								<div class="form-group">
	                				<label class="col-md-3">Sort By: </label>
									<div class="col-md-9">
										<?php $option=array('1'=>'Name','2'=>'Category','5'=>'Times Purchased');?>
										<?php echo $this->Form->input('sort',array('options'=>$option,'id'=>'category','class'=>'form-control','label'=>false,'div'=>false,'required'));?>
									</div>
                				</div>
                				<div class="form-group">
	                				<label class="col-md-3">Order: </label>
									<div class="col-md-9">
										<?php $option=array('1'=>'Ascending','2'=>'Descending');?>
										<?php echo $this->Form->input('sorttype',array('options'=>$option,'id'=>'category','class'=>'form-control','label'=>false,'div'=>false,'required'));?>
									</div>
	                			</div>
	               				<div class="form-group">
	                				<label class="col-md-3">Report for: </label>
									<div class="col-md-9">
										<?php $option=array('1'=>'Purchased Only','2'=>'Given Free by Admin','3'=>'All');?>
										<?php echo $this->Form->input('reporttype',array('options'=>$option,'id'=>'category','class'=>'form-control','label'=>false,'div'=>false,'required'));?>
									</div>
	                			</div>
	                			<div class="form-group">
	                				<label class="col-md-3"></label>
	                				<div class="col-md-9">
	                					<input type="submit" class="btn btn-primary" value="Generate Purchased Stickers Report" />
                					</div>
                				</div>
                			<?php echo $this->Form->end();?>
                		</div>
                		<div class="col-md-4 col-md-offset-3">
                			<h2 class="text-center">Appusers Report</h2>
                			<?php echo $this->Form->create('Appusers',array('action'=>'appuserexport','class'=>'form-horizontal'));?>
                				<div class="form-group">
	                				<label class="col-md-3">Type: </label>
									<div class="col-md-9">
										<?php $option=array('1'=>'Full Report','2'=>'Date Added','3'=>'email');?>
										<?php echo $this->Form->input('type',array('options'=>$option,'id'=>'atype','class'=>'form-control','label'=>false,'div'=>false,'required'));?>
									</div>
	                			</div>
	                			<div id="name" class="form-group">
	                				<label class="col-md-3">Email: </label>
									<div class="col-md-9">
										<?php echo $this->Form->input('email',array('type'=>'email','class'=>'form-control','label'=>false,'div'=>false,'placeholder'=>'email'));?>
									</div>
	                			</div>
	                			<div id="stickers" class="form-group">
	                				<label class="col-md-3">Include: </label>
									<div class="col-md-9">
										<?php $option=array('1'=>'Purchased Stickers','2'=>'Devices','3'=>'Used Stickers','4'=>'All');?>
										<?php echo $this->Form->input('include',array('options'=>$option,'id'=>'category','class'=>'form-control','label'=>false,'div'=>false,'required'));?>
									</div>
                				</div>
	                			<div id="dp5" class="form-group">
	                				<label class="col-md-3">From:</label>
	                				<div class="col-md-9">
	                					<?php echo $this->Form->input('from',array('id'=>'datepicker-example5','class'=>'form-control','div'=>false,'label'=>false)); ?>
	                				</div>
	                			</div>
	                			<div id="dp6" class="form-group">
	                				<label class="col-md-3">To:</label>
	                				<div class="col-md-9">
	                					<?php echo $this->Form->input('to',array('id'=>'datepicker-example6','class'=>'form-control','div'=>false,'label'=>false)); ?>
									</div>
								</div>
								<div id="sort" class="form-group">
	                				<label class="col-md-3">Sort By: </label>
									<div class="col-md-9">
										<?php $option=array('1'=>'Email','2'=>'Zip','3'=>'City','4'=>'Country','5'=>'Date Added',);?>
										<?php echo $this->Form->input('sort',array('options'=>$option,'id'=>'category','class'=>'form-control','label'=>false,'div'=>false,'required'));?>
									</div>
                				</div>
                				<div id="order" class="form-group">
	                				<label class="col-md-3">Order: </label>
									<div class="col-md-9">
										<?php $option=array('1'=>'Ascending','2'=>'Descending');?>
										<?php echo $this->Form->input('sorttype',array('options'=>$option,'id'=>'category','class'=>'form-control','label'=>false,'div'=>false,'required'));?>
									</div>
	                			</div>
	                			<div id="status" class="form-group">
	                				<label class="col-md-3">Status: </label>
									<div class="col-md-9">
										<?php $option=array('1'=>'Active','2'=>'Deactive','3'=>'All');?>
										<?php echo $this->Form->input('status',array('options'=>$option,'id'=>'category','class'=>'form-control','label'=>false,'div'=>false,'required'));?>
									</div>
	                			</div>
	                			<div class="form-group">
	                				<label class="col-md-3"></label>
	                				<div class="col-md-9">
	                					<input type="submit" class="btn btn-primary" value="Generate Appuser Report" />
                					</div>
                				</div>
                			<?php echo $this->Form->end();?>
                		</div>                		                		
                	</div>
                </div>
                
                
                
           <!-- <div class="row text-center">
          		<div class="col-sm-12">
			<ul class="list-inline">
				<li>
					<?php
					  		echo $this->Html->link('Stickers',array('controller'=>'Stickers','action'=>'export'),array('class'=>'btn btn-primary'));
				    	?>
		        </li>
		        <li>
		       		<?php
					  		echo $this->Html->link('Categories',array('controller'=>'Categories','action'=>'export'),array('class'=>'btn btn-primary'));
				    	?>
		        </li>
		        <li>
		        	<?php
					  		echo $this->Html->link('Appusers',array('controller'=>'Appusers','action'=>'export'),array('class'=>'btn btn-primary'));
				    	?>	
		        </li>
		        <li>
		        	<?php
					  		echo $this->Html->link('Popular Stickers',array('controller'=>'Dashboard','action'=>'export'),array('class'=>'btn btn-primary'));
				    	?>
		        </li>
		        <li>
		        	<?php
					  		echo $this->Html->link('Free Stickers Given',array('controller'=>'Appusers','action'=>'exportfree'),array('class'=>'btn btn-primary'));
				    	?>
		        </li>
		       
			</ul>
				</div>
          </div>   -->    	
                <div class="row">
                <?php echo $this -> element('legends'); ?>
                </div>
            
            <!-- /.container-fluid -->

        </div>
        <script>
        $(document).ready(function(){
        	if($("#type").val()==='1'){
        		$("#dp1").hide();
        		$("#dp2").hide();
        	}
        	$("#type").change(function(){
        		if($(this).val()==='1'){
        			$("#dp1").hide();
        			$("#dp2").hide();
        		}else if($(this).val()==='2' || $(this).val()==='3'){
        			$("#dp1").show();
        			$("#dp2").show();
        		}
        	});
        	if($("#ctype").val()==='1'){
        		$("#dp3").hide();
        		$("#dp4").hide();
        	}
        	$("#ctype").change(function(){
        		if($(this).val()==='1'){
        			$("#dp3").hide();
        			$("#dp4").hide();
        		}else if($(this).val()==='2' || $(this).val()==='3'){
        			$("#dp3").show();
        			$("#dp4").show();
        		}
        	});
        	if($("#atype").val()==='1'){
        		$("#dp5").hide();
        		$("#dp6").hide();
        		$("#sort").show();
        		$("#order").show();
        		$("#status").show();
        		$("#name").hide();
        		$("#stickers").hide();
        	}
        	$("#atype").change(function(){
        		if($(this).val()==='1'){
        			$("#dp5").hide();
        			$("#dp6").hide();
        			$("#sort").show();
        			$("#order").show();
        			$("#status").show();
        			$("#name").hide();
        			$("#stickers").hide();
        		}else if($(this).val()==='2'){
        			$("#dp5").show();
        			$("#dp6").show();
        			$("#sort").show();
        			$("#order").show();
        			$("#status").show();
        			$("#name").hide();
        			$("#stickers").hide();
        		}else if($(this).val()==='3'){
        			$("#dp5").hide();
        			$("#dp6").hide();
        			$("#sort").hide();
        			$("#order").hide();
        			$("#status").hide();
        			$("#name").show();
        			$("#stickers").show();
        		}
        	});
        	if($("#ptype").val()==1){
        		$("#dp7").hide();
        		$("#dp8").hide();
        	}
        	$("#ptype").change(function(){
        		if($("#ptype").val()==1){
        			$("#dp7").hide();
        			$("#dp8").hide();
        		}else if($("#ptype").val()==2){
        			$("#dp7").show();
        			$("#dp8").show();
        		}
        	});
        });
        	
        </script>
        <!-- /#page-wrapper -->