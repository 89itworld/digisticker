<div id="page-wrapper">
	<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">
            View Appuser </h1>
            <ul class="list-inline pull-right a-tag">
            	<li>
            		<?php echo $this->Html->link('<i class="fa fa-arrow-left"></i> Go Back',$this->request->referer(),array('escape'=>false,'class'=>'pull-right a-tag')); ?></a>
            	</li>
            </ul>
            <ol class="breadcrumb">
	            <li class="active">
    	            <i class="fa fa-users "></i> Appusers
                </li>
                <li class="active">
                    <i class="fa fa-search"></i> View
                </li>
                <li class="active">
                    <i class="fa fa-money"></i> Purchased Stickers
                </li>
        	</ol>
		</div>
	</div>
	<h4>User : <strong><?php echo $name;?></strong></h4>
	<?php if(isset($result)){?>
    <div class="row">
    	<div class='col-md-6 col-md-offset-3'>
    		<div class="table-responsive">
    			<table class="table table-hover table-striped">
    				<th>S.No.</th>
    				<th>Name</th>
    				<th>Price</th>
    				<th>Created</th>
    				<th>Modified</th>
    				<tbody>
    					<?php $i = 1;
									isset($this -> passedArgs['page']) ? $SrNos = ((($this -> passedArgs['page'] * 10) - 10) + $i) : $SrNos = $i;
									?>
    					<?php foreach ($result as $key=>$data){ ?>
    					<tr>
    						<td><?php echo $SrNos; ?></td>
    						<td><?php echo $data['Sticker']['name']; ?></td>
    						<td><?php echo $data['Sticker']['price']; ?></td>
    						<td><?php echo date("F j, Y, g:i A",strtotime($data['Sticker']['created']));?></td>
    						<td><?php echo date("F j, Y, g:i A",strtotime($data['Sticker']['modified']));?></td>
    					</tr>
    					<?php $SrNos++; } ?>
    				</tbody>
    			</table>
    			
    		</div>
    	</div>
    </div>
    <?php }else{?>
    	<div class="row">
                		<div class="col-lg-12">
                			<div class="text-success" style="text-align:center;">
                				No Sticker Found!
                			</div>
                		</div>
                	</div>
    <?php } ?>
	</div>
	<?php echo $this -> element('legends'); ?>
</div>