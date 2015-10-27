<div id="page-wrapper">
<?php 
	echo $this->Session->flash();
?>
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Inbox </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-bar-chart-o fa-dashboard"></i> Dashboard 
                            </li>
                            <li class="active">
                                <i class="fa fa-bar-chart-o fa-envelope"></i> Inbox
                            </li>
                        </ol>
                    </div>
                </div>
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
                	<div class='col-sm-12'>
                		<div class="table-responsive">
                			<?php echo $this->Form->create('Messages',array('controller'=>'Messages','action'=>'index','class'=>'form-inline','onsubmit'=>'return confirmsubmit()'));?>
							<table class="table table-hover table-striped">
								<thead>
									<tr>
										<th>
											<?php echo $this->Form->checkbox('', array('id'=>'selectall','name'=>'data[Messages][checks][]','value'=>'All','class'=>'case','hiddenField' => false)); ?>
										</th>
										<th>S.No.</th>
										<th><?php echo $this -> Paginator -> sort('from', 'From'); ?></th>
										<th>Subject</th>
										<th>Time</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i = 1;
									isset($this -> passedArgs['page']) ? $SrNos = ((($this -> passedArgs['page'] * 10) - 10) + $i) : $SrNos = $i;
									?>
									<?php foreach($result as $r=>$data){ ?>
										
									<tr>
										<td>
											<?php echo $this->Form->checkbox('', array('name'=>'data[Messages][checks][]','value'=>$data['Message']['id'],'class'=>'case','hiddenField' => false)); ?>
										</td>
										<td><?php echo $SrNos; ?></td>
										<td><?php echo $data['Message']['from']; ?></td>
										<td><?php echo $data['Message']['subject']; ?></td>
										<td><?php echo date("F j, Y, g:i A",strtotime($data['Message']['created'])); ?></td>
										<td>
											<?php 
												echo $this -> Html -> link('<span data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-search view"></i></span>', array('controller' => 'Messages', 'action' => 'view', base64_encode($data['Message']['id'])), array('escape' => false));
												echo $this -> Html -> link('<span data-toggle="tooltip" data-placement="top" title="Delete"> <i class="fa fa-close delete"></i></span>', array('controller' => 'Messages', 'action' => 'delete', base64_encode($data['Message']['id'])), array('escape' => false, 'confirm' => 'Are you sure you wish to DELETE this Message?'));
											?>
										</td>
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
		var agree=confirm("Messages once deleted will not be retrieved. Continue?");

		if (agree)
    	return true ;
			else
   		return false ;
	}
</script>
        <!-- /#page-wrapper -->