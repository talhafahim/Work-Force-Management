<?php namespace App\Models;

use CodeIgniter\Model;

class Model_OTC extends Model {
	
	///////////////////////////////////////////////////////////
	function get_otc($id = null,$cust_id=null){
		$db = \Config\Database::connect();
		//
		$builder = $db->table('bo_cust_otc');
		if(!empty($id)){
			$builder->where('id',$id);
		}if(!empty($cust_id)){
			$builder->where('cust_id',$cust_id);
		} 
		return $builder;
	}
	//////////////////////////////////////////////////////////////////
	function get_otc_detail($otc_id=null){
		$db = \Config\Database::connect();
		//
		$builder = $db->table('bo_cust_otc_detail');
		if(!empty($otc_id)){
			$builder->where('otc_id',$otc_id);
		}
		return $builder;
	}
	//////////////////////////////////////////////////////////////////
	function get_otc_bill($otc_id=null,$cust_id=null,$status=null){
		$db = \Config\Database::connect();
		//
		$builder = $db->table('bo_cust_otc_bill');
		if(!empty($otc_id)){
			$builder->where('otc_id',$otc_id);
		}if(!empty($cust_id)){
			$builder->where('cust_id',$cust_id);
		}if(!empty($status)){
			$builder->where('status',$status);
		}
		return $builder;
	}
	//////////////////////////////////////////////////////////////////
}