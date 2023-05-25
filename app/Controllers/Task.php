<?php

namespace App\Controllers;
use \Hermawan\DataTables\DataTable;
use App\Models\Model_Customer;
use App\Models\Model_Task;
use App\Models\Model_General;
use App\Models\Model_Users;
use App\Models\Model_Team;

class Task extends BaseController
{
	public function __construct(){

		parent::__construct();
		$this->db = \Config\Database::connect();
		$this->input = \Config\Services::request();
	}
	public function my_task()
	{
		if(isLoggedIn()){	
			$modelGeneral = new Model_General();
			$data['return_reason'] = $modelGeneral->get_return_reason()->get();
			$data['misc_equipment'] = $modelGeneral->get_misc_equipment()->get();
			return view('customer/my-task',$data);	
		}else{
			return redirect()->to(base_url('login'));
		}
	}
	//
	public function dashboard()
	{
		return view('cpanel/dashboard');
	}
	//
	public function empty()
	{
		return view('cpanel/empty');	
	}
	//
	public function show_assign_list(){
		if(isLoggedIn()){
			$id = session()->get('id');
			//
			$taskModel = new Model_Task();
			$builder = $taskModel->get_task(null,null,$id);
			//
			return DataTable::of($builder)->addNumbering('no')
			//
			->filter(function ($builder, $request) {
				if ($request->status)
					$builder->where('status', $request->status);
			})
			//
			->add('taskStatus', function($row){
				//
				$status = ($row->status == 'complete') ? 'installed' : ( ($row->status == 'reject') ? 'return' : ($row->status) );
				//
				return '<span class="badge badge-soft-info" style="font-size:15px;">'.ucfirst($status).'</span>';
			})
			->add('action', function($row){
				$actionHtml = '<div class="btn-group">';
				if($row->status != 'commission' && $row->status != 'reject'){
					$actionHtml .= '<button type="button" id="updateUN"  class="btn btn-primary btn-sm" data-un="'. 				$row->un_number.'" task-id="'.$row->id.'"><i class="fa fa-tasks"></i></button>';
				}
				$actionHtml .= '	
				<a href="'.base_url().'/task/view-detail/'.$row->id.'" class="btn btn-info btn-sm" title="View Detail"><i class="fa fa-info-circle"></i></a>
				</div>';
				return $actionHtml;
			})
			//
			->toJson(true);
			
		}
	}
	///
	public function task_detail(){
		$uri = new \CodeIgniter\HTTP\URI(current_url());
		$data['un'] = $uri->getSegment(3);
		$customerModel = new Model_Customer();
		$unCount = $customerModel->get_customer_info(null,$data['un'])->countAllResults();
		
		if(isLoggedIn() && $unCount > 0){
			//
			return view('customer/my-task-detail',$data);
		}else{
			return redirect()->to(base_url('login'));
		}
	}
	//////////////////////////////////
	public function show_update_modal_content(){
		$un_number = $this->input->getPost('un');
		$task_id = $this->input->getPost('id');
		$user_id = session()->get('id');
			//
		$customerModel = new Model_Customer();
		$taskDetail=$customerModel->get_customer_info($task_id)->get()->getRow();
			//
		$modelGeneral = new Model_General();
		$gateway = $modelGeneral->get_gateway(null,null,$user_id,'assigned')->get()->getResult();
		$data['gateway'] = array_column($gateway, 'serial');
		//
		$sim = $modelGeneral->get_sim(null,null,$user_id,'assigned')->get()->getResult();
		$data['sim'] = array_column($sim, 'icc_id');
		//
		$data['currentStatus'] =  $taskDetail->status;
		return json_encode($data);
	}
	//////////////////////////////////
	public function update_task(){
		if(isLoggedIn()){
			$modelCustomer = new Model_Customer();
			$modelGeneral = new Model_General();
			$modelTask = new Model_Task();
			$modelUsers = new Model_Users();
			$imgname = mt_rand(100000,999999).date('Hms');
			//
			$error = null;
			$user_id = session()->get('id');
			$un_number = $this->input->getPost('un_number');
			$task_id = $this->input->getPost('task_id');
			$options = $this->input->getPost('options');
			$status = $this->input->getPost('status');
			$gateway = $this->input->getPost('gateway');
			$sim = $this->input->getPost('sim');
			$otherEquipment = $this->input->getPost('otherEquipment');
			$equipQty = $this->input->getPost('equipQty');
			$returnReason = $this->input->getPost('returnReason');
			$pic1 = $this->input->getFile('pic1');
			$pic2 = $this->input->getFile('pic2');
			$pic3 = $this->input->getFile('pic3');
			$pic4 = $this->input->getFile('pic4');
			$pic5 = $this->input->getFile('pic5');
			//
			$validation =  \Config\Services::validation();
			$validate = $this->validate([
				'status' => ['label' => 'Status', 'rules' => 'trim|required'],
				'options' => ['label' => 'Option', 'rules' => 'trim|required'],
			]);
			if(!$validate){
				$error = $validation->listErrors();
				$error = str_replace(array("\n", "\r"), '', $error);
				$error =  nl2br($error);
			}
			//
			if($status == 'reject' && empty($returnReason) ){
				$error = 'Please select reject reason';
			}
			//
			if($status == 'complete' && (empty($gateway) || empty($sim) || empty($otherEquipment) )){
				$error = 'Please put gateway,SIM & other equipment';
			}
			//
			if(!empty($gateway) && ($status == 'complete' || $status == 'commission') ){
				foreach ($gateway as $gatewayValue) {
					$checkGateway = $modelGeneral->get_gateway(null,$gatewayValue,$user_id,'assigned')->countAllResults();
					if($checkGateway <= 0){
						$error = 'Error : Inavlid Gateway Serial#'.$gatewayValue;
						break;
					}
				}	
				//
			}
			//
			if(!empty($sim) && ($status == 'complete' || $status == 'commission') ){
				foreach ($sim as $simValue) {
					$checkSIM = $modelGeneral->get_sim(null,$simValue,$user_id,'assigned')->countAllResults();
					if($checkSIM <= 0){
						$error = 'Error : Inavlid SIM ICC ID'.$simValue;
						break;
					}
				}
			}
			//
			if($status == 'reject' && empty($_FILES['pic1']['name']) && empty($_FILES['pic2']['name']) && empty($_FILES['pic3']['name']) && empty($_FILES['pic4']['name']) && empty($_FILES['pic5']['name']) ){
				$checkPicRequire = $modelGeneral->get_return_reason($returnReason)->get()->getRow();
				if($checkPicRequire->pic_require == 1){
					$error = 'Provide atleast one picture';
				}
			}
			//
			if(empty($error) && ($status == 'complete' || $status == 'commission')){
				//
				foreach($otherEquipment as $key => $eqValue){
					$inventoryExist = $modelGeneral->get_users_misc_equipment($eqValue,$user_id)->countAllResults();
					if($equipQty[$key] > 0){
						if($inventoryExist <= 0){
							$equipInfo = $modelGeneral->get_misc_equipment($eqValue)->get()->getRow();
							$error = 'Error : '.$equipInfo->name.' has not been assigned to you.';
							break;
						}
					}
				}	
				//
				if(empty($error)){
					foreach($otherEquipment as $key => $eqValue){
						$equipdata = $modelGeneral->get_users_misc_equipment($eqValue,$user_id)->get()->getRow();
						if($equipQty[$key] > 0){
							if($equipdata->stock < $equipQty[$key]){
								$equipInfo = $modelGeneral->get_misc_equipment($equipdata->equip_id)->get()->getRow();
								$error = 'Error : '.$equipInfo->name.' out of stock';
								break;
							}
						}
					}
				}
				//
				if(count($otherEquipment) != count(array_unique($otherEquipment)) ){
					$error = 'Error : Equipment can not be repeated';
				}
				//
				if(empty($error) && empty($_FILES['pic1']['name']) && empty($_FILES['pic2']['name']) && empty($_FILES['pic3']['name']) && empty($_FILES['pic4']['name']) && empty($_FILES['pic5']['name'])){
					$error = 'Provide atleast one picture';
				}
			}
			//
			if(empty($error)){
				$countOtherUn = $this->db->table('bo_customer_info')->whereIn('status',['travelling','on site'])->where('assign_to',$user_id)->where('un_number !=',$un_number)->countAllResults();
				if($countOtherUn > 0){
					$error = 'Error : Finish you previous task first';
				}
			}
			//
			if(empty($error)){
				$data['day_start'] = $modelUsers->get_day_routine($user_id,'start',date('Y-m-d'))->countAllResults();
				$data['break'] = $modelUsers->get_day_routine($user_id,'break',date('Y-m-d'))->countAllResults();
				$data['resume'] = $modelUsers->get_day_routine($user_id,'resume',date('Y-m-d'))->countAllResults();
				$data['day_end'] = $modelUsers->get_day_routine($user_id,'end',date('Y-m-d'))->countAllResults();
				//
				if(($data['day_start'] <= 0) || ($data['break'] > 0 && $data['resume'] <= 0) || ($data['day_end'] > 0)){
					$error = 'Please check you day routine';
				}
			}
			/////////////////////////////////////////////////////////////////////////////////////
			/////////////////////////////////////////////////////////////////////////////////////
			if(empty($error)){
				$this->db->transStart();
			//
				if($options == 'single'){
					//////////////////////////////// SINGLE START ////////////////////////////////////////////////

					$this->db->table('bo_customer_info')->where('id',$task_id)->where('assign_to',$user_id)->update(['status' => $status]);
				//
					if($status == 'complete' || $status == 'commission'){
					//
						$modelGeneral->task_detail_insert($task_id, $status, null, $imgname.'1.jpg', $imgname.'2.jpg', $imgname.'3.jpg', $imgname.'4.jpg', $imgname.'5.jpg',$user_id);
						$task_detail_id = $this->db->insertID();
						//
						if($gateway){
							foreach ($gateway as $gatewayValue) {
								$this->db->table('task_gateway')->insert(['task_id' => $task_id, 'gateway_serial' => $gatewayValue, 'task_detail_id' => $task_detail_id]);
							//
								$this->db->table('gateway')->where('serial',$gatewayValue)->where('status','assigned')->update(['status' => 'used']);
							}
						}
						//
						if($sim){
							foreach ($sim as $simValue) {
								$this->db->table('task_sim')->insert(['sim_icc_id' => $simValue, 'task_detail_id' => $task_detail_id]);
							//
								$this->db->table('sim')->where('icc_id',$simValue)->where('status','assigned')->update(['status' => 'utilized']);
							}
						}
						//
						foreach($otherEquipment as $key => $equipOther){
							if(!empty($otherEquipment[$key]) && $equipQty[$key] > 0){
								//
								$equipInfo = $modelGeneral->get_users_misc_equipment($otherEquipment[$key],$user_id)->get()->getRow();
								//
								$this->db->table('task_misc_equipment')->insert(['task_id' => $task_id, 'equip_id' => $otherEquipment[$key], 'qty' => $equipQty[$key], 'task_detail_id' => $task_detail_id, 'rate' => $equipInfo->rate, 'total' => $equipQty[$key]*$equipInfo->rate ]);
								//
								$this->db->query("UPDATE `users_misc_equipment` set `stock` = `stock` - '$equipQty[$key]'  where `user_id` =  '$user_id' and `equip_id` = '$otherEquipment[$key]'");

							}
						}
						/////////////////
						$modelTeam = new Model_Team();
						$team_id = $modelTeam->get_team_member(null,$user_id)->get()->getRow();
						if($team_id){
							$teamMember = $modelTeam->get_team_member($team_id->team_id);
							foreach($teamMember->get()->getResult() as $memberValue){
								$this->db->table('task_team_member')->insert(['task_id' => $task_id, 'team_id' => $team_id->team_id, 'user_id' => $memberValue->user_id, 'status' => $status]);
							}
						}
						/////////////////
					//
					}else if($status == 'reject'){
					//
						$modelGeneral->task_detail_insert($task_id, $status, $returnReason, $imgname.'1.jpg', $imgname.'2.jpg', $imgname.'3.jpg', $imgname.'4.jpg', $imgname.'5.jpg',$user_id);
					//
					}
					//
					//
					if(!empty($_FILES['pic1']['name'])){
						if(file_exists('./picture/'.$imgname.'1.jpg')){
							unlink('./picture/'.$imgname.'1.jpg');
						}
						$pic1->move('./picture',$imgname.'1.jpg');
					}if(!empty($_FILES['pic2']['name'])){
						if(file_exists('./picture/'.$imgname.'2.jpg')){
							unlink('./picture/'.$imgname.'2.jpg');
						}
						$pic2->move('./picture',$imgname.'2.jpg');
					}if(!empty($_FILES['pic3']['name'])){
						if(file_exists('./picture/'.$imgname.'3.jpg')){
							unlink('./picture/'.$imgname.'3.jpg');
						}
						$pic3->move('./picture',$imgname.'3.jpg');
					}if(!empty($_FILES['pic4']['name'])){
						if(file_exists('./picture/'.$imgname.'4.jpg')){
							unlink('./picture/'.$imgname.'4.jpg');
						}
						$pic4->move('./picture',$imgname.'4.jpg');
					}if(!empty($_FILES['pic5']['name'])){
						if(file_exists('./picture/'.$imgname.'5.jpg')){
							unlink('./picture/'.$imgname.'5.jpg');
						}
						$pic5->move('./picture',$imgname.'5.jpg');
					}
					
					//
					create_action_log('task id '.$task_id);

					//////////////////////////////// SINGLE END ////////////////////////////////////////////////

				}else if($options == 'multiple'){
					$currTask = $modelCustomer->get_customer_info($task_id)->get()->getRow();
					//
					$taskarry = $modelTask->get_task(null,$currTask->un_number,$user_id,$currTask->status);
					//
					foreach($taskarry->get()->getResult() as $value){
						$task_id = $value->id;
						//
						if($status == 'complete' || $status == 'commission'){
							//
							$modelGeneral->task_detail_insert($task_id, $status, null, $imgname.'1.jpg', $imgname.'2.jpg', $imgname.'3.jpg', $imgname.'4.jpg', $imgname.'5.jpg',$user_id);
							$task_detail_id = $this->db->insertID();
							//
							if($gateway){
								foreach ($gateway as $gatewayValue) {
									$this->db->table('task_gateway')->insert(['task_id' => $task_id, 'gateway_serial' => $gatewayValue, 'task_detail_id' => $task_detail_id]);
								//
									$this->db->table('gateway')->where('serial',$gatewayValue)->where('status','assigned')->update(['status' => 'used']);
								}
							}
							//
							if($sim){
								foreach ($sim as $simValue) {
									$this->db->table('task_sim')->insert(['sim_icc_id' => $simValue, 'task_detail_id' => $task_detail_id]);
							//
									$this->db->table('sim')->where('icc_id',$simValue)->where('status','assigned')->update(['status' => 'utilized']);
								}
							}
							//
							foreach($otherEquipment as $key => $equipOther){
								if(!empty($otherEquipment[$key]) && $equipQty[$key] > 0){
									//
									$equipInfo = $modelGeneral->get_users_misc_equipment($otherEquipment[$key],$user_id)->get()->getRow();
									//
									$this->db->table('task_misc_equipment')->insert(['task_id' => $task_id, 'equip_id' => $otherEquipment[$key], 'qty' => $equipQty[$key], 'task_detail_id' => $task_detail_id, 'rate' => $equipInfo->rate, 'total' => $equipQty[$key]*$equipInfo->rate ]);
									//
									$this->db->query("UPDATE `users_misc_equipment` set `stock` = `stock` - '$equipQty[$key]'  where `user_id` =  '$user_id' and `equip_id` = '$otherEquipment[$key]' ");
								}
							}
							/////////////////
							$modelTeam = new Model_Team();
							$team_id = $modelTeam->get_team_member(null,$user_id)->get()->getRow();
							if($team_id){
								$teamMember = $modelTeam->get_team_member($team_id->team_id);
								foreach($teamMember->get()->getResult() as $memberValue){
									$this->db->table('task_team_member')->insert(['task_id' => $task_id, 'team_id' => $team_id->team_id, 'user_id' => $memberValue->user_id, 'status' => $status]);
								}
							}
							/////////////////
							
						}else if($status == 'reject'){
							//
							$modelGeneral->task_detail_insert($task_id, $status, $returnReason, $imgname.'1.jpg', $imgname.'2.jpg', $imgname.'3.jpg', $imgname.'4.jpg', $imgname.'5.jpg',$user_id);
						}
						//
						create_action_log('task id '.$task_id);
					}
					//
					if(!empty($_FILES['pic1']['name'])){
						if(file_exists('./picture/'.$imgname.'1.jpg')){
							unlink('./picture/'.$imgname.'1.jpg');
						}
						$pic1->move('./picture',$imgname.'1.jpg');
					}if(!empty($_FILES['pic2']['name'])){
						if(file_exists('./picture/'.$imgname.'2.jpg')){
							unlink('./picture/'.$imgname.'2.jpg');
						}
						$pic2->move('./picture',$imgname.'2.jpg');
					}if(!empty($_FILES['pic3']['name'])){
						if(file_exists('./picture/'.$imgname.'3.jpg')){
							unlink('./picture/'.$imgname.'3.jpg');
						}
						$pic3->move('./picture',$imgname.'3.jpg');
					}if(!empty($_FILES['pic4']['name'])){
						if(file_exists('./picture/'.$imgname.'4.jpg')){
							unlink('./picture/'.$imgname.'4.jpg');
						}
						$pic4->move('./picture',$imgname.'4.jpg');
					}if(!empty($_FILES['pic5']['name'])){
						if(file_exists('./picture/'.$imgname.'5.jpg')){
							unlink('./picture/'.$imgname.'5.jpg');
						}
						$pic5->move('./picture',$imgname.'5.jpg');
					}
					//
					$this->db->table('bo_customer_info')->where('un_number',$currTask->un_number)->where('assign_to',$user_id)->where('status',$currTask->status)->update(['status' => $status]);
				}
				$this->db->transComplete();
				return $this->response->setStatusCode(200)->setBody('Updated Successfully');
			}else{
				return $this->response->setStatusCode(401,$error);
			}
			/////////////////////////////////////////////////////////////////////////////////////
			/////////////////////////////////////////////////////////////////////////////////////
		}else{
			return $this->response->setStatusCode(401,'Session Timeout');
		}
	}
	//


	public function test(){
		echo $this->db->table('bo_customer_info')->whereIn('status',['travelling','on site','complete'])->where('assign_to',$user_id)->where('un_number !=',$un_number)->countAllResults();
	}

}
