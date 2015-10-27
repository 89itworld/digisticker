<div id="page-wrapper">
	<div class='container-fluid'>
		<div class="row">
        	<div class="col-lg-12">
            	<h1 class="page-header">Dashboard</h1>
                <ol class="breadcrumb">
                	<li class="active">
                    	<i class="fa fa-dashboard"></i> Dashboard
                    </li>
                </ol>
            </div>
        </div>
        
        <div class="row">
        	<div class="col-sm-12">
        		<div class="col-md-6">
        			<div class="col-lg-6 col-md-6">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-3">
									<i class="fa fa-bar-chart-o fa-5x"></i>
								</div>
								<div class="col-xs-9 text-right">
									<div class="huge"><?php if(empty($cat_num)){echo "0";}else{echo $cat_num;} ?></div>
										<div>Total Categories</div>
								</div>
							</div>
						</div>
					<?php echo $this->Html->link('<div class="panel-footer"><span class="pull-left">View Details</span><span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span><div class="clearfix"></div></div>',array('controller'=>'Categories','action'=>'index'),array('escape'=>false));?>
						
					
					</div>
				</div>
				<div class="col-lg-6 col-md-6">
					<div class="panel panel-green">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-3">
									<i class="fa fa-star-half-o fa-5x"></i>
								</div>
								<div class="col-xs-9 text-right">
									<div class="huge"><?php if(empty($sticker_num)){echo "0";}else{echo $sticker_num;} ?></div>
										<div>Total Stickers</div>
								</div>
							</div>
						</div>
					<?php echo $this->Html->link('<div class="panel-footer"><span class="pull-left">View Details</span><span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span><div class="clearfix"></div></div>',array('controller'=>'Stickers','action'=>'index'),array('escape'=>false));?>
						
					
					</div>
				</div>
				<div class="col-lg-6 col-md-6">
					<div class="panel panel-red">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-3">
									<i class="fa fa-users fa-5x"></i>
								</div>
								<div class="col-xs-9 text-right">
									<div class="huge"><?php if(empty($user_num)){echo "0";}else{echo $user_num;} ?></div>
										<div>Total App Users</div>
								</div>
							</div>
						</div>
					<?php echo $this->Html->link('<div class="panel-footer"><span class="pull-left">View Details</span><span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span><div class="clearfix"></div></div>',array('controller'=>'Appusers','action'=>'index'),array('escape'=>false));?>
						
					
					</div>
				</div>
				<div class="col-lg-6 col-md-6">
					<div class="panel panel-yellow">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-3">
									<i class="fa fa-envelope fa-5x"></i>
								</div>
								<div class="col-xs-9 text-right">
									<div class="huge"><?php if(empty($msg_num)){echo "0";}else{echo $msg_num;} ?></div>
										<div>Total Messages</div>
								</div>
							</div>
						</div>
					<?php echo $this->Html->link('<div class="panel-footer"><span class="pull-left">View Details</span><span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span><div class="clearfix"></div></div>',array('controller'=>'Messages','action'=>'index'),array('escape'=>false));?>
						
					
					</div>
				</div>
				<div class="col-lg-6 col-md-6">
					<div class="panel panel-green">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-3">
									<i class="fa fa-heart fa-5x"></i>
								</div>
								<div class="col-xs-9 text-right">
									<div class="huge"><?php if(empty($fav_num)){echo "0";}else{echo $fav_num;}?></div>
										<div>Popular Stickers</div>
								</div>
							</div>
						</div>
					<?php echo $this->Html->link('<div class="panel-footer"><span class="pull-left">View Details</span><span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span><div class="clearfix"></div></div>',array('controller'=>'Dashboard','action'=>'popular'),array('escape'=>false));?>
						
					
					</div>
				</div>
				<div class="col-lg-6 col-md-6">
				<div class="panel panel-red">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-money fa-5x"></i>
							</div>
							<div class="col-xs-9 text-right">
								<div class="huge"><?php if(empty($pur_num)){echo "0";}else{echo $pur_num;} ?></div>
									<div>Total Stickers Sold</div>
							</div>
						</div>
					</div>
				<?php echo $this->Html->link('<div class="panel-footer"><span class="pull-left"></span><span class="pull-right"><i class="fa fa-arrow-circle-rght"></i></span><div class="clearfix"></div></div>',"#",array('escape'=>false));?>
					
				
				</div>
			</div>
       </div>
		<div class="col-md-6">
			<div class="panel panel-red">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-long-arrow-right"></i> Top 5 Most Used Stickers </h3>
                            </div>
                            <div class="panel-body">
                                <div id="morris-donut"></div>
                                <div class="text-right">
                                    <?php echo $this->Html->link('View Details <i class="fa fa-arrow-circle-right"></i>',array('controller'=>'Dashboard','action'=>'mostused'),array('escape'=>false)); ?>
                           </div>
                     </div>
                </div>
		</div>	
        	</div>
        </div>
         <div class="row">
         	<div class="col-lg-12">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-long-arrow-right"></i> Sticker Purchases By <?php if(isset($chart['0']['0']['month']) && isset($chart['0']['0']['year'])){ echo "Month";}else{echo "Year";}?>
                                	<?php echo $this->Form->create('purchase');?>
                                <ul class="list-inline pull-right" style="margin-top: -28px;">
                                	<li>
                                		<?php $options=array('1'=>'Month','2'=>'Year');?>
                                		<?php echo $this->Form->input('time',array('type'=>'select','options'=>$options,'class'=>'form-group','style'=>'color: black;','label'=>false,'div'=>false));?>
                                	</li>
                                	<li>
                                		<input type="submit" class="btn btn-primary" value="Show" />
                                	</li>
                                </ul>
                                <?php echo $this->Form->end();?>
                                </h3>
                            </div>
                            <div class="panel-body">
                                <div id="morris-line-chart"></div>
                                <div class="text-right">
                                    <!-- <a href="#">View Details <i class="fa fa-arrow-circle-right"></i></a> -->
                                </div>
                            </div>
                        </div>
         	</div>
         </div> 
         <div class="row">
         	<div class="col-md-12">
			<div class="panel panel-red">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-long-arrow-right"></i> Packs Per User </h3>
                            </div>
                            <div class="panel-body">
                                <div id="morris-bar"></div>
                                <div class="text-right">
                                    <?php echo $this->Html->link('View Details <i class="fa fa-arrow-circle-right"></i>',array('controller'=>'dashboard','action'=>'packs'),array('escape'=>false)); ?>
                           </div>
                     </div>
                </div>
		</div>	
         </div>
	</div>
</div>

<?php if(isset($chart['0']['0']['month']) && isset($chart['0']['0']['year'])){?>
<script>
	new Morris.Line({
  // ID of the element in which to draw the chart.
  element: 'morris-line-chart',
  // Chart data records -- each entry in this array corresponds to a point on
  // the chart.
  data: [
  <?php foreach ($chart As $key=>$value){
  		if($value['0']['month']<=9){
  			$value['0']['month']="0".$value['0']['month'];
  		}
	
	 ?>
    <?php echo "{ month: '".$value['0']['year']."-".$value['0']['month']."', value: ".$value['0']['count']." },";?>
   
    <?php }?>
  ],
  // The name of the data record attribute that contains x-values.
  xkey: 'month',
  xLabels:'month',
  // A list of names of data record attributes that contain y-values.
  ykeys: ['value'],
  // Labels for the ykeys -- will be displayed when you hover over the
  // chart.
  labels: ['Sticker']
});
</script>
<?php }else if(isset($chart['0']['0']['year'])){ ?>
<script>
	new Morris.Line({
  // ID of the element in which to draw the chart.
  element: 'morris-line-chart',
  // Chart data records -- each entry in this array corresponds to a point on
  // the chart.
  data: [
  <?php foreach ($chart As $key=>$value){?>
    <?php echo "{ year: '".$value['0']['year']."', value: ".$value['0']['count']." },";?>
   
    <?php }?>
  ],
  // The name of the data record attribute that contains x-values.
  xkey: 'year',
  xLabels:'year',
  // A list of names of data record attributes that contain y-values.
  ykeys: ['value'],
  // Labels for the ykeys -- will be displayed when you hover over the
  // chart.
  labels: ['Sticker']
});
</script>

<?php }?>
<script>
Morris.Donut({
  element: 'morris-donut',
  data: [
  <?php foreach($mostused as $key=>$value){?>
    <?php echo "{label: '".ucfirst($value['name']['Sticker']['name'])."', value: '".$value['value']."' },";?>
    <?php } ?>
  ]
});
</script>
<script>
	Morris.Bar({
  element: 'morris-bar',
  data: [
  <?php foreach($result as $key=>$value){?>
  	
  	<?php echo "{ y: '".$value['name']."', p: ".$value['packs']." },";?>
  
  <?php } ?>
  ],
  xkey: 'y',
  ykeys: 'p',
  labels: ['Packs','packs']
});
</script>
<script>
	setTimeout(function(){
   window.location.reload(1);
}, 60000);
</script>