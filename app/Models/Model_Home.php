<?php namespace App\Models;

use CodeIgniter\Model;

class Model_Home extends Model {
	

	function get_slider($id = null){
		$db = \Config\Database::connect();
		//
		$builder = $db->table('bo_site_slider');
		
		if(!empty($id)){
			$builder->where('id',$id);
		}
		$query= $builder->get();
		return $query;
	}

	function get_payment_method($id = null){
		$db = \Config\Database::connect();
		//
		$builder = $db->table('bo_site_payment_method');
		
		if(!empty($id)){
			$builder->where('id',$id);
		}
		$query= $builder->get();
		return $query;
	}

	function get_contact_detail(){
		$db = \Config\Database::connect();
		$builder = $db->table('bo_site_contact_form');
		$query= $builder->get();
		return $query;
	}

	function get_all_queries(){
		$db = \Config\Database::connect();
		$builder = $db->table('bo_site_query_form');
		$query= $builder->get();
		return $query;
	}
}