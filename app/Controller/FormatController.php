<?php
	class FormatController extends AppController{
		
		public function q1(){
			
			$this->setFlash('Question: Please change Pop Up to mouse over (soft click)');
				
			
			
// 			$this->set('title',__('Question: Please change Pop Up to mouse over (soft click)'));
		}

		public function q1_submit() {
			if(isset($this->data['Type']['type'])) {
				$this->set('selection', $this->data['Type']['type']);
				$message = 'You have successfully submitted your selection';
        $this->setFlash($message, array('class' => 'alert-successful'));
			} else {
				$this->redirect(array('controller' => 'Format' , 'action' => 'q1'));
			}
		}
		
		public function q1_detail(){

			$this->setFlash('Question: Please change Pop Up to mouse over (soft click)');
				
			
			
// 			$this->set('title',__('Question: Please change Pop Up to mouse over (soft click)'));
		}
		
	}