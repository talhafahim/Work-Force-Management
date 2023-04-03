<?php namespace App\Models;

use CodeIgniter\Model;

class Model_Radius extends Model {
	
	public function __construct(){

		parent::__construct();
		$this->db = \Config\Database::connect();
	}
	//
	function insert_radusergroup($username){
		$data = array('username' => $username);
		$builder = $this->db->table('radusergroup');
		$builder->insert($data);	
	}
	//
	function get_radusergroup($username=null,$groupname=null){
		$builder = $this->db->table('radusergroup');
		if(!empty($username)){
			$builder->where('username',$username);
		} if(!empty($groupname)){
			$builder->whereIn('groupname',$groupname);
		}
		return $builder;
	}
	//
	function insert_radcheck($username,$password){
		$data = [
			[
				'username' => $username,
				'attribute'  => 'Cleartext-Password',
				'value'  => $password,
			],
			[
				'username' => $username,
				'attribute'  => 'Simultaneous-Use',
				'value'  => 1,
			],
			[
				'username' => $username,
				'attribute'  => 'Calling-Station-Id',
				'value'  => 'NEW',
			]
		];

		$builder = $this->db->table('radcheck');
		$builder->insertBatch($data);	
	}
	//
	function insert_radreply($username,$ip){
		$data = array(
			'username' => $username,
			'attribute'  => 'Framed-IP-Address',
			'value'  => $ip
		);
		$builder = $this->db->table('radreply');
		$builder->insert($data);	
	}
	//
	function get_radreply($username=null,$ip=null){
		$builder = $this->db->table('radreply');
		if(!empty($username)){
			$builder->where('username',$username);
		}if(!empty($ip)){
			$builder->where('value',$ip);
		}
		return $builder;

	}
	//
	function get_radacct_online($username=null,$groupname=null,$acctstoptime=null){
		$builder = $this->db->table('radacct as acct');
		$builder->join('radusergroup as group','acct.username = group.username');
		$builder->select('group.*,acct.username,acct.acctstarttime,acct.acctstoptime,acct.callingstationid,acct.framedipaddress');
		if(!empty($username)){
			$builder->where('acct.username',$username);
		}if(!empty($groupname)){
			$builder->whereIn('group.groupname',$groupname);
		}
		$builder->where('acctstoptime',null);
		$builder->orderBy('radacctid','DESC');
		return $builder;

	}
	//
	function get_radacct($username=null){
		$builder = $this->db->table('radacct');
		$builder->select('username,acctstarttime,acctstoptime,callingstationid,framedipaddress');
		if(!empty($username)){
			$builder->where('username',$username);
		}
		return $builder;
	}
	

}