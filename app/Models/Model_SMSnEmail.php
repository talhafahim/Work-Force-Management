<?php namespace App\Models;

use CodeIgniter\Model;

class Model_SMSnEmail extends Model {
	
	public function __construct(){

		parent::__construct();
		$this->db = \Config\Database::connect();
	}
	//
	function sendEmail($to,$msg,$cc=null,$sub='BlackOptic'){

		$email = \Config\Services::email();

		$email->setTo($to);
		$email->setFrom('noreply@lbi.net.pk', 'BlackOptic');
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
// 		curl_setopt($ch, CURLOPT_URL, "https://pk.eocean.us/APIManagement/API/RequestAPI?user=logon_eocean&pwd=AMKBBT0SdSAm6jnYDq4VHqbPVob51xM%2fPoLf7F9q4OOD60EQMy4DiABBj4uRmeRxYg%3d%3d&sender=Logon&reciever=$number&msg-data=$msg&response=string"); 
// // old api
// //curl_setopt($ch, CURLOPT_URL, "http://110.93.218.36:24555/api?action=sendmessage&username=$username&password=$password&recipient=$number&originator=99095&messagedata=$msg"); // new api
// //
// 		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// 		$result = curl_exec($ch);
//
	}
	
}