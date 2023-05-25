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
	///////////////////////////////////////////
	function get_team_member_byJoin($team_id=null,$status=null){
		$db = \Config\Database::connect();
		//
		$builder = $db->table('team_member as member');
		$builder->join('bo_users as user','user.id = member.user_id');
		$builder->select('user.username,user.firstname,user.lastname,user.status');
		if(!empty($team_id)){
			$builder->where('member.team_id',$team_id);
		}if(!empty($status)){
			$builder->where('user.status',$status);
		}
		return $builder;
	}
	//////////////////////////
	function get_team_cost($team_id){
		$builder = $this->db->table('team_member as team')
		->join('bo_users as user','user.id = team.user_id')
		->where('team.team_id',$team_id)
		->select('sum(staff_cost) as total_sum');
		return $builder;
	}

}