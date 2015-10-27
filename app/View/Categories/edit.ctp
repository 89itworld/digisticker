<div id="page-wrapper">
<?php
	echo $this -> Session -> flash();
?>	
	<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">
            Edit Category </h1>
            <ul class="list-inline pull-right a-tag">
            	<li>
            		<?php echo $this->Html->link('<i class="fa fa-list"></i> List Categories',array('controller'=>'Categories','action'=>'index'),array('escape'=>false,'class'=>'pull-right a-tag')); ?></a>
            	</li>
            </ul>
            <ol class="breadcrumb">
	            <li class="active">
    	            <i class="fa fa-bar-chart-o"></i> Categories
                </li>
                <li class="active">
                    <i class="fa fa-edit"></i> Edit
                </li>
        	</ol>
		</div>
	</div>
    <div class="row">
    	<div class="col-lg-6">
						<?php echo $this->Form->create('Categorie',array('class'=>'form-horizontal','enctype'=>'multipart/form-data')); ?>
						  <div class="form-group">
						    <label class="col-sm-4 control-label">Name: </label>
							    <div class="col-sm-8">
							      <?php echo $this->Form->input('name',array('id'=>'name','type'=>'text','class'=>'form-control','placeholder'=>'Category Name','default'=>$name,'label'=>false,'div'=>false));?>
							    	<span id="nameerr" class='error'></span>
							    </div>
							</div>
							
							<div class="form-group">
						    <label class="col-sm-4 control-label">Image: </label>
							    <div class="col-sm-8">
							      <?php echo $this->Form->input('upload',array('id'=>'imgupload','type'=>'file','label'=>false,'div'=>false,'required'=>false));?>
							    	<span id="imgerr" class='error'></span>
							    </div>
							</div>
							
							<div class="form-group">
							    <div class="col-sm-8 pull-right">
									<?php echo $this->Form->input('submit',array('class'=>'btn btn-primary','type'=>'submit','value'=>'Add','label'=>false,'div'=>false));?>
							    </div>
							</div>
								  	
							<?php echo $this->Form->end();?>  
							
                      </div>
                      <div class="col-lg-6">
                      	<strong style="vertical-align: top;">Current Image</strong>
                      	<?php echo $this->Html->image("uploads/categories/$image",array('style'=>'width:144px; height:144px;','class'=>'center-block')); ?>
                      </div>
    </div>            
	
	</div>
</div>
<!-- <script>
    	function validate(){
    		var ext = $('#imgupload').val().split('.').pop().toLowerCase();
    		if($('#name').val().length<5){
    			$('#nameerr').html(' * Name Should be of atleast 5 characters.');
    			return false;
    		}else
    		if(ext==""){
    			return true;
    		}
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
    </script> -->