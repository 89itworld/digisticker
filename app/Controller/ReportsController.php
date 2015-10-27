<?php
	class ReportsController extends AppController{
		var $components=array('Session','Checkurl');
		public function index(){
			if($this->Session->check("id")){
				$this->layout="admin";
			}else{
				$this->redirect(array('controller'=>'Users','action'=>'index'));
			}
		}
	}
?>