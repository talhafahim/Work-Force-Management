<?php namespace App\Models;

use CodeIgniter\Model;

class Model_Users extends Model {
	

	function get_users($id=null,$username=null,$email=null,$status=null){
		$db = \Config\Database::connect();
		//
		$builder = $db->table('bo_users');
		$builder->orderBy('status');
		if(!empty($id)){
			$builder->where('id',$id);
		} if(!empty($username)){
			$builder->where('username',$username);
		} if(!empty($email)){
			$builder->where('email',$email);
		} if(!empty($status)){
			$builder->whereIn('status',$status);
		}
		return $builder;
	}
	// //
	function submenu_list(){
		$db = \Config\Database::connect();
		//
		$builder = $db->table('bo_sub_menus');
		$builder->select('bo_sub_menus.*,bo_menus.menu as menu');
		$builder->join('bo_menus','bo_sub_menus.menu_id = bo_menus.id','left');
		$builder->orderBy('bo_menus.order_menu','ASC');
		$builder->orderBy('bo_sub_menus.menu_id','ASC');
		return $builder;
	}
	//
	function crud_detail($sub_menu_id,$id){
		$db = \Config\Database::connect();
		//
		$builder = $db->table('bo_crud_access');
		$builder->where('sub_menu_id',$sub_menu_id);
		$builder->where('id',$id);
		$query = $builder->get();
		return $query;
	}
	// 
	// 
	function get_main_menu($id=null){
		$db = \Config\Database::connect();
		//
		$builder = $db->table('bo_menus');
		if(!empty($id)){
			$builder->where('id',$id);
		}
		return $builder;	
	}
	// 
	function get_day_routine($user_id=null,$status=null,$date=null){
		$db = \Config\Database::connect();
		//
		$builder = $db->table('day_routine');
		if(!empty($user_id)){
			$builder->where('user_id',$user_id);
		}if(!empty($status)){
			$builder->where('status',$status);
		}if(!empty($date)){
			$builder->where('date',$date);
		}
		return $builder;	
	}
}