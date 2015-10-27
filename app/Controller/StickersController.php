<?php
	class StickersController extends AppController{
		var $components=array('Session','Checkurl');
		public function index(){
			if($this->Session->check('id')){
				$this->loadModel('Sticker');
				$this->loadModel('Categorie');
				$this->loadModel('Stickeruse');
				$this->layout='admin';
				$cat=$this->Categorie->find('list',array('conditions'=>array('is_active'=>1,'is_deleted'=>0)));
				$this->set('option',$cat);
				// $conditions = array();
				$conditions=array('is_deleted'=>0);
				$limit=50;
				if(!empty($this->params['url']['searchtype'])){
					if($this->params['url']['searchtype']==1){
						$conditions=array('Sticker.name LIKE '=>"%".$this->params['url']['sticker_name']."%",'is_deleted'=>0);
					}elseif($this->params['url']['searchtype']==2){
						if($this->params['url']['type_id']==0){
							$conditions=array('Sticker.category_id'=>$this->params['url']['category_id'],'is_deleted'=>0);
						}elseif($this->params['url']['type_id']==1 || $this->params['url']['type_id']==2){
							$conditions=array('Sticker.category_id'=>$this->params['url']['category_id'],'type_id'=>$this->params['url']['type_id'],'is_deleted'=>0);
						}
					}
				}
				if(!empty($this->params['url']['time'])){
					$from=$this->params['url']['from'];
					$to=$this->params['url']['to'];
					if($this->params['url']['time']==1){
						$conditions="WHERE Sticker.created >= '".date($from)."' AND Sticker.created <='".date($to.' 23:59:59')."'";
					}elseif($this->params['url']['time']==2){
						$conditions="WHERE Sticker.modified >='".date($from)."' AND Sticker.modified <= '".date($to.'23:59:59')."'";
					}
				}
				$this->Sticker->virtualFields['total']='SUM(`Stickeruse`.`count`)';
				$cond="`Stickeruse`.`sticker_id`=`Sticker`.`id`";
				$this->paginate = array('fields'=>array('Sticker.id','Sticker.image','Sticker.type_id','Sticker.name','Sticker.category_id','Sticker.price','Sticker.is_active','Sticker.created','Sticker.modified','SUM(`Stickeruse`.`count`) AS total'),'joins'=>array(array('table'=>'stickeruses','alias'=>'Stickeruse','type'=>'left','conditions'=>$cond)),'recursive' => -1,'limit' => $limit,'conditions' => $conditions,'group'=>'Sticker.id','order'=>'Sticker.name');
		        
		        $result = $this->paginate('Sticker');
				foreach($result as $key=>$r){
					$f=$this->Categorie->find('first',array('fields'=>'name','conditions'=>array('id'=>$r['Sticker']['category_id'])));
					$result[$key]['Sticker']['category_name']=$f['Categorie']['name'];	
					
				}
		        $this->set('result', $result);
			}
			else{
				$this->redirect(array('controller'=>'Users','action'=>'index'));
			}
		}
		
		public function add(){
			if($this->Session->check('id')){
				App::Import('Model','Sticker');
				$this->Sticker=new Sticker();
				$this->layout='admin';
				$this->loadModel('Categorie');
				$this->loadModel('Device');
				$this->loadModel('Notification');
				$result=$this->Categorie->find('list',array('conditions'=>array('is_active'=>1,'is_deleted'=>0)));
				$result=array(0=>'Choose a Category')+$result;
				// pr($result);die;
				$this->set('option',$result);
				if($this->request->is('post')){
					 $this->Sticker->set($this->request->data);
					// pr($this->request->data);die;
					if($this->Sticker->validates()){
						
					 	if($this->Checkurl->clean($this->request->data['Sticker']['upload']['name']) && !empty($this->request->data['Sticker']['upload']['name'])){
                        	$file = $this->request->data['Sticker']['upload']; //put the data into a var for easy use
                        	$ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
                       		$arr_ext = array('png','jpg', 'jpeg', 'gif'); //set allowed extensions
                        	//only process if the extension is valid
                        	if(in_array($ext, $arr_ext)){
                        		$file['name']="IMG".time().".".$ext;
                                //do the actual uploading of the file. First arg is the tmp name, second arg is 
                                //where we are putting it
                                move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/uploads/' . $file['name']);
                                //prepare the filename for database entry
                        	}
                		}
						$time=date('Y-m-d H:i:s');
						$this->Sticker->save(array('name'=>$this->Checkurl->clean($this->request->data['Sticker']['name']),'image'=>$file['name'],'category_id'=>$this->Checkurl->clean($this->request->data['Sticker']['categorie']),'price'=>$this->Checkurl->clean($this->request->data['Sticker']['price']),'type_id'=>$this->Checkurl->clean($this->request->data['Sticker']['type']),'created'=>"$time"));
						$this->Session->setFlash("Added Successfully.",'flash_success');
						$this->redirect(array('controller'=>'Stickers','action'=>'add'));
					}
				}
			}else{
				$this->redirect(array('controller'=>'Users','action'=>'index'));
			}
		}
		public function activate($data,$url){
			if($this->Session->check('id') && !empty($data) && !empty($url)){
				$this->layout=false;
				$this->render(false);
				$id=base64_decode($data);
				$url=base64_decode($url);
				$pageno=$this->Checkurl->cUrl($url);
				$this->loadModel('Sticker');
				$this->Sticker->save(array('id' => $id, 'is_active' => 1));
				$this->redirect($this->referer());
			}else{
				$this->redirect(array('controller'=>'Users','action'=>'index'));
			}
		}
		public function deactivate($data,$url){
			if($this->Session->check('id') && !empty($data) && !empty($url)){
				$this->layout=false;
				$this->render(false);
				$id=base64_decode($data);
				$url=base64_decode($url);
				$pageno=$this->Checkurl->cUrl($url);
				$this->loadModel('Sticker');
				$this->loadModel('Cart');
				$this->Sticker->save(array('id' => $id, 'is_active' => 0));
				$this->Cart->deleteAll(array('sticker_id'=>$id));
				$this->redirect($this->referer());
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
				App::Import('Model','Sticker');
				$this->Sticker=new Sticker();
				App::Import('Model','Categorie');
				$this->Categorie=new Categorie();
				// $this->Sticker->unbindModel(array('belongsTo' => array('Categorie')), true);
				$result=$this->Sticker->find('first',array('conditions'=>array('id'=>$id)));
				$category=$this->Categorie->find('first',array('fields'=>'name','conditions'=>array('id'=>$result['Sticker']['category_id'])));
				
				$this->set('name',$result['Sticker']['name']);
				$this->set('category',$category['Categorie']['name']);
				$this->set('price',$result['Sticker']['price']);
				$this->set('type',$result['Sticker']['type_id']);
				$this->set('image',$result['Sticker']['image']);
				$this->set('pageno',$pageno);
			}else{
				$this->redirect(array('controller'=>'Users','action'=>'index'));
			}
		}
		public function edit($data=null,$url=null){
			if($this->Session->check('id') && !empty($data) && !empty($url)){
				$url=base64_decode($url);
				$id=base64_decode($data);
				$pageno=$this->Checkurl->cUrl($url);
				$this->layout='admin';
				App::Import('Model','Sticker');
				$this->Sticker=new Sticker();
				$this->loadModel('Categorie');
				$this->Categorie=new Categorie();
				$result=$this->Categorie->find('list',array('conditions'=>array('is_active'=>1,'is_deleted'=>0)));
				// pr($result);die;
				$this->set('option',$result);
				// $this->Sticker->unbindModel(array('belongsTo' => array('Categorie')), true);
				$result=$this->Sticker->find('first',array('conditions'=>array('id'=>$id)));
				$this->set('name',$result['Sticker']['name']);
				$this->set('image',$result['Sticker']['image']);
				$this->set('default',$result['Sticker']['category_id']);
				$this->set('price',$result['Sticker']['price']);
				$this->set('type',$result['Sticker']['type_id']);
				$this->set('pageno',$pageno);
				if($this->request->is('post')){
					// pr($this->request->data);die;
					if(!empty($this->request->data)){
						 if(!empty($this->request->data['Sticker']['upload']['name'])){
	                        $file = $this->request->data['Sticker']['upload']; //put the data into a var for easy use
	                        $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
	                        $arr_ext = array('png','jpg', 'jpeg', 'gif'); //set allowed extensions
	                        // only process if the extension is valid
	                        if(in_array($ext, $arr_ext)){
	                        	$file['name']="IMG".time().".".$ext;
	                            //do the actual uploading of the file. First arg is the tmp name, second arg is 
	                            //where we are putting it
	                            move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/uploads/' . $file['name']);
	                            //prepare the filename for database entry
	                        }
	                		$this->Sticker->save(array('id'=>$id,'name'=>$this->Checkurl->clean($this->request->data['Sticker']['name']),'image'=>$file['name'],'category_id'=>$this->Checkurl->clean($this->request->data['Sticker']['categorie']),'type_id'=>$this->Checkurl->clean($this->request->data['Sticker']['type']),'price'=>$this->Checkurl->clean($this->request->data['Sticker']['price'])));
							$this->Session->setFlash("Edited Successfully.",'flash_success');
						 }else{
							$this->Sticker->save(array('id'=>$id,'name'=>$this->Checkurl->clean($this->request->data['Sticker']['name']),'category_id'=>$this->Checkurl->clean($this->request->data['Sticker']['categorie']),'price'=>$this->Checkurl->clean($this->request->data['Sticker']['price']),'type_id'=>$this->Checkurl->clean($this->request->data['Sticker']['type'])));
							$this->Session->setFlash("Edited Successfully.",'flash_success');
							
						}
					}
					$this->redirect($this->referer());
				}
			}else{
				$this->redirect(array('controller'=>'Users','action'=>'index'));
			}
			
			
		}
		public function delete($data=null){
			if($this->Session->check('id') && !empty($data)){
				$this->layout=false;
				$this->render(false);
				$id=base64_decode($data);
				$this->loadModel('Sticker');
				$this->loadModel('Cart');
				$this->Sticker->save(array('id' => $id, 'is_deleted' => 1,'is_active'=>0));
				$this->Cart->deleteAll(array('sticker_id'=>$id));
				$this->redirect($this->referer());
			}else{
				$this->redirect(array('controller'=>'Users','action'=>'index'));
			}
			
		}
		public function view_deleted(){
			if($this->Session->check('id')){
				App::Import('Model','Sticker');
				$this->Sticker=new Sticker();
				$this->layout='admin';
				$conditions=array('is_deleted'=>1);
				$this->paginate = array('recursive' => -1,'limit' => 10,'conditions' => $conditions,);
		        $result = $this->paginate('Sticker');
		        $this->set('result', $result);
			}else{
				$this->redirect(array('controller'=>'Users','action'=>'index'));
			}
		}

		public function undelete($data=null){
			if($this->Session->check('id') && !empty($data)){
				$this->layout=false;
				$this->render(false);
				$id=base64_decode($data);
				$this->loadModel('Sticker');
				$this->loadModel('Categorie');
				$cat=$this->Sticker->find('first',array('fields'=>'category_id','conditions'=>array('id'=>$id)));
				// pr($cat);die;
				if($this->Categorie->find('first',array('conditions'=>array('id'=>$cat['Sticker']['category_id'],'is_deleted'=>0)))){
					$this->Sticker->save(array('id' => $id, 'is_deleted' => 0));
				}else{
					$this->Session->setFlash('Categorie for this Sticker is deleted.','flash_custom');					
				}
				$this->redirect($this->referer());
			}else{
				$this->redirect(array('controller'=>'Users','action'=>'index'));
			}	
			
		}	

		public function sendmessage($registatoin_ids, $message){
			
			// Set POST variables
			$url = 'https://android.googleapis.com/gcm/send';
			$fields = array('registration_ids' => $registatoin_ids, 'data' => $message );
			
			$headers = array('Authorization: key=' . 'AIzaSyB-Ktn9yficAvHdllpgGPy2vrLArqcCiTo', 'Content-Type: application/json');
			$ch = curl_init();
 
	        // Set the url, number of POST vars, POST data
	        curl_setopt($ch, CURLOPT_URL, $url);
	 
	        curl_setopt($ch, CURLOPT_POST, true);
	        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	 
	        // Disabling SSL Certificate support temporarly
	        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	 
	        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
	 
	        // Execute post
	        $result = curl_exec($ch);
	        if ($result === FALSE) {
	            die('Curl failed: ' . curl_error($ch));
	        }
	 
	        // Close connection
	        curl_close($ch);
	        echo $result;
		}
		public function bulk(){
			if($this->Session->check('id')){
				$this->loadModel('Sticker');
				$this->loadModel('Cart');
				$this->autoRender=false;
				if(!empty($this->request->data['Free'])){
				$data=$this->request->data['Free']['checks'];
				if($this->request->data['submit']==="Delete"){
					if(!empty($data)){
						// pr($data);die;
						// pr($this->request->data);die;
						if($this->request->data['Free']['checks']['0']=='all'){
							$this->Sticker->updateAll(array('is_deleted'=>1,'is_active'=>0),array('is_deleted'=>0));
							$this->Cart->deleteAll();
						}else{
							foreach($data as $key=>$value){
								$this->Sticker->create();
								$this->Sticker->save(array('id'=>$value,'is_deleted'=>1));
								$this->Cart->deleteAll(array('sticker_id'=>$value));
							}
						}
						$this->Session->setFlash("Deleted Successfully",'flash_success');
						$this->redirect($this->referer());
					}else{
						$this->Session->setFlash("Select Atleast One Sticker",'flash_custom');	
						$this->redirect($this->referer());					
					}
				}elseif($this->request->data['submit']==="Activate"){
					if(!empty($data)){
						// pr($data);die;
						// pr($this->request->data);die;
						if($this->request->data['Free']['checks']['0']=='all'){
							$this->Sticker->updateAll(array('is_active'=>1),array('is_active'=>0));
						}else{
							foreach($data as $key=>$value){
								$this->Sticker->create();
								$this->Sticker->save(array('id'=>$value,'is_active'=>1));
							}
						}
						$this->Session->setFlash("Activated Successfully",'flash_success');
						$this->redirect($this->referer());
					}else{
						$this->Session->setFlash("Select Atleast One Sticker",'flash_custom');	
						$this->redirect($this->referer());					
					}
				}elseif($this->request->data['submit']==="Deactivate"){
					if(!empty($data)){
						// pr($data);die;
						if($this->request->data['Free']['checks']['0']=='all'){
							$this->Sticker->updateAll(array('is_active'=>0),array('is_active'=>1));
						}else{
							foreach($data as $key=>$value){
								$this->Sticker->create();
								$this->Sticker->save(array('id'=>$value,'is_active'=>0));
								$this->Cart->deleteAll(array('sticker_id'=>$value));
							}
						}
						$this->Session->setFlash("Deactivated Successfully",'flash_success');
						$this->redirect($this->referer());
					}else{
						$this->Session->setFlash("Select Atleast One Sticker",'flash_custom');	
						$this->redirect($this->referer());					
					}
				}elseif($this->request->data['submit']==="Markfree"){
						if(!empty($data)){
							foreach($data as $key=>$value){
								if($value!='all'){
									$this->Sticker->create();
									$this->Sticker->save(array('id'=>$value,'type_id'=>1,'price'=>0.00));									
								}
							}
						$this->Session->setFlash("Marked As Free Successfully",'flash_success');
						$this->redirect($this->referer());
					}else{
						$this->Session->setFlash("Select Atleast One Sticker",'flash_custom');	
						$this->redirect($this->referer());					
					}
				}elseif($this->request->data['submit']==="Markpaid"){
					if(!empty($data)){
						foreach($data as $key=>$value){
							if($value!='all'){
								$this->Sticker->create();
								$this->Sticker->save(array('id'=>$value,'type_id'=>2,'price'=>0.00));
							}	
						}
						$this->Session->setFlash("Marked As Paid Successfully",'flash_success');
						$this->redirect($this->referer());
					}else{
						$this->Session->setFlash("Select Atleast One Sticker",'flash_custom');	
						$this->redirect($this->referer());					
					}
				}
			}else{
				$this->Session->setFlash("Select Atleast One Sticker",'flash_custom');
				$this->redirect($this->referer());
			}	
			}else{
				$this->redirect(array('controller'=>'Users','action'=>'index'));
			}
		}

		public function stickerexport(){
			if($this->Session->check('id')){
				$this->autoRender=false;
				App::import('Vendor','ExcelWriter');
				$date=date("Y-m-d");
				$this->loadModel('Sticker');
				$request=$this->request->data;
				// pr($request);
				$conditions=array();
				if($request['Stickers']['type']==1){
					$reportname="FULL";
					if($request['Stickers']['status']==1){
						$conditions="Sticker.is_active=1";
					}elseif($request['Stickers']['status']==2){
						$conditions="Sticker.is_active=0";
					}else{
						$conditions=array();
					}
				}elseif($request['Stickers']['type']==2){
					$from=$this->request->data['Stickers']['from'];
					$to=$this->request->data['Stickers']['to'];
					$reportname="Created From ".date('jS F, Y',strtotime($from.' 00:00:00'))." To ".date("jS F, Y",strtotime($to.' 23:59:59'));
					$conditions="WHERE Sticker.created >= '".date($from.' 00:00:00')."' AND Sticker.created <='".date($to.' 23:59:59')."' ";
					if($request['Stickers']['status']==1){
						$conditions.="AND Sticker.is_active=1";
					}elseif($request['Stickers']['status']==2){
						$conditions.="AND Sticker.is_active=0";
					}else{
						$conditions.="";
					}
				}elseif($request['Stickers']['type']==3){
					$from=$this->request->data['Stickers']['from'];
					$to=$this->request->data['Stickers']['to'];
					$reportname="Modified From ".date('jS F, Y',strtotime($from.' 00:00:00'))." To ".date("jS F, Y",strtotime($to.' 23:59:59'));
					$conditions="WHERE Sticker.modified >= '".date($from.' 00:00:00')."' AND Sticker.modified <='".date($to.' 23:59:59')."' ";
					if($request['Stickers']['status']==1){
						$conditions.="AND Sticker.is_active=1";
					}elseif($request['Stickers']['status']==2){
						$conditions.="AND Sticker.is_active=0";
					}else{
						$conditions.="";
					}
					// pr($conditions);die;
				}
					if($request['Stickers']['sort']==1){
						if($request['Stickers']['sorttype']==1){
							$order="Sticker.name ASC";
						}else{
							$order="Sticker.name DESC";
						}
					}elseif($request['Stickers']['sort']==2){
						if($request['Stickers']['sorttype']==1){
							$order="Categorie.name ASC";
						}else{
							$order="Categorie.name DESC";
						}
					}elseif($request['Stickers']['sort']==3){
						if($request['Stickers']['sorttype']==1){
							$order="Sticker.type_id ASC";
						}else{
							$order="Sticker.type_id DESC";
						}
					}elseif($request['Stickers']['sort']==4){
						if($request['Stickers']['sorttype']==1){
							$order="Sticker.is_active ASC";
						}else{
							$order="Sticker.is_active DESC";
						}
					}elseif($request['Stickers']['sort']==5){
						if($request['Stickers']['sorttype']==1){
							$order="total ASC";
						}else{
							$order="total DESC";
						}
					}elseif($request['Stickers']['sort']==6){
						if($request['Stickers']['sorttype']==1){
							$order="Sticker.created ASC";
						}else{
							$order="Sticker.created DESC";
						}
					}elseif($request['Stickers']['sort']==7){
						if($request['Stickers']['sorttype']==1){
							$order="Sticker.modified ASC";
						}else{
							$order="Sticker.modified DESC";
						}
					}else{
						$order="Sticker.name ASC";
					}
					
				$cond="`Stickeruse.sticker_id`=`Sticker`.`id`";
				$cond2="`Categorie`.`id`=`Sticker`.`category_id`";
				$result=$this->Sticker->find('all',array('fields'=>array('Sticker.id','Sticker.name','Sticker.category_id','Sticker.type_id','Sticker.is_active','Sticker.is_deleted','Sticker.created','Sticker.modified','SUM(`Stickeruse`.`count`) AS total','Categorie.name'),'joins'=>array(array('table'=>'stickeruses','alias'=>'Stickeruse','type'=>'left','conditions'=>$cond),array('table'=>'categories','alias'=>'Categorie','type'=>'left','conditions'=>$cond2)),'conditions'=>$conditions,'order'=>$order,'group'=>'Sticker.id'));
				if(empty($result)){
					$this->Session->setFlash("No Data Found","flash_custom");
					$this->redirect(array('controller'=>'Reports'));
				}
				$fileName=WWW_ROOT."files".DS."Excel".DS."Sticker_Report"."_".$reportname."_".$date.".xls";
	            $excel = new ExcelWriter($fileName);
	            $excel->writeCol("S. No.",array('font-weight'=>'bold'));
	            $excel->writeCol("Name",array('font-weight'=>'bold'));
	            $excel->writeCol("Activation Status",array('font-weight'=>'bold'));
	            $excel->writeCol("Deletion Status",array('font-weight'=>'bold'));
				$excel->writeCol("Type",array('font-weight'=>'bold'));
	            $excel->writeCol("Category",array('font-weight'=>'bold'));
	            $excel->writeCol("Times Used",array('font-weight'=>'bold'));
	            $excel->writeCol("Created",array('font-weight'=>'bold'));
				$excel->writeCol("Modified",array('font-weight'=>'bold'));
				
	            foreach($result as $key=>$data){
	                if($key==0){
	                    $excel->writeLine(array(), array());
	                }
	                $excel->writeCol($key+1, array());
	                $excel->writeCol($data['Sticker']['name']);
					if($data['Sticker']['is_active']==1){
						$excel->writeCol("Active");	
					}else{
						$excel->writeCol("Inactive");
					}
					if($data['Sticker']['is_deleted']==0){
						$excel->writeCol("Not Deleted");
					}else{
						$excel->writeCol("Deleted");
					}
					if($data['Sticker']['type_id']==1){
						$excel->writeCol("Free");
					}else{
						$excel->writeCol("Paid");
					}
					$excel->writeCol($data['Categorie']['name']);
					if(!empty($data['0']['total'])){
						$excel->writeCol($data['0']['total']);	
					}else{
						$excel->writeCol('None');						
					}
					$excel->writeCol(date("F j, Y, g:i A",strtotime($data['Sticker']['created'])));
					$excel->writeCol(date("F j, Y, g:i A",strtotime($data['Sticker']['modified'])));
					$excel->writeLine(array());
	            }
				$this->redirect(DS."files".DS."Excel".DS."Sticker_Report"."_".$reportname."_".$date.".xls");
       	 	}else{
       	 		$this->redirect(array('controller'=>'Users','action'=>'index'));	
       	 	}
		}


		public function purchasedexport(){
			if($this->Session->check('id')){
				$this->autoRender=false;
				App::import('Vendor','ExcelWriter');
				$date=date("Y-m-d");
				$this->loadModel('Purchasedsticker');
				$request=$this->request->data;
				// echo "Work in Progress \n";
				// pr($request);die;
				$conditions=array('Purchasedsticker.by_admin'=>0);
				if($request['Stickers']['type']==1){
					$reportname="FULL";
					if($request['Stickers']['reporttype']==1){
						$conditions="Purchasedsticker.by_admin=0";
					}elseif($request['Stickers']['reporttype']==2){
						$conditions="Purchasedsticker.by_admin=1";
					}elseif($request['Stickers']['reporttype']==3){
						$conditions=array();
					}
				}elseif($request['Stickers']['type']==2){
					$reportname="By_DATE";
					$from=$request['Stickers']['from'];
					$to=$request['Stickers']['to'];
					$conditions="WHERE Purchasedsticker.created >= '".date($from.' 00:00:00')."' AND Purchasedsticker.created <='".date($to.' 23:59:59')."' ";
					if($request['Stickers']['reporttype']==1){
						$conditions.=" AND Purchasedsticker.by_admin=0";
					}elseif($request['Stickers']['reporttype']==2){
						$conditions.=" AND Purchasedsticker.by_admin=1";
					}elseif($request['Stickers']['reporttype']==3){
					}
				}
					// pr($conditions);die;
					if($request['Stickers']['sort']==1){
						if($request['Stickers']['sorttype']==1){
							$order="Sticker.name ASC";
						}else{
							$order="Sticker.name DESC";
						}
					}elseif($request['Stickers']['sort']==2){
						if($request['Stickers']['sorttype']==1){
							$order="Categorie.name ASC";
						}else{
							$order="Categorie.name DESC";
						}
					}elseif($request['Stickers']['sort']==5){
						if($request['Stickers']['sorttype']==1){
							$order="total ASC";
						}else{
							$order="total DESC";
						}
					}else{
						$order="Sticker.name ASC";
					}
				$cond="`Sticker`.`id`=`Purchasedsticker.sticker_id`";
				$cond2="`Categorie`.`id`=`Sticker`.`category_id`";
				$result=$this->Purchasedsticker->find('all',array('fields'=>array('Sticker.id','Sticker.name','Sticker.category_id','Sticker.type_id','Sticker.is_active','Sticker.is_deleted','Sticker.created','Sticker.modified','Purchasedsticker.created','Categorie.name','COUNT(`Purchasedsticker`.`sticker_id`) AS total'),'joins'=>array(array('table'=>'stickers','alias'=>'Sticker','type'=>'left','conditions'=>$cond),array('table'=>'categories','alias'=>'Categorie','type'=>'left','conditions'=>$cond2)),'conditions'=>$conditions,'order'=>$order,'group'=>'Sticker.id'));
				// $log = $this->Purchasedsticker->getDataSource()->getLog(false, false);
			    // debug($log);
			    // foreach($result as $key=>$value){
// 			    	
			    // }
				// echo "Work in progress.\n";
// 				
				// pr($result);die;
				if(empty($result)){
					$this->Session->setFlash("No Data Found","flash_custom");
					$this->redirect(array('controller'=>'Reports'));
				}
				
				$fileName=WWW_ROOT."files".DS."Excel".DS."Purchased_Stickers_Report"."_".$reportname."_".$date.".xls";
	            $excel = new ExcelWriter($fileName);
	            $excel->writeCol("S. No.",array('font-weight'=>'bold'));
	            $excel->writeCol("Name",array('font-weight'=>'bold'));
	            $excel->writeCol("Activation Status",array('font-weight'=>'bold'));
	            $excel->writeCol("Category",array('font-weight'=>'bold'));
				if($request['Stickers']['reporttype']==2){
					$excel->writeCol("Times Given",array('font-weight'=>'bold'));
				}else{
					$excel->writeCol("Times Purchased",array('font-weight'=>'bold'));
				}
	            foreach($result as $key=>$data){
	                if($key==0){
	                    $excel->writeLine(array(), array());
	                }
	                $excel->writeCol($key+1, array());
	                $excel->writeCol($data['Sticker']['name']);
					if($data['Sticker']['is_active']==1){
						$excel->writeCol("Active");	
					}else{
						$excel->writeCol("Inactive");
					}
					$excel->writeCol($data['Categorie']['name']);
					$excel->writeCol($data['0']['total']);	
					$excel->writeLine(array());
	            }
				$this->redirect(DS."files".DS."Excel".DS."Purchased_Stickers_Report"."_".$reportname."_".$date.".xls");
       	 	}else{
       	 		$this->redirect(array('controller'=>'Users','action'=>'index'));	
       	 	}
		}
	}
?>