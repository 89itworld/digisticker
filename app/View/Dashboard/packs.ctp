<div id="page-wrapper">
	<div class='container-fluid'>
		<div class="row">
        	<div class="col-lg-12">
            	<h1 class="page-header">Packs Per User</h1>
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
                    	<i class="fa fa-retweet"></i> Packs Per User
                    </li>
                </ol>
            </div>
        </div>
        <?php if(isset($result)){?>
                <div class="row">
                	<div class='col-sm-12'>
                		<div class="table-responsive">
							<table class="table table-hover table-striped">
								<thead>
									<tr>
										<th>S.No.</th>
										<th>User</th>
										<!-- <th>Image</th> -->
										<th>Packs</th>
										
									</tr>
								</thead>
								<tbody>
									<?php $i = 1;
									// isset($this -> passedArgs['page']) ? $SrNos = ((($this -> passedArgs['page'] * 10) - 10) + $i) : $SrNos = $i;
									?>
									<?php foreach($result as $r=>$data){ ?>
									
									<tr>
										<td><?php echo $i; ?></td>
										<td>
												<?php echo ucfirst($data['name']); ?>
										</td>
										<!-- <td><?php echo $data['Sticker']['image']; ?></td> -->
										<td><?php echo ucfirst($data['packs']); ?></td>
									</tr>
									<?php $i++;
										}
									?>
								</tbody>
								
								
            
					               
					                
					            
							</table>
							<div class="clearfix"></div>
								
								<div class="pagination remove-margin" style="float:right;">
            
				                
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
                				No Data Found!
                			</div>
                		</div>
                	</div>
					    	<?php }?>  
                </div>
                <?php echo $this -> element('legends'); ?>
   </div>
</div>