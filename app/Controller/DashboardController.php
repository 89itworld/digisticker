<?php
	class DashboardController extends AppController{
		var $components=array('Session');
		public function index(){
			if($this->Session->check('id')){
				$this->layout='admin';
				$this->loadModel('Categorie');
				$this->loadModel('Sticker');
				$this->loadModel('Appuser');
				$this->loadModel('Message');
				$this->loadModel('Purchasedsticker');
				$this->loadModel('Stickeruse');
				$this->loadModel('Pack');
				$cond="Sticker.id=Favsticker.sticker_id";
				$conditions="GROUP BY Favsticker.sticker_id HAVING count(Favsticker.sticker_id) >= 2";
				$data=$this->Sticker->find('list',array('joins'=>array(array('table'=>'favstickers','alias'=>'Favsticker','type'=>'inner','conditions'=>$cond)),'conditions'=>$conditions));
				$condis="WHERE by_admin=0 GROUP BY year, month";
				$fields="YEAR(created) as year, MONTH(created) as month, COUNT(*) as count";
				if(!empty($this->request->data)){
					if($this->request->data['purchase']['time']==2){
						$condis="WHERE by_admin=0 GROUP BY year";
						$fields="YEAR(created) as year, COUNT(*) as count";
					}
				}else{
					$condis="WHERE by_admin=0 GROUP BY year, month";
					$fields="YEAR(created) as year, MONTH(created) as month, COUNT(*) as count";
				}
				$chart=$this->Purchasedsticker->find('all',array('fields'=>$fields,'conditions'=>$condis));
				$fields="sticker_id, SUM(`count`) AS total";
				$used=$this->Stickeruse->find('all',array('fields'=>$fields,'order'=>'total DESC','group' => 'sticker_id','limit'=>5));
				foreach($used as $k=>$v){
					$name=$this->Sticker->find('first',array('fields'=>'name','conditions'=>array('id'=>$v['Stickeruse']['sticker_id'])));
					$mostused[]=array('name'=>$name,'value'=>$v['0']['total']);
				}
				$packdata=$this->Pack->find('all');
				foreach($packdata as $key=>$value){
					$name=$this->Appuser->find('first',array('fields'=>'email','conditions'=>array('id'=>$value['Pack']['user_id'])));
					$result[]=array('name'=>$name['Appuser']['email'],'packs'=>$value['Pack']['count']);
				}
				if(!empty($result)){
					$this->set('result',$result);	
				}
				if(!empty($mostused)){
					$this->set('mostused',$mostused);	
				}
				$this->set('chart',$chart);
				$this->set('fav_num',count($data));
				$this->set('cat_num',$this->Categorie->find('count',array('conditions'=>array('is_deleted'=>0))));
				$this->set('sticker_num',$this->Sticker->find('count',array('conditions'=>array('is_deleted'=>0))));
				$this->set('user_num',$this->Appuser->find('count',array('conditions'=>array('is_active'=>1))));				
				$this->set('msg_num',$this->Message->find('count'));
				$this->set('pur_num',$this->Purchasedsticker->find('count',array('conditions'=>array('by_admin'=>0))));
			}else{
				$this->redirect(array('controller'=>'Users','action'=>'index'));
			}
		}

		public function packs(){
			if($this->Session->check('id')){
				$this->layout="admin";
				$this->loadModel('Pack');
				$this->loadModel('Appuser');
				$packdata=$this->Pack->find('all',array('order'=>'count DESC'));
				foreach($packdata as $key=>$value){
					$name=$this->Appuser->find('first',array('fields'=>'email','conditions'=>array('id'=>$value['Pack']['user_id'])));
					$result[]=array('name'=>$name['Appuser']['email'],'packs'=>$value['Pack']['count']);
				}
				if(!empty($result)){
					$this->set('result',$result);
				}
			}else{
				$this->redirect(array('controller'=>'Users','action'=>'index'));
			}
		}
        
		public function popular(){
			if($this->Session->check('id')){
				$this->layout="admin";
				$this->loadModel('Sticker');
				$this->loadModel('Categorie');
				$cond="Sticker.id=Favsticker.sticker_id";
				$conditions="GROUP BY Favsticker.sticker_id HAVING count(Favsticker.sticker_id) >= 2";
				$this->paginate = array('fields'=>array('Sticker.id','Sticker.name','Sticker.image','Sticker.type_id','Sticker.category_id','Sticker.created','Sticker.modified'),'joins'=>array(array('table'=>'favstickers','alias'=>'Favsticker','type'=>'inner','conditions'=>$cond)),'recursive' => -1,'limit' => 10,'conditions' => $conditions);
				$data=$this->paginate('Sticker');
			    foreach($data as $key=>$value){
			    	$f=$this->Categorie->find('first',array('fields'=>'name','conditions'=>array('id'=>$value['Sticker']['category_id'])));
					$data[$key]['Sticker']['category_name']=$f['Categorie']['name'];
			    }
			    $this->set('result',$data);
			}else{
				$this->redirect(array('controller'=>'Users','action'=>'index'));
			}
		}

		public function mostused(){
			if($this->Session->check('id')){
				$this->layout="admin";
				$this->loadModel('Sticker');
				$this->loadModel('Categorie');
				$fields="Sticker.id, Sticker.name, Sticker.image, Sticker.type_id, Sticker.category_id, Sticker.created, Sticker.modified, SUM(`Stickeruse`.`count`)";
				$cond="Sticker.id=Stickeruse.sticker_id";
				$conditions="Sticker.is_active=1 AND Sticker.is_deleted=0 GROUP BY Sticker.id ORDER BY SUM(`Stickeruse`.`count`) DESC";
				$this->paginate = array('fields'=>$fields,'joins'=>array(array('table'=>'stickeruses','alias'=>'Stickeruse','type'=>'inner','conditions'=>$cond)),'recursive' => -1,'limit' => 50,'conditions' => $conditions);
				$result=$this->paginate('Sticker');
				foreach($result as $key=>$value){
					$c=$this->Categorie->find('first',array('fields'=>'name','conditions'=>array('id'=>$value['Sticker']['category_id'])));
					$data[]=array('sticker'=>$value,'category'=>$c['Categorie']['name']);
				}
				$this->set('result',$data);
			}else{
				$this->redirect(array('controller'=>'Users','action'=>'index'));
			}
		}
		
		public function export(){
    		if($this->Session->check('id')){
    			App::import('Vendor','ExcelWriter');
    			$date=date("Y-m-d");
    			$this->loadModel('Sticker');
    			$this->loadModel('Categorie');
    			$cond="Sticker.id=Favsticker.sticker_id";
    			$conditions="GROUP BY Favsticker.sticker_id HAVING count(Favsticker.sticker_id) >= 2";
                $data=$this->Sticker->find('all',array('fields'=>array('Sticker.id','Sticker.name','Sticker.image','Sticker.type_id','Sticker.category_id','Sticker.created','Sticker.modified'),'joins'=>array(array('table'=>'favstickers','alias'=>'Favsticker','type'=>'inner','conditions'=>$cond)),'conditions'=>$conditions));
    			foreach($data as $key=>$value){
    			    $f=$this->Categorie->find('first',array('fields'=>'name','conditions'=>array('id'=>$value['Sticker']['category_id'])));
    				$data[$key]['Sticker']['category_name']=$f['Categorie']['name'];
    			}
    			$fileName=WWW_ROOT."files".DS."Excel".DS."PopularSticker_Report"."_".$date.".xls";
    			$this->autoRender=false;
                $excel = new ExcelWriter($fileName);
                $excel->writeCol("S. No.");
                $excel->writeCol("Name");
                $excel->writeCol("Category");
                $excel->writeCol("Type");
                $excel->writeCol("Created");
    			$excel->writeCol("Modified");
                foreach($data as $key=>$value){
                    if($key==0){
                        $excel->writeLine(array(), array());
                    }
                    $excel->writeCol($key+1, array());
                    $excel->writeCol(ucfirst($value['Sticker']['name']));
                    $excel->writeCol(ucfirst($value['Sticker']['category_name']));
    				if($value['Sticker']['type_id']==1){
    					$excel->writeCol("Free");
    				}else{
    					$excel->writeCol("Paid");
    				}
    				$excel->writeCol(date("F j, Y, g:i A",strtotime($value['Sticker']['created'])));
    				$excel->writeCol(date("F j, Y, g:i A",strtotime($value['Sticker']['modified'])));
                    $excel->writeLine(array(), array());
                }
    			$this->redirect(DS."files".DS."Excel".DS."PopularSticker_Report"."_".$date.".xls");
    		}else{
    			$this->redirect(array('controller'=>'Users','action'=>'index'));
    		}
    	}
	}
?>