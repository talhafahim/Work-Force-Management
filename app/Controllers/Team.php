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
			$data['modelTeam'] = new Model_Team();
			$data['modelUsers'] = new Model_Users();
			$data['users'] = $data['modelUsers']->get_users(null,null,null,['engineer','driver','technician','trainee']);
			$data['teamList'] = $data['modelTeam']->get_team();
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
			$modelUsers = new Model_Users();
			foreach ($member as $value) {
				$alreadyMember = $modelTeam->get_team_member(null,$value)->countAllResults();
				if($alreadyMember > 0){
					$userInfo = $modelUsers->get_users($value)->get()->getRow();
					$error = $userInfo->firstname.' '.$userInfo->lastname.' is already a member of a team';
					break;
				}
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
		}
		//
		$modelUsers = new Model_Users();
		if(!empty($member)){
			foreach ($member as $value) {
				$alreadyMember = $this->db->table('team_member')->where('user_id',$value)->where('team_id !=',$team_id)->countAllResults();
				if($alreadyMember > 0){
					$userInfo = $modelUsers->get_users($value)->get()->getRow();
					$error = $userInfo->firstname.' '.$userInfo->lastname.' is already a member of a team';
					break;
				}
			}}
		//
			if(empty($error)){
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
	////////////////////////////////////////////////////
		public function detial_sheet(){
			if(isLoggedIn() && access_crud('Team','view')){
			//
				return view('cpanel/team_detail_sheet');
			}else{
				return redirect()->to(base_url('login'));
			}
		}
	///////////////////////////////////////////////////
		public function show_team_detail_content(){
			$data['modelTeam'] = new Model_Team();
			$data['modelUsers'] = new Model_Users();
			//
			$data['teamList'] = $data['modelTeam']->get_team()->orderBy('id','DESC');
		//
			foreach($data['teamList']->get()->getResult() as $key => $value){ ?>
				<tr>
					<td><?= $value->name;?></td>
					<td>
						<?php 
						$engineerList = $data['modelTeam']->get_team_member_byJoin($value->id,'engineer');
						foreach ($engineerList->get()->getResult() as $eValue) {
							echo $eValue->firstname.' '.$eValue->lastname.'<br>';
						}?>
					</td>
					<td>
						<?php 
						$engineerList = $data['modelTeam']->get_team_member_byJoin($value->id,'technician');
						foreach ($engineerList->get()->getResult() as $eValue) {
							echo $eValue->firstname.' '.$eValue->lastname.'<br>';
						}?>
					</td>
					<td>
						<?php 
						$engineerList = $data['modelTeam']->get_team_member_byJoin($value->id,'trainee');
						foreach ($engineerList->get()->getResult() as $eValue) {
							echo $eValue->firstname.' '.$eValue->lastname.'<br>';
						}?>
					</td>
					<td>
						<?php 
						$engineerList = $data['modelTeam']->get_team_member_byJoin($value->id,'driver');
						foreach ($engineerList->get()->getResult() as $eValue) {
							echo $eValue->firstname.' '.$eValue->lastname.'<br>';
						}?>
					</td>
					<td style="text-align:right;">
						<?= $teamCost = $data['modelTeam']->get_team_cost($value->id)->get()->getRow()->total_sum;?>
					</td>
					<td>
						<a href="javascript:void(0);" class="text-info edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" data-serial="<?php echo $value->id;?>"><i class="fa fa-edit"></i></a>
						&nbsp;&nbsp;&nbsp;
						<a href="javascript:void(0);" class="text-danger delete" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" data-serial="<?php echo $value->id;?>"><i class="fa fa-trash-alt"></i></a>
					</td>
				</tr>
			<?php }
		//
		}


public function test(){
		$modelTeam = new Model_Team();
		echo $teamCost = $modelTeam->get_team_cost(5)->get()->getRow()->total_sum;
	}
}
