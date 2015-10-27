<?php
	class CategoriesController extends AppController{
		var $components=array('Session','Checkurl');
		public function index(){
			if($this->Session->check('id')){
				$this->loadModel('Categorie');
				$this->layout='admin';
				$limit=100;
				$conditions=array('Categorie.is_deleted'=>0);
				if(!empty($this->request->data)){
					if(empty($this->request->data['Categorie']['time'])){
						$this->Session->setFlash('Please Select a date type','flash_custom');
						$this->redirect(array('Controller'=>'Categories','action'=>'index'));	
					}else{
						if(!empty($this->request->data['Categorie']['from']) && !empty($this->request->data['Categorie']['to'])){
							if($this->request->data['Categorie']['time']==1){
								$from=$this->request->data['Categorie']['from'];
								$to=$this->request->data['Categorie']['to'];
								$conditions="WHERE Categorie.created >= '".date($from)."' AND Categorie.created <='".date($to.' 23:59:59')."'";
								$limit=100;
								// pr($conditions);die;
							}
							if($this->request->data['Categorie']['time']==2){
								$from=$this->request->data['Categorie']['from'];
								$to=$this->request->data['Categorie']['to'];
								$conditions="WHERE Categorie.updated >='".date($from)."' AND Categorie.updated <= '".date($to.' 23:59:59')."'";
								$limit=100;
								// pr($conditions);die;
							}
						}
					}
				}
				
				$this->Categorie->virtualFields['Total'] = 'COUNT(`Sticker`.`id`)';
				$cond="`Sticker`.`category_id` = `Categorie`.`id` AND `Sticker`.`is_deleted`=`0`";
				$fields="`Categorie`.`id`, `Categorie`.`image`, `Categorie`.`name`, `Categorie`.`is_active`, `Categorie`.`created`, `Categorie`.`updated`, COUNT(`Sticker`.`id`) AS Total";
				$this->paginate = array('fields'=>$fields,'joins'=>array(array('table'=>'stickers','alias'=>'Sticker','type'=>'left','conditions'=>$cond)),'conditions' => $conditions,'recursive' => -1,'limit' => $limit,'group'=>'Categorie.id');
		        $result = $this->paginate('Categorie');
				// $log = $this->Categorie->getDataSource()->getLog(false, false);
		        // debug($log);
		        // pr($result);die;
		        $this->set('result', $result);
				
			}else{
				$this->redirect(array('controller'=>'Users','action'=>'index'));
			}
		}
		public function add(){
			if($this->Session->check('id')){
				App::Import('Model','Categorie');
				$this->Categorie=new Categorie();
				$this->layout='admin';
				if($this->request->is('post')){
					 $this->Categorie->set($this->request->data);
					// pr($this->request->data);die;
					if($this->Categorie->validates()){
					 	if($this->Checkurl->clean($this->request->data['Categorie']['upload']['name']) && !empty($this->request->data['Categorie']['upload']['name'])){
                        	$file = $this->request->data['Categorie']['upload']; //put the data into a var for easy use
                        	$ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
                       		$arr_ext = array('png','jpg', 'jpeg', 'gif'); //set allowed extensions
                        	//only process if the extension is valid
                        	if(in_array($ext, $arr_ext)){
                        		$file['name']="IMG".time().".".$ext;
                                //do the actual uploading of the file. First arg is the tmp name, second arg is 
                                //where we are putting it
                                move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/uploads/categories/' . $file['name']);

                                //prepare the filename for database entry
                                
                        	}
                		}
						$time=date('Y-m-d H:i:s');
						$this->Categorie->save(array('name'=>$this->Checkurl->clean($this->request->data['Categorie']['name']),'image'=>$file['name'],'is_active'=>0,'created'=>$time));
						$this->Session->setFlash("Added Successfully.",'flash_success');
						$this->redirect($this->referer());
						
					}
				}
			}else{
				$this->redirect(array('controller'=>'Users','action'=>'index'));
			}
			
		}
		public function activate($data=null,$url=null){
			if($this->Session->check('id')  && !empty($data) && !empty($url)){
				$this->layout=false;
				$this->render(false);
				$id=base64_decode($data);
				$url=base64_decode($url);
				$pageno=$this->Checkurl->cUrl($url);
				$this->loadModel('Categorie');
				$this->loadModel('Sticker');
				$this->Categorie->save(array('id' => $id, 'is_active' => 1));
				$this->Sticker->updateAll(array('is_active' => 1),array('category_id'=>$id));
				$this->Session->setFlash("Activated Successfully.",'flash_success');
				$this->redirect($this->referer());
				
			}else{
				$this->redirect(array('controller'=>'Users','action'=>'index'));
			}
		}
		public function deactivate($data=null,$url=null){
			if($this->Session->check('id')  && !empty($data) && !empty($url)){
				$this->layout=false;
				$this->render(false);
				$id=base64_decode($data);
				$url=base64_decode($url);
				$pageno=$this->Checkurl->cUrl($url);
				$this->loadModel('Categorie');
				$this->loadModel('Sticker');
				$this->Categorie->save(array('id' => $id, 'is_active' => 0));
				$this->Sticker->updateAll(array('is_active' => 0),array('category_id'=>$id));
				$this->Session->setFlash("Deactivated Successfully.",'flash_success');
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
				$this->loadModel('Categorie');
				$this->loadModel('Sticker');
				$stickers=$this->Sticker->find('all',array('conditions'=>array('category_id'=>$id,'is_deleted'=>0),'order'=>'name'));
				$result=$this->Categorie->find('first',array('conditions'=>array('id'=>$id)));
				$this->set('name',$result['Categorie']['name']);
				$this->set('image',$result['Categorie']['image']);
				$this->set('stickers',$stickers);
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
				App::Import('Model','Categorie');
				$this->Categorie=new Categorie();
				$result=$this->Categorie->find('first',array('conditions'=>array('id'=>$id)));
				$this->set('name',$result['Categorie']['name']);
				$this->set('image',$result['Categorie']['image']);
				if($this->request->is('post')){
					// pr($this->request->data);die;
					if(!empty($this->request->data)){
						 if(!empty($this->request->data['Categorie']['upload']['name'])){
	                        $file = $this->request->data['Categorie']['upload']; //put the data into a var for easy use
	                        $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
	                        $arr_ext = array('png','jpg', 'jpeg', 'gif'); //set allowed extensions
	                        //only process if the extension is valid
	                        if(in_array($ext, $arr_ext)){
	                        	$file['name']="IMG".time().".".$ext;
	                            //do the actual uploading of the file. First arg is the tmp name, second arg is 
	                            //where we are putting it
	                            move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/uploads/categories/' . $file['name']);
	                            //prepare the filename for database entry
	                        }
	                		$this->Categorie->save(array('id'=>$id,'name'=>$this->request->data['Categorie']['name'],'image'=>$file['name']));
						 	$this->Session->setFlash(" Edited Successfully.",'flash_success');
						}else{
							$this->Categorie->save(array('id'=>$id,'name'=>$this->request->data['Categorie']['name']));
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
				$this->loadModel('Categorie');
				$this->loadModel('Sticker');
				$this->Categorie->save(array('id' => $id, 'is_deleted' => 1,'is_active'=>0));
				$this->Sticker->updateAll(array('is_deleted'=>1),array('category_id'=>$id));
				$this->redirect($this->referer());
			}else{
				$this->redirect(array('controller'=>'Users','action'=>'index'));
			}
			
		}
		public function view_deleted(){
			if($this->Session->check('id')){
				App::Import('Model','Categorie');
				$this->Categorie=new Categorie();
				$this->layout='admin';
				$conditions=array('is_deleted'=>1);
				$this->paginate = array('recursive' => -1,'limit' => 10,'conditions' => $conditions,);
		        $result = $this->paginate('Categorie');
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
				$this->loadModel('Categorie');
				$this->loadModel('Sticker');
				$this->Categorie->save(array('id' => $id, 'is_deleted' => 0));
				$this->Sticker->updateAll(array('is_deleted'=>0,'is_active'=>0),array('category_id'=>$id));
				$this->redirect($this->referer());
			}else{
				$this->redirect(array('controller'=>'Users','action'=>'index'));
			}	
			
		}
		public function categoryexport(){
			if($this->Session->check('id')){
				// pr($this->request->data);
				$this->autoRender=false;
				App::import('Vendor','ExcelWriter');
				$date=date("Y-m-d");
				$this->loadModel('Categorie');
				$request=$this->request->data;
				// pr($request);
				$conditions=array();
				if($request['Categories']['type']==1){
					$reportname="FULL";
					if($request['Categories']['status']==1){
						$conditions="Categorie.is_active=1";
					}elseif($request['Categories']['status']==2){
						$conditions="Categorie.is_active=0";
					}else{
						$conditions=array();
					}
				}elseif($request['Categories']['type']==2){
					$from=$this->request->data['Categories']['from'];
					$to=$this->request->data['Categories']['to'];
					$reportname="Created From ".date('jS F, Y',strtotime($from.' 00:00:00'))." To ".date("jS F, Y",strtotime($to.' 23:59:59'));
					$conditions="WHERE Categorie.created >= '".date($from.' 00:00:00')."' AND Categorie.created <='".date($to.' 23:59:59')."' ";
					if($request['Categories']['status']==1){
						$conditions.="AND Categorie.is_active=1";
					}elseif($request['Categories']['status']==2){
						$conditions.="AND Categorie.is_active=0";
					}else{
						$conditions.="";
					}
				}elseif($request['Categories']['type']==3){
					$from=$this->request->data['Categories']['from'];
					$to=$this->request->data['Categories']['to'];
					$reportname="Modified From ".date('jS F, Y',strtotime($from.' 00:00:00'))." To ".date("jS F, Y",strtotime($to.' 23:59:59'));
					$conditions="WHERE Categorie.updated >= '".date($from.' 00:00:00')."' AND Categorie.updated <='".date($to.' 23:59:59')."' ";
					if($request['Categories']['status']==1){
						$conditions.="AND Categorie.is_active=1";
					}elseif($request['Categories']['status']==2){
						$conditions.="AND Categorie.is_active=0";
					}else{
						$conditions.="";
					}
					// pr($conditions);die;
				}
					if($request['Categories']['sort']==1){
						if($request['Categories']['sorttype']==1){
							$order="Categorie.name ASC";
						}else{
							$order="Categorie.name DESC";
						}
					}elseif($request['Categories']['sort']==4){
						if($request['Categories']['sorttype']==1){
							$order="Categorie.is_active ASC";
						}else{
							$order="Categorie.is_active DESC";
						}
					}elseif($request['Categories']['sort']==5){
						if($request['Categories']['sorttype']==1){
							$order="total ASC";
						}else{
							$order="total DESC";
						}
					}elseif($request['Categories']['sort']==6){
						if($request['Categories']['sorttype']==1){
							$order="Categorie.created ASC";
						}else{
							$order="Categorie.created DESC";
						}
					}elseif($request['Categories']['sort']==7){
						if($request['Categories']['sorttype']==1){
							$order="Categorie.updated ASC";
						}else{
							$order="Categorie.updated DESC";
						}
					}else{
						$order="Categorie.name ASC";
					}
					
				$cond="`Sticker.category_id`=`Categorie`.`id`";
				$result=$this->Categorie->find('all',array('fields'=>array('Categorie.id','Categorie.name','Categorie.is_active','Categorie.is_deleted','Categorie.created','Categorie.updated','COUNT(`Sticker`.`id`) AS total'),'joins'=>array(array('table'=>'stickers','alias'=>'Sticker','type'=>'inner','conditions'=>$cond)),'conditions'=>$conditions,'order'=>$order,'group'=>'Categorie.id'));
				if(empty($result)){
					$this->Session->setFlash("No Data Found","flash_custom");
					$this->redirect(array('controller'=>'Reports'));
				}
				// pr($result);die;
				$fileName=WWW_ROOT."files".DS."Excel".DS."Category_Report"."_".$reportname."_".$date.".xls";
	            $excel = new ExcelWriter($fileName);
	            $excel->writeCol("S. No.",array('font-weight'=>'bold'));
	            $excel->writeCol("Name",array('font-weight'=>'bold'));
	            $excel->writeCol("Activation Status",array('font-weight'=>'bold'));
	            $excel->writeCol("Deletion Status",array('font-weight'=>'bold'));
				$excel->writeCol("Total Stickers",array('font-weight'=>'bold'));
	            $excel->writeCol("Created",array('font-weight'=>'bold'));
				$excel->writeCol("Modified",array('font-weight'=>'bold'));
				
	            foreach($result as $key=>$data){
	                if($key==0){
	                    $excel->writeLine(array(), array());
	                }
	                $excel->writeCol($key+1, array());
	                $excel->writeCol($data['Categorie']['name']);
					if($data['Categorie']['is_active']==1){
						$excel->writeCol("Active");	
					}else{
						$excel->writeCol("Inactive");
					}
					if($data['Categorie']['is_deleted']==0){
						$excel->writeCol("Not Deleted");
					}else{
						$excel->writeCol("Deleted");
					}
					if(!empty($data['0']['total'])){
						$excel->writeCol($data['0']['total']);	
					}else{
						$excel->writeCol('None');						
					}
					$excel->writeCol(date("F j, Y, g:i A",strtotime($data['Categorie']['created'])));
					$excel->writeCol(date("F j, Y, g:i A",strtotime($data['Categorie']['updated'])));
					$excel->writeLine(array());
	            }
				$this->redirect(DS."files".DS."Excel".DS."Category_Report"."_".$reportname."_".$date.".xls");
       	 	}else{
       	 		$this->redirect(array('controller'=>'Users','action'=>'index'));	
       	 	}
		}
	}
?>