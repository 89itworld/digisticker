<div id="page-wrapper">
<?php 
	echo $this->Session->flash();
?>
	<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">
            View Appuser </h1>
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
	<h4>User : <strong><?php echo $name;?></strong></h4>
	<?php echo $this->Form->create('Free')?>
    <div class="row">
    	<div class='col-md-6 col-md-offset-3'>
    		<div class="table-responsive">
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
									// isset($this -> passedArgs['page']) ? $SrNos = ((($this -> passedArgs['page'] * 10) - 10) + $i) : $SrNos = $i;
									?>
    					<?php foreach ($result as $key=>$data){ ?>
    					<tr>
    						<td>
								<?php echo $this->Form->checkbox('', array('name'=>'data[Free][checks][]','value'=>$data['Sticker']['id'],'class'=>'case','hiddenField' => false)); ?>
							</td>
    						<td><?php echo $i; ?></td>
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
    					<?php $i++; } ?>
    				</tbody>
    			</table>
    			<div class="clearfix"></div>
							
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
