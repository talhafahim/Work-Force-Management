<?php

namespace App\Controllers;
use App\Models\Model_Package;
use App\Models\Model_Radius;
use App\Models\Model_Customer;
use App\Models\Model_Elastix;

class Home extends BaseController
{
	public function index()
	{
		$html = null;
		$modelElastix = new Model_Elastix();
		$data = $modelElastix->get_active_calls();	
		$data = json_decode($data);
		$countArr = count($data);
		$activeCalls = $data[$countArr-2];
		if($countArr > 3){
			for($i=0;$i<($countArr-3);$i++){
				$callerID = $data[$i]->CallerID;
				if((strlen($callerID)) > 5){
					$html = $callerID.'<br>';
				}
				// echo '<br>';
				// echo 'working';
			}
		}

		// if(empty($data[3])){
		// 	echo $data[1];
		// }else{
		// 	echo ($data[3]); 	
		// }
		// echo $html;
		// d($data);
       
    }
}
