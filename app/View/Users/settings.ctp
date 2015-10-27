<div id="page-wrapper">
	<?php 
		echo $this->Session->flash();
	?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header"> Settings</h1>
				<ol class="breadcrumb">
					<li>
						<i class="fa fa-dashboard"></i>
						Dashboard
					</li>
					<li class="active">
						<i class="fa fa-cog"></i>
						Settings
					</li>
				</ol>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-8">
				<h3>Change Password</h3>
<?php echo $this->Form->Create('User',array('controller'=>'Users','action'=>'settings','class'=>'form-horizontal')); ?>
				  <div class="form-group">
				    <label for="inputEmail3" class="col-sm-2 control-label">Old Password</label>
				    <div class="col-sm-10">
				      <?php echo $this->Form->input('oldpassword',array('id'=>'oldpass','class'=>'form-control','type'=>'password','label'=>false,'div'=>false,'placeholder'=>'Old Password','required')); ?>
				<span id="operr"><?php if(isset($operr)){echo $operr;}?></span>
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="inputPassword3" class="col-sm-2 control-label">New Password</label>
				    <div class="col-sm-10">
				      <?php echo $this->Form->input('newpassword',array('id'=>'newpass','class'=>'form-control','type'=>'password','label'=>false,'div'=>false,'placeholder'=>'New Password','required')); ?>
				<span id="nperr"><?php if(isset($nperr)){echo $nperr;}?></span>
				    </div>
				  </div>
				   <div class="form-group">
				    <label for="inputPassword3" class="col-sm-2 control-label">Confirm Password</label>
				    <div class="col-sm-10">
				     <?php echo $this->Form->input('cnfrmpass',array('id'=>'cnewpass','class'=>'form-control','type'=>'password','label'=>false,'div'=>false,'placeholder'=>'New Password','required')); ?>
				<span id="cnperr"><?php if(isset($cnperr)){echo $cnperr;}?></span>
				    </div>
				  </div>
				  
				  <div class="form-group">
				    <div class="col-sm-offset-2 col-sm-10">
				      <input type="submit" class="btn btn-primary" value="Change Password"/>
				    </div>
				  </div>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-8">
		<?php echo $this->Form->Create('User',array('url'=>array('controller'=>'Users','action'=>'settings'),'class'=>'form-horizontal')); ?>
				  <div class="form-group">
				    <label class="col-sm-2">Contact Email</label>
				    <div class="col-sm-10">
				      <?php echo $this->Form->input('cmail',array('class'=>'form-control','placeholder'=>'email','type'=>'email','default'=>$cmail,'div'=>false,'label'=>false));?>
				    	<span style="color:red">*Appuser's queries will be sent to this email. Currently used email is shown by default.</span>
				    </div>
				  </div>
				  <button type="submit" class="col-md-offset-2 col-md-2 btn btn-primary">Change Email</button>
			<?php echo $this->Form->end(); ?>
			</div>
		</div>
		<br/>
		<div class="row">
			<div class="col-lg-8">
				
				<?php echo $this->Form->Create('User',array('url'=>array('controller'=>'Users','action'=>'settings'),'class'=>'form-horizontal')); ?>
				  <div class="form-group">
				    <label class="col-sm-2">Sending Email</label>
				    <div class="col-sm-10">
				      <?php echo $this->Form->input('smail',array('class'=>'form-control','placeholder'=>'email','type'=>'email','default'=>$smail,'div'=>false,'label'=>false));?>
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="col-sm-2">PORT</label>
				    <div class="col-sm-10">
				      <?php echo $this->Form->input('port',array('class'=>'form-control','placeholder'=>'port','type'=>'number','default'=>$port,'div'=>false,'label'=>false));?>
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="col-sm-2">Password</label>
				    <div class="col-sm-10">
				      <?php echo $this->Form->input('password',array('class'=>'form-control','placeholder'=>'password','type'=>'password','default'=>$pass,'div'=>false,'label'=>false));?>
				    <span style="color:red">*Password for this email account.</span>
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="col-sm-2">Host</label>
				    <div class="col-sm-10">
				      <?php echo $this->Form->input('host',array('class'=>'form-control','placeholder'=>'host','type'=>'text','default'=>$host,'div'=>false,'label'=>false));?>
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="col-sm-2">Transport</label>
				    <div class="col-sm-10">
				      <?php echo $this->Form->input('transport',array('class'=>'form-control','placeholder'=>'transport','type'=>'text','default'=>$trans,'div'=>false,'label'=>false));?>
				    <span style="color:red">*Make sure you enter all the fields correctly. Currently used settings are shown by default.</span>
				    </div>
				  </div>
				  <button type="submit" class="col-md-offset-2 col-md-2 btn btn-primary">Change Email</button>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>
