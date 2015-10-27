<div id="page-wrapper">
	<div class='container-fluid'>
		<div class="row">
        	<div class="col-lg-12">
            	<h1 class="page-header">Popular Stickers</h1>
            	<ul class="list-inline pull-right a-tag">
            		<li>
            			<?php echo $this->Html->link('<i class="fa fa-arrow-left"></i> Go Back',$this->request->referer(),array('escape'=>false,'class'=>'pull-right a-tag')); ?></a>
            		</li>
            	</ul>
                <ol class="breadcrumb">
                	<li class="active">
                    	<i class="fa fa-dashboard"></i> Dashboard
                    </li>
                    <li class="active">
                    	<i class="fa fa-heart"></i> Popular Stickers
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
							<table class="table table-hover table-striped">
								<thead>
									<tr>
										<th>S.No.</th>
										<th><?php echo $this -> Paginator -> sort('name', 'Name'); ?></th>
										<!-- <th>Image</th> -->
										<th><?php echo $this -> Paginator -> sort('category_id', 'Category'); ?></th>
										<th><?php echo $this -> Paginator -> sort('type_id', 'Type'); ?></th>
										
										<th>Created</th>
										<th>Modified</th>
										
									</tr>
								</thead>
								<tbody>
									<?php $i = 1;
									isset($this -> passedArgs['page']) ? $SrNos = ((($this -> passedArgs['page'] * 10) - 10) + $i) : $SrNos = $i;
									?>
									<?php foreach($result as $r=>$data){ ?>
									
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
										<td><?php echo ucfirst($data['Sticker']['category_name']); ?></td>
										<td><?php if($data['Sticker']['type_id']!=1){ echo "Paid";}else{ echo "Free"; }?></td>
										
										<td><?php echo date("F j, Y, g:i A",strtotime($data['Sticker']['created'])); ?></td>
										<td><?php echo date("F j, Y, g:i A",strtotime($data['Sticker']['modified'])); ?></td>
										
										
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
   </div>
</div>