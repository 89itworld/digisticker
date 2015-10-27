	<body>
		<nav class="navbar-inverse">
			<?php echo $this->Html->image('logo.png',array('class'=>'logo'));?>
		</nav>
		<div class="container">
			  	<?php 
					echo $this->Session->flash();
				?>
			<div class="row vertical-offset-100">
				
				<div class="loginpanel col-md-4 col-md-offset-4">
					<?php echo $this->Html->image('login.png',array('class'=>'login-img'));?>
					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="row-fluid user-row">
								<?php echo $this->Html->image('user-login.png',array('class'=>'center-block'));?>
							</div>
						</div>
						<div class="panel-body">
							<?php echo $this->Form->create('User',array('class'=>'form-signin')); ?>
								<fieldset>
									<label class="panel-login"> <div class="login_result"></div> </label>
									<?php echo $this->Form->input('username',array('class'=>'form-control','placeholder'=>'Username','id'=>'username','type'=>'email','div'=>false,'label'=>false,'required'));?>
									<!-- <input class="form-control" placeholder="Username" id="username" type="text"> -->
									<?php echo $this->Form->input('password',array('class'=>'form-control','placeholder'=>'Password','id'=>'password','type'=>'password','div'=>false,'label'=>false,'required'));?>
									<!-- <input class="form-control" placeholder="Password" id="password" type="password"> -->
									<div class="checkbox">
										<label>
										<?php echo $this->Form->input('remember',array('type'=>'checkbox','label'=>false,'div'=>false));?>
											Remember Me
										</label>
										</div>
								
									<input class="btn btn-lg btn-success btn-block" type="submit" id="login" value="Login »">
									<div class="pull-right"><h4><?php echo $this->Html->link('Forgot Password?',array('controller'=>'Users','action'=>'resetPassword'));?></h4></div>
								</fieldset>
							<?php echo $this->Form->end();?>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</body>
