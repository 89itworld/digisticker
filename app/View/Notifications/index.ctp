<div id="page-wrapper">
<?php 
	echo $this->Session->flash();
?>
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Push Notifications </h1>
                            <!-- <ul class="list-inline pull-right a-tag">
                            	<li>
                            		<?php echo $this -> Html -> link('<i class="fa fa-user-times"></i> View Inactive Users', array('controller' => 'Appusers', 'action' => 'view_deleted'), array('escape' => false)); ?></a>
                            	</li>
                            </ul> -->
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-bar-users fa-bell"></i> Push Notifications
                            </li>
                        </ol>
                    </div>
                </div>
                <?php echo $this->Html->link('Clear Filters',array('controlller'=>'Notifications','action'=>'index'),array('class'=>'btn btn-primary')); ?>
					            <div class="pagination remove-margin" style="float:right;">
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
                <div class="row">
                	<div class='col-sm-9 col-sm-offset-2'>
                		<div class="table-responsive">
                			<?php echo $this->Form->create('Notifications',array('controller'=>'Notifications','action'=>'index','class'=>'form-inline','onsubmit'=>'return confirmsubmit()'));?>
							<table class="table table-hover table-striped">
								<thead>
									<tr>
										<th>
											<?php echo $this->Form->checkbox('', array('id'=>'selectall','name'=>'data[Notifications][checks][]','value'=>'All','class'=>'case','hiddenField' => false)); ?>
										</th>
										<th>S.No.</th>
										<th><?php echo $this->paginator->sort('user','User');?></th>
										<th><?php echo $this->paginator->sort('notification','Notification');?></th>
										<th><?php echo $this->paginator->sort('created','Time');?></th>
										<!-- <th>Status</th> -->
									</tr>
								</thead>
								<tbody>
									<?php $i = 1;
										isset($this -> passedArgs['page']) ? $SrNos = ((($this -> passedArgs['page'] * 50) - 50) + $i) : $SrNos = $i;
									?>
									<?php foreach($result as $r=>$data){ ?>
								
									<tr>
										<td>
											<?php echo $this->Form->checkbox('', array('name'=>'data[Notifications][checks][]','value'=>$data['Notification']['id'],'class'=>'case','hiddenField' => false)); ?>
										</td>
										<td><?php echo $SrNos; ?></td>
										<td><?php echo $data['Appuser']['user']; ?></td>
										<td><?php echo $data['Notification']['notification'];?></td>
										<td><?php echo date("F j, Y, g:i A",strtotime($data['Notification']['created']));?></td>
									</tr>
									<?php $SrNos++;
										}
									?>
								</tbody>
								
							</table>
							<input class="btn btn-primary" type="submit" value="Delete"/>
								<?php echo $this->form->end();?>
							<div class="clearfix"></div>
					            <div class="pagination remove-margin" style="float:right;">
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
	function confirmsubmit(){
		var agree=confirm("Notifications once deleted will not be retrieved. Continue?");

		if (agree)
    	return true ;
			else
   		return false ;
	}
</script>
        <!-- /#page-wrapper -->