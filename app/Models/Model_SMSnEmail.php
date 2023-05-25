<?php namespace App\Models;

use CodeIgniter\Model;

class Model_SMSnEmail extends Model {
	
	public function __construct(){

		parent::__construct();
		$this->db = \Config\Database::connect();
	}
	//
	function sendEmail($to,$msg,$cc=null,$sub='Notification'){

		$email = \Config\Services::email();

		$email->setTo($to);
		$email->setFrom('noreply@gmail.com', 'My App');
		if(!empty($cc)){
			$email->setCC($cc);
		}
		$email->setSubject($sub);
		$email->setMessage($msg);

		$email->send();
	}
	//
	function sendSMS($number,$msg){
// 		$ch = curl_init();
// 		curl_setopt($ch, CURLOPT_URL, ""); 
// // old api
// //curl_setopt($ch, CURLOPT_URL, ""); // new api
// //
// 		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// 		$result = curl_exec($ch);
//
	}
	
}