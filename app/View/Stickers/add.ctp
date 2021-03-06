
        <div id="page-wrapper">
<?php
	echo $this->Session->flash();
?>
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Add New Sticker
                        </h1>
                        <ul class="list-inline pull-right a-tag">
            				<li>
                        		<?php echo $this->Html->link('<i class="fa fa-list"></i> List Stickers',array('controller'=>'Stickers','action'=>'index'),array('escape'=>false,'class'=>'pull-right a-tag')); ?></a>
                        	</li>
                        </ul>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-star-half-o"></i> Stickers
                            </li>
                           <li class="active">
                                <i class="fa fa-plus"></i> Add
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
				<div class="row">
					<div class="col-lg-12">
						<?php echo $this->Form->create('Sticker',array('class'=>'form-horizontal','enctype'=>'multipart/form-data','onsubmit'=>'return validate()')); ?>
						  <div class="form-group">
						    <label class="col-sm-2 control-label">Name: </label>
							    <div class="col-sm-3">
							      <?php echo $this->Form->input('name',array('id'=>'name','type'=>'text','class'=>'form-control','placeholder'=>'Sticker Name','label'=>false,'div'=>false,'required'));?>
							    	<span id="nameerr" class='error'></span>
							    </div>
							</div>
							
							<div class="form-group">
						    <label class="col-sm-2 control-label">Image: </label>
							    <div class="col-sm-10">
							      <?php echo $this->Form->input('upload',array('id'=>'imgupload','type'=>'file','label'=>false,'div'=>false,'required'));?>
							    	<span id="imgerr" style="color:#ff0000;"></span>
							    </div>
							</div>
							<span id="imgerr" class='error'></span>
							 <div class="form-group">
						    <label class="col-sm-2 control-label">Category: </label>
							    <div class="col-sm-3">
							      <?php echo $this->Form->input('categorie',array('options'=>$option,'id'=>'category','class'=>'form-control','label'=>false,'div'=>false,'required'));?>
							    	
							    </div>
							</div>
							<div class="form-group">
						    <label class="col-sm-2 control-label">Price: </label>
							    <div class="col-sm-3">
							      <?php echo $this->Form->input('price',array('id'=>'price','type'=>'text','class'=>'form-control','placeholder'=>'Sticker Price','value'=>'0.00','label'=>false,'div'=>false));?>
							    	<span id="nameerr" class='error'></span>
							    </div>
							</div>
							<div class="form-group">
						    <label class="col-sm-2 control-label">Type: </label>
							    <div class="col-sm-3">
							      <?php echo $this->Form->input('type',array('options'=>array('0'=>'Select','1'=>'Free','2'=>'Paid'),'id'=>'category','class'=>'form-control','label'=>false,'div'=>false,'required'));?>
							    	<span id="nameerr" class='error'></span>
							    </div>
							</div>
							<div class="form-group">
							    <div class="col-sm-10 pull-right">
									<?php echo $this->Form->input('submit',array('class'=>'btn btn-primary','type'=>'submit','value'=>'Add','label'=>false,'div'=>false));?>
							    </div>
							</div>
								  	
							<?php echo $this->Form->end();?>  
							
                      </div>
                    </div>
				</div>
                
                <!-- /.row -->

                
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <script>
    	function validate(){
    		var ext = $('#imgupload').val().split('.').pop().toLowerCase();
    		
    		if($('#name').val().length<3){
    			$('#nameerr').html(' * Name Should be of atleast 3 characters.');
    			return false;
    		}else 
    		if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
    				$('#imgerr').html(' * Only gif, png, jpg, jpeg are allowed.');
					return false;
			}else
			if($("#imgupload")[0].files[0].size > 307200){
				$('#imgerr').html(' * Max file size is 300KB.');
				return false;
			}else
			return true;
    	}
    </script>