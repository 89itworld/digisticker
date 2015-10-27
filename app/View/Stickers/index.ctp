<div id="page-wrapper">
<?php 
	echo $this->Session->flash();
?>
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Manage Stickers </h1>
                            
                            <ul class="list-inline pull-right a-tag">
                            	<li>
                            		<?php echo $this -> Html -> link(' <i class="fa fa-plus"></i> Add New Sticker ', array('controller' => 'Stickers', 'action' => 'add'), array('escape' => false)); ?></a>| 
                            	</li>
                            	<li>
                            		<?php echo $this -> Html -> link('<i class="fa fa-close"></i> View Deleted Stickers', array('controller' => 'Stickers', 'action' => 'view_deleted'), array('escape' => false)); ?></a>
                            	</li>
                            </ul>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-star-half-o fa-icon"></i> Stickers
                            </li>
                        </ol>
                    </div>
                </div>
                <?php echo $this->Form->create('Sticker',array('type'=>'get','class'=>'form-inline','url' => array('controller' => 'Stickers', 'action' => 'index')));?>
                <div class="row">
                	<div class="form-group">
                		<label class="col-md-6 control-label">Search By: </label>
						<div class="col-md-6">
							<?php echo $this->Form->input('searchtype',array('options'=>array('1'=>'Name','2'=>'Category'),'id'=>'searchtype','class'=>'form-control','label'=>false,'div'=>false));?>
						</div>
                	</div>
                	<div class="form-group">
						<div class="col-md-6">
							<?php echo $this->Form->input('sticker_name',array('id'=>'name','class'=>'form-control','placeholder'=>'Name','label'=>false,'div'=>false));?>
						</div>
                	</div>
                	<div class="form-group">
						<div class="col-md-6">
							<?php echo $this->Form->input('category_id',array('options'=>$option,'id'=>'category','class'=>'form-control','label'=>false,'div'=>false));?>
						</div>
                	</div>
                	<div id='type' class="form-group">
                		<label class="col-md-6 control-label">Select Type: </label>
						<div class="col-md-6">
							<?php $opt=array('0'=>'All','1'=>'Free','2'=>'Paid'); ?>
							<?php echo $this->Form->input('type_id',array('options'=>$opt,'class'=>'form-control','label'=>false,'div'=>false));?>
						</div>
                	</div>
                	<div class="form-group">
						<div class="col-md-2">
							<button type="submit" class="btn btn-primary form-group">Show</button>
						</div>
                	</div>
                <?php echo $this->Form->end();?>
                </div><br />
                <div class="row">
                <?php echo $this->Form->create('Sticker',array('class'=>'form-inline','type'=>'get','url' => array('controller' => 'Stickers', 'action' => 'index')));?>
                			<div class="form-group">
                				<label class="col-md-3">Type: </label>
								<div class="col-md-6">
									<?php $option=array('1'=>'Created','2'=>'Modified');?>
									<?php echo $this->Form->input('time',array('options'=>$option,'id'=>'category','class'=>'form-control','label'=>false,'div'=>false,'required'));?>
								</div>
                			</div>
                			<div class="form-group">
                				<label>From:</label>
                				<?php echo $this->Form->input('from',array('id'=>'datepicker-example1','class'=>'form-control','div'=>false,'label'=>false,'required')); ?>
                			</div>
                			<div class="form-group">
                				<label>To:</label>
                				<?php echo $this->Form->input('to',array('id'=>'datepicker-example2','class'=>'form-control','div'=>false,'label'=>false,'required')); ?>
                			</div>
                			<input type="submit" class="btn btn-primary" value="Search"/>
                		<?php echo $this->Form->end(); ?>
                	</div>
                <br/>
                <?php echo $this->Html->link('Clear Filters',array('controlller'=>'Stickers','action'=>'index'),array('class'=>'btn btn-primary')); ?>
                <?php echo $this->Form->create('Sticker',array('class'=>'form-inline','url' => array('controller' => 'Stickers', 'action' => 'bulk'),'onsubmit'=>'return confirmsubmit()'));?>
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
							<table class="table table-hover table-striped">
								<thead>
									<tr>
										<th>
											<?php echo $this->Form->checkbox('', array('id'=>'selectall','name'=>'data[Free][checks][]','value'=>"all",'class'=>'case','hiddenField' => false)); ?>
										</th>
										<th>S.No.</th>
										<th><?php echo $this -> Paginator -> sort('name', 'Name'); ?></th>
										<!-- <th>Image</th> -->
										<th><?php echo $this -> Paginator -> sort('category_id', 'Category'); ?></th>
										<th><?php echo $this -> Paginator -> sort('type_id', 'Price'); ?></th>
										<th><?php echo $this -> Paginator -> sort('is_active', 'Status'); ?></th>
										<th><?php echo $this -> Paginator -> sort('total', 'Times Used'); ?></th>
										<th><?php echo $this -> Paginator -> sort('created', 'Created'); ?></th>
										<th><?php echo $this -> Paginator -> sort('modified', 'Modified'); ?></th>
										<th>Action</th>
										
									</tr>
								</thead>
								<tbody>
									<?php $i = 1;
									isset($this -> passedArgs['page']) ? $SrNos = ((($this -> passedArgs['page'] * 50) - 50) + $i) : $SrNos = $i;
									?>
									<?php foreach($result as $r=>$data){ ?>
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
										<td>
											<?php echo $this->Form->checkbox('', array('name'=>'data[Free][checks][]','value'=>$data['Sticker']['id'],'class'=>'case','hiddenField' => false)); ?>
										</td>
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
										<td><?php echo ucfirst($data['Sticker']['category_name']); ?></td>
										<td><?php if($data['Sticker']['type_id']!=1){ echo "Paid";}else{ echo "Free"; }?></td>
										<td><?php
											if ($data['Sticker']['is_active'] == 1) {echo $this -> Html -> link($active, array('controller' => 'Stickers', 'action' => $action, base64_encode($data['Sticker']['id']), base64_encode($this -> here)), array('escape' => false, 'confirm' => 'Are you sure you wish to DEACTIVATE this Sticker?'));
											} else { echo $this -> Html -> link($active, array('controller' => 'Stickers', 'action' => $action, base64_encode($data['Sticker']['id']), base64_encode($this -> here)), array('escape' => false, 'confirm' => 'Are you sure you wish to ACTIVATE this Sticker?'));
											}?>
										</td>
										<td><?php if(!empty($data['0']['total'])){ echo $data['0']['total'];}else{echo "0";}?></td>
										<td><?php echo date("F j, Y, g:i A",strtotime($data['Sticker']['created'])); ?></td>
										<td><?php echo date("F j, Y, g:i A",strtotime($data['Sticker']['modified'])); ?></td>
										<td>
											<?php echo $this -> Html -> link('<span data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-search view"></i></span>', array('controller' => 'Stickers', 'action' => 'view', base64_encode($data['Sticker']['id']), base64_encode($this -> here)), array('escape' => false));
											echo $this -> Html -> link('<span data-toggle="tooltip" data-placement="top"  title="Edit"> &nbsp;<i class="fa fa-edit edit"></i></span>', array('controller' => 'Stickers', 'action' => 'edit', base64_encode($data['Sticker']['id']), base64_encode($this -> here)), array('escape' => false));
											echo $this -> Html -> link('<span data-toggle="tooltip" data-placement="top" title="Delete"> &nbsp;<i class="fa fa-close delete"></i></span>', array('controller' => 'Stickers', 'action' => 'delete', base64_encode($data['Sticker']['id'])), array('escape' => false, 'confirm' => 'Are you sure you wish to DELETE this Sticker?'));
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
				            <div class="row">
				            	<div class="col-sm-1">
				            		<?php echo $this->Form->input('Delete',array('type'=>'submit','name'=>'submit','class'=>'form-group btn btn-primary','label'=>false,'div'=>false,'confirm' => 'Are you sure you wish to DELETE these Stickers?'));?>
				            	</div>
				            	<div class="col-sm-1">
				            		<?php echo $this->Form->input('Activate',array('type'=>'submit','name'=>'submit','class'=>'form-group btn btn-primary','label'=>false,'div'=>false,'confirm' => 'Are you sure you wish to ACTIVATE these Stickers?'));?>
				            	</div>
				            	<div class="col-sm-1">
				            		<?php echo $this->Form->input('Deactivate',array('type'=>'submit','name'=>'submit','class'=>'form-group btn btn-primary','label'=>false,'div'=>false,'confirm' => 'Are you sure you wish to DEACTIVATE these Stickers?'));?>
				            	</div>
				            	<div class="col-sm-1">
				            		<?php echo $this->Form->input('Markfree',array('type'=>'submit','name'=>'submit','class'=>'form-group btn btn-primary','label'=>false,'div'=>false,'confirm' => 'Are you sure you wish to Mark these Stickers FREE?'));?>
				            	</div>
				            	<div class="col-sm-1">
				            		<?php echo $this->Form->input('Markpaid',array('type'=>'submit','name'=>'submit','class'=>'form-group btn btn-primary','label'=>false,'div'=>false,'confirm' => 'Are you sure you wish to Mark these Stickers PAID?'));?>
				            	</div>
				            </div>
							
	<?php echo $this->Form->end();?>						
								<!-- <div class="pagination remove-margin" style="float:right;">
            
					                <?php
                
               						 if($this->Paginator->counter(array('format' => '%pages%'))>1){
                  					    echo $prev_link = '« ' . $this->paginator -> prev('Previous');?>
        			
                 					   &nbsp;<?php echo $this -> Paginator -> numbers(); ?>&nbsp;
         
                 					   <?php echo $next_link = $this->paginator -> next('Next'). ' »';?>
        
               							 <?php }?>
					                
					            </div> -->
					          
					          
						</div>
                	</div>
                </div>
                <?php echo $this -> element('legends'); ?>
            </div>
            <!-- /.container-fluid -->

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
		var agree=confirm("Are you sure you wish to continue?");

		if (agree)
    	return true ;
			else
   		return false ;
	}
</script>
<script>
	$(document).ready(function(){
		if($('#searchtype').val()=='1'){
			$('#category').hide();
			$('#type').hide();
		}
		$('#searchtype').change(function(){
			if($('#searchtype').val()=='1'){
				$('#category').hide();
				$('#type').hide();
				$('#name').show();
			}
			if($('#searchtype').val()=='2'){
				$('#category').show();
				$('#type').show();
				$('#name').hide();
			}
		});
	});
</script>
        <!-- /#page-wrapper -->