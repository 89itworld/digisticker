<?php
	class AppusersController extends AppController{
		// var $helpers = array('Html', 'Form','Csv');
		var $components=array('Session','Checkurl');
		public function index(){
			if($this->Session->check('id')){
				$this->loadModel('Appuser');
				$this->loadModel('Device');
				$this->layout='admin';
				// $conditions=array('is_active'=>1);
				// $this->paginate = array('recursive' => -1,'limit' => 10,'conditions' => $conditions,);
				
				$this->Appuser->virtualFields['total']='SUM(`Stickeruse`.`count`)';
				$cond="`Stickeruse`.`user_id`=`Appuser`.`id`";
				$conditions2="`Appuser`.`is_active`=1";
				if(!empty($this->params['url']['type'])){
					if($this->params['url']['type']=='1'){
						$email=$this->params['url']['q'];
						$conditions2="`Appuser`.`is_active`=1 AND `Appuser`.`email` LIKE '%".$email."%'";
						$this->request->params['named']['email']=$email;
					}elseif($this->params['url']['type']=='2'){
						$zip=$this->params['url']['q'];
						$conditions2="`Appuser`.`is_active`=1 AND `Appuser`.`zip`='".$zip."'";
						$this->request->params['named']['q']=$zip;
					}elseif($this->params['url']['type']=='3'){
						$city=$this->params['url']['q'];
						$conditions2="`Appuser`.`is_active`=1 AND `Appuser`.`city`='".$city."'";
						$this->request->params['named']['q']=$city;
					}elseif($this->params['url']['type']=='4'){
						$country=$this->params['url']['q'];
						$conditions2="`Appuser`.`is_active`=1 AND `Appuser`.`country`='".$country."'";
						$this->request->params['named']['q']=$country;
					}
				}
				
				if(!empty($this->params['url']['from']) && !empty($this->params['url']['to'])){
					$from=$this->params['url']['from'];
					$to=$this->params['url']['to'];
					// pr($from);die;
					$conditions2="`Appuser`.`is_active`=1 AND Appuser.created >= '".date($from.' 00:00:00')."' AND Appuser.created <='".date($to.' 23:59:59')."'";
					$this->request->params['url']['from']=date($from.' 00:00:00');
					$this->request->params['url']['to']=date($to.' 23:59:59');
				}
				$this->paginate = array('fields'=>array('Appuser.id','Appuser.email','Appuser.city','Appuser.zip','Appuser.country','Appuser.created','Appuser.is_active','SUM(`Stickeruse`.`count`) AS total'),'joins'=>array(array('table'=>'stickeruses','alias'=>'Stickeruse','type'=>'left','conditions'=>$cond)),'conditions' => $conditions2,'group'=>'Appuser.id','limit' => 100,'recursive' =>-1,'order'=>'Appuser.created DESC');
		        
		        $result = $this->paginate('Appuser');
		        foreach($result as $k=>$v){
					$result[$k]['Appuser']['dtotal']=$this->Device->find('count',array('conditions'=>array('user_id'=>$v['Appuser']['id'])));	
		        }
				// pr($result);die;
		        $this->set('result', $result);
				
			}else{
				$this->redirect(array('controller'=>'Users','action'=>'index'));
			}
		}
		
		public function view_deleted(){
			if($this->Session->check('id')){
				$this->loadModel('Appuser');
				$this->layout='admin';
				$conditions=array('is_active'=>0);
				$this->paginate = array('recursive' => -1,'limit' => 10,'conditions' => $conditions,);
		        $result = $this->paginate('Appuser');
		        $this->set('result', $result);
			}else{
				$this->redirect(array('controller'=>'Users','action'=>'index'));
			}
			
		}
		
		public function view($data=null,$url=null){
			if($this->Session->check('id') && !empty($data) && !empty($url)){
				$this->layout='admin';
				$id=base64_decode($data);
				$url=base64_decode($url);
				$pageno=$this->Checkurl->cUrl($url);
				$this->loadModel('Device');
				$this->loadModel('Appuser');
				$this->Appuser->create();
				// pr($id);die;
				$name=$this->Appuser->find('first',array('fields'=>array('id','email'),'conditions'=>array('id'=>$id)));
				
				$conditions=array('user_id'=>$id);
				$this->paginate = array('recursive' => -1,'limit' => 10,'conditions' => $conditions,);
				$result = $this->paginate('Device');
				$this->set('pageno',$pageno);
				$this->set('id',$name['Appuser']['id']);
				$this->set('name',$name['Appuser']['email']);
				$this->set('result',$result);
			}else{
				$this->redirect(array('controller'=>'Users','action'=>'index'));
			}
		}
		public function free($data,$name){
			if($this->Session->check('id')){
				$this->layout='admin';
				$id=base64_decode($data);
				$n=base64_decode($name);
				$this->loadModel('Sticker');
				$this->loadModel('Mysticker');
				$this->loadModel('Purchasedsticker');
				$conditions="WHERE Sticker.id NOT IN (SELECT sticker_id FROM purchasedstickers WHERE user_id=$id) AND Sticker.type_id=2 AND Sticker.is_active=1";
				$result = $this->Sticker->find('all',array('fields'=>array('DISTINCT id','image','name','created','modified','price','category_id'),'conditions'=>$conditions));
				// $this->paginate = array('recursive' => -1,'conditions' => $conditions,);
		        // $this->paginate = array('fields'=>array('DISTINCT id','image','name','created','modified','price'),'recursive' => -1,'limit' => 10,'conditions' => $conditions);
				// $result=$this->paginate('Sticker');
				$this->set('result',$result);
				$this->set('name',$n);
				if($this->request->is('post')){
					if(empty($this->request->data)){
						
						$this->Session->setFlash('Select Atleast 1 Sticker','flash_custom');
					}else{
						if($this->request->data['Free']['checks']['0']=="all"){
							// $this->Purchasedsticker->save(array('user_id'=>$id,'sticker_id'=>$value,'by_admin'=>1));
							foreach($result as $key=>$value){
								$this->Purchasedsticker->create();
								$this->Purchasedsticker->save(array('user_id'=>$id,'sticker_id'=>$value['Sticker']['id'],'by_admin'=>1));
								$this->Mysticker->create();
								$this->Mysticker->save(array('user_id'=>$id,'sticker_id'=>$value['Sticker']['id'],'category_id'=>$value['Sticker']['category_id']));
							}
						}else{
							$check=$this->request->data['Free']['checks'];
							// pr($check);die;
							foreach($check as $key=>$value){
								$this->Purchasedsticker->create();
								$this->Purchasedsticker->save(array('user_id'=>$id,'sticker_id'=>$value,'by_admin'=>1));
								$cat=$this->Sticker->find('first',array('fields'=>'category_id'));
								// pr($cat);
								
								$this->Mysticker->create();
								$this->Mysticker->save(array('user_id'=>$id,'sticker_id'=>$value,'category_id'=>$cat['Sticker']['category_id']));
							}
						}
					}
					$this->redirect($this->referer());
				}
				
			}else{
				$this->redirect(array('controller'=>'Users','action'=>'index'));
			}
		}

		public function purchased($data,$name){
			if($this->Session->check('id')){
				$this->layout="admin";
				$id=base64_decode($data);
				$n=base64_decode($name);
				$this->loadModel('Purchasedsticker');
				$this->loadModel('Sticker');
				$conditions=array('user_id'=>$id);
				$sticker=$this->Purchasedsticker->find('all',array('conditions'=>$conditions));
				foreach($sticker as $k=>$v){
					$result[]=$this->Sticker->find('first',array('conditions'=>array('id'=>$v['Purchasedsticker']['sticker_id'])));
				}
				// pr($result);die;
				$this->set('name',$n);
				if(!empty($result)){
					$this->set('result',$result);	
				}
				
			}else{
				$this->redirect(array('controller'=>'Users','action'=>'index'));
			}
		}
		public function usage($data,$name){
			if($this->Session->check('id')){
				$this->layout="admin";
				$this->loadModel('Sticker');
				$this->loadModel('Categorie');
				$id=base64_decode($data);
				$n=base64_decode($name);
				$fields="Sticker.id, Sticker.name, Sticker.image, Sticker.type_id, Sticker.category_id, Sticker.created, Sticker.modified, SUM(`Stickeruse`.`count`)AS total";
				$cond="Sticker.id=Stickeruse.sticker_id";
				$conditions="WHERE Stickeruse.user_id=$id GROUP BY Sticker.id ORDER BY count DESC";
				$this->paginate = array('fields'=>$fields,'joins'=>array(array('table'=>'stickeruses','alias'=>'Stickeruse','type'=>'inner','conditions'=>$cond)),'recursive' => -1,'limit' => 10,'conditions' => $conditions);
				
				$result=$this->paginate('Sticker');
				// $log = $this->Sticker->getDataSource()->getLog(false, false);
			    // debug($log);
				// pr($result);die;
				foreach($result as $key=>$value){
					$c=$this->Categorie->find('first',array('fields'=>'name','conditions'=>array('id'=>$value['Sticker']['category_id'])));
					$dat[]=array('sticker'=>$value,'category'=>$c['Categorie']['name']);
				}
				$this->set('name',$n);
				if(!empty($dat)){
					$this->set('result',$dat);	
				}
			}else{
				$this->redirect(array('controller'=>'Users','action'=>'index'));
			}
		}
		public function allfree($data=null){
			if($this->Session->check("id") && !empty($data)){
				$this->layout="admin";
				$this->loadModel('Sticker');
				$this->loadModel('Appuser');
				$this->loadModel('Purchasedsticker');
				// $data=base64_decode($data);
				$data=explode("-", base64_decode($data));
				// pr($data);die;
				if(!empty($this->request->data)){
					$stickers=$this->request->data['Free']['checks'];
					if($data['0']=='All'){
						$user=$this->Appuser->find('all',array('fields'=>'id','conditions'=>array('is_active'=>1)));
						if($stickers['0']=="all"){
							$st=$this->Sticker->find('all',array('fields'=>'id','conditions'=>array('type_id'=>2,'is_active'=>1,'is_deleted'=>0)));
							foreach($user as $key=>$value){
								foreach($st as $k=>$v){
									$r=$this->Purchasedsticker->find('first',array('conditions'=>array('user_id'=>$value['Appuser']['id'],'sticker_id'=>$v['Sticker']['id'])));
									if(empty($r)){
										$this->Purchasedsticker->create();
										$this->Purchasedsticker->save(array('user_id'=>$value['Appuser']['id'],'sticker_id'=>$v['Sticker']['id'],'by_admin'=>1));
									}
								}
							}
						}else{
							foreach($user as $key=>$value){
								foreach($stickers as $k=>$v){
									$r=$this->Purchasedsticker->find('first',array('conditions'=>array('user_id'=>$value['Appuser']['id'],'sticker_id'=>$v)));
									if(empty($r)){
										$this->Purchasedsticker->create();
										$this->Purchasedsticker->save(array('user_id'=>$value['Appuser']['id'],'sticker_id'=>$v,'by_admin'=>1));
									}	
								}
							}	
						}
					}else{
						if($stickers['0']=="all"){
							$st=$this->Sticker->find('all',array('fields'=>'id','conditions'=>array('type_id'=>2,'is_active'=>1,'is_deleted'=>0)));
							foreach($data as $key=>$value){
								foreach($st as $k=>$v){
									$r=$this->Purchasedsticker->find('first',array('conditions'=>array('user_id'=>$value,'sticker_id'=>$v['Sticker']['id'])));
									if(empty($r)){
										$this->Purchasedsticker->create();
										$this->Purchasedsticker->save(array('user_id'=>$value,'sticker_id'=>$v['Sticker']['id'],'by_admin'=>1));
									}	
								}
							}
						}else{
							foreach($data as $key=>$value){
								foreach($stickers as $k=>$v){
									$r=$this->Purchasedsticker->find('first',array('conditions'=>array('user_id'=>$value,'sticker_id'=>$v)));
									if(empty($r)){
										$this->Purchasedsticker->create();
										$this->Purchasedsticker->save(array('user_id'=>$value,'sticker_id'=>$v,'by_admin'=>1));
									}
								}
							}
						}
					}
					$this->Session->setFlash('Given Successfully','flash_success');
				}
				$this->paginate=array('recursive'=>-1,'limit'=>1000,'conditions'=>array('type_id'=>2,'is_active'=>1,'is_deleted'=>0));
				$result=$this->paginate('Sticker');
				$this->set('result',$result);
			}else{
				$this->redirect(array('controller'=>'Users','action'=>'index'));
			}
		}
		public function viewfree(){
			if($this->Session->check('id')){
				$this->layout="admin";
				$this->loadModel('Purchasedsticker');
				$this->paginate=array('fields'=>array('Sticker.name','Sticker.image','Appuser.email','Sticker.created','Sticker.modified','Purchasedsticker.created'),'joins'=>array(array('table'=>'stickers','alias'=>'Sticker','type'=>'left','conditions'=>array('Sticker.id=Purchasedsticker.sticker_id')),array('table'=>'appusers','alias'=>'Appuser','type'=>'left','conditions'=>array('Appuser.id=Purchasedsticker.user_id'))),'limit'=>50);
				$data=$this->paginate('Purchasedsticker');
				// pr($data);die;
				$this->set('result',$data);
			}else{
				$this->redirect(array('controller'=>'Users','action'=>'index'));
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
				$user=$this->Appuser->find('first',array('conditions'=>array('email'=>$email)));
					if(!empty($user)){
						if($user['Appuser']['email']==$email && ((strtotime(date("Y-m-d H:i:s",time()))-strtotime(date("Y-m-d H:i:s",$time)))/60)<1440){
							if($this->request->is('post')){
								if($this->request->data['Appuser']['password']==$this->request->data['Appuser']['cpassword']){
									if($this->Appuser->save(array('id'=>$id,'password'=>md5($this->Checkurl->clean($this->request->data['Appuser']['password']))))){
										$this->Session->setFlash("Password changed successfully.",'flash_success');
										$this->redirect($this->referer());
									}
								}else{
									$this->set('error',"Password do not match");
								}
							}
						}else{
							$this->redirect(array('controller'=>'Userss','action'=>'index'));
						}
					}else{
						
						$this->redirect(array('controller'=>'Userss','action'=>'index'));
					}
			}else{
				$this->redirect(array('controller'=>'Userss','action'=>'index'));
			}
			
		}








		public function appuserexport(){
			if($this->Session->check('id')){
				$this->autoRender=false;
				App::import('Vendor','ExcelWriter');
				$date=date("Y-m-d");
				$this->loadModel('Appuser');
				$request=$this->request->data;
				// pr($request);
				$conditions=array();
				if($request['Appusers']['type']==1){
					$reportname="FULL";
					if($request['Appusers']['status']==1){
						$conditions="Appuser.is_active=1";
					}elseif($request['Appusers']['status']==2){
						$conditions="Appuser.is_active=0";
					}else{
						$conditions="1=1";
					}
					if($request['Appusers']['sort']==1){
						if($request['Appusers']['sorttype']==1){
							$order="`Appuser`.`email` ASC";
						}else{
							$order="`Appuser`.`email` DESC";
						}
					}elseif($request['Appusers']['sort']==2){
						if($request['Appusers']['sorttype']==1){
							$order="`Appuser`.`zip` ASC";
						}else{
							$order="`Appuser`.`zip` DESC";
						}
					}elseif($request['Appusers']['sort']==3){
						if($request['Appusers']['sorttype']==1){
							$order="`Appuser`.`city` ASC";
						}else{
							$order="`Appuser`.`city` DESC";
						}
					}elseif($request['Appusers']['sort']==4){
						if($request['Appusers']['sorttype']==1){
							$order="`Appuser`.`country` ASC";
						}else{
							$order="`Appuser`.`country` DESC";
						}
					}elseif($request['Appusers']['sort']==5){
						if($request['Appusers']['sorttype']==1){
							$order="`Appuser`.`created` ASC";
						}else{
							$order="`Appuser`.`created` DESC";
						}
					}else{
						$order="`Appuser`.`email` ASC";
					}
				$cond="Device.user_id=Appuser.id";
				$cond2="Stickeruse.user_id=Appuser.id";
				$cond3="Purchasedsticker.user_id=Appuser.id";
				$result=$this->Appuser->query("SELECT  `Appuser`.`id`, `Appuser`.`zip`, `Appuser`.`city`, `Appuser`.`email`, `Appuser`.`country`, `Appuser`.`created`, `Appuser`.`is_active`,( SELECT  SUM(`count`) FROM  digistic_stickerapp.stickeruses WHERE  user_id = `Appuser`.`id` ) AS totalused,( SELECT  COUNT(*) FROM  digistic_stickerapp.devices WHERE  user_id = `Appuser`.`id` ) AS tdevice,( SELECT COUNT(`id`) FROM digistic_stickerapp.purchasedstickers WHERE user_id=`Appuser`.`id` ) AS pstickers FROM  digistic_stickerapp.`appusers` AS Appuser WHERE $conditions GROUP BY  `Appuser`.`id` ORDER BY $order");		
				// $log = $this->Appuser->getDataSource()->getLog(false, false);
			    // debug($log);
				// pr($result);die;		
				}elseif($request['Appusers']['type']==2){
					$from=$this->request->data['Appusers']['from'];
					$to=$this->request->data['Appusers']['to'];
					$reportname="Date Range From ".date('jS F, Y',strtotime($from.' 00:00:00'))." To ".date("jS F, Y",strtotime($to.' 23:59:59'));
					$conditions="WHERE Appuser.created >= '".date($from.' 00:00:00')."' AND Appuser.created <='".date($to.' 23:59:59')."' ";
					if($request['Appusers']['status']==1){
						$conditions=" AND Appuser.is_active=1 ";
					}elseif($request['Appusers']['status']==2){
						$conditions=" AND Appuser.is_active=0 ";
					}
					if($request['Appusers']['sort']==1){
						if($request['Appusers']['sorttype']==1){
							$order="`Appuser`.`email` ASC";
						}else{
							$order="`Appuser`.`email` DESC";
						}
					}elseif($request['Appusers']['sort']==2){
						if($request['Appusers']['sorttype']==1){
							$order="`Appuser`.`zip` ASC";
						}else{
							$order="`Appuser`.`zip` DESC";
						}
					}elseif($request['Appusers']['sort']==3){
						if($request['Appusers']['sorttype']==1){
							$order="`Appuser`.`city` ASC";
						}else{
							$order="`Appuser`.`city` DESC";
						}
					}elseif($request['Appusers']['sort']==4){
						if($request['Appusers']['sorttype']==1){
							$order="`Appuser`.`country` ASC";
						}else{
							$order="`Appuser`.`country` DESC";
						}
					}elseif($request['Appusers']['sort']==5){
						if($request['Appusers']['sorttype']==1){
							$order="`Appuser`.`created` ASC";
						}else{
							$order="`Appuser`.`created` DESC";
						}
					}else{
						$order="`Appuser`.`email` ASC";
					}
					$result=$this->Appuser->query("SELECT  `Appuser`.`id`, `Appuser`.`zip`, `Appuser`.`city`, `Appuser`.`email`, `Appuser`.`country`, `Appuser`.`created`, `Appuser`.`is_active`,( SELECT  SUM(`count`) FROM  digistic_stickerapp.stickeruses WHERE  user_id = `Appuser`.`id` ) AS totalused,( SELECT  COUNT(*) FROM  digistic_stickerapp.devices WHERE  user_id = `Appuser`.`id` ) AS tdevice,( SELECT COUNT(`id`) FROM digistic_stickerapp.purchasedstickers WHERE user_id=`Appuser`.`id` ) AS pstickers FROM  digistic_stickerapp.`appusers` AS Appuser $conditions GROUP BY  `Appuser`.`id` ORDER BY $order");	
				}
				// pr($result);die;
				if($request['Appusers']['type']==1 || $request['Appusers']['type']==2){
					if(empty($result)){
						$this->Session->setFlash("No Data Found","flash_custom");
						$this->redirect(array('controller'=>'Reports'));
					}
				}
				if($request['Appusers']['type']==1 || $request['Appusers']['type']==2){
					$fileName=WWW_ROOT."files".DS."Excel".DS."Appuser_Report"."_".$reportname."_".$date.".xls";
		            $excel = new ExcelWriter($fileName);
		            $excel->writeCol("S. No.",array('font-weight'=>'bold'));
		            $excel->writeCol("Email",array('font-weight'=>'bold'));
		            $excel->writeCol("Activation Status",array('font-weight'=>'bold'));
		            $excel->writeCol("ZIP",array('font-weight'=>'bold'));
					$excel->writeCol("City",array('font-weight'=>'bold'));
		            $excel->writeCol("Country",array('font-weight'=>'bold'));
		            $excel->writeCol("Total Stickers Used",array('font-weight'=>'bold'));
		            $excel->writeCol("Total Devices",array('font-weight'=>'bold'));
					$excel->writeCol("Total Stickers Purchased",array('font-weight'=>'bold'));
					$excel->writeCol("Date Registered",array('font-weight'=>'bold'));
		            foreach($result as $key=>$data){
		                if($key==0){
		                    $excel->writeLine(array(), array());
		                }
		                $excel->writeCol($key+1, array());
		                $excel->writeCol($data['Appuser']['email']);
						if($data['Appuser']['is_active']==1){
							$excel->writeCol("Active");	
						}else{
							$excel->writeCol("Inactive");
						}
						if(!empty($data['Appuser']['zip'])){
							$excel->writeCol($data['Appuser']['zip']);
						}else{
							$excel->writeCol("Not Available");
						}
						$excel->writeCol($data['Appuser']['city']);
						$excel->writeCol($data['Appuser']['country']);
						if(!empty($data['0']['totalused'])){
							$excel->writeCol($data['0']['totalused']);	
						}else{
							$excel->writeCol('None');						
						}
						if(!empty($data['0']['tdevice'])){
							$excel->writeCol($data['0']['tdevice']);	
						}else{
							$excel->writeCol('None');						
						}
						if(!empty($data['0']['pstickers'])){
							$excel->writeCol($data['0']['pstickers']);	
						}else{
							$excel->writeCol('None');						
						}
						$excel->writeCol(date("F j, Y, g:i A",strtotime($data['Appuser']['created'])));
						$excel->writeLine(array());
		            }
					$this->redirect(DS."files".DS."Excel".DS."Appuser_Report"."_".$reportname."_".$date.".xls");
				}else{
					// pr($request);
					$id=$this->Appuser->find('first',array('fields'=>'id','conditions'=>array('email'=>$request['Appusers']['email'])));
					// pr($id);
					// $conditions="WHERE id=".$id['Appuser']['id'];
					if($request['Appusers']['include']==1){
						$reportname="for ".$request['Appusers']['email']."_Purchased Stickers";
						$this->loadModel('Purchasedsticker');
						$query="SELECT * FROM `appusers` INNER JOIN purchasedstickers on purchasedstickers.user_id=appusers.id INNER JOIN stickers ON stickers.id=purchasedstickers.sticker_id WHERE appusers.id=".$id['Appuser']['id'];
						$result=$this->Appuser->query($query);
						// pr($result);die;
						$fileName=WWW_ROOT."files".DS."Excel".DS."Appuser_Report"."_".$reportname."_".$date.".xls";
						$excel = new ExcelWriter($fileName);
						$excel->writeCol("USER",array('font-weight'=>'bold','color'=>'green'));
						$excel->writeCol("DATA",array('font-weight'=>'bold','color'=>'green'));
						$excel->writeLine(array());
						$excel->writeLine(array());
						$excel->writeCol("S. No.",array('font-weight'=>'bold'));
			            $excel->writeCol("Email",array('font-weight'=>'bold'));
		    	        $excel->writeCol("Activation Status",array('font-weight'=>'bold'));
		        	    $excel->writeCol("ZIP",array('font-weight'=>'bold'));
						$excel->writeCol("City",array('font-weight'=>'bold'));
			            $excel->writeCol("Country",array('font-weight'=>'bold'));
						$excel->writeCol("Date Registered",array('font-weight'=>'bold'));
						$excel->writeLine(array());
						$excel->writeCol("1");
						$excel->writeCol($result['0']['appusers']['email']);
						if($result['0']['appusers']['is_active']==1){
							$excel->writeCol("Active");
						}else{
							$excel->writeCol("Inactive");
						}
						if(!empty($result['0']['appusers']['zip'])){
							$excel->writeCol($result['0']['appusers']['zip']);
						}else{
							$excel->writeCol("Not Available");
						}
						$excel->writeCol($result['0']['appusers']['city']);
						$excel->writeCol($result['0']['appusers']['country']);
						$excel->writeCol($result['0']['appusers']['created']);
						$excel->writeLine(array());
						$excel->writeLine(array());
						$excel->writeCol("PURCHASED",array('font-weight'=>'bold','color'=>'green'));
						$excel->writeCol("STICKER",array('font-weight'=>'bold','color'=>'green'));
						$excel->writeCol("DATA",array('font-weight'=>'bold','color'=>'green'));
						$excel->writeLine(array());
						$excel->writeLine(array());
						$excel->writeCol("S. No.",array('font-weight'=>'bold'));
			            $excel->writeCol("Name",array('font-weight'=>'bold'));
		    	        $excel->writeCol("Activation Status",array('font-weight'=>'bold'));
						$excel->writeCol("Created",array('font-weight'=>'bold'));
						$excel->writeCol("Modified",array('font-weight'=>'bold'));
						foreach($result as $key=>$data){
			                if($key==0){
			                    $excel->writeLine(array(), array());
			                }
			                $excel->writeCol($key+1, array());
			                $excel->writeCol($data['stickers']['name']);
							if($data['stickers']['is_active']==1){
								$excel->writeCol("Active");	
							}else{
								$excel->writeCol("Inactive");
							}
							$excel->writeCol(date("F j, Y, g:i A",strtotime($data['stickers']['created'])));
							$excel->writeCol(date("F j, Y, g:i A",strtotime($data['stickers']['modified'])));
							$excel->writeLine(array());
		            }
						$this->redirect(DS."files".DS."Excel".DS."Appuser_Report"."_".$reportname."_".$date.".xls");
						
						
					}elseif($request['Appusers']['include']==2){
						$reportname="for ".$request['Appusers']['email']."_Devices";
						$query="SELECT * FROM `appusers` INNER JOIN devices on devices.user_id=appusers.id WHERE appusers.id=".$id['Appuser']['id'];
						$result=$this->Appuser->query($query);
						// pr($result);die;
						$fileName=WWW_ROOT."files".DS."Excel".DS."Appuser_Report"."_".$reportname."_".$date.".xls";
						$excel = new ExcelWriter($fileName);
						$excel->writeCol("USER",array('font-weight'=>'bold','color'=>'green'));
						$excel->writeCol("DATA",array('font-weight'=>'bold','color'=>'green'));
						$excel->writeLine(array());
						$excel->writeLine(array());
						$excel->writeCol("S. No.",array('font-weight'=>'bold'));
			            $excel->writeCol("Email",array('font-weight'=>'bold'));
		    	        $excel->writeCol("Activation Status",array('font-weight'=>'bold'));
		        	    $excel->writeCol("ZIP",array('font-weight'=>'bold'));
						$excel->writeCol("City",array('font-weight'=>'bold'));
			            $excel->writeCol("Country",array('font-weight'=>'bold'));
						$excel->writeCol("Date Registered",array('font-weight'=>'bold'));
						$excel->writeLine(array());
						$excel->writeCol("1");
						$excel->writeCol($result['0']['appusers']['email']);
						if($result['0']['appusers']['is_active']==1){
							$excel->writeCol("Active");
						}else{
							$excel->writeCol("Inactive");
						}
						if(!empty($result['0']['appusers']['zip'])){
							$excel->writeCol($result['0']['appusers']['zip']);
						}else{
							$excel->writeCol("Not Available");
						}
						$excel->writeCol($result['0']['appusers']['city']);
						$excel->writeCol($result['0']['appusers']['country']);
						$excel->writeCol($result['0']['appusers']['created']);
						$excel->writeLine(array());
						$excel->writeLine(array());
						$excel->writeCol("DEVICES",array('font-weight'=>'bold','color'=>'green'));
						$excel->writeCol("DATA",array('font-weight'=>'bold','color'=>'green'));
						$excel->writeLine(array());
						$excel->writeLine(array());
						$excel->writeCol("S. No.",array('font-weight'=>'bold'));
						$excel->writeCol("IMEI",array('font-weight'=>'bold'));
						$excel->writeCol("Device Type",array('font-weight'=>'bold'));
						$excel->writeCol("Notification",array('font-weight'=>'bold'));
						$excel->writeCol("Activation Status",array('font-weight'=>'bold'));
						$excel->writeCol("Date Registered",array('font-weight'=>'bold'));
						foreach($result as $key=>$data){
							if($key==0){
			                    $excel->writeLine(array(), array());
			                }
							$excel->writeCol($key+1, array());
							$excel->writeCol($data['devices']['imei']);
							if($data['devices']['device_type']==1){
								$excel->writeCol("Android");	
							}else{
								$excel->writeCol("IOS");
							}
							if($data['devices']['notification']==1){
								$excel->writeCol("On");	
							}else{
								$excel->writeCol("Off");
							}
							if($data['devices']['is_active']==1){
								$excel->writeCol("Active");	
							}else{
								$excel->writeCol("Inactive");
							}
							$excel->writeCol(date("F j, Y, g:i A",strtotime($data['devices']['created'])));
							$excel->writeLine(array(), array());
						}
						
						$this->redirect(DS."files".DS."Excel".DS."Appuser_Report"."_".$reportname."_".$date.".xls");
						
					}elseif($request['Appusers']['include']==3){
						$reportname="for ".$request['Appusers']['email']."_Used Stickers";
						$query="SELECT * FROM `appusers` INNER JOIN stickeruses on stickeruses.user_id=appusers.id INNER JOIN stickers ON stickers.id=stickeruses.sticker_id WHERE appusers.id=".$id['Appuser']['id']." ORDER BY stickeruses.count DESC";
						$result=$this->Appuser->query($query);
						// pr($result);die;
						$fileName=WWW_ROOT."files".DS."Excel".DS."Appuser_Report"."_".$reportname."_".$date.".xls";
						$excel = new ExcelWriter($fileName);
						$excel->writeCol("USER",array('font-weight'=>'bold','color'=>'green'));
						$excel->writeCol("DATA",array('font-weight'=>'bold','color'=>'green'));
						$excel->writeLine(array());
						$excel->writeLine(array());
						$excel->writeCol("S. No.",array('font-weight'=>'bold'));
			            $excel->writeCol("Email",array('font-weight'=>'bold'));
		    	        $excel->writeCol("Activation Status",array('font-weight'=>'bold'));
		        	    $excel->writeCol("ZIP",array('font-weight'=>'bold'));
						$excel->writeCol("City",array('font-weight'=>'bold'));
			            $excel->writeCol("Country",array('font-weight'=>'bold'));
						$excel->writeCol("Date Registered",array('font-weight'=>'bold'));
						$excel->writeLine(array());
						$excel->writeCol("1");
						$excel->writeCol($result['0']['appusers']['email']);
						if($result['0']['appusers']['is_active']==1){
							$excel->writeCol("Active");
						}else{
							$excel->writeCol("Inactive");
						}
						if(!empty($result['0']['appusers']['zip'])){
							$excel->writeCol($result['0']['appusers']['zip']);
						}else{
							$excel->writeCol("Not Available");
						}
						$excel->writeCol($result['0']['appusers']['city']);
						$excel->writeCol($result['0']['appusers']['country']);
						$excel->writeCol($result['0']['appusers']['created']);
						$excel->writeLine(array());
						$excel->writeLine(array());
						$excel->writeCol("USED",array('font-weight'=>'bold','color'=>'green'));
						$excel->writeCol("STICKER",array('font-weight'=>'bold','color'=>'green'));
						$excel->writeCol("DATA",array('font-weight'=>'bold','color'=>'green'));
						$excel->writeLine(array());
						$excel->writeLine(array());
						$excel->writeCol("S. No.",array('font-weight'=>'bold'));
			            $excel->writeCol("Name",array('font-weight'=>'bold'));
		    	        $excel->writeCol("Activation Status",array('font-weight'=>'bold'));
						$excel->writeCol("Created",array('font-weight'=>'bold'));
						$excel->writeCol("Modified",array('font-weight'=>'bold'));
						$excel->writeCol("Times Used",array('font-weight'=>'bold'));
						foreach($result as $key=>$data){
			                if($key==0){
			                    $excel->writeLine(array(), array());
			                }
			                $excel->writeCol($key+1, array());
			                $excel->writeCol($data['stickers']['name']);
							if($data['stickers']['is_active']==1){
								$excel->writeCol("Active");	
							}else{
								$excel->writeCol("Inactive");
							}
							$excel->writeCol(date("F j, Y, g:i A",strtotime($data['stickers']['created'])));
							$excel->writeCol(date("F j, Y, g:i A",strtotime($data['stickers']['modified'])));
							$excel->writeCol($data['stickeruses']['count']);
							$excel->writeLine(array());
		            }
						$this->redirect(DS."files".DS."Excel".DS."Appuser_Report"."_".$reportname."_".$date.".xls");
						
						
						
					}else{
						$reportname="for ".$request['Appusers']['email']."_All Data";
						$q1="SELECT * FROM `appusers` INNER JOIN devices on devices.user_id=appusers.id WHERE appusers.id=".$id['Appuser']['id'];
						$result=$this->Appuser->query($q1);
						// pr($result);die;
						$fileName=WWW_ROOT."files".DS."Excel".DS."Appuser_Report"."_".$reportname."_".$date.".xls";
						$excel = new ExcelWriter($fileName);
						$excel->writeCol("USER",array('font-weight'=>'bold','color'=>'green'));
						$excel->writeCol("DATA",array('font-weight'=>'bold','color'=>'green'));
						$excel->writeLine(array());
						$excel->writeLine(array());
						$excel->writeCol("S. No.",array('font-weight'=>'bold'));
			            $excel->writeCol("Email",array('font-weight'=>'bold'));
		    	        $excel->writeCol("Activation Status",array('font-weight'=>'bold'));
		        	    $excel->writeCol("ZIP",array('font-weight'=>'bold'));
						$excel->writeCol("City",array('font-weight'=>'bold'));
			            $excel->writeCol("Country",array('font-weight'=>'bold'));
						$excel->writeCol("Date Registered",array('font-weight'=>'bold'));
						$excel->writeLine(array());
						$excel->writeCol("1");
						$excel->writeCol($result['0']['appusers']['email']);
						if($result['0']['appusers']['is_active']==1){
							$excel->writeCol("Active");
						}else{
							$excel->writeCol("Inactive");
						}
						if(!empty($result['0']['appusers']['zip'])){
							$excel->writeCol($result['0']['appusers']['zip']);
						}else{
							$excel->writeCol("Not Available");
						}
						$excel->writeCol($result['0']['appusers']['city']);
						$excel->writeCol($result['0']['appusers']['country']);
						$excel->writeCol($result['0']['appusers']['created']);
						$excel->writeLine(array());
						$excel->writeLine(array());
						$excel->writeCol("DEVICES",array('font-weight'=>'bold','color'=>'green'));
						$excel->writeCol("DATA",array('font-weight'=>'bold','color'=>'green'));
						$excel->writeLine(array());
						$excel->writeLine(array());
						$excel->writeCol("S. No.",array('font-weight'=>'bold'));
						$excel->writeCol("IMEI",array('font-weight'=>'bold'));
						$excel->writeCol("Device Type",array('font-weight'=>'bold'));
						$excel->writeCol("Notification",array('font-weight'=>'bold'));
						$excel->writeCol("Activation Status",array('font-weight'=>'bold'));
						$excel->writeCol("Date Registered",array('font-weight'=>'bold'));
						foreach($result as $key=>$data){
							if($key==0){
			                    $excel->writeLine(array(), array());
			                }
							$excel->writeCol($key+1, array());
							$excel->writeCol($data['devices']['imei']);
							if($data['devices']['device_type']==1){
								$excel->writeCol("Android");	
							}else{
								$excel->writeCol("IOS");
							}
							if($data['devices']['notification']==1){
								$excel->writeCol("On");	
							}else{
								$excel->writeCol("Off");
							}
							if($data['devices']['is_active']==1){
								$excel->writeCol("Active");	
							}else{
								$excel->writeCol("Inactive");
							}
							$excel->writeCol(date("F j, Y, g:i A",strtotime($data['devices']['created'])));
							$excel->writeLine(array(), array());
						}
						$q2="SELECT * FROM `appusers` INNER JOIN purchasedstickers on purchasedstickers.user_id=appusers.id INNER JOIN stickers ON stickers.id=purchasedstickers.sticker_id WHERE appusers.id=".$id['Appuser']['id'];
						$result=$this->Appuser->query($q2);
						$excel->writeLine(array());
						$excel->writeCol("PURCHASED",array('font-weight'=>'bold','color'=>'green'));
						$excel->writeCol("STICKER",array('font-weight'=>'bold','color'=>'green'));
						$excel->writeCol("DATA",array('font-weight'=>'bold','color'=>'green'));
						$excel->writeLine(array());
						$excel->writeLine(array());
						$excel->writeCol("S. No.",array('font-weight'=>'bold'));
			            $excel->writeCol("Name",array('font-weight'=>'bold'));
		    	        $excel->writeCol("Activation Status",array('font-weight'=>'bold'));
						$excel->writeCol("Created",array('font-weight'=>'bold'));
						$excel->writeCol("Modified",array('font-weight'=>'bold'));
						foreach($result as $key=>$data){
			                if($key==0){
			                    $excel->writeLine(array(), array());
			                }
			                $excel->writeCol($key+1, array());
			                $excel->writeCol($data['stickers']['name']);
							if($data['stickers']['is_active']==1){
								$excel->writeCol("Active");	
							}else{
								$excel->writeCol("Inactive");
							}
							$excel->writeCol(date("F j, Y, g:i A",strtotime($data['stickers']['created'])));
							$excel->writeCol(date("F j, Y, g:i A",strtotime($data['stickers']['modified'])));
							$excel->writeLine(array());
		            	}
						$excel->writeLine(array());
						$excel->writeCol("USED",array('font-weight'=>'bold','color'=>'green'));
						$excel->writeCol("STICKER",array('font-weight'=>'bold','color'=>'green'));
						$excel->writeCol("DATA",array('font-weight'=>'bold','color'=>'green'));
						$excel->writeLine(array());
						$excel->writeLine(array());
						$excel->writeCol("S. No.",array('font-weight'=>'bold'));
			            $excel->writeCol("Name",array('font-weight'=>'bold'));
		    	        $excel->writeCol("Activation Status",array('font-weight'=>'bold'));
						$excel->writeCol("Created",array('font-weight'=>'bold'));
						$excel->writeCol("Modified",array('font-weight'=>'bold'));
						$excel->writeCol("Times Used",array('font-weight'=>'bold'));
						$q3="SELECT * FROM `appusers` INNER JOIN stickeruses on stickeruses.user_id=appusers.id INNER JOIN stickers ON stickers.id=stickeruses.sticker_id WHERE appusers.id=".$id['Appuser']['id']." ORDER BY stickeruses.count DESC";
						$result=$this->Appuser->query($q3);
						foreach($result as $key=>$data){
			                if($key==0){
			                    $excel->writeLine(array(), array());
			                }
			                $excel->writeCol($key+1, array());
			                $excel->writeCol($data['stickers']['name']);
							if($data['stickers']['is_active']==1){
								$excel->writeCol("Active");	
							}else{
								$excel->writeCol("Inactive");
							}
							$excel->writeCol(date("F j, Y, g:i A",strtotime($data['stickers']['created'])));
							$excel->writeCol(date("F j, Y, g:i A",strtotime($data['stickers']['modified'])));
							$excel->writeCol($data['stickeruses']['count']);
							$excel->writeLine(array());
		            }
						$this->redirect(DS."files".DS."Excel".DS."Appuser_Report"."_".$reportname."_".$date.".xls");
					}
					
					// pr($result);die;
				}
       	 	}else{
       	 		$this->redirect(array('controller'=>'Users','action'=>'index'));	
       	 	}
		}
	}
?>