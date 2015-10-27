<div id="page-wrapper">
<?php
	echo $this -> Session -> flash();
?>
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Manage Categories </h1>
                            
                            <ul class="list-inline pull-right a-tag">
                            	<li>
                            		<?php echo $this -> Html -> link(' <i class="fa fa-plus"></i> Add New Category ', array('controller' => 'Categories', 'action' => 'add'), array('escape' => false)); ?></a>| 
                            	</li>
                            	<li>
                            		<?php echo $this -> Html -> link('<i class="fa fa-close"></i> View Deleted Categories', array('controller' => 'Categories', 'action' => 'view_deleted'), array('escape' => false)); ?></a>
                            	</li>
                            </ul>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-bar-chart-o fa-icon"></i> Categories
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                	<div class="col-lg-12">
                		<?php echo $this->Form->create('Categorie',array('class'=>'form-inline','url' => array('controller' => 'Categories', 'action' => 'index')));?>
                			<div class="form-group">
                				<label class="col-md-3">Type: </label>
								<div class="col-md-6">
									<?php $option=array('1'=>'Created','2'=>'Modified');?>
									<?php echo $this->Form->input('time',array('options'=>$option,'id'=>'category','class'=>'form-control','label'=>false,'div'=>false,'required'));?>
								</div>
                			</div>
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
                </div><br />
                <?php echo $this->Html->link('Clear Filters',array('controlller'=>'Categories','action'=>'index'),array('class'=>'btn btn-primary')); ?>
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
								<thead>
									<tr>
										<th>S.No.</th>
										<th><?php echo $this -> Paginator -> sort('Categorie.name', 'Name'); ?></th>
										<th><?php echo $this -> Paginator -> sort('Categorie.is_active', 'Status'); ?></th>
										<th><?php echo $this -> Paginator -> sort('Categorie.Total', 'Total Stickers'); ?></th>
										<th><?php echo $this -> Paginator -> sort('Categorie.created', 'Created'); ?></th>
										<th><?php echo $this -> Paginator -> sort('Categorie.updated', 'Modified'); ?></th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i = 1;
									isset($this -> passedArgs['page']) ? $SrNos = ((($this -> passedArgs['page'] * 100) - 100) + $i) : $SrNos = $i;
									?>
									<?php foreach($result as $r=>$data){ ?>
										<?php
										if ($data['Categorie']['is_active'] == 1) {
											$active = "<span data-toggle='tooltip' data-placement='top' title='Deactivate'><i class='fa fa-check-square activeicon'></i></span>";
											$action = "deactivate";
										} else {
											$active = "<span data-toggle='tooltip' data-placement='top' title='Activate'><i class='fa fa-minus-square deactiveicon'></i></span>";
											$action = "activate";
										}
										 ?>
									<tr>
										<td><?php echo $SrNos; ?></td>
										<td><a href="#" class="tooltip1">
											<?php echo ucfirst($data['Categorie']['name']); ?>
												<span>
													<?php echo $this->Html->image("callout_black.gif",array('class'=>'callout'));?>
													<?php echo $this->Html->image("uploads/categories/".$data['Categorie']['image'],array('style'=>'float:right;')) ;?>
												</span>
											</a>
											
											
										</td>
										
										<td><?php
										if ($data['Categorie']['is_active'] == 1) {echo $this -> Html -> link($active, array('controller' => 'Categories', 'action' => $action, base64_encode($data['Categorie']['id']), base64_encode($this -> here)), array('escape' => false, 'confirm' => 'Are you sure you wish to DEACTIVATE this Category?'));
										} else { echo $this -> Html -> link($active, array('controller' => 'Categories', 'action' => $action, base64_encode($data['Categorie']['id']), base64_encode($this -> here)), array('escape' => false, 'confirm' => 'Are you sure you wish to ACTIVATE this Category?'));
										}
 ?></td>
 										<td><?echo $data['0']['Total'];?></td>
 										<td><?php echo date("F j, Y, g:i A",strtotime($data['Categorie']['created'])); ?></td>
 										<td><?php echo date("F j, Y, g:i A",strtotime($data['Categorie']['updated'])); ?></td>
										<td>
											<?php echo $this -> Html -> link('<span data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-search view"></i></span> ', array('controller' => 'Categories', 'action' => 'view', base64_encode($data['Categorie']['id']), base64_encode($this -> here)), array('escape' => false));
											echo $this -> Html -> link('<span data-toggle="tooltip" data-placement="top"  title="Edit"> &nbsp;<i class="fa fa-edit edit"></i></span> ', array('controller' => 'Categories', 'action' => 'edit', base64_encode($data['Categorie']['id']), base64_encode($this -> here)), array('escape' => false));
											echo $this -> Html -> link('<span data-toggle="tooltip" data-placement="top" title="Delete"> &nbsp;<i class="fa fa-close delete"></i></span>', array('controller' => 'Categories', 'action' => 'delete', base64_encode($data['Categorie']['id'])), array('escape' => false, 'confirm' => 'Are you sure you wish to DELETE this Category?'));
											?>
										</td>
									</tr>
									<?php $SrNos++;
										}
									?>
								</tbody>
							</table>
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
        <!-- /#page-wrapper -->