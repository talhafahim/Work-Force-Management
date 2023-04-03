<?php namespace App\Models;

use CodeIgniter\Model;

class Model_Notification extends Model {
	
	public function __construct(){

		parent::__construct();
		$this->db = \Config\Database::connect();
	}
	//
	function todays_alert($id){
		$builder = $this->db->table('reminder as rem');
		$builder->join('remind_read as read','rem.rem_id = read.rem_id');
		$builder->where('read.for',$id);
		$builder->where('read.status','0');
		$builder->where('rem.status','1');
		$builder->orderBy('read.read_id','DESC');
		$builder->groupBy('read.rem_id');
		$query = $builder->get();
		return $query;
	}

	function get_all_reminder($my_remind = NULL) {
		$today = date('Y-m-d');
		$currentTime = strtotime(date('H:i:s'));
		$user_id = session()->get('id');
		$fromDate = date("Y-m-d", strtotime(date( "Y-m-d", strtotime( $today ) ) . "-3 month" ) );

		$builder = $this->db->table('reminder as rem');
		$builder->select('rem.*, read.*, users.id, users.firstname,users.lastname');
		$builder->join('remind_read as read','read.rem_id = rem.rem_id');
		$builder->join('bo_users as users','read.user_id = users.id');
		if ($my_remind) {
			$builder->where('read.user_id', $user_id);
		} else {
			$builder->where('read.for', $user_id);
			$builder->where('rem.remind_date <=', $today);
			$builder->where('rem.remind_date >=', $fromDate);
		}
		$builder->where('rem.status','1');
		$builder->orderBy('read.read_id','DESC');
		$builder->groupBy('read.rem_id');
		$query = $builder->get()->getResult();

		if ($my_remind) {
			return $query;
		} else {

			if (count($query) > 0) {
				$query2 = array();
				foreach ($query as $key => $value) {

					if ($value->remind_date == $today) {

						$remindTime = strtotime($value->time);
						if ($currentTime > $remindTime) {
							array_push($query2, $value);
						}

					} else {
						array_push($query2, $value);
					}
				}

				if (count($query2) > 0) {
					return $query2;
				} else {
					return NULL;
				}

			} else {
				return $query;
			}
		}
	}

	function getReminderById($rem_id) {
		$builder = $this->db->table('reminder');
		$builder->select('reminder.*, users.firstname,users.lastname');
		$builder->join('bo_users as users','reminder.user_id = users.id', 'left');
		$builder->where('rem_id', $rem_id);
		$query = $builder->get()->getRow();
		return $query;
	}

	function getReminderUsersById($rem_id) {
		$builder = $this->db->table('remind_read as read');
		$builder->select('read.*, users.id, users.firstname,users.lastname,users.username');
		$builder->join('bo_users as users','read.for = users.id');
		$builder->where('rem_id', $rem_id);
		$query = $builder->get()->getResult();
		return $query;
	}

	function checkNewReminder()
	{
		$user_id = session()->get('id');

		$currentTime = strtotime(date('H:i:s'));
		$today = date('Y-m-d');
		$fromDate = date("Y-m-d", strtotime(date( "Y-m-d", strtotime( $today ) ) . "-3 month" ) );

		$builder = $this->db->table('reminder as rem');
		$builder->select('rem.*, read.*, users.id, users.firstname,users.lastname, read.status as readStatus');
		$builder->join('remind_read as read','read.rem_id = rem.rem_id');
		$builder->join('bo_users as users','read.user_id = users.id');
		$builder->where('read.for', $user_id);
		$builder->where('read.status', '0');
		$builder->where('rem.status', '1');
		$builder->where('rem.remind_date <=', $today);
		$builder->where('rem.remind_date >=', $fromDate);
		$builder->orderBy('read.read_id','DESC');
		$query = $builder->get()->getResultArray();

		if (count($query) > 0) {
			$query2 = array();
			foreach ($query as $key => $value) {

				if ($value['remind_date'] == $today) {

					$remindTime = strtotime($value['time']);
					if ($currentTime > $remindTime) {
						array_push($query2, $value);
					}

				} else {
					array_push($query2, $value);
				}
			}

			if (count($query2) > 0) {
				return $query2;
			} else {
				return NULL;
			}
			
		} else {
			return NULL;
		}
	}

	function markRead($read_id)
	{
		$this->db->table('remind_read')->where('read_id',$read_id)->update(['status' => '1']);
	}
	//
	function set_notification($title,$txt,$for){
		$createdBy = session()->get('id');
		//
		$data = array(
			'date'	=> date('Y-m-d'),
			'time'	=> date('H:i:s'),
			'title'	=> $title,
			'text'	=> $txt,
			'remind_date'	=> date('Y-m-d'),
			'user_id'	=>	$createdBy,
			'status' => '1'
		);
		$this->db->table('reminder')->insert($data);
			//
		$rem_id = $this->db->insertID();
			//
		foreach($for as $forval){
			$data2 = array(
				'user_id'	=>	$createdBy,
				'for'		=>	$forval,
				'rem_id'	=>	$rem_id,
				'status'	=>	'0'
			);
			$this->db->table('remind_read')->insert($data2);
		}
	}

}