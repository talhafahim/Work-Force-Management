<?php namespace App\Models;

use CodeIgniter\Model;

class Model_Team extends Model {
	/////////////////////////////////////////
	function get_team($id = null,$name=null){
		$db = \Config\Database::connect();
		//
		$builder = $db->table('team');
		if(!empty($id)){
			$builder->where('id',$id);
		}if(!empty($name)){
			$builder->where('name',$name);
		}
		return $builder;
	}
	/////////////////////////////////////////
	function get_team_member($team_id = null,$user_id=null){
		$db = \Config\Database::connect();
		//
		$builder = $db->table('team_member');
		if(!empty($team_id)){
			$builder->where('team_id',$team_id);
		}if(!empty($user_id)){
			$builder->where('user_id',$user_id);
		}
		return $builder;
	}

}