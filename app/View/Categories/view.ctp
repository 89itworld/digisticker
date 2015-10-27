<div id="page-wrapper">
	<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">
            View Category </h1>
            <ul class="list-inline pull-right a-tag">
            	<li>
            		<?php echo $this->Html->link('<i class="fa fa-arrow-left"></i> Go Back',$this->request->referer(),array('escape'=>false,'class'=>'pull-right a-tag')); ?></a>
            	</li>
            </ul>
            <ol class="breadcrumb">
	            <li class="active">
    	            <i class="fa fa-bar-chart-o "></i> Categories
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
    						<td><strong>Image</strong></td>
    						<td><?php echo $this->Html->image("uploads/categories/$image",array('style'=>'width:144px; height:144px;')); ?></td>
    					</tr>
    				</tbody>
    			</table>
    		</div>
    	</div>
    </div>   
    
    <div class="clearfix"></div>
    <center><h3>Stickers In <?php echo ucfirst($name); ?> Category</h3><hr/></center>
	                  <div class="row">
                	<div class='col-sm-12'>
                		<div class="table-responsive">
							<table class="table table-hover table-striped">
								<thead>
									<tr>
										<th>S.No.</th>
										<th>Name</th>
										<!-- <th>Image</th> -->
										
										
										<th>Status</th>
										<th>Created</th>
										<th>Modified</th>
										
										
									</tr>
								</thead>
								<tbody>
									<?php $i = 1;
									isset($this -> passedArgs['page']) ? $SrNos = ((($this -> passedArgs['page'] * 50) - 50) + $i) : $SrNos = $i;
									?>
									<?php foreach($stickers as $r=>$data){ ?>
										<?php
										if ($data['Sticker']['is_active'] == 1) {
											$active = "<span data-toggle='tooltip' data-placement='top' title='Deactivate'><i class='fa fa-check-square activeicon'></i></span>";
											$action = "deactivate";
										} else {
											$active = "<span data-toggle='tooltip' data-placement='top' title='Activate'><i class='fa fa-minus-square deactiveicon'></i></span>";
											$action = "activate";
										}
										 ?>
									<tr>
										<td><?php echo $SrNos; ?></td>
										<td>
											<a href="#" class="tooltip1">
												<?php echo ucfirst($data['Sticker']['name']); ?>
												<span>
													<!-- <img class="callout" src="img/callout_black.gif" /> -->
													<?php echo $this->Html->image("callout_black.gif",array('class'=>'callout'));?>
													<?php echo $this->Html->image("uploads/".$data['Sticker']['image'],array('style'=>'float:right;')) ;?>
												</span>
											</a>
										</td>
										<!-- <td><?php echo $data['Sticker']['image']; ?></td> -->
										
										
										<td><?php
											if ($data['Sticker']['is_active'] == 1) {echo $active;
											} else { echo $active;
											}?>
										</td>
										<td><?php echo date("F j, Y, g:i A",strtotime($data['Sticker']['created'])); ?></td>
										<td><?php echo date("F j, Y, g:i A",strtotime($data['Sticker']['modified'])); ?></td>
										
									</tr>
									<?php $SrNos++;
										}
									?>
								</tbody>
							</table>
						</div>
                	</div>
                </div>
                <div class="clearfix"></div>
                <?php echo $this->element('legends');?>
	</div>
</div>