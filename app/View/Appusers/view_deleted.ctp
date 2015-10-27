<div id="page-wrapper">
<?php 
	echo $this->Session->flash();
?>
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Inactive Appusers </h1>
                            <ul class="list-inline pull-right a-tag">
                            	<li>
                           			<?php echo $this->Html->link('<i class="fa fa-list"></i> List Appusers',array('controller'=>'Appusers','action'=>'index'),array('escape'=>false,'class'=>'pull-right a-tag')); ?></a> 
                            	</li>
                            </ul>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-users"></i> App Users
                            </li>
                            <li class="active">
                                <i class="fa fa-user-times"></i> Inactive App Users
                            </li>
                        </ol>
                    </div>
                </div>
                <?php if(!empty($result)){?>
                	<div class="pagination remove-margin pull-right" style="float:right;">
                		<?php echo "Results(".$this->Paginator->params()['count'].")";?>
            						<?php echo "Page ".$this->Paginator->counter()." "; ?>
					                <?php
					                
					                if($this->Paginator->counter(array('format' => '%pages%'))>1){
					                      echo $prev_link = '« ' . $this->paginator -> prev('Previous');?>
					        
					                    &nbsp;<?php echo $this -> Paginator -> numbers(); ?>&nbsp;
					         
					                    <?php echo $next_link = $this -> paginator -> next('Next') . ' »'; ?>
					        
					                <?php } ?>
					                
					            </div>
                <div class="row">
                	<div class='col-lg-12'>
                		<?php echo $this->Form->create('Notifications',array('controller'=>'Notifications','action'=>'push','class'=>'navbar-form '));?>
                		<div class="table-responsive">
							<table class="table table-hover table-striped">
								<thead>
									<tr>
										<th>
											<?php echo $this->Form->checkbox('', array('id'=>'selectall','name'=>'data[Notifications][checks][]','value'=>"Allin",'class'=>'case','hiddenField' => false)); ?>
										</th>
										<th>S.No.</th>
										<th>Email</th>
										<th>Status</th>
										<th>Country</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$i = 1;
        			                    isset($this->passedArgs['page'])?$SrNos=((($this->passedArgs['page']*10)-10)+$i):$SrNos=$i;
									?>
									<?php foreach($result as $r=>$data){ ?>
									<tr>
										<td>
											<?php echo $this->Form->checkbox('', array('name'=>'data[Notifications][checks][]','value'=>$data['Appuser']['id'],'class'=>'case','hiddenField' => false)); ?>
										</td>
										<td><?php echo $SrNos;?></td>
										<td><?php echo ucfirst($data['Appuser']['email']); ?></td>
										<td><i class='fa fa-minus-square deactiveicon'></i></td>
										<td><?php echo $data['Appuser']['country']; ?></td>
									</tr>
									<?php $SrNos++; }?>
								</tbody>
								
							</table>
							<div class="pagination remove-margin pull-right" style="float:right;">
								<?php echo "Results(".$this->Paginator->params()['count'].")";?>
            						<?php echo "Page ".$this->Paginator->counter()." "; ?>
					                <?php
					                
					                if($this->Paginator->counter(array('format' => '%pages%'))>1){
					                      echo $prev_link = '« ' . $this->paginator -> prev('Previous');?>
					        
					                    &nbsp;<?php echo $this -> Paginator -> numbers(); ?>&nbsp;
					         
					                    <?php echo $next_link = $this -> paginator -> next('Next') . ' »'; ?>
					        
					                <?php } ?>
					                
					            </div>
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
                <?php }else{?>
                	<div class="row">
                		<div class="col-lg-12">
                			<div class="text-success" style="text-align:center;">
                				No Inactive User Found!
                			</div>
                		</div>
                	</div>
                	<?php }?>
                <!-- /.row -->

                
                <!-- /.row -->

                
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->
<?php echo $this->element('legends');?>
        </div>
                <script language="javascript">
        $(function(){
        	$("#selectall").click(function(){
        		$('.case').prop('checked', this.checked);
        		});
        	});
</script>
        <!-- /#page-wrapper -->