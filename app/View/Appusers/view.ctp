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
        	</ol>
		</div>
	</div>
	<h4>User : <strong><?php echo $name;?></strong></h4>
    <div class="row">
    	<div class='col-md-10 col-md-offset-1'>
    		<div class="table-responsive">
    			<table class="table table-hover table-striped">
    				<th>S.No.</th>
    				<th>Device Id</th>
    				<th>Device Type</th>
    				<th>Status</th>
    				<th>Notification Status</th>
    				<th>Date Added</th>
    				<tbody>
    					<?php $i=1; foreach ($result as $key=>$data){ ?>
    					<tr>
    						<td><?php echo $i; ?></td>
    						<td><?php echo $data['Device']['imei']; ?></td>
    						<td><?php if($data['Device']['device_type']==1){
    								echo "Android";
    							}else if($data['Device']['device_type']==2){
    								echo "IOS";
    							} ?></td>
    						<td><?php if($data['Device']['is_active']==1){
    								echo "<span data-toggle='tooltip' data-placement='top' title='Active'><i class='fa fa-check-square activeicon' style='cursor:pointer;'></i></span>";
    							}else{
    								echo "<span data-toggle='tooltip' data-placement='top' title='Inactive'><i class='fa fa-minus-square deactiveicon' style='cursor:pointer;'></i></span>";
    							} ?></td>
    						<td><?php if($data['Device']['notification']==1){
    								echo "<span data-toggle='tooltip' data-placement='top' title='Notification Enabled'><i class='fa fa-bell activeicon' style='cursor:pointer;'></i></span>";
    							}else{
    								echo "<span data-toggle='tooltip' data-placement='top' title='Notification Disabled'><i class='fa fa-bell-slash deactiveicon' style='cursor:pointer;'></i></span>";
    							} ?></td>
    							<td><?php echo date("F j, Y, g:i A",strtotime($data['Device']['created']));?></td>
    					</tr>
    					<?php $i++; } ?>
    				</tbody>
    			</table>
    		</div>
    	</div>
    </div>
    <div class="row text-center">
    	<ul class="list-inline">        
			<li>
			<?php
				echo $this->Html->link('View Purchased Stickers',array('controller'=>'Appusers','action'=>'purchased',base64_encode($id),base64_encode($name)),array('class'=>'btn btn-primary'));
			?>
		</li>
		<li>
			<?php
				echo $this->Html->link('View Used Stickers',array('controller'=>'Appusers','action'=>'usage',base64_encode($id),base64_encode($name)),array('class'=>'btn btn-primary'));
			?>
		</li>
    	<li>         
			<?php
				echo $this->Html->link('Give Stickers for Free',array('controller'=>'Appusers','action'=>'free',base64_encode($id),base64_encode($name)),array('class'=>'btn btn-primary'));
			?>
		</li>
		</ul>
	</div>
	</div>
	<?php echo $this -> element('legends'); ?>
</div>