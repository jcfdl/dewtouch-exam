<?php
	class MigrationController extends AppController{

		public $uses = array('Member', 'Transaction', 'TransactionItem');
		public $components = array('Paginator');
		public $paginate = array();
		
		public function q1(){			
			$this->setFlash('Question: Migration of data to multiple DB table');
		}
		
		public function q1_instruction(){
			$this->setFlash('Question: Migration of data to multiple DB table');
		}

		public function index() {
			$this->set('title', __('Migration of data to multiple DB table'));
			$conditions = array();
			$limit = 10;
			$this->paginate['conditions'] = $conditions;
			$this->paginate['limit'] = $limit;
			$this->Paginator->settings = $this->paginate;
			$records = $this->Paginator->paginate('Transaction');

			$this->set('records', $records);
		}		

		public function import() {
			$ctr = 0;
			set_time_limit(0);			
			ini_set("auto_detect_line_endings", true);
			if(isset($this->data['FileUpload'])) {
				$csv_array = array();
				$file = $this->data['FileUpload']['file'];
				$name = explode(".", $file['name']);
	      $name = uniqid().".".$name[1];
	      $ext = substr(strtolower(strrchr($name, '.')), 1); 
	      $arr_ext = array('csv');
	      if(in_array($ext, $arr_ext)) {
	      	$csvfile = fopen($file['tmp_name'], "r");
					$header = fgetcsv($csvfile);
					while(($data = fgetcsv($csvfile, 1000, ",")) !== FALSE) {
						$type = explode(" ", $data[3]);
						$date = date('Y-m-d H:i:s', strtotime($data[0] . '+5 months, +18 hours'));
						$transaction_date = date('Y-m-d', strtotime($data[0]));
						$month = date('n', strtotime($data[0]));
						$year = date('Y', strtotime($data[0]));
						$member = $this->Member->find('first', array('conditions'=>array('type'=>$type[0],'no'=>$type[1])));
						if($member) {
							$member_id = $member['Member']['id'];
						} else {
							$this->Member->clear();
							$this->Member->save(array(
								'type' => $type[0],
								'no' => $type[1],
								'name' => $data[2],
								'company' => $data[5],
								'created' => $date,
								'modified' => $date
							));
							$member_id = $this->Member->getInsertID();
						}

						$transaction = $this->Transaction->find('first', array('conditions'=>array('member_id'=>$member_id, 'receipt_no'=>$data[8], 'payment_method'=>$data[6], 'payment_type'=>$data[10])));

						if($transaction) {
							$transaction_id = $transaction['Transaction']['id'];
						} else {

							$this->Transaction->clear();
							$this->Transaction->save(array(
								'member_id'=>$member_id,
								'member_name'=>$data[2],
								'member_paytype'=>$data[4],
								'member_company'=>$data[5],
								'date'=>$transaction_date,
								'year'=>$year,
								'month'=>$month,
								'ref_no'=>$data[1],
								'receipt_no'=>$data[8],
								'payment_method'=>$data[6],
								'batch_no'=>$data[7],
								'cheque_no'=>$data[9],
								'payment_type'=>$data[10],
								'renewal_year'=>$data[11],
								'subtotal'=>$data[12],
								'tax'=>$data[13],
								'total'=>$data[14],
								'created'=>$date,
								'modified'=>$date
							));
							$transaction_id = $this->Transaction->getInsertID();
						} 

						$titem = $this->TransactionItem->find('first', array('conditions'=>array('transaction_id'=>$transaction_id, 'table_id'=>$member_id)));

						if(empty($titem)) {
							$this->TransactionItem->clear();
							$this->TransactionItem->save(array(
								'transaction_id'=>$transaction_id,
								'description'=>"Being Payment for : \n" .$data[10]. " : " .$data[11],
								'quantity'=>1,
								'unit_price'=>$data[12],
								'sum'=>$data[12],
								'created'=>$date,
								'modified'=>$date,
								'table'=>'Member',
								'table_id'=>$member_id
							));

							$ctr++;
						}
					}
					fclose($csvfile);
					$message = 'You have succesfully migrated '.$ctr.' records!';
	        $this->setFlash($message, array('class' => 'alert-success'));
	        $this->redirect(array('controller' => 'Migration' , 'action' => 'index'));

	      } else {
	      	$message = 'Your file should only be a CSV file.';
	        $this->setFlash($message, array('class' => 'alert-danger'));
	        $this->redirect(array('controller' => 'Migration' , 'action' => 'index'));
	      }
			}
		}
	}