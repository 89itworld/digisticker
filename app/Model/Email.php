<?php
	class Email extends AppModel{
		var $name="Email";
		
		public function getConfig(){
			$config=$this->find('first',array('fields'=>array('sendingemail','port','password','host','transport'),'conditions'=>array('id'=>1)));
			
			return array(
							'port' => $config['Email']['port'],
							'username' => $config['Email']['sendingemail'],
        					'password' => base64_decode($config['Email']['password']),
        					'transport' => $config['Email']['transport'],
        					'tls' => false,
							'host' => $config['Email']['host']
						);
		}
	}
?>