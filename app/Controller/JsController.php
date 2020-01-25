<?php
	class JsController extends AppController{
		public $uses = array('Inventory');

		public function q1(){			
			$this->set('title',__('Question: Please change Pop Up to mouse over (soft click)'));
		}
		
		public function q1_detail(){			
			$this->set('title',__('Question: Please change Pop Up to mouse over (soft click)'));
		}

		public function getRows() {
			$this->layout = false;
			$records = $this->Inventory->find('all');
			$this->set('records', $records);
		}

		public function insertRow() {
			$this->Inventory->save();
			exit();
		}

		public function deleteRow() {
			$this->Inventory->delete($this->data['id']);
			exit();
		}

		public function updateRow() {
			$value = $this->data['value'];
			$field = $this->data['field'];
			$id = $this->data['id'];
			$conditions = array();
			if($value) {
				if($field == 'description') {
					$this->Inventory->id = $id;
					$this->Inventory->save(array($field=>$value));
				} else {
					$record = $this->Inventory->find('first', array('conditions'=>array('id'=>$id)));
					if($field == 'quantity') {
						$conditions['quantity'] = $value;
						$conditions['amount'] = $value * (!empty($record) ? $record['Inventory']['price'] : 0);
					} else {
						$conditions['price'] = $value;
						$conditions['amount'] = $value * (!empty($record) ? $record['Inventory']['quantity'] : 0);
					}
					$this->Inventory->id = $id;
					$this->Inventory->save($conditions);
				}
			}
			exit();

		}
		
	}