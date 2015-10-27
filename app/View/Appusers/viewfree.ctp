<div id="page-wrapper">
<?php 
	echo $this->Session->flash();
?>
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            View Free Stickers </h1>
                            <ul class="list-inline pull-right a-tag">
                            	<li>
                           			<?php echo $this->Html->link('<i class="fa fa-arrow-left"></i> Go Back',$this->request->referer(),array('escape'=>false,'class'=>'pull-right a-tag')); ?></a> 
                            	</li>
                            </ul>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-users"></i> App Users
                            </li>
                            <li class="active">
                                <i class="fa fa-share"></i> View Free Stickers
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
                		<div class="table-responsive">
							<table class="table table-hover table-striped deleted-image">
								<thead>
									<tr>
										<th>S.No.</th>
										<th>Sticker</th>
										<th>Image</th>
										<th>Given To</th>
										<th>Given At</th>
										<th>Sticker Created</th>
										<th>Sticker Modified</th>
										
									</tr>
								</thead>
								<tbody>
									<?php
										$i = 1;
        			                    isset($this->passedArgs['page'])?$SrNos=((($this->passedArgs['page']*50)-50)+$i):$SrNos=$i;
									?>
									<?php foreach($result as $r=>$data){ ?>
									<tr>
										<td><?php echo $SrNos;?></td>
										<td><?php echo ucfirst($data['Sticker']['name']); ?></td>
										<td><?php echo $this->Html->image(Router::Url("/img/uploads/".$data['Sticker']['image'])); ?></td>
										<td><?php echo ucfirst($data['Appuser']['email']); ?></td>
										<td><?php echo date("F j, Y, g:i A",strtotime($data['Purchasedsticker']['created']));?></td>
										<td><?php echo date("F j, Y, g:i A",strtotime($data['Sticker']['created']));?></td>
										<td><?php echo date("F j, Y, g:i A",strtotime($data['Sticker']['modified']));?></td>
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
						</div>
                	</div>
                </div>
                <?php }else{?>
                	<div class="row">
                		<div class="col-lg-12">
                			<div class="text-success" style="text-align:center;">
                				No Free Sticker Given!
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