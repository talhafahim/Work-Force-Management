<?php namespace App\Models;

use CodeIgniter\Model;

class Model_Elastix extends Model {
	

	function get_active_calls(){
		$url = 'http://voip.logon.com.pk/api/api.php?cmd=activecall';
        return call_API($url);
	}
	
	
}