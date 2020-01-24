<?php
	class OrderReportController extends AppController{

		public function index(){

			$this->setFlash('Multidimensional Array.');

			$this->loadModel('Order');
			$orders = $this->Order->find('all',array('conditions'=>array('Order.valid'=>1),'recursive'=>2));
			// debug($orders);exit;

			$this->loadModel('Portion');
			$portions = $this->Portion->find('all',array('conditions'=>array('Portion.valid'=>1),'recursive'=>2));
			// debug($portions);exit;


			// To Do - write your own array in this format
			// $order_reports = array(
			// 	'Order 1' => array(
			// 		'Ingredient A' => 1,
			// 		'Ingredient B' => 12,
			// 		'Ingredient C' => 3,
			// 		'Ingredient G' => 5,
			// 		'Ingredient H' => 24,
			// 		'Ingredient J' => 22,
			// 		'Ingredient F' => 9,
			// 	),
			// 	'Order 2' => array(
		 //  		'Ingredient A' => 13,
		 //  		'Ingredient B' => 2,
		 //  		'Ingredient G' => 14,
		 //  		'Ingredient I' => 2,
		 //  		'Ingredient D' => 6,
			// 	),
			// );
			$order_reports = array();
			foreach($orders AS $order_key => $order_value) {
				foreach($order_value['OrderDetail'] AS $od_key => $od_value) {
					$qty = $od_value['quantity'];
					$item_id = $od_value['item_id'];
					foreach($portions AS $p_key => $p_value) {
						if($p_value['Item']['id'] == $item_id) {
							foreach($p_value['PortionDetail'] AS $pd_key => $pd_value) {
								$value = $pd_value['value'] * $qty;				
								if(!empty($order_reports[$order_value['Order']['name']])) {
									if(array_key_exists($pd_value['Part']['name'], $order_reports[$order_value['Order']['name']])) {
										$get_value = $order_reports[$order_value['Order']['name']][$pd_value['Part']['name']];
										$order_reports[$order_value['Order']['name']][$pd_value['Part']['name']] = $get_value + $value;
									}	else {
										$order_reports[$order_value['Order']['name']][$pd_value['Part']['name']] = $value;
									}	
								} else {									
									$order_reports[$order_value['Order']['name']][$pd_value['Part']['name']] = $value;
								}
							}
						}
					}
				}
			}
			$this->set('order_reports',$order_reports);
			$this->set('title',__('Orders Report'));
		}

		public function Question(){

			$this->setFlash('Multidimensional Array.');

			$this->loadModel('Order');
			$orders = $this->Order->find('all',array('conditions'=>array('Order.valid'=>1),'recursive'=>2));

			// debug($orders);exit;

			$this->set('orders',$orders);

			$this->loadModel('Portion');
			$portions = $this->Portion->find('all',array('conditions'=>array('Portion.valid'=>1),'recursive'=>2));
				
			// debug($portions);exit;

			$this->set('portions',$portions);

			$this->set('title',__('Question - Orders Report'));
		}

	}