<div id="page-wrapper">
	<div class='container-fluid'>
		<div class="row">
        	<div class="col-lg-12">
            	<h1 class="page-header">View Used Stickers</h1>
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
                <li class="active">
                    <i class="fa fa-retweet"></i> Used Stickers
                </li>
        	</ol>
            </div>
        </div>
        <h4>User : <strong><?php echo $name;?></strong></h4>
        <?php if(isset($result)){?>
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
                	<div class='col-sm-12'>
                		<div class="table-responsive">
							<table class="table table-hover table-striped">
								<thead>
									<tr>
										<th>S.No.</th>
										<th>Name</th>
										<th>Category</th>
										<th>Type</th>
										<th>Times Used</th>
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
												<?php echo ucfirst($data['sticker']['Sticker']['name']); ?>
												<span>
													<?php echo $this->Html->image("callout_black.gif",array('class'=>'callout'));?>
													<?php echo $this->Html->image("uploads/".$data['sticker']['Sticker']['image'],array('style'=>'float:right;')) ;?>
												</span>
											</a>
										</td>
										<td><?php echo ucfirst($data['category']); ?></td>
										<td><?php if($data['sticker']['Sticker']['type_id']!=1){ echo "Paid";}else{ echo "Free"; }?></td>
										<td><?php echo $data['sticker']['0']['total'];?></td>
										<td><?php echo date("F j, Y, g:i A",strtotime($data['sticker']['Sticker']['created'])); ?></td>
										<td><?php echo date("F j, Y, g:i A",strtotime($data['sticker']['Sticker']['modified'])); ?></td>
										
										
									</tr>
									<?php $SrNos++;
										}
									?>
								</tbody>
								
								
            
					               
					                
					            
							</table>
							<div class="clearfix"></div>
								
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
                	<?php }else{?>    
					    	<div class="row">
                		<div class="col-lg-12">
                			<div class="text-success" style="text-align:center;">
                				No Sticker Found!
                			</div>
                		</div>
                	</div>
					    	<?php }?>  
                </div>
                <?php echo $this -> element('legends'); ?>
   </div>
</div>