<?php

class FileUploadController extends AppController {
	public function index() {
		$file_uploads = array();
		$get_all = 0;
		ini_set("auto_detect_line_endings", true);
		$this->set('title', __('File Upload Answer'));

		if(isset($this->data['FileUpload'])) {
			$last_rec = $this->FileUpload->find('first', array('order'=>array('id'=>'DESC')));
			if(empty($last_rec)) {
				$get_all = 1;
			}
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
					$this->FileUpload->clear();
					$this->FileUpload->save(array(
						'name' => $data[0],
						'email' => $data[1]
					));
				}
				fclose($csvfile);
				$message = 'Successfully imported CSV File';
        $this->setFlash($message, array('class' => 'alert-success'));
        if($get_all) {
        	$this->redirect(array('controller' => 'FileUpload' , 'action' => 'index', 'all'=>1));
        } else {
        	$this->redirect(array('controller' => 'FileUpload' , 'action' => 'index', 'id'=>$last_rec['FileUpload']['id']));
        }
      } else {
      	$message = 'Your file should only be a CSV file.';
        $this->setFlash($message, array('class' => 'alert-danger'));
        $this->redirect(array('controller' => 'FileUpload' , 'action' => 'index'));
      }
		}
		if(isset($this->params['named']['all'])) {
			$file_uploads = $this->FileUpload->find('all');
		}
		if(isset($this->params['named']['id'])) {
			$file_uploads = $this->FileUpload->find('all', array('conditions'=>array('id >' => $this->params['named']['id'])));
		}
		$this->set(compact('file_uploads'));
	}
}