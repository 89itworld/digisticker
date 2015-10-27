<?php 
	class CheckurlComponent extends Component{
		public function cUrl($data){
			if(is_numeric(substr($data,strpos($data,':')+1))){
				return substr($data,strpos($data,':')+1);
			}else{
				return 1;
			}
		}
		public function clean($data){
			$data = trim($data);
		  	$data = stripslashes($data);
		  	$data = htmlspecialchars($data);
		  	return $data;
		}
		public function sendMail($to,$sub,$msg){
			App::uses('CakeEmail', 'Network/Email');
			$Email = new CakeEmail('dynamic');
			// $Email->sender('support@yourcompany.com', 'Your Company Support');
			$Email->from(array('amuk89itworld@gmail.com' => 'Digi Stickers'))
    			->viewVars(array('subject' =>$sub,'content',$msg))
				->emailFormat('html')
				->template('email')
				// ->replyTo($from)
    			->to($to)
    			->subject($sub)
    			->send($msg);
				
		}
		public function sendeeMail($to,$sub,$msg){
			App::uses('CakeEmail', 'Network/Email');
			$Email = new CakeEmail('dynamic');
			// $Email->sender('support@yourcompany.com', 'Your Company Support');
			$Email->from(array('amuk89itworld@gmail.com' => 'Digi Stickers'))
    			->viewVars(array('subject' =>$sub,'content',$msg))
				->emailFormat('html')
				->template('newemailtemplate','newemailtemplate')
				// ->replyTo($from)
    			->to($to)
    			->subject($sub)
    			->send($msg);
				
		}
		public function sendEmail($to,$from){
			App::uses('CakeEmail', 'Network/Email');
			$Email = new CakeEmail('dynamic');
			$msg="Hey,\nI downloaded this cool Digi Stickers App and I thought you would be interested in downloading it too.\nCheck it out! <a href='https://play.google.com/store/apps/details?id=com.tdb.tbdapp.&hl=en'>Click Here</a>\n";
			$sub="Your Friend invited you!!";
			// $Email->sender('support@yourcompany.com', 'Your Company Support');
			$Email->from(array('amuk89itworld@gmail.com' => 'Digi Stickers'))
    			// ->viewVars(array('subject' =>$sub))
    			->viewVars(array('subject' =>$sub,'content',$msg))
				->emailFormat('html')
				->template('emailInvite','emailInvite')
				->replyTo($from)
    			->to($to)
    			->subject($sub)
				->send($msg);
		}
	}
?>