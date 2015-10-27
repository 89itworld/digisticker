<div id="page-wrapper">
	<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">
            View Message </h1>
            <ul class="list-inline pull-right a-tag">
            	<li>
             		<?php echo $this->Html->link('<i class="fa fa-envelope"></i> Inbox ',array('controller'=>'Messages','action'=>'index'),array('escape'=>false,'class'=>'pull-right a-tag')); ?></a>
            	</li>
            </ul>
            <ol class="breadcrumb">
	            <li class="active">
    	            <i class="fa fa-dashboard "></i> Dashboard
                </li>
                <li class="active">
                    <i class="fa fa-search"></i> View Message
                </li>
        	</ol>
		</div>
	</div>
    <div class="row message">
    	<div class='col-md-10 col-md-offset-1'>
    		<h3>Subject: <?php echo $subject;?></h3>
    		<?php echo $this->Html->image('dummypicture.png',array('class'=>'img-circle','width'=>'40'));?>
    		<!-- <img src="../../img/dummypicture.png" alt="" class="img-circle" width="40"/> -->
    		<i class="fa fa-envelope-o message-color"></i>
    		<strong>From: </strong>
    		<?php echo $from;?>
    		<span class="pull-right date-div"><?php echo date("F j, Y, g:i A",strtotime($time));?></span>
    		<p><strong>Message</strong></p>
    		<hr/>
    		<p><?php echo $msg;?></p>
    	</div>
    </div>            
	
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){

//Check if the current URL contains '#'
if(document.URL.indexOf("#")==-1)
{
// Set the URL to whatever it was plus "#".
url = document.URL+"#";
location = "#";

//Reload the page
location.reload(true);

}
});
</script> 