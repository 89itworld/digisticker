<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- <a class="navbar-brand" href="#">Admin Panel</a> -->
                <?php echo $this->Html->link('Digi-Stickers',array('controller'=>'Dashboard','action'=>'index'),array('class'=>'navbar-brand','escape'=>false)); ?>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-envelope"></i><?php if(count($message)!=0){ ?> <span class="badge"><?php echo count($message);?></span><?php }?> Messages </a>
                    <ul class="dropdown-menu message-dropdown">
					<?php foreach($message as $key=>$value){?>
						<?php
							$datetimearray = explode(" ", $value['Message']['created']);
							$time = $datetimearray[1];
							$date = date('d-m-Y',strtotime($datetimearray[0]));
						?>
                        <li class="message-preview">
                            <?php echo $this->Html->link('<div class="media">
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong>'.$value["Message"]["from"].'</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> On '.$date.' at '.$time.'</p>
                                        <p>'. $value["Message"]["subject"].'</p>
                                    </div>
                                </div>',array('controller'=>'Messages','action'=>'view', base64_encode($value['Message']['id'])), array('escape' => false)); ?>
                        </li>
                        <?php }?>
                        <li class="message-footer">
                            <?php echo $this->Html->link('Read All Messages',array('controller'=>'Messages','action'=>'index')); ?>
                        </li>
                    </ul>
                </li>
                
                
                
                        <li>
                            <?php echo $this->Html->link('<i class="fa fa-fw fa-gear"></i> Settings',array('controller'=>'Users','action'=>'settings'),array('escape'=>false));?>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <?php echo $this->Html->link('<i class="fa fa-fw fa-power-off"></i> Log Out',array('controller'=>'Users','action'=>'logout'),array('escape'=>false));?>
                        </li>
                
                
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="<?php echo (!empty($this->params['controller']) && ($this->params['controller']=='Dashboard') || ($this->params['controller']=='Users') || ($this->params['controller']=='Messages'))?'active' :'inactive' ?>">
                        <?php echo $this->Html->link('<i class="fa fa-fw fa-dashboard"></i> Dashboard <span></span>',array('controller'=>'Dashboard','action'=>'index'),array('escape'=>false)); ?>
                    </li>
                    <li class="<?php echo (!empty($this->params['controller']) && ($this->params['controller']=='Categories') )?'active' :'inactive' ?>">
                        <?php echo $this->Html->link("<i class='fa fa-fw fa-bar-chart-o'></i> Manage Categories <span></span>",array('controller'=>'Categories','action'=>'index'), array('escape' => false)); ?>
                    </li>
                    <li class="<?php echo (!empty($this->params['controller']) && ($this->params['controller']=='Stickers') )?'active' :'inactive' ?>">
                        <?php echo $this->Html->link("<i class='fa fa-fw fa-star-half-o'></i> Manage Stickers <span></span>",array('controller'=>'Stickers','action'=>'index'), array('escape' => false)); ?>
                    </li>
                    <li class="<?php echo (!empty($this->params['controller']) && ($this->params['controller']=='Appusers') )?'active' :'inactive' ?>">
                        <?php echo $this->Html->link("<i class='fa fa-fw fa-users'></i> Manage App Users <span></span>",array('controller'=>'Appusers','action'=>'index'), array('escape' => false)); ?>
                    </li>
                    <li class="<?php echo (!empty($this->params['controller']) && ($this->params['controller']=='Notifications') )?'active' :'inactive' ?>">
                        <?php echo $this->Html->link("<i class='fa fa-fw fa-bell'></i> Push Notifications <span></span>",array('controller'=>'Notifications','action'=>'index'), array('escape' => false)); ?>
                    </li>
                    <li class="<?php echo (!empty($this->params['controller']) && ($this->params['controller']=='Reports') )?'active' :'inactive' ?>">
                        <?php echo $this->Html->link("<i class='fa fa-fw fa-file-text'></i> Generate Reports <span></span>",array('controller'=>'Reports','action'=>'index'), array('escape' => false)); ?>
                    </li>
                    <!-- <li>
                        <a href="tables.html"><i class="fa fa-fw fa-table"></i> Tables</a>
                    </li>
                    <li>
                        <a href="forms.html"><i class="fa fa-fw fa-edit"></i> Forms</a>
                    </li>
                    <li>
                        <a href="bootstrap-elements.html"><i class="fa fa-fw fa-desktop"></i> Bootstrap Elements</a>
                    </li>
                    <li>
                        <a href="bootstrap-grid.html"><i class="fa fa-fw fa-wrench"></i> Bootstrap Grid</a>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> Dropdown <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo" class="collapse">
                            <li>
                                <a href="#">Dropdown Item</a>
                            </li>
                            <li>
                                <a href="#">Dropdown Item</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="blank-page.html"><i class="fa fa-fw fa-file"></i> Blank Page</a>
                    </li>
                    <li>
                        <a href="index-rtl.html"><i class="fa fa-fw fa-dashboard"></i> RTL Dashboard</a>
                    </li> -->
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>