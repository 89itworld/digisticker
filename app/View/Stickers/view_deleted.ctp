<div id="page-wrapper">
<?php 
	echo $this->Session->flash();
?>
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Deleted Stickers </h1>
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
                                <i class="fa fa-close"></i> Deleted Stickers
                            </li>
                        </ol>
                    </div>
                </div>
                <?php if(!empty($result)){?>
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
                	<div class='col-lg-12'>
                		<div class="table-responsive">
							<table class="table table-hover table-striped deleted-image ">
								<thead>
									<tr>
										<th>S.No.</th>
										<th>Name</th>
										<th>Image</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$i = 1;
        			                    isset($this->passedArgs['page'])?$SrNos=((($this->passedArgs['page']*10)-10)+$i):$SrNos=$i;
									?>
									<?php foreach($result as $r=>$data){ ?>
									<tr>
										<td><?php echo $SrNos;?></td>
										<td><?php echo ucfirst($data['Sticker']['name']); ?></td>
										<td><?php echo $this->Html->image("uploads/".$data['Sticker']['image']); ?></td>
										<td><i class='fa fa-minus-square deactiveicon'></i></td>
										<td>
											<?php
												echo $this->Html->link('<span data-toggle="tooltip" data-placement="top" title="Restore"> <i class="fa fa-refresh undelete"></i></span>',array('controller'=>'Stickers','action'=>'undelete',base64_encode($data['Sticker']['id'])),array('escape'=>false,'confirm' => 'Are you sure you wish to RESTORE this Sticker?'));
											?>
											
											
											
										</td>
									</tr>
									<?php $SrNos++; }?>
								</tbody>
								
							</table>
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
                <?php }else{?>
                	<div class="row">
                		<div class="col-lg-12">
                			<div class="text-success" style="text-align:center;">
                				No Sticker Found!
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
        <!-- /#page-wrapper -->