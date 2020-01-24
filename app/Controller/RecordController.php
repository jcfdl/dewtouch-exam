<?php
	class RecordController extends AppController{

		public $components = array('Paginator');
		public $paginate = array();
		
		public function index(){
			ini_set('memory_limit','256M');
			set_time_limit(0);
			$limit = 10;
			$conditions = array();
	    if(($this->request->is('post') || $this->request->is('put')) && isset($this->data['Filter'])){
	      $filter_url['controller'] = $this->request->params['controller'];
	      $filter_url['action'] = $this->request->params['action'];
	      $filter_url['page'] = 1;
	      foreach($this->data['Filter'] as $name => $value){
	        if($value){
	          $filter_url[$name] = urlencode($value);
	        }
	      } 
      	return $this->redirect($filter_url);
    	} else {
	      foreach($this->params['named'] as $param_name => $value){
	        if(!in_array($param_name, array('page','sort','direction'))){         
	          if($param_name == "search"){
	          	$sanitize = urldecode($value);
	            $conditions['OR'] = array(
	              array('name LIKE' => '%' . $sanitize . '%'),
	                array('id LIKE' => '%' . $sanitize . '%')
	            );
	          } elseif ($param_name == 'limit') {
	          	$limit = $value;
	          }   
	          $this->request->data['Filter'][$param_name] = $value;
	        }
	      }
   		}

			$this->paginate['conditions'] = $conditions;
			$this->paginate['limit'] = $limit;
			$this->Paginator->settings = $this->paginate;		
			
			// $records = $this->Record->find('all');
			$records = $this->Paginator->paginate('Record');
			
			$this->set('records',$records);			
			
			$this->set('title',__('List Record'));
			$this->set('search', isset($this->params['named']['search']) ? urldecode($this->params['named']['search']) : "");
			$this->set('limit', isset($this->params['named']['limit']) ? $this->params['named']['limit'] : "");
			$this->set('limit_option', Array(10=>10,25=>25,50=>50,100=>100));
			
			$this->setFlash('Listing Record page too slow, try to optimize it.');
		}		
		
// 		public function update(){
// 			ini_set('memory_limit','256M');
			
// 			$records = array();
// 			for($i=1; $i<= 1000; $i++){
// 				$record = array(
// 					'Record'=>array(
// 						'name'=>"Record $i"
// 					)			
// 				);
				
// 				for($j=1;$j<=rand(4,8);$j++){
// 					@$record['RecordItem'][] = array(
// 						'name'=>"Record Item $j"		
// 					);
// 				}
				
// 				$this->Record->saveAssociated($record);
// 			}
			
			
			
// 		}
	}