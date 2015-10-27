<?php
	class MessagesController extends AppController{
		var $components=array('Session','Checkurl');	
		public function index(){
			if($this->Session->check('id')){
				$this->layout='admin';
				$this->loadModel('Message');
				$this->paginate = array('recursive' => -1,'limit' => 10,'order'=>'created DESC');
		        $result = $this->paginate('Message');
				// pr($result);die;
		        $this->set('result',$result);
				if(!empty($this->request->data)){
					$data=$this->request->data['Messages']['checks'];
					// pr($data);die;
					if($data['0']=="All"){
						$this->Message->query('TRUNCATE TABLE messages;');
					}else{
						foreach($data as $key=>$value){
							$this->Message->delete($value);
						}
					}
					$this->Session->setFlash('Deleted Successfully','flash_success');
					$this->redirect($this->referer());
				}
				
			}else{
				$this->redirect(array('controller'=>'Users','action'=>'index'));
			}
			
		}
		public function view($data=null){
			if($this->Session->check('id') && !empty($data)){
				$this->layout='admin';
				$id=base64_decode($data);
				$this->loadModel('Message');
				$result=$this->Message->find('all',array('conditions'=>array('id'=>$id)));
				if(empty($result)){
					$this->redirect(array('controller'=>'Messages','action'=>'index'));
				}else{
					$this->Message->save(array('id'=>$id,'is_read'=>1));
					// pr($result);die;
					$this->set('from',$result['0']['Message']['from']);
					$this->set('subject',$result['0']['Message']['subject']);
					$this->set('msg',$result['0']['Message']['msg']);
					$this->set('time',$result['0']['Message']['created']);
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
				$this->loadModel('Message');
				$this->Message->delete($id);
				$this->redirect(array('controller'=>'Messages','action'=>'index'));
			}else{
				$this->redirect(array('controller'=>'Users','action'=>'index'));
			}
			
		}
	}
?>