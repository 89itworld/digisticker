<div id="page-wrapper">
	<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">
            View Sticker </h1>
            <ul class="list-inline pull-right a-tag">
            	<li>
            		<?php echo $this->Html->link('<i class="fa fa-arrow-left"></i> Go Back',$this->request->referer(),array('escape'=>false,'class'=>'pull-right a-tag')); ?></a>
            	</li>
            </ul>
            <ol class="breadcrumb">
	            <li class="active">
    	            <i class="fa fa-star-half-o "></i> Stickers
                </li>
                <li class="active">
                    <i class="fa fa-search"></i> View
                </li>
        	</ol>
		</div>
	</div>
    <div class="row">
    	<div class='col-md-6 col-md-offset-3'>
    		<div class="table-responsive">
    			<table class="table table-hover table-striped">
    				<tbody>
    					<tr>
    						<td><strong>Name</strong></td>
    						<td><?php echo ucfirst($name); ?></td>
    					</tr>
    					<tr>
    						<td><strong>Category</strong></td>
    						<td><?php echo ucfirst($category); ?></td>
    					</tr>
    					<tr>
    						<td><strong>Price</strong></td>
    						<td><?php echo $price; ?></td>
    					</tr>
    					<tr>
    						<td><strong>Type</strong></td>
    						<td><?php if($type==1){echo "Free";}else{echo "Paid"; } ?></td>
    					</tr>
    					<tr>
    						<td><strong>Image</strong></td>
    						<td><?php echo $this->Html->image("uploads/$image",array('style'=>'width:185px; height:185px;')); ?></td>
    					</tr>
    				</tbody>
    			</table>
    		</div>
    	</div>
    </div>

           <?php echo $this->element('legends');?>     
</div>
</div>