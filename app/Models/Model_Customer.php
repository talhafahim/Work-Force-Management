<?php namespace App\Models;

use CodeIgniter\Model;

class Model_Customer extends Model {
	/////////////////////////////////////////
	function get_customer_info($id = null,$un=null,$assign_to=null,$status=null,$assign_on=null){
		$db = \Config\Database::connect();
		//
		$builder = $db->table('bo_customer_info');
		if(!empty($id)){
			$builder->where('id',$id);
		}if(!empty($un)){
			$builder->where('un_number',$un);
		}if(!empty($assign_to)){
			$builder->where('assign_to',$assign_to);
		}if(!empty($status)){
			$builder->where('status',$status);
		}if(!empty($assign_on)){
			$builder->where('assign_on >=',$assign_on.' 00:00:00');
			$builder->where('assign_on <=',$assign_on.' 23:59:59');
		}
		return $builder;
	}
	//
	function get_task_group($assign_to=null,$status=null){
		$db = \Config\Database::connect();
		//
		$builder = $db->table('bo_customer_info');
		if(!empty($assign_to)){
			$builder->where('assign_to',$assign_to);
		}if(!empty($status)){
			$builder->where('status',$status);
		}
		return $builder;
	}
	// ///////////////////////////////////////////////////////////
	// function get_customer($id = null,$username = null,$status = null,$email = null,$nic = null,$mobile = null){
	// 	$db = \Config\Database::connect();
	// 	//
	// 	$builder = $db->table('bo_customer');
	// 	if(!empty($id)){
	// 		$builder->where('id',$id);
	// 	}if(!empty($username)){
	// 		$builder->where('username',$username);
	// 	} if(!empty($status)){
	// 		$builder->whereIn('status',$status);
	// 	} if(!empty($email)){
	// 		$builder->where('email',$email);
	// 	} if(!empty($nic)){
	// 		$builder->where('nic',$nic);
	// 	} if(!empty($mobile)){
	// 		$builder->like('mobilephone',$mobile);
	// 	}
	// 	return $builder;
	// }
	// ///////////////////////////////////////////////////////
	// function get_customer_for_login($username = null){
	// 	$db = \Config\Database::connect();
	// 	//
	// 	$builder = $db->table('bo_customer');
	// 	if(!empty($username)){
	// 		$builder->where('username',$username);
	// 		$builder->orWhere('email',$username);
	// 	}
	// 	return $builder;
	// }
	// ///////////////////////////////////////////////////////////
	// function get_customer_except($id=null,$email=null){
	// 	$db = \Config\Database::connect();
	// 	//
	// 	$builder = $db->table('bo_customer');
	// 	$builder->orderBy('status');
	// 	if(!empty($id)){
	// 		$builder->whereNotIn('id',$id);
	// 	}if(!empty($email)){
	// 		$builder->where('email',$email);
	// 	}
	// 	return $builder;
	// }
	// ///////////////////////////////////////////////////////////
	// function get_customer_contract($id=null,$cust_id=null,$status=null){
	// 	$db = \Config\Database::connect();
	// 	//
	// 	$builder = $db->table('bo_cust_contract');
	// 	if(!empty($id)){
	// 		$builder->where('id',$id);
	// 	}if(!empty($cust_id)){
	// 		$builder->where('cust_id',$cust_id);
	// 	}if(!empty($status)){
	// 		$builder->where('status',$status);
	// 	}
	// 	return $builder;
	// }
	// //////////////////////////////////////////////////////////////////////
	// function insert_bill($cust_id,$cont_id,$bill_date,$bill_month,$bill_days,$uniq){
	// 	$db = \Config\Database::connect();
	// 	//
	// 	$sql = "INSERT IGNORE INTO `bo_cust_bill` (`cust_id`, `cont_id`, `bill_date`, `bill_month`, `bill_days`, `uniq`) VALUES ('$cust_id', '$cont_id', '$bill_date', '$bill_month', '$bill_days','$uniq') ";
	// 	$db->query($sql);
	// 	//
	// 	return 1;
	// }
	// ///////////////////////////////////////////////////////////
	// function get_customer_bill($id=null,$cust_id=null,$status=null){
	// 	$db = \Config\Database::connect();
	// 	//
	// 	$builder = $db->table('bo_cust_bill');
	// 	if(!empty($id)){
	// 		$builder->where('id',$id);
	// 	}if(!empty($cust_id)){
	// 		$builder->where('cust_id',$cust_id);
	// 	}if(!empty($status)){
	// 		$builder->where('status',$status);
	// 	}
	// 	return $builder;
	// }
	// //////////////////////////////////////////////////////////////////
	// function insert_status_info($username){
	// 	$data = array('username' => $username);
	// 	$builder = $this->db->table('bo_cust_status_info');
	// 	$builder->insert($data);	
	// }
	// ////////////////////////////////////////////////////////////////////
	// function get_usual_ip($ip=null,$status=null){
	// 	$db = \Config\Database::connect();
	// 	//
	// 	$builder = $db->table('bo_cust_usual_ips');
	// 	if(!empty($ip)){
	// 		$builder->where('ip',$ip);
	// 	}if(!empty($status)){
	// 		$builder->where('status',$status);
	// 	}
	// 	$builder->limit(1);
	// 	return $builder;
	// }
}