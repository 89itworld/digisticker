<?php
	class UsersController extends AppController{
		var $components=array('Session','Checkurl','Cookie');
		
		 public function beforeFilter() {
		        parent::beforeFilter();
		        //cookie setings   
		        $this->Cookie->name = 'stickerapp';
		        $this->Cookie->time = '2 weeks';  // or '1 hour'
		        $this->Cookie->path = '/';
		        $this->Cookie->domain = 'digi-stickers.com';
		        $this->Cookie->secure = false;
		        $this->Cookie->key = '39lbkutg1i2l0kta6785d8qki5';
		        $this->Cookie->httpOnly = true;
    	}
		
		public function index(){
			$this->layout='login';
			App::Import('Model','User');
			$this->User=new User();
			if(!$this->Session->check('id')){
				if($this->Cookie->check('user')){
					$result=$this->User->find('first',array('conditions'=>array('email'=>$this->Cookie->read('user.email'),'password'=>$this->Cookie->read('user.password'),'user_type'=>1)));
					if($result){
						$this->Session->write('id',$result['User']['id']);
						$this->redirect(array('controller'=>'Dashboard','action'=>'index'));
				}
				// $this->Cookie->destroy('user');
				
				}else{
					if($this->request->is('post')){
					// pr($this->request->data);die;
						$result=$this->User->find('first',array('conditions'=>array('email'=>$this->Checkurl->clean($this->request->data['User']['username']),'password'=>md5($this->Checkurl->clean($this->request->data['User']['password'])),'user_type'=>1)));
					// pr($result);die;
						if($result){
							if($this->request->data['User']['remember']==1){
								$this->Cookie->write('user',array('email'=>$this->Checkurl->clean($this->request->data['User']['username']),'password'=>md5($this->Checkurl->clean($this->request->data['User']['password']))));
							}else{
								if($this->Cookie->check('user')){
									$this->Cookie->destroy('user');
								}
							}
							$this->Session->write('id',$result['User']['id']);
						
							$this->redirect(array('controller'=>'Dashboard','action'=>'index'));
						}else{
							$this->Session->setFlash(" Invalid Username or Password.",'flash_custom');
							$this->redirect(array('controller'=>'Users','action'=>'index'));
						}
					}
				}
				
			}else{
				$this->redirect(array('controller'=>'Dashboard','action'=>'index'));
			}


		}
		public function logout(){
			$this->layout=false;
			$this->render(false);
			$this->Session->destroy();
			if($this->Cookie->check('user')){
				$this->Cookie->destroy('user');
			}
			
			$this->redirect(array('controller'=>'Users','action'=>'index'));
		}
		public function settings(){
			if($this->Session->check('id')){
				// pr($this->referer());die;
				$this->layout='admin';
				$this->loadModel('User');
				$this->loadModel('Email');
				$cmail=$this->Email->find('first',array('fields'=>array('contactemail','sendingemail','port','password','host','transport'),'conditions'=>array('id'=>1)));
				$this->set('cmail',$cmail['Email']['contactemail']);
				$this->set('smail',$cmail['Email']['sendingemail']);
				$this->set('port',$cmail['Email']['port']);
				$this->set('pass',base64_decode($cmail['Email']['password']));
				$this->set('host',$cmail['Email']['host']);
				$this->set('trans',$cmail['Email']['transport']);
				if($this->request->is('post')){
					if(!empty($this->request->data['User']['cmail'])){
						$this->Email->save(array('id'=>1,'contactemail'=>$this->request->data['User']['cmail']));
						$this->Session->setFlash('Changed Successfully','flash_success');
					}else if(!empty($this->request->data['User']['smail']) && !empty($this->request->data['User']['port']) && !empty($this->request->data['User']['password']) && !empty($this->request->data['User']['host']) && !empty($this->request->data['User']['transport'])){
						$this->Email->save(array('id'=>1,'sendingemail'=>$this->request->data['User']['smail'],'port'=>$this->request->data['User']['port'],'password'=>base64_encode($this->request->data['User']['password']),'host'=>$this->request->data['User']['host'],'transport'=>$this->request->data['User']['transport']));
						$this->Session->setFlash('Changed Successfully','flash_success');
					}else{
						$result=$this->User->find('first',array('fields'=>'password','conditions'=>array('id'=>$this->Session->read('id'))));
						if(!empty($result)){
							if(md5($this->request->data['User']['oldpassword'])===$result['User']['password']){
								if($this->request->data['User']['newpassword']===$this->request->data['User']['cnfrmpass']){
									if(strlen($this->request->data['User']['newpassword'])>8){
										$this->User->save(array('id'=>$this->Session->read('id'),'password'=>md5($this->request->data['User']['newpassword'])));
										$this->redirect(array('controller'=>'Users','action'=>'logout'));
									}else{
										$this->set('nperr',"Length Should be more than 8 characters.");
									}
								}else{
									$this->set('cnperr',"Passwords do not match");
								}
									
							}else{
								$this->set('operr',"Invalid Password");
								// $this->redirect(array('controller'=>'Users','action'=>'settings'));
							}
						}
					}

				}
			}else{
				$this->redirect(array('controller'=>'Users','action'=>'index'));
			}
		}
		
		public function resetPassword(){
			$this->layout='resetpass';
			if($this->request->is('post')){
				if(!empty($this->request->data)){
					$this->loadModel('User');	
					$result=$this->User->find('first',array('conditions'=>array('email'=>$this->Checkurl->clean($this->request->data['User']['username']),'user_type'=>1)));
					if(!empty($result)){
						// $this->User->updateAll(array('change_pass_req'=>time()),array('email'=>$this->Checkurl->clean($this->request->data['User']['username'])));
						$to=$result['User']['email'];
						$sub="Reset Password";
						$key="1sa35v";
						$time=time();
						$msg="You requested to change your Password. \nThe Link will expire in 15 minutes. \nPlease visit this link : http://digi-stickers.com/Users/changePassword?refrenceid=".str_replace('=',$key,base64_encode(base64_encode($result['User']['id'])."^".base64_encode($result['User']['email'])."^".base64_encode($time)));
						$this->Checkurl->sendMail($to,$sub,$msg);
						$this->Session->setFlash('An e-mail is sent to you. Please check your e-mail','flash_success');
						$this->redirect(array('controller'=>'Users','action'=>'index'));
					}else{
						$this->set('error',"Invalid email");
					}
				}
			}
		}	
				
		public function changePassword(){
			$this->layout='resetpass';
			if(!empty($this->params['url']['refrenceid'])){
				$data=explode('^',base64_decode(str_replace('1sa35v','=',$this->params['url']['refrenceid'])));
				$id=base64_decode($data['0']);
				$email=base64_decode($data['1']);
				$time=base64_decode($data['2']);
				$this->loadModel('User');
				// pr(date("Y-m-d H:i:s",$time));
				$user=$this->User->find('first',array('conditions'=>array('email'=>$email)));
					if(!empty($user)){
						if($user['User']['email']==$email && ((strtotime(date("Y-m-d H:i:s",time()))-strtotime(date("Y-m-d H:i:s",$time)))/60)<15){
							if($this->request->is('post')){
								if($this->request->data['User']['password']==$this->request->data['User']['cpassword']){
									if($this->User->save(array('id'=>$id,'password'=>md5($this->Checkurl->clean($this->request->data['User']['password']))))){
										$this->Session->setFlash("Password changed successfully.",'flash_success');
										$this->redirect(array('controller'=>'Users','action'=>'index'));
									}
								}else{
									$this->set('error',"Password do not match");
								}
							}
						}else{
							$this->Session->setFlash('Link Expired try again.','flash_custom');
							$this->redirect(array('controller'=>'Users','action'=>'index'));
						}
					}else{
						$this->Session->setFlash('Link Expired try again.','flash_custom');
						$this->redirect(array('controller'=>'Users','action'=>'index'));
					}
			}else{
				$this->redirect(array('controller'=>'Users','action'=>'index'));
			}
			
		}		
			
		
	}
?>