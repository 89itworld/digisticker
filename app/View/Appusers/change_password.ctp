<div class="container">
	<?php 
		echo $this->Session->flash();
	?>
    <div class="row">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body new-class">
                        <div class="text-center">
                          <?php echo $this->Html->image('lost_password.png');?>
                          <h3 class="text-center">Forgot Password?</h3>
                          <p>If you have forgotten your password - reset it here.</p>
                            <div class="panel-body">
                              
                              <?php echo $this->Form->create('Appuser');?><!--start form--><!--add form action as needed-->
                                <fieldset style="margin-top:18px">
                                  <div class="form-group">
                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                      <!--EMAIL ADDRESS-->
                                      <?php echo $this->Form->input('password',array('id'=>'password','class'=>'form-control','label'=>false,'div'=>false,'required','placeholder'=>'New Password'));?>
                                    </div>
                                    <br/>
                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                      <!--EMAIL ADDRESS-->
                                      <?php echo $this->Form->input('cpassword',array('id'=>'cpassword','class'=>'form-control','type'=>'password','label'=>false,'div'=>false,'required','placeholder'=>'Confirm Password'));?>
                                    </div>
                                    <span style="color:red"><?php if(isset($error)){echo $error;}?></span>
                                  </div>
                                  <div class="form-group">
                                    <input class="btn btn-lg btn-primary btn-block" value="Reset My Password" type="submit">
                                  </div>
                                </fieldset>
                             <?php echo $this->Form->end();?><!--/end form-->
                              
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>