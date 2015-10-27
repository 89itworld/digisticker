<?php
	class NotificationsController extends AppController{
		var $components=array('Session');
		public function index(){
			if($this->Session->check('id')){
				$this->loadModel('Notification');
				$this->layout='admin';
				$this->Notification->virtualFields['user']="Appuser.email";
				 // $result=$this->Notification->query("SELECT n.id, n.notification , n.created,(SELECT email FROM appusers WHERE appusers.id=n.user_id ) AS users FROM `notifications` AS n");
				 $this->paginate=array('fields'=>array('Notification.id','Notification.notification','Notification.created','Appuser.email AS user'),'joins'=>array(array('table'=>'appusers','alias'=>'Appuser','type'=>'left','conditions'=>'Appuser.id=Notification.user_id')),'limit'=>50,'recursive'=>-1);
		        // = $this->Appuser->find('all',array('conditons'=>$conditions));
		        $result=$this->paginate('Notification');
				// pr($result);die;
		        $this->set('result', $result);
				if(!empty($this->request->data)){
					$data=$this->request->data['Notifications']['checks'];
					// pr($data);die;
					if($data['0']=="All"){
						$this->Notification->query('TRUNCATE TABLE notifications;');
					}else{
						foreach($data as $key=>$value){
							$this->Notification->delete($value);
						}
					}
					$this->Session->setFlash('Deleted Successfully','flash_success');
					$this->redirect($this->referer());
				}
				
			}else{
				$this->redirect(array('controller'=>'Users','action'=>'index'));
			}	
		}
		
		public function push(){
			$this->autoRender=false;
			if($this->Session->check('id')){
				// pr($this->request->data);die;
				if(!empty($this->request->data['submit'])){
					if($this->request->data['submit']=="Give Free Stickers" && !empty($this->request->data['Notifications']['checks'])){
						$this->redirect(array('controller'=>'Appusers','action'=>'allfree',base64_encode(implode("-", $this->request->data['Notifications']['checks']))));
					}else{
						$this->Session->setFlash('Select atleast 1 user','flash_custom');
						$this->redirect($this->referer());
					}
				}elseif(!empty($this->request->data['Notifications']['message'])){
					// pr($this->request->data);die;
					if(!empty($this->request->data['Notifications']['checks'])){
					$this->loadModel('Notification');
					$this->loadModel('Appuser');
					$this->loadModel('Device');
					// $data=$this->Appuser->find()
					$check=$this->request->data['Notifications']['checks'];
					$msg=$this->request->data['Notifications']['message'];
					// pr($check);
					
					if($check['0']==='All'){
						$condition="notification = 1 AND is_active = 1";
					}elseif($check['0']==="Allin"){
						$condition="is_active = 0";
					}else{
						$condition="WHERE ";
						$count = count($check);
						foreach($check as $key=>$value){
							if ($key != ($count-1)){
								$condition.="user_id=".$value." || ";
							}else{
								$condition.="user_id=".$value." ";
							}
						}
						$condition.=" AND notification = 1 AND is_active = 1;";
					}
					// pr($condition);die;
					$result=$this->Device->find('all',array('fields'=>array('id','user_id','regid','imei','device_type'),'conditions'=>$condition));
					foreach($result as $key=>$value){
						$this->Notification->create();
						$this->Notification->save(array('notification'=>$msg,'user_id'=>$value['Device']['user_id'],'device_id'=>$value['Device']['imei']));
				    	if($value['Device']['device_type']==1){
				    		$registatoin_ids=array($value['Device']['regid']);
							$message = array("msg" => $msg);
							$this->sendmessage($registatoin_ids,$message);
							// pr($registatoin_ids);
				    	}else{
				    		$this->sendios($value['Device']['regid'],$msg);
							// echo $value['Device']['regid']."<br/>";
				    	}
					}
					$this->Session->setFlash('Notification Sent','flash_success');
					$this->redirect(array('controller'=>'Appusers','action'=>'index'));
				}else{
					$this->Session->setFlash('Select atleast 1 user','flash_custom');
					$this->redirect($this->referer());
				}
			}else{
				$this->Session->setFlash('Please enter a message','flash_custom');
				$this->redirect($this->referer());
			}
		}
	}
		
		public function sendmessage($registatoin_ids, $message) {
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
		}
	  public function sendios($token,$msg){
	  		
			// Put your device token here (without spaces):
			$deviceToken = $token;
			
			// Put your private key's passphrase here:
			// $passphrase = 'digi1234';
				$passphrase = 'digistickers1234';
			// Put your alert message here:
			$message = $msg;
			
			////////////////////////////////////////////////////////////////////////////////
			
			$ctx = stream_context_create();
			stream_context_set_option($ctx, 'ssl', 'local_cert', 'DigiCK.pem');
			stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
			
			// Open a connection to the APNS server
			$fp = stream_socket_client(
				'ssl://gateway.sandbox.push.apple.com:2195', $err,
				$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
			
			if (!$fp)
				exit("Failed to connect: $err $errstr" . PHP_EOL);
			
			// echo 'Connected to APNS' . PHP_EOL;
			
			// Create the payload body
			$body['aps'] = array(
				'alert' => $message,
				'sound' => 'default'
				);
			
			// Encode the payload as JSON
			$payload = json_encode($body);
			
			// Build the binary notification
			$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
			
			// Send it to the server
			$result = fwrite($fp, $msg, strlen($msg));
			
			// if (!$result)
				// echo 'Message not delivered' . PHP_EOL;
			// else
				// echo 'Message successfully delivered' . PHP_EOL;
			
			// Close the connection to the server
			fclose($fp);
	  }
	}
?>