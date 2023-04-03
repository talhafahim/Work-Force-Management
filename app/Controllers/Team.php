<?php
namespace App\Controllers;
use App\Models\Model_General;
use App\Models\Model_Task;
use App\Models\Model_Users;
use App\Models\Model_Team;
use App\Models\Model_Notification;
use CodeIgniter\HTTP\Request;
use \Hermawan\DataTables\DataTable;

class Team extends BaseController
{	
	public function __construct(){

		parent::__construct();
		$this->db = \Config\Database::connect();
		$this->input = \Config\Services::request();
	}
	//
	public function index()
	{
		if(isLoggedIn() && access_crud('Team','view')){
			$modelTeam = new Model_Team();
			$modelUsers = new Model_Users();
			$data['users'] = $modelUsers->get_users(null,null,null,['engineer','driver','technician']);
			$data['teamList'] = $modelTeam->get_team();
			//
			return view('cpanel/team',$data);
		}else{
			return redirect()->to(base_url('login'));
		}

	}
    //
	public function create_team(){
		$error = null;
		if(isLoggedIn() && access_crud('Team','create')){
			$name = $this->input->getPost('name');
			$member = $this->input->getPost('member');
			$validation =  \Config\Services::validation();
			$validate = $this->validate([
				'name' => ['label' => 'Team Name', 'rules' => 'required|trim'],
				'member' => ['label' => 'Team Member', 'rules' => 'required|trim'],
			]);
			if(!$validate){
				$error = $validation->listErrors();
			}
			$modelTeam = new Model_Team();
			$teamalready = $modelTeam->get_team(null,$name)->countAllResults();
			if($teamalready > 0){
				$error = 'Error : Team name already exist';
			}
			//
			if(empty($error)){
				$this->db->transStart();
				$this->db->table('team')->insert(['name' => $name]);
				$team_id = $this->db->insertID();
				//
				if($team_id){
					foreach ($member as $value) {
						$this->db->table('team_member')->insert(['team_id' => $team_id, 'user_id' => $value]);
					}
				}
				//
				create_action_log($name); 
				$this->db->transComplete();
				return $this->response->setStatusCode(200)->setBody('Created Successfully');
			}else{
				return $this->response->setStatusCode(401,$error);
			}
		}else{
			return $this->response->setStatusCode(401,'Access Denied');
		}
	}
    ////////////////////////////////////////////////////////////////////
	public function delete_team(){
		$id = $this->input->getPost('id');
		if(isLoggedIn() && access_crud('Team','delete')){
			//
			// $this->db->transStart();
			$query = $this->db->table('team')->where('id',$id)->delete();
			if(empty($query)){
				return $this->response->setStatusCode(401,'You can not delete this.');
			}else{
				create_action_log('id#'.$id); 
				return $this->response->setStatusCode(200)->setBody('Deleted Successfully');
			}
			// $this->db->transComplete();
		}else{
			return $this->response->setStatusCode(401,'Access Denied');
		}
	}
	////////////////////////////////////////////////////////
	public function team_member_list(){
		$data['team_id'] = $this->input->getPost('id');
		$modelTeam = new Model_Team();
		$modelUsers = new Model_Users();
		$data['id'] = array();
		$data['name'] = array();
		$data['status'] = array();
		$data['teamName'] = $modelTeam->get_team($data['team_id'])->get()->getRow()->name;
		$memberList = $modelTeam->get_team_member($data['team_id']);
		foreach($memberList->get()->getResult() as $key => $value){
			$userInfo = $modelUsers->get_users($value->user_id)->get()->getRow();
			array_push($data['id'],$userInfo->id);
			array_push($data['name'],$userInfo->firstname.' '.$userInfo->lastname);
			array_push($data['status'],$userInfo->status);
		}
		return json_encode($data);
	}
	////////////////////////////////////////////////////////
	public function update_team_action(){
		$error = null;
		$team_id = $this->input->getPost('teamid');
		$member = $this->input->getPost('member');
		if(!isLoggedIn() || !access_crud('Team','update')){
			$error = 'Access Denied';
		}if(empty($error)){
			//
			$this->db->table('team_member')->where('team_id',$team_id)->delete();
			//
			if(!empty($member)){
				foreach ($member as $value) {
					$this->db->table('team_member')->insert(['team_id' => $team_id, 'user_id' => $value]);
				}
			}
			create_action_log($team_id);
			return $this->response->setStatusCode(200)->setBody('Updated Successfully');
		}else{
			return $this->response->setStatusCode(401,$error);
		}

	}


}
