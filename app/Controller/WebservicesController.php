<?php
class WebservicesController extends AppController{
		var $components=array('Checkurl');	
		public function categories(){
			$this->autoRender=false;
			if(!empty($this->params['url']['uid'])){
				$this->loadModel('Cart');
				$this->loadModel('Categorie');
				$this->loadModel('Sticker');
				$count=$this->Cart->Find('count',array('conditions'=>array('user_id'=>$this->params['url']['uid'])));
				$categories=$this->Categorie->find('all',array('fields'=>array('id','name','image'),'conditions'=>array('is_active'=>1,'is_deleted'=>0),'order'=>'name ASC'));
				if(!empty($categories)){
					$result['status']='1';
					$result['message']='success';
					foreach($categories as $key=>$value){
						$r=$this->Sticker->find('count',array('conditions'=>array('category_id'=>$value['Categorie']['id'])));
						if($r!=0){
							$result['data'][]=array('id'=>$value['Categorie']['id'],'name'=>$value['Categorie']['name'],'image'=>Router::Url('/img/uploads/categories/',true).$value['Categorie']['image']);
						}
					}
				}else{
					$result['status']='0';
					$result['message']='fail';
					$result['data']='no categories found';
				}
				$result['count']=$count;
				echo json_encode($result);
			}
		}
		public function AllMyCat(){
			$this->autoRender=false;
			if(!empty($this->params['url']['uid'])){
				$this->loadModel('Cart');
				$this->loadModel('Categorie');
				$this->loadModel('Sticker');
				$uid=$this->params['url']['uid'];
				$count=$this->Cart->Find('count',array('conditions'=>array('user_id'=>$uid)));
				$cond="Categorie.id=Mysticker.category_id";
				$conditions="WHERE Categorie.is_active=1 AND Categorie.is_deleted=0 AND Mysticker.user_id='".$uid."'";
				$categories=$this->Categorie->find('all',array('fields'=>array(' DISTINCT id','name','image'),'joins'=>array(array('table'=>'mystickers','alias'=>'Mysticker','type'=>'inner','conditions'=>$cond)),'conditions'=>$conditions,'order'=>'name ASC'));
				if(!empty($categories)){
					$result['status']='1';
					$result['message']='success';
					foreach($categories as $key=>$value){
						$r=$this->Sticker->find('count',array('conditions'=>array('category_id'=>$value['Categorie']['id'])));
						if($r!=0){
							$result['data'][]=array('id'=>$value['Categorie']['id'],'name'=>$value['Categorie']['name'],'image'=>Router::Url('/img/uploads/categories/',true).$value['Categorie']['image']);
						}
					}
					
				}else{
					$result['status']='0';
					$result['message']='fail';
					$result['data']='no categories found';
				}
			}
			$result['count']=$count;
			echo json_encode($result);
		}
		
		public function allstickers(){
			$this->autoRender=false;
			if(!empty($this->params['url']['uid']) && !empty($this->params['url']['cid'])){
				$this->loadModel('Sticker');
				$this->loadModel('Categorie');
				$uid=$this->params['url']['uid'];
				$cid=$this->params['url']['cid'];
				$cond="Sticker.id=Purchasedsticker.sticker_id";
				$conditions="(`Purchasedsticker`.`user_id` = $uid  AND `Sticker`.`is_active` = 1 AND `Sticker`.`is_deleted` = 0 AND `Sticker`.`category_id` = $cid) or (`Sticker`.`category_id`=$cid AND `Sticker`.`type_id` = 1)";
				$stickers=$this->Sticker->find('all',array('fields'=>array(' DISTINCT Sticker.id','Sticker.name','Sticker.image','Sticker.category_id'),'joins'=>array(array('table'=>'purchasedstickers','alias'=>'Purchasedsticker','type'=>'left','conditions'=>$cond)),'conditions'=>$conditions,'order'=>'Sticker.name'));
				if(!empty($stickers)){
					$result['status']='1';
					$result['message']='success';
					foreach($stickers as $key=>$value){
						$catname=$this->Categorie->find('first',array('fields'=>'name','conditions'=>array('id'=>$value['Sticker']['category_id'])));
						 $result['data'][]=array('id'=>$value['Sticker']['id'],'name'=>$value['Sticker']['name'],'image'=>Router::Url('/img/uploads/',true).$value['Sticker']['image'],'category'=>$catname['Categorie']['name']);
					}
				}else{
					$result['status']='0';
					$result['message']='fail';
					$result['data']='no stickers found';
				}
				echo json_encode($result);
			}
		}
		
		public function getStickersByCat(){
			$this->autoRender=false;
			if(!empty($this->params['url']['category_id']) && !empty($this->params['url']['uid'])){
				$uid=$this->params['url']['uid'];
				$this->loadModel('Sticker');
				$this->loadModel('Purchasedsticker');
				$this->loadModel('Cart');
				$count=$this->Cart->Find('count',array('conditions'=>array('user_id'=>$uid)));
				$uid=$this->params['url']['uid'];
				$cid=$this->params['url']['category_id'];
				$conditions="`Sticker`.`modified` >= NOW() - INTERVAL 2 WEEK";
				$nsticker=$this->Sticker->find('list',array('fields'=>array('id','name','image','type_id'),'conditions'=>$conditions));
				$psticker=$this->Purchasedsticker->find('list',array('fields'=>array('sticker_id'),'conditions'=>array('user_id'=>$uid)));
				$stickers=$this->Sticker->find('all',array('fields'=>array('DISTINCT Sticker.id','Sticker.name','Sticker.image','Sticker.type_id'),'conditions'=>array('category_id'=>$cid,'is_active'=>1,'is_deleted'=>0),'order'=>'name ASC'));
				if(!empty($stickers)){
					$result['status']='1';
					$result['message']='success';
					foreach($stickers as $key=>$value){
						if(in_array($value['Sticker']['id'],$psticker)){
							$type="1";
						}else{
			        		$type=$value['Sticker']['type_id'];
			        	}
						if(in_array($value['Sticker']['name'],$nsticker)){
							$is_new="1";
						}else{
							$is_new="0";
						}
						$result['data'][]=array('id'=>$value['Sticker']['id'],'name'=>$value['Sticker']['name'],'image'=>Router::Url('/img/uploads/',true).$value['Sticker']['image'],'type'=>$type,'is_new'=>$is_new);
					}
				}else{
					$result['status']='0';
					$result['message']='fail';
					$result['data']='no stickers found';
				}
				
			}else{
				$result['status']='0';
				$result['message']='fail';
				$result['data']='category or userid not found';
			}
		$result['count']=$count;
		echo json_encode($result);	
	}
		public function search(){
			$this->autoRender=false;
			if(!empty($this->params['url']['q']) && !empty($this->params['url']['uid'])){
				$keyword=$this->params['url']['q'];
				$uid=$this->params['url']['uid'];
				$this->loadModel('Sticker');
				$this->loadModel('Purchasedsticker');
				$this->loadModel('Cart');
				$count=$this->Cart->Find('count',array('conditions'=>array('user_id'=>$uid)));
				$psticker=$this->Purchasedsticker->find('list',array('fields'=>'sticker_id','conditions'=>array('user_id'=>$uid)));
				$cond="Sticker.category_id = Categorie.id";
				$conditions="WHERE (Categorie.name LIKE '%".$keyword."%' AND Categorie.is_active=1 AND Categorie.is_deleted=0) OR (Sticker.name LIKE '%".$keyword."%' AND Sticker.is_active=1 AND Sticker.is_deleted=0)";
				$stickers=$this->Sticker->find('all',array('fields'=>array(' DISTINCT Sticker.id','Sticker.name','Sticker.image','Sticker.category_id','Sticker.type_id'),'joins'=>array(array('table'=>'categories','alias'=>'Categorie','type'=>'left','conditions'=>$cond)),'conditions'=>$conditions,'order'=>'Sticker.name ASC'));
				if(!empty($stickers)){
					$result['status']='1';
					$result['message']='success';
					foreach($stickers as $key=>$value){
						if(in_array($value['Sticker']['id'],$psticker)){
			        		$type="1";
			        	}else{
			        		$type=$value['Sticker']['type_id'];
			        	}	
						$result['data'][]=array('id'=>$value['Sticker']['id'],'name'=>$value['Sticker']['name'],'image'=>Router::Url('/img/uploads/',true).$value['Sticker']['image'],'type'=>$type);
					}
				}else{
					$result['status']='0';
					$result['message']='fail';
					$result['data']='no sticker found';
				}
				$result['count']=$count;
				echo json_encode($result);
			}
		}
		
		public function resendCode(){
			$this->autoRender=false;
			if(!empty($this->params['url']['email'])){
				$this->loadModel('Appuser');
				$res=$this->Appuser->find('first',array('fields'=>array('activationcode','email'),'conditions'=>array('email'=>$this->params['url']['email'])));
				if(!empty($res)){
					$result['status']='1';
					$result['message']='success';
					$to=$res['Appuser']['email'];
					$sub="Your Digi Stickers Email Verification Code";
					$msg = "Hello,\n\nYour email activation code is : ".$res['Appuser']['activationcode']."\n\nThank you for registering with Digi Stickers!\n\nSincerely,\n\nThe Digi Stickers Team";
					$this->Checkurl->sendMail($to,$sub,$msg);
					$result['data']="activation resent successfully";
				}else{
					$result['status']='0';
					$result['message']='fail';
					$result['data']='User not found';
				}
				echo json_encode($result);
			}
		}

		public function submitCode(){
			$this->autoRender=false;
			if(!empty($this->params['url']['id']) && !empty($this->params['url']['code'])){
				$this->loadModel('Appuser');
				$dat=$this->Appuser->find('first',array('conditions'=>array('id'=>$this->params['url']['id'],'activationcode'=>$this->params['url']['code'])));
				if(!empty($dat)){
					$this->Appuser->save(array('id'=>$dat['Appuser']['id'],'is_active'=>1,'conditions'=>array('id'=>$dat['Appuser']['id'])));
					$result['status']='1';
					$result['message']='success';
					$result['id']=$dat['Appuser']['id'];
				}else{
					$result['status']='0';
					$result['message']='fail';
					$result['data']='incorrect code';
				}	
				echo json_encode($result);
			}
		}
		
		public function addToFav(){
			$this->autoRender=false;
			if(!empty($this->params['url']['uid']) && !empty($this->params['url']['sid'])){
				$this->loadModel('Appuser');
				$this->loadModel('Sticker');
				$this->loadModel('Favsticker');
				$usercheck=$this->Appuser->find('first',array('fields'=>'id','conditions'=>array('id'=>$this->params['url']['uid'],'is_active'=>1)));
				$stickercheck=$this->Sticker->find('first',array('fields'=>'id','conditions'=>array('id'=>$this->params['url']['sid'],'is_active'=>1,'is_deleted'=>0)));
				if(!empty($usercheck) && !empty($stickercheck)){
					$favcheck=$this->Favsticker->find('first',array('conditions'=>array('user_id'=>$this->params['url']['uid'],'sticker_id'=>$this->params['url']['sid'])));
					if(empty($favcheck)){
						$data=array('user_id'=>$usercheck['Appuser']['id'],'sticker_id'=>$stickercheck['Sticker']['id']);
						if($this->Favsticker->save($data)){
							$result['status']='1';
							$result['message']='success';
							$result['data']="Sticker added successfully";
						}else{
							$result['status']='0';
							$result['message']='fail';
							$result['data']="Sticker couldn't be added";
						}
					}else{
						$result['status']='0';
						$result['message']='fail';
						$result['data']="sticker already added";
					}
					
				}else{
					$result['status']='0';
					$result['message']='fail';
					$result['data']="user or sticker not found";
				}
				echo json_encode($result);
			}
		}
		
		public function getFav(){
			$this->autoRender=false;
			if(!empty($this->params['url']['uid'])){
				$this->loadModel('Favsticker');
				$this->loadModel('Sticker');
				$this->loadModel('Cart');
				$uid=$this->params['url']['uid'];
				$count=$this->Cart->Find('count',array('conditions'=>array('user_id'=>$uid)));
				$cond="Sticker.id=Favsticker.sticker_id";
				$conditions="(Favsticker.user_id = $uid AND Sticker.is_active = 1 AND Sticker.is_deleted = 0)";
				$data=$this->Sticker->find('all',array('fields'=>array( 'DISTINCT Sticker.id','Sticker.name','Sticker.image','Sticker.category_id'),'joins'=>array(array('table'=>'favstickers','alias'=>'Favsticker','type'=>'inner','conditions'=>$cond)),'conditions'=>$conditions,'order'=>'Sticker.name ASC'));
		        if(!empty($data)){
		        	$result['status']='1';
					$result['message']='success';
		        	foreach($data as $key=>$value){
		        		$result['data'][]=array('id'=>$value['Sticker']['id'],'name'=>$value['Sticker']['name'],'image'=>Router::Url('/img/uploads/',true).$value['Sticker']['image']);
		        	}
					
		        }else{
		        	$result['status']='0';
					$result['message']='fail';
					$result['data']="Sticker Not Found";
		        }
				$result['count']=$count;
		        echo json_encode($result);
			}
		}

		public function deleteFav(){
			if(!empty($this->params['url']['uid']) && !empty($this->params['url']['sid'])){
				$this->autoRender=false;
				$this->loadModel("Favsticker");
				$data=$this->Favsticker->find('first',array('fields'=>'id','conditions'=>array('user_id'=>$this->params['url']['uid'],'sticker_id'=>$this->params['url']['sid'])));
				if($this->Favsticker->delete($data['Favsticker']['id'])){
					$result['status']='1';
					$result['message']='success';
					$result['data']="Favourite deleted successfully";
				}else{
					$result['status']='0';
					$result['message']='fail';
					$result['data']="Some error occured";
				}
				echo json_encode($result);
			}
		}
		
		public function contact(){
			$this->autoRender=false;
			$this->loadModel('Email');
			$email=$this->Email->find('first',array('fields'=>'contactemail','conditions'=>array('id'=>1)));
			if(!empty($this->params['url']['uid']) && !empty($this->params['url']['subject']) && !empty($this->params['url']['message'])){
				$this->loadModel('Appuser');
				$this->loadModel('Message');
				$data=$this->Appuser->find('first',array('fields'=>'email','conditions'=>array('id'=>$this->params['url']['uid'])));
				$to=$data['Appuser']['email'];
				$sub="Feedback regarding ".$this->params['url']['subject'];
				$message=$this->params['url']['message'];
				$msg="Thank you for contacting the Digi Stickers Team.\n We will review your inquiry and get back to you soon! \n\n <strong>Message:</strong> ".$message;
				$to2=$email['Email']['contactemail'];
				$sub2="Feedback regarding ".$this->params['url']['subject'];
				$msg2="Feedback recieved From: </b>".$data['Appuser']['email']."</b>\n".$message;
				if(!empty($data)){
					$this->Message->save(array('from'=>$data['Appuser']['email'],'subject'=>$sub,'msg'=>$message));
					$this->Checkurl->sendeeMail($to,$sub,$msg);
					$this->Checkurl->sendeeMail($to2,$sub2,$msg2);
					$result['status']='1';
					$result['message']='success';
					$result['data']="Feedback recieved";
				}else{
					$result['status']='0';
					$result['message']='fail';
					$result['data']="User not found";
				}
				echo json_encode($result);
			}
		}
		
		public function contact_new(){
            $this->autoRender=false;
            $this->loadModel('Email');
            $email=$this->Email->find('first',array('fields'=>'contactemail','conditions'=>array('id'=>1)));
            if(!empty($this->params['url']['uid']) && !empty($this->params['url']['subject']) && !empty($this->params['url']['message']) && !empty($this->params['url']['email'])){
                $this->loadModel('Newuser');
                $this->loadModel('Message');
                $this->loadModel('Useremail');
                $data=$this->Useremail->find('first',array('fields'=>'email','conditions'=>array('user_id'=>$this->params['url']['uid'])));
                if(!empty($data)){
                    if($data['Useremail']['email']!=$this->params['url']['email']){
                        $this->Useremail->save(array('id'=>$data['Useremail']['id'],'email'=>$this->params['url']['email']));
                    }
                }else{
                    $this->Useremail->save(array('user_id'=>$this->params['url']['uid'],'email'=>$this->params['url']['email']));
                }
                $to=$this->params['url']['email'];
                $sub="Feedback regarding ".$this->params['url']['subject'];
                $message=$this->params['url']['message'];
                $msg="Thank you for contacting the Digi Stickers Team.\n We will review your inquiry and get back to you soon! \n\n <strong>Message:</strong> ".$message;
                $to2=$email['Email']['contactemail'];
                $sub2="Feedback regarding ".$this->params['url']['subject'];
                $msg2="Feedback recieved From: </b>".$this->params['url']['email']."</b>\n".$message;
                $this->Message->save(array('from'=>$this->params['url']['email'],'subject'=>$sub,'msg'=>$message));
                $this->Checkurl->sendeeMail($to,$sub,$msg);
                $this->Checkurl->sendeeMail($to2,$sub2,$msg2);
                $result['status']='1';
                $result['message']='success';
                $result['data']="Feedback recieved";
                echo json_encode($result);
            }
        }
        
        
		public function addToCart(){
			$this->autoRender=false;
			if(!empty($this->params['url']['uid']) && !empty($this->params['url']['sid'])){
				$this->loadModel('Cart');
				$this->loadModel('Appuser');
				$this->loadModel('Sticker');
				$usercheck=$this->Appuser->find('first',array('fields'=>'id','conditions'=>array('id'=>$this->params['url']['uid'],'is_active'=>1)));
				$stickercheck=$this->Sticker->find('first',array('fields'=>'id','conditions'=>array('id'=>$this->params['url']['sid'],'is_active'=>1,'is_deleted'=>0)));
				if(!empty($usercheck) && !empty($stickercheck)){	
					$data=$this->Cart->find('first',array('conditions'=>array('user_id'=>$this->params['url']['uid'],'sticker_id'=>$this->params['url']['sid'])));
					if(empty($data)){
						if($this->Cart->save(array('user_id'=>$this->params['url']['uid'],'sticker_id'=>$this->params['url']['sid']))){
							$result['status']='1';
							$result['message']='success';
							$result['data']="Added to cart  successfully";
						}else{
							$result['status']='0';
							$result['message']='fail';
							$result['data']="Some error occured";
						}
					}else{
						$result['status']='0';
						$result['message']='fail';
						$result['data']="Already in cart";
					}
				}else{
					$result['status']='0';
					$result['message']='fail';
					$result['data']="user or sticker not found";
				}
				$count=$this->Cart->Find('count',array('conditions'=>array('user_id'=>$this->params['url']['uid'])));
				$result['count']=$count;
				echo json_encode($result);
			}
		}
		
		public function getCart(){
			$this->autoRender=false;
			if(!empty($this->params['url']['uid'])){
				$uid=$this->params['url']['uid'];	
				$this->loadModel('Cart');
				$this->loadModel('Sticker');
				$count=$this->Cart->Find('count',array('conditions'=>array('user_id'=>$this->params['url']['uid'])));
				$cond="Sticker.id=Cart.sticker_id";
				$conditions="(Cart.user_id = $uid AND Sticker.is_active = 1 AND Sticker.is_deleted = 0)";
				$data=$this->Sticker->find('all',array('fields'=>array('DISTINCT Sticker.id','Sticker.name','Sticker.image'),'joins'=>array(array('table'=>'carts','alias'=>'Cart','type'=>'inner','conditions'=>$cond)),'conditions'=>$conditions,'order'=>'Sticker.name ASC'));
		         if(!empty($data)){
		        	$result['status']='1';
					$result['message']='success';
		        	foreach($data as $key=>$value){
		        		$result['data'][]=array('id'=>$value['Sticker']['id'],'name'=>$value['Sticker']['name'],'image'=>Router::Url('/img/uploads/',true).$value['Sticker']['image']);
		        	}
					$result['count']=count($data);
		        }else{
		        	$result['status']='0';
					$result['message']='fail';
					$result['data']="Sticker Not Found";
		        }
				$result['count']=$count;
		        echo json_encode($result);
			}
		}
		
		public function deleteCart(){
			$this->autoRender=false;
			if(!empty($this->params['url']['uid']) && !empty($this->params['url']['sid'])){
				$this->loadModel('Cart');
				
				$data=$this->Cart->find('first',array('fields'=>'id','conditions'=>array('user_id'=>$this->params['url']['uid'],'sticker_id'=>$this->params['url']['sid'])));
				if(!empty($data)){
					if($this->Cart->delete($data['Cart']['id'])){
						$result['status']='1';
						$result['message']='success';
						$result['data']="Cart entry deleted successfully";
					}else{
						$result['status']='0';
						$result['message']='fail';
						$result['data']="Some error occured";
					}
				}else{
					$result['status']='0';
					$result['message']='fail';
					$result['data']="No record found";
				}
				$count=$this->Cart->Find('count',array('conditions'=>array('user_id'=>$this->params['url']['uid'])));
				$result['count']=$count;
				echo json_encode($result);
			}
		}
		
		public function newStickers(){
			if(!empty($this->params['url']['uid'])){
				$this->autoRender=false;
				$uid=$this->params['url']['uid'];
				$this->loadModel('Sticker');
				$this->loadModel('Cart');
				$this->loadModel('Purchasedsticker');
				$count=$this->Cart->Find('count',array('conditions'=>array('user_id'=>$this->params['url']['uid'])));
				$conditions="`Sticker`.`modified` >= NOW() - INTERVAL 1 WEEK AND `Sticker`.`is_active`=1 AND `Sticker`.`is_deleted`=0";
				$data=$this->Sticker->find('all',array('fields'=>array('id','name','image','type_id','category_id'),'conditions'=>$conditions,'order'=>'name ASC'));
				$psticker=$this->Purchasedsticker->find('list',array('fields'=>'sticker_id','conditions'=>array('user_id'=>$uid)));
				if(!empty($data)){
			        	$result['status']='1';
						$result['message']='success';
			        	foreach($data as $key=>$value){
			        		if(in_array($value['Sticker']['id'],$psticker)){
			        			$type="1";
			        		}else{
			        			$type=$value['Sticker']['type_id'];
			        	}
			        		$result['data'][]=array('id'=>$value['Sticker']['id'],'name'=>$value['Sticker']['name'],'image'=>Router::Url('/img/uploads/',true).$value['Sticker']['image'],'type'=>$type,'category_id'=>$value['Sticker']['category_id']);
			        	}
			        }else{
			        	$result['status']='0';
						$result['message']='fail';
						$result['data']="Sticker Not Found";
			        }
					$result['count']=$count;
			        echo json_encode($result);
			}
			
		}
		
		public function popular(){
			$this->autoRender=false;
			if(!empty($this->params['url']['uid'])){
				$uid=$this->params['url']['uid'];
				$this->loadModel('Sticker');
				$this->loadModel('Favsticker');
				$this->loadModel('Purchasedsticker');
				$this->loadModel('Cart');
				$count=$this->Cart->Find('count',array('conditions'=>array('user_id'=>$this->params['url']['uid'])));
				$psticker=$this->Purchasedsticker->find('list',array('fields'=>'sticker_id','conditions'=>array('user_id'=>$uid)));
				$cond="Sticker.id=Favsticker.sticker_id";
				$conditions="WHERE `Sticker`.`is_active`=1 AND `Sticker`.`is_deleted`=0 GROUP BY Favsticker.sticker_id HAVING count(Favsticker.sticker_id) >= 4 ";
				$data=$this->Sticker->find('all',array('fields'=>array('Sticker.id','Sticker.name','Sticker.image','Sticker.type_id','Sticker.category_id'),'joins'=>array(array('table'=>'favstickers','alias'=>'Favsticker','type'=>'inner','conditions'=>$cond)),'conditions'=>$conditions,'order'=>'Sticker.name ASC','limit'=>45));
			    if(!empty($data)){
			        	$result['status']='1';
						$result['message']='success';
			        	foreach($data as $key=>$value){
			        		if(in_array($value['Sticker']['id'],$psticker)){
			        			$type="1";
			        		}else{
			        			$type=$value['Sticker']['type_id'];
			        		}
			        		$result['data'][]=array('id'=>$value['Sticker']['id'],'name'=>$value['Sticker']['name'],'image'=>Router::Url('/img/uploads/',true).$value['Sticker']['image'],'type'=>$type,'category_id'=>$value['Sticker']['category_id']);
			        	}
			        }else{
			        	$result['status']='0';
						$result['message']='fail';
						$result['data']="Sticker Not Found";
			        }
					$result['count']=$count;
			    echo json_encode($result);
			}
		}
		
		public function ShowAll(){
			$this->autoRender=false;
			if(!empty($this->params['url']['uid'])){
				$this->loadModel('Sticker');
				$this->loadModel('Purchasedsticker');
				$conditions="`Sticker`.`modified` >= NOW() - INTERVAL 2 WEEK";
				$nsticker=$this->Sticker->find('list',array('fields'=>array('id','name','image','type_id'),'conditions'=>$conditions));
				$uid=$this->params['url']['uid'];
				$stickers=$this->Sticker->find('all',array('fields'=>array('Sticker.id','Sticker.name','Sticker.image','Sticker.type_id'),'order'=>'Sticker.name ASC'));
				$psticker=$this->Purchasedsticker->find('list',array('fields'=>array('sticker_id'),'conditions'=>array('user_id'=>$uid)));
				$cond="Sticker.id=Favsticker.sticker_id";
				$conditions="WHERE `Sticker`.`is_active`=1 AND `Sticker`.`is_deleted`=0 GROUP BY Favsticker.sticker_id HAVING count(Favsticker.sticker_id) >= 1";
				$msticker=$this->Sticker->find('list',array('fields'=>array('Sticker.id','Sticker.name','Sticker.image','Sticker.type_id'),'joins'=>array(array('table'=>'favstickers','alias'=>'Favsticker','type'=>'inner','conditions'=>$cond)),'conditions'=>$conditions));
				if(!empty($stickers)){
					$result['status']='1';
					$result['message']='success';
					foreach($stickers as $key=>$value){
						if(in_array($value['Sticker']['id'],$psticker)){
							$type=1;
						}else{
			        		$type=$value['Sticker']['type_id'];
			        	}
						if(in_array($value['Sticker']['name'],$msticker)){
							$is_mp=1;
						}else{
							$is_mp=0;
						}
						if(in_array($value['Sticker']['name'],$nsticker)){
							$is_new=1;
						}else{
							$is_new=0;
						}
					$result['data'][]=array('id'=>$value['Sticker']['id'],'name'=>$value['Sticker']['name'],'image'=>Router::Url('/img/uploads/',true).$value['Sticker']['image'],'type'=>$type,'is_mp'=>$is_mp,'is_new'=>$is_new);	
					}
				}else{
					$result['status']='0';
					$result['message']='fail';
					$result['data']="Sticker Not Found";
				}
				echo json_encode($result);
			}
		}
		
		public function NotificationToggle(){
			$this->autoRender=false;
			if(isset($this->params['url']['state']) && !empty($this->params['url']['uid']) && !empty($this->params['url']['device_id'])){
				$this->loadModel('Device');
				$uid=$this->params['url']['uid'];
				$state=$this->params['url']['state'];
				$imei=$this->params['url']['device_id'];
				$id=$this->Device->find('first',array('fields'=>'id','conditions'=>array('user_id'=>$uid,'imei'=>$imei)));
				if(!empty($id)){
						if($this->Device->save(array('id'=>$id['Device']['id'],'notification'=>$state))){
						$result['status']='1';
						$result['message']='success';
					}else{
						$result['status']='0';
						$result['message']='fail';
					}
				}else{
					$result['status']='0';
					$result['message']='fail';
				}
				echo json_encode($result);
			}
		}
		
        public function NotificationToggle_new(){
            $this->autoRender=false;
            if(isset($this->params['url']['state']) && !empty($this->params['url']['uid'])){
                $this->loadModel('Newuser');
                $uid=$this->params['url']['uid'];
                $state=$this->params['url']['state'];
                if(!empty($uid)){
                        if($this->Newuser->save(array('id'=>$uid,'notification'=>$state))){
                        $result['status']='1';
                        $result['message']='success';
                    }else{
                        $result['status']='0';
                        $result['message']='fail';
                    }
                }else{
                    $result['status']='0';
                    $result['message']='fail';
                }
                echo json_encode($result);
            }
        }
        
        
		public function sendInvite(){
			$this->autoRender=false;
			if(!empty($this->params['url']['uid']) && !empty($this->params['url']['emails'])){
				$emails=explode(',', $this->params['url']['emails']);
				$uid=$this->params['url']['uid'];
				$this->loadModel('Appuser');
				$from=$this->Appuser->find('first',array('fields'=>'email','conditions'=>array('id'=>$uid)));
				if(!empty($from)){
					foreach($emails as $key=>$value){
						$this->Checkurl->sendEmail($value,$from['Appuser']['email']);
					}
					$result['status']='1';
					$result['message']='success';
				}else{
					$result['status']='0';
					$result['message']='fail';
				}
				echo json_encode($result);
			}
		}
		
		public function getNotification(){
			$this->autoRender=false;
			if(!empty($this->params['url']['uid']) && !empty($this->params['url']['device_id'])){
				$this->loadModel('Notification');
				$uid=$this->params['url']['uid'];
				$did=$this->params['url']['device_id'];
				$conditions="where user_id=$uid AND device_id='$did' AND `created` >= NOW() - INTERVAL 2 WEEK";
				$data=$this->Notification->find('all',array('fields'=>array('notification','created'),'conditions'=>$conditions));
				if(!empty($data)){
					$result['status']='1';
					$result['message']='success';
					foreach($data as $key=>$value){
						$dt =  new DateTime($value['Notification']['created'], new DateTimeZone('America/Chicago'));
						$t=$dt->format('r');
						$result['data'][]=array('notification'=>$value['Notification']['notification'],'time'=>date("F j, Y, g:i A",strtotime($t)));
					}
				}else{
					$result['status']='0';
					$result['message']='fail';
					$result['data']="Notification not found";	
				}
				echo json_encode($result);
			}
		}
		
		public function addToMyStickers(){
			$this->autoRender=false;
			if(!empty($this->params['url']['sid']) && !empty($this->params['url']['uid']) && !empty($this->params['url']['cid'])){
				$this->loadModel('Mysticker');
				$this->loadModel('Cart');
				$count=$this->Cart->Find('count',array('conditions'=>array('user_id'=>$this->params['url']['uid'])));
				$sid=$this->params['url']['sid'];
				$uid=$this->params['url']['uid'];
				$stickerexists=$this->Mysticker->find('first',array('fields'=>'id','conditions'=>array('sticker_id'=>$sid,'user_id'=>$uid)));
				if(empty($stickerexists)){
						$data=array('user_id'=>$this->params['url']['uid'],'sticker_id'=>$this->params['url']['sid'],'category_id'=>$this->params['url']['cid']);
					if($this->Mysticker->save($data)){
						$result['status']='1';
						$result['message']='success';
						$result['data']="sticker added successfully";
					}else{
						$result['status']='0';
						$result['message']='fail';
						$result['data']="Some error occurred";
					}
				}else{
					$result['status']='0';
					$result['message']='fail';
					$result['data']="Sticker Already exists";
				}
				$result['count']=$count;
				echo json_encode($result);
			}
		}
		
		public function AllMySticker(){
			$this->autoRender=false;
			if(!empty($this->params['url']['uid'])){
				$uid=$this->params['url']['uid'];
				$this->loadModel('Sticker');
				$this->loadModel('Cart');
				$count=$this->Cart->Find('count',array('conditions'=>array('user_id'=>$this->params['url']['uid'])));
				$cond="Sticker.id=Mysticker.sticker_id";
				$conditions="`Mysticker`.`user_id` = $uid  AND `Sticker`.`is_active` = 1 AND `Sticker`.`is_deleted` = 0";
				$stickers=$this->Sticker->find('all',array('fields'=>array('DISTINCT Sticker.id','Sticker.name','Sticker.image'),'joins'=>array(array('table'=>'mystickers','alias'=>'Mysticker','type'=>'inner','conditions'=>$cond)),'conditions'=>$conditions,'order'=>'Sticker.name ASC'));
			    if(!empty($stickers)){
			    	$result['status']='1';
					$result['message']='success';	
			    	foreach($stickers as $key=>$value){
			        	$result['data'][]=array('id'=>$value['Sticker']['id'],'name'=>$value['Sticker']['name'],'image'=>Router::Url('/img/uploads/',true).$value['Sticker']['image']);
			        }
					
			    }else{
			    	$result['status']='0';
					$result['message']='fail';
					$result['data']="No Sticker Found";
			    }
				$result['count']=$count;    
			    echo json_encode($result);    
			}
		}
		
		public function AllMyStickerByCat(){
			$this->autoRender=false;
			if(!empty($this->params['url']['uid']) && !empty($this->params['url']['cid'])){
				$uid=$this->params['url']['uid'];
				$cid=$this->params['url']['cid'];
				$this->loadModel('Sticker');
				$this->loadModel('Cart');
				$count=$this->Cart->Find('count',array('conditions'=>array('user_id'=>$this->params['url']['uid'])));
				$cond="Sticker.id=Mysticker.sticker_id";
				$conditions="`Mysticker`.`user_id` = $uid  AND `Sticker`.`category_id`=$cid AND `Sticker`.`is_active` = 1 AND `Sticker`.`is_deleted` = 0";
				$stickers=$this->Sticker->find('all',array('fields'=>array('DISTINCT Sticker.id','Sticker.name','Sticker.image'),'joins'=>array(array('table'=>'mystickers','alias'=>'Mysticker','type'=>'inner','conditions'=>$cond)),'conditions'=>$conditions,'order'=>'Sticker.name ASC'));
				if(!empty($stickers)){
			    	$result['status']='1';
					$result['message']='success';	
			    	foreach($stickers as $key=>$value){
			        	$result['data'][]=array('id'=>$value['Sticker']['id'],'name'=>$value['Sticker']['name'],'image'=>Router::Url('/img/uploads/',true).$value['Sticker']['image']);
			        }
			    }else{
			    	$result['status']='0';
					$result['message']='fail';
					$result['data']="No Sticker Found";
			    }   
				$result['count']=$count;
			    echo json_encode($result);
			}
		}
		
		public function AllMyStickerRecent(){
			$this->autoRender=false;
			if(!empty($this->params['url']['uid'])){
				$uid=$this->params['url']['uid'];
				$this->loadModel('Sticker');
				$this->loadModel('Cart');
				$count=$this->Cart->Find('count',array('conditions'=>array('user_id'=>$this->params['url']['uid'])));
				$cond="Sticker.id=Mysticker.sticker_id";
				$conditions="`Mysticker`.`user_id` = $uid  AND `Sticker`.`is_active` = 1 AND `Sticker`.`is_deleted` = 0 AND `Mysticker`.`created` >= NOW() - INTERVAL 2 WEEK";
				$stickers=$this->Sticker->find('all',array('fields'=>array('DISTINCT Sticker.id','Sticker.name','Sticker.image'),'joins'=>array(array('table'=>'mystickers','alias'=>'Mysticker','type'=>'inner','conditions'=>$cond)),'conditions'=>$conditions,'order'=>'Sticker.name ASC'));
				if(!empty($stickers)){
			    	$result['status']='1';
					$result['message']='success';	
			    	foreach($stickers as $key=>$value){
			        	$result['data'][]=array('id'=>$value['Sticker']['id'],'name'=>$value['Sticker']['name'],'image'=>Router::Url('/img/uploads/',true).$value['Sticker']['image']);
			        }
			    }else{
			    	$result['status']='0';
					$result['message']='fail';
					$result['data']="No Sticker Found";
			    } 
			    $result['count']=$count;  
			    echo json_encode($result);
			}
		}
		
			public function register(){
			$this->autoRender=false;
			$this->loadModel('Appuser');
			$this->loadModel('Device');
			if(!empty($this->params['url']['regid']) && !empty($this->params['url']['email']) && !empty($this->params['url']['imei'])){
				$emailexist=$this->Appuser->find('first',array('fields'=>'id','conditions'=>array('email'=>$this->params['url']['email'])));
				if(empty($emailexist)){
						$activation=rand ( 10000 , 99999 );
						$data=array('email'=>$this->params['url']['email'],'zip'=>$this->params['url']['zip'],'city'=>$this->params['url']['city'],'country'=>$this->params['url']['country']);
						if($this->Appuser->save($data)){
							$dat=$this->Appuser->find('first',array('fields'=>array('id'),'conditions'=>array('email'=>$this->params['url']['email'])));
							$datadevice=array('user_id'=>$dat['Appuser']['id'],'regid'=>$this->params['url']['regid'],'imei'=>$this->params['url']['imei'],'device_type'=>$this->params['url']['type'],'activationcode'=>$activation,'is_active'=>0);
							$this->Device->save($datadevice);
							$result['status']='1';
							$result['message']='success';
							foreach($dat as $key=>$value){
								$result['id']=$value['id'];
							}
							$msg="\tYour Activation Code is : <b>$activation</b> \n\n\tThank you for registering with Digi Stickers!\n\n\tSincerely,\n\n\tThe Digi Stickers Team";
							$this->Checkurl->sendMail($this->params['url']['email'],'Your Digi Stickers Email Verification Code',$msg);
						}else{
							$result['status']='0';
							$result['message']='fail';
							$result['data']='registration failed';
						}
				}else{
					$activation=rand ( 10000 , 99999 );
					$data=array('user_id'=>$emailexist['Appuser']['id'],'regid'=>$this->params['url']['regid'],'imei'=>$this->params['url']['imei'],'device_type'=>$this->params['url']['type'],'activationcode'=>$activation,'is_active'=>0);
					$devicexist=$this->Device->find('first',array('fields'=>'id','conditions'=>array('imei'=>$this->params['url']['imei'],'user_id'=>$emailexist['Appuser']['id'])));
					if(empty($devicexist)){
						if($this->Device->find('count',array('conditions'=>array('user_id'=>$emailexist['Appuser']['id'])))<4){
							if($this->Device->save($data)){
							$dat=$this->Appuser->find('first',array('fields'=>array('id'),'conditions'=>array('id'=>$emailexist['Appuser']['id'])));
							$result['status']='1';
							$result['message']='success';
							$result['id']=$dat['Appuser']['id'];
							$msg="Your Activation Code is :  $activation  \n\nThank you for registering with Digi Stickers!\n\nSincerely,\n\nThe Digi Stickers Team";
							$this->Checkurl->sendMail($this->params['url']['email'],'Your Digi Stickers Email Verification Code',$msg);
							}else{
								$result['status']='0';
								$result['message']='fail';
								$result['data']='registration failed';
							}
						}else{
							$result['status']='2';
							$result['message']='fail';
							$result['data']='Max Device Limit Reached';
						}
					}else{
						$data=array('id'=>$devicexist['Device']['id'],'user_id'=>$emailexist['Appuser']['id'],'regid'=>$this->params['url']['regid'],'imei'=>$this->params['url']['imei'],'device_type'=>$this->params['url']['type'],'activationcode'=>$activation,'is_active'=>0,'notification'=>1);
						if($this->Device->save($data)){
							$dat=$this->Appuser->find('first',array('fields'=>array('id'),'conditions'=>array('id'=>$emailexist['Appuser']['id'])));
							$result['status']='1';
							$result['message']='success';
							$result['id']=$dat['Appuser']['id'];
							$msg="Your Activation Code is :  $activation  \n\nThank you for registering with Digi Stickers!\n\nSincerely,\n\nThe Digi Stickers Team";
							$this->Checkurl->sendMail($this->params['url']['email'],'Your Digi Stickers Email Verification Code',$msg);
						}else{
							$result['status']='0';
							$result['message']='fail';
							$result['data']='registration failed';
						}
					}
				}
				
			}else{
				$result['status']='0';
				$result['message']='fail';
				$result['data']='regid or email or imei not found';
			}
			echo json_encode($result);
		}
		
		public function register_new(){
			$this->autoRender=false;
			$this->loadModel('Appuser');
			$this->loadModel('Device');
			if(!empty($this->params['url']['regid']) && !empty($this->params['url']['email']) && !empty($this->params['url']['imei']) && !empty($this->params['url']['password']) && !empty($this->params['url']['type'])){
				$emailexists=$this->Appuser->find('first',array('conditions'=>array('email'=>$this->Checkurl->clean($this->params['url']['email']))));
				if(!empty($emailexists)){
					$result['status']="3";
					$result['message']="Email Already Registered.";
				}else{
					$activation=rand ( 10000 , 99999 );
					$userdata=array('email'=>$this->Checkurl->clean($this->params['url']['email']),'password'=>md5($this->Checkurl->clean($this->params['url']['password'])),'is_active'=>0,'zip'=>$this->Checkurl->clean($this->params['url']['zip']),'city'=>$this->Checkurl->clean($this->params['url']['city']),'country'=>$this->Checkurl->clean($this->params['url']['country']),'activationcode'=>$activation);
					if($this->Appuser->save($userdata)){
						$msg="Your Activation Code is :  $activation  \n\nThank you for registering with Digi Stickers!\n\nSincerely,\n\nThe Digi Stickers Team";
						$this->Checkurl->sendMail($this->params['url']['email'],'Your Digi Stickers Email Verification Code',$msg);
						$id=$this->Appuser->id;
						$devicedata=array('user_id'=>$id,'regid'=>$this->Checkurl->clean($this->params['url']['regid']),'imei'=>$this->Checkurl->clean($this->params['url']['imei']),'device_type'=>$this->Checkurl->clean($this->params['url']['type']),'is_active'=>1);
						if($this->Device->save($devicedata)){
							$result['status']="1";
							$result['message']="Registration Successfull";
							$result['id']=$id;
						}else{
							$this->Appuser->delete($id);
							$result['status']="0";
							$result['message']="Some error occured";
						}
					}else{
						$result['status']="0";
						$result['message']="Some error occured";
					}
				}
				echo json_encode($result);
			}
			
		}
		
        public function registerByDevice(){
            if(!empty($this->params['url']['imei']) && !empty($this->params['url']['regid']) && !empty($this->params['url']['type'])){
                $this->loadModel('Newuser');
                $deviceexists=$this->Newuser->find('first',array('conditions'=>array('imei'=>$this->params['url']['imei'])));
                $data=array('imei'=>$this->params['url']['imei'],'regid'=>$this->params['url']['regid'],'type'=>$this->params['url']['type'], 'notification'=>1,'created'=>date('Y-m-d h:i:s',time()));
                if(empty($deviceexists)){
                    if($this->Newuser->save($data)){
                        $result['status']="1";
                        $result['message']="success";
                        $result['id']=$this->Newuser->id;
                        $result['notification']="1";
                    }else{
                        $result['status']="0";
                        $result['message']="fail";
                        $result['data']="Some Error Occurred";
                    }
                }else{
                    $result['status']="1";
                    $result['message']="success";
                    $result['id']=$deviceexists['Newuser']['id'];
                    $result['notification']=$deviceexists['Newuser']['notification'];
                }
                echo json_encode($result);
                die;
            }
        }
        
		public function login(){
			$this->autoRender=false;
			$this->loadModel('Appuser');
			$this->loadModel('Device');	
			if(!empty($this->params['url']['regid']) && !empty($this->params['url']['email']) && !empty($this->params['url']['imei']) && !empty($this->params['url']['password']) && !empty($this->params['url']['type'])){
				$check=$this->Appuser->find('first',array('conditions'=>array('email'=>$this->Checkurl->clean($this->params['url']['email']),'password'=>md5($this->Checkurl->clean($this->params['url']['password'])))));
				if(!empty($check)){
					if($check['Appuser']['is_active']==1){
						$count=$this->Device->find('count',array('conditions'=>array('user_id'=>$check['Appuser']['id'])));
						$devicexists=$this->Device->find('first',array('conditions'=>array('user_id'=>$check['Appuser']['id'],'imei'=>$this->Checkurl->clean($this->params['url']['imei']))));
						if(!empty($devicexists)){
							$result['status']="1";
							$result['message']="Success";
							$result['id']=$check['Appuser']['id'];
						}else{
							if($count<4){
								$devicedata=array('user_id'=>$check['Appuser']['id'],'regid'=>$this->Checkurl->clean($this->params['url']['regid']),'imei'=>$this->Checkurl->clean($this->params['url']['imei']),'device_type'=>$this->Checkurl->clean($this->params['url']['type']),'is_active'=>1);
								if($this->Device->save($devicedata)){
									$result['status']="1";
									$result['message']="Success";
									$result['id']=$check['Appuser']['id'];
								}else{
									$result['status']="0";
									$result['message']="Some error occured";
								}
							}else{
								$result['status']="2";
								$result['message']="Maximum Device Limit Reached";
							}
						}
					}else{
						$result['status']="4";
						$result['message']="Enter Activation Code";
					}
				}else{
					$result['status']="0";
					$result['message']="Invalid Email/Password";
				}
				echo json_encode($result);
			}
		}
		
		public function forgotPassword(){
			$this->autoRender=false;	
			if(!empty($this->params['url']['email'])){
				$this->loadModel('Appuser');
				$emailexists=$this->Appuser->find('first',array('conditions'=>array('email'=>$this->Checkurl->clean($this->params['url']['email']))));
				if(!empty($emailexists)){
					$result['status']='1';
					$result['message']="success";
					$to=$emailexists['Appuser']['email'];
					$sub="Reset Password";
					$key="1sa35v";
					$time=time();
					$msg="You requested to change your Password. \nThe Link will expire in 24 hours. \nPlease visit this link : http://103.230.152.50/stickerapp/Appusers/changePassword?refrenceid=".str_replace('=',$key,base64_encode(base64_encode($emailexists['Appuser']['id'])."^".base64_encode($emailexists['Appuser']['email'])."^".base64_encode($time)));
					$this->Checkurl->sendMail($to,$sub,$msg);
				}else{
					$result['status']="0";
					$result['message']="Email Not Found";
				}
				echo json_encode($result);
			}
		}
		
		public function usage(){
			$this->autoRender=false;
			if(!empty($this->params['url']['uid']) && !empty($this->params['url']['sid'])){
				$uid=$this->params['url']['uid'];
				$sid=$this->params['url']['sid'];
				$this->loadModel('Stickeruse');
				$data=$this->Stickeruse->find('first',array('fields'=>'id','conditions'=>array('user_id'=>$uid,'Sticker_id'=>$sid)));
				if(!empty($data)){
					if($this->Stickeruse->updateAll(array('count'=>'count+1'),array('id'=>$data['Stickeruse']['id']))){
						$result['status']='1';
						$result['message']='Success';
					}else{
						$result['status']='0';
						$result['message']='fail';
					}
				}else{
					$data=array('user_id'=>$uid,'sticker_id'=>$sid,'count'=>1);
					if($this->Stickeruse->save($data)){
						$result['status']='1';
						$result['message']='Success';
					}else{
						$result['status']='0';
						$result['message']='fail';
					}
				}
				echo json_encode($result);
			}
		}
		
		public function purchase(){
			if(!empty($this->params['url']['uid'])){
				$this->autoRender=false;
				$this->loadModel('Cart');
				$this->loadModel('Purchasedsticker');
				$this->loadModel('Mysticker');
				$this->loadModel('Pack');
				$this->loadModel('Sticker');
				$uid=$this->params['url']['uid'];
				$cart=$this->Cart->find('all',array('conditions'=>array('user_id'=>$uid)));
				if(!empty($cart)){
					foreach($cart As $key=>$value){
						$this->Purchasedsticker->create();
						$this->Purchasedsticker->save(array('user_id'=>$value['Cart']['user_id'],'sticker_id'=>$value['Cart']['sticker_id'],'by_admin'=>0));
						$catid=$this->Sticker->find('first',array('fields'=>'category_id','conditions'=>array('id'=>$value['Cart']['sticker_id'])));
						$this->Mysticker->create();
						$this->Mysticker->save(array('user_id'=>$uid,'sticker_id'=>$value['Cart']['sticker_id'],'category_id'=>$catid['Sticker']['category_id']));
						$this->Cart->delete($value['Cart']['id']);
					}
					$userexists=$this->Pack->find('first',array('conditions'=>array('user_id'=>$uid)));
					if(empty($userexists)){
						if($this->Pack->save(array('user_id'=>$uid,'count'=>1))){
							$result['status']='1';
							$result['message']='Success';
						}else{
							$result['status']='0';
							$result['message']='fail';
						}
					}else{
						if($this->Pack->updateAll(array('count'=>'count+1'),array('id'=>$userexists['Pack']['id']))){
							$result['status']='1';
							$result['message']='Success';
						}else{
							$result['status']='0';
							$result['message']='fail';
						}
					}
				}else{
					$result['status']='0';
					$result['message']='fail';
					$result['data']="Cart is empty";
				}
			echo json_encode($result);
			}
		}
	}
?>