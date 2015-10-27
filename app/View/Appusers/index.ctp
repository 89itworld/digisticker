<div id="page-wrapper">
<?php 
	echo $this->Session->flash();
?>
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Manage App Users </h1>
                            
                            <ul class="list-inline pull-right a-tag">
                            	<li>
                            		<?php echo $this -> Html -> link('<i class="fa fa-share"></i> View Free Stickers', array('controller' => 'Appusers', 'action' => 'viewfree'), array('escape' => false)); ?></a> |
                            		<?php echo $this -> Html -> link('<i class="fa fa-user-times"></i> View Inactive Users', array('controller' => 'Appusers', 'action' => 'view_deleted'), array('escape' => false)); ?></a>
                            	</li>
                            </ul>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-bar-users fa-users"></i> App Users
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                	<div class="col-lg-12">
                		<?php echo $this->Form->create('Appuser',array('class'=>'form-inline col-lg-6','type'=>'get','url' => array('controller' => 'Appusers', 'action' => 'index')));?>
                			<div class="form-group">
                				<?php echo $this->Form->input('type',array('id'=>'type','options'=>array('1'=>'Email','2'=>'ZIP','3'=>'City','4'=>'Country'),'class'=>'form-control','div'=>false,'label'=>false));?>	
                			</div>
                			<div class="form-group">
								<div class="col-md-7">
									<?php echo $this->Form->input('q',array('id'=>'searcht','type'=>'text','class'=>'form-control','label'=>false,'div'=>false,'required'));?>
								</div>
                			</div>
                			<input type="submit" class="btn btn-primary" value="Search"/>
                		<?php echo $this->Form->end(); ?>
                		
                		<?php echo $this->Form->create('Appuser',array('class'=>'form-inline col-lg-6','type'=>'get','url' => array('controller' => 'Appusers', 'action' => 'index')));?>
                			<div class="form-group">
                				<label>From:</label>
                				<?php echo $this->Form->input('from',array('id'=>'datepicker-example1','class'=>'form-control','div'=>false,'label'=>false)); ?>
                			</div>
                			<div class="form-group">
                				<label>To:</label>
                				<?php echo $this->Form->input('to',array('id'=>'datepicker-example2','class'=>'form-control','div'=>false,'label'=>false)); ?>
                			</div>
                			<input type="submit" class="btn btn-primary" value="Search"/>
                		<?php echo $this->Form->end(); ?>
                	
                	</div>
                </div>
                <br/>
                <?php echo $this->Html->link('Clear Filters',array('controlller'=>'Appusers','action'=>'index'),array('class'=>'btn btn-primary')); ?>
					            <div class="pagination remove-margin pull-right">
					            	<?php echo "Results(".$this->Paginator->params()['count'].")";?>
	            					<?php echo "Page ".$this->Paginator->counter()." "; ?>
					                <?php
					                
					                if($this->Paginator->counter(array('format' => '%pages%'))>1){
					                      //echo '« ' . $this->paginator -> prev('Previous');
					        				echo $this->Paginator->first('< first');?>
					                    &nbsp;<?php echo $this -> Paginator -> numbers(); ?>&nbsp;
					         
					                    <?php // echo $this->paginator -> next('Next'). ' »'; 
					                    		echo $this->Paginator->last('last >');
					                    	?>>
					        
					                <?php } ?>
				                
				           		 </div>
				<div class="clearfix"></div>           		 
                <div class="row">
                	<div class='col-sm-12'>
                		<div class="table-responsive">
							<table class="table table-hover table-striped">
								<?php echo $this->Form->create('Notifications',array('controller'=>'Notifications','action'=>'push','class'=>'navbar-form navbar-left pull-right'));?>
								<thead>
									<tr>
										<th>
											<?php echo $this->Form->checkbox('', array('id'=>'selectall','name'=>'data[Notifications][checks][]','value'=>'All','class'=>'case','hiddenField' => false)); ?>
										</th>
										<th>S.No.</th>
										<th><?php echo $this -> Paginator -> sort('email', 'Name'); ?></th>
										<th><?php echo $this->Paginator->sort('is_active','Verification');?></th>
										<th><?php echo $this -> Paginator -> sort('Appuser.zip', 'Zip'); ?></th>
										<th><?php echo $this -> Paginator -> sort('Appuser.city', 'City'); ?></th>
										<th><?php echo $this -> Paginator -> sort('country', 'Country'); ?></th>
										<th><?php echo $this -> Paginator -> sort('Appuser.total', 'Sticker Used'); ?></th>
										<th>Total Devices</th>
										<th><?php echo $this -> Paginator -> sort('Appuser.created', 'Date Added'); ?></th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i = 1;
									isset($this -> passedArgs['page']) ? $SrNos = ((($this -> passedArgs['page'] * 10) - 10) + $i) : $SrNos = $i;
									?>
									<?php foreach($result as $r=>$data){ ?>
										<?php
										if ($data['Appuser']['is_active'] == 1) {
											$active = "<span data-toggle='tooltip' data-placement='top' title='Verified'><i class='fa fa-check-square activeicon'></i></span>";
											$action = "deactivate";
										} else {
											$active = "<span data-toggle='tooltip' data-placement='top' title='Not Verified'><i class='fa fa-minus-square deactiveicon'></i></span>";
											$action = "activate";
										}
										 ?>
									<tr>
										<td>
											<?php echo $this->Form->checkbox('', array('name'=>'data[Notifications][checks][]','value'=>$data['Appuser']['id'],'class'=>'case','hiddenField' => false)); ?>
										</td>
										<td><?php echo $SrNos; ?></td>
										<td><?php echo $data['Appuser']['email']; ?></td>
										<td><?php
											if ($data['Appuser']['is_active'] == 1) {
												echo $active;
											}else {
												 echo $active;
												}
 										?></td>
 										<td><?php echo $data['Appuser']['zip'];?></td>
 										<td><?php echo ucfirst($data['Appuser']['city']);?></td>
 										<td><?php echo ucfirst($data['Appuser']['country']); ?></td>
 										<td><?php if(!empty($data['0']['total'])){ echo $data['0']['total'];}else{echo "0";} ?></td>
 										<td><?php echo $data['Appuser']['dtotal'];?></td>
 										<td><?php echo date("F j, Y, g:i A",strtotime($data['Appuser']['created']));?></td>
 										<td><?php echo $this -> Html -> link('<span data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-search view"></i></span>', array('controller' => 'Appusers', 'action' => 'view', base64_encode($data['Appuser']['id']), base64_encode($this -> here)), array('escape' => false)); ?></td>
									</tr>
									<?php $SrNos++;
										}
									?>
								</tbody>
							</table>
							 <?php
							// echo $this->Html->link('Export',array('controller'=>'Appusers','action'=>'export'), array('target'=>'_blank'));
 
							// ?>
							<div class="clearfix"></div>
					            <div class="pagination remove-margin pull-right">
					            	<?php echo "Results(".$this->Paginator->params()['count'].")";?>
	            					<?php echo "Page ".$this->Paginator->counter()." "; ?>
					                <?php
					                
					                if($this->Paginator->counter(array('format' => '%pages%'))>1){
					                      //echo '« ' . $this->paginator -> prev('Previous');
					        				echo $this->Paginator->first('< first');?>
					                    &nbsp;<?php echo $this -> Paginator -> numbers(); ?>&nbsp;
					         
					                    <?php // echo $this->paginator -> next('Next'). ' »'; 
					                    		echo $this->Paginator->last('last >');
					                    	?>>
					        
					                <?php } ?>
				                
				           		 </div>
						<div class="clearfix"></div>
						<ul class="list-inline">
							<li><?php echo $this->Form->input('Give Free Stickers',array('type'=>'submit','name'=>'submit','class'=>'form-group btn btn-primary','label'=>false,'div'=>false));?></li>
						</ul>
					   <div class="row">
					<div class="col-lg-12">
						<ul class="list-inline pull-right sticker-message">
							<li><label for="message">Message</label></li>
							<li><?php echo $this->Form->textarea('message',array('class'=>'form-control','rows'=>'1','style'=>''));?></li>
							<li><?php echo $this->Form->button('Send Notification',array('class'=>'btn btn-primary','label'=>false,'div'=>false));?></li>
						</ul>
						
				        
				     <?php echo $this->Form->end();?>
					</div>
				</div>
				       
						</div>
                	</div>
                </div>
            </div>
            <!-- /.container-fluid -->
<?php echo $this -> element('legends'); ?>
        </div>
<script language="javascript">
        $(function(){
        	$("#selectall").click(function(){
        		$('.case').prop('checked', this.checked);
        		});
        	});
</script>
<script>
	$(document).ready(function(){
		if($('#type').val()=='1'){
			$('#searcht').attr('placeholder','someone@example.com');
		}
		$("#type").change(function(){
			if($(this).val()=='1'){
				$('#searcht').attr('placeholder','someone@example.com');
			}
			if($(this).val()==='2'){
				$('#searcht').attr('placeholder','eg. 248001');
			}
			if($(this).val()==='3'){
				$('#searcht').attr('placeholder','eg. Helena');
			}
			if($(this).val()==='4'){
				$('#searcht').attr('placeholder','eg. India');
			}
		});
	});
</script>
        <!-- /#page-wrapper -->