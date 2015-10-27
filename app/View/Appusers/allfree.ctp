<div id="page-wrapper">
<?php 
	echo $this->Session->flash();
?>
	<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">
            View Appuser </h1>
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
                    <i class="fa fa-search"></i> Give Stickers for Free
                </li>
        	</ol>
		</div>
	</div>
	 
	<?php echo $this->Form->create('Free')?>
    <div class="row">
    	<div class='col-md-6 col-md-offset-3'>
    		<div class="table-responsive">
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
    			<table id="freetable", class="table table-hover table-striped">
    				<th>
						<?php echo $this->Form->checkbox('', array('id'=>'selectall','name'=>'data[Free][checks][]','value'=>"all",'class'=>'case','hiddenField' => false)); ?>
					</th>
    				<th>S.No.</th>
    				<th>Name</th>
    				<th>Price</th>
    				<th>Created</th>
    				<th>Modified</th>
    				<tbody>
    					<?php $i = 1;
									 isset($this -> passedArgs['page']) ? $SrNos = ((($this -> passedArgs['page'] * 1000) - 1000) + $i) : $SrNos = $i;
									?>
    					<?php foreach ($result as $key=>$data){ ?>
    					<tr>
    						<td>
								<?php echo $this->Form->checkbox('', array('name'=>'data[Free][checks][]','value'=>$data['Sticker']['id'],'class'=>'case','hiddenField' => false)); ?>
							</td>
    						<td><?php echo $SrNos; ?></td>
    						<td><a href="#" class="tooltip1">
											<?php echo ucfirst($data['Sticker']['name']); ?>
												<span>
													<?php echo $this->Html->image("callout_black.gif",array('class'=>'callout'));?>
													<?php echo $this->Html->image("uploads/".$data['Sticker']['image'],array('style'=>'float:right;')) ;?>
												</span>
											</a></td>
    						<td><?php echo $data['Sticker']['price'];?></td>
    						<td><?php echo date("F j, Y, g:i A",strtotime($data['Sticker']['created']));?></td>
    						<td><?php echo date("F j, Y, g:i A",strtotime($data['Sticker']['modified']));?></td>
    					</tr>
    					<?php $SrNos++; } ?>
    				</tbody>
    			</table>
    			<div class="clearfix"></div>
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
    		</div>
    	</div>
    </div>
    	<div class="row">
    		<div class="col-sm-4 col-sm-offset-7">            
				<button type="submit" class="btn btn-primary">Give For Free</button>
			</div>
		</div>
		<?php echo $this->Form->end();?>
	</div>
	<?php echo $this -> element('legends'); ?>
</div>
<script language="javascript">
        $(function(){
        	$("#selectall").click(function(){
        		$('.case').prop('checked', this.checked);
        		});
        	});
</script>
