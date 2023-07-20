<?php

namespace App\Controllers;
use \Hermawan\DataTables\DataTable;
use App\Models\Model_Customer;
use App\Models\Model_Tools;
use App\Models\Model_Users;
use App\Models\Model_Task;
use App\Models\Model_General;
use App\Models\Model_Team;

class Customer extends BaseController
{
	public function __construct(){

		parent::__construct();
		$this->db = \Config\Database::connect();
		$this->input = \Config\Services::request();
	}
	//
	public function customer_list()
	{
		if(isLoggedIn() && access_crud('All work Orders','view')){
			return view('cpanel/customerList');
		}else{
			return redirect()->to(base_url('login'));
		}
	}
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function create()
	{
		if(isLoggedIn() && access_crud('Task Create','create')){
			$tools = new Model_Tools();
			$data['cities'] = $tools->get_cities();
			return view('cpanel/customerCreate',$data);
		}else{
			return redirect()->to(base_url('login'));
		}
	}
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	// public function view()
	// {
	// 	$custID = $this->input->getPost('custID');
	// 	$customerModel = new Model_Customer();
	// 	$modelpkg = new Model_Package();
	// 	//
	// 	$data['info'] = $customerModel->get_customer($custID)->get()->getRow();
	// 	$data['cont'] = $customerModel->get_customer_contract(null,$custID,'Active')->get()->getRow();
	// 	if($data['cont']){
	// 		$data['pkg'] = $modelpkg->get_package($data['cont']->pkg_id)->get()->getRow();
	// 	}
	// 	return json_encode($data);
	// }
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function show_list(){
		if(isLoggedIn()){
			//$customerModel = new Model_Customer();
			//$builder = $customerModel->get_customer_info()->orderBy('id','DESC');
			$builder = $this->db->table('bo_customer_info as task')
			->select('un_number,meter_number,scenario,meter_type,protocol,meter_model,prem_type,task.status,task.id,assign_to,user.username')
			->join('bo_users as user','task.assign_to = user.id','left')
			->orderBy('id','DESC');
			//
			return DataTable::of($builder)
			//
			->filter(function ($builder, $request) {
				if ($request->status && $request->status != 'all')
					$builder->where('task.status', $request->status);
			})
			//
			->add('taskStatus', function($row){
				//
				$status = ($row->status == 'complete') ? 'installed' : ( ($row->status == 'reject') ? 'return' : ($row->status) );
				//
				return '<span class="badge badge-soft-info" style="font-size:15px;">'.ucfirst($status).'</span>';
			})
			//
			->add('assign_to', function($row){
				//
				if(!empty($row->assign_to)){
					$modelUsers = new Model_Users();
					$userInfo = $modelUsers->get_users($row->assign_to)->get()->getRow();
					return $userInfo->firstname.' '.$userInfo->lastname;
				}
			})
			//
			->add('action', function($row){
				//
				$actionHtml = '<div class="btn-group">';
				if($row->status == 'unallocated' || $row->status == 'commission' || $row->status == 'reject'){
					$actionHtml .= '<button type="button" id="assignBtn" assign-id="'.$row->assign_to.'" data-id="'.$row->id.'" class="btn btn-primary btn-sm" title="Assign Now"><i class="fa fa-tasks"></i></button>';
				}
				$actionHtml .= '<a href="'.base_url().'/task/view-detail/'.$row->id.'" class="btn btn-info btn-sm" title="View Detail"><i class="fa fa-info-circle"></i></a>';

				if($row->status == 'unallocated' || $row->status == 'schedule' || $row->status == 'travelling' || $row->status == 'on site'){
					$actionHtml .= '<a type="button" class="btn btn-danger btn-sm delete" data-serial="'.$row->id.'" title="Delete"><i class="fa fa-trash"></i></a>';
				}
				
				$actionHtml .= '</div>';

				return $actionHtml;
			})
			//
			->toJson(true);
		}
	}
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	public function save_customer(){
		if(isLoggedIn() && access_crud('Task Create','create')){
			$error = null;
			$user_id = session()->get('id');
			//
			$fname = $this->input->getPost('fname');
			$lname = $this->input->getPost('lname');
			$cnic = $this->input->getPost('cnic');
			$mobile = $this->input->getPost('mobile');
			$phone = $this->input->getPost('phone');
			$email = $this->input->getPost('email');
			$passport = $this->input->getPost('passport');
			$city = $this->input->getPost('city');
			$address = $this->input->getPost('address');
			$service = $this->input->getPost('service');
			//
			$nicFront = $this->input->getFile('nicFront');
			$nicBack = $this->input->getFile('nicBack');
			//
			$validation =  \Config\Services::validation();
			$validate = $this->validate([
				'fname' => ['label' => 'First Name', 'rules' => 'required|trim|regex_match[/^[a-zA-Z ]+$/]'],
				'lname' => ['label' => 'Last Name', 'rules' => 'required|trim|regex_match[/^[a-zA-Z ]+$/]'],
				'cnic' => ['label' => 'CNIC#', 'rules' => 'required|trim|regex_match[/^[0-9]{5}-[0-9]{7}-[0-9]$/]'],
				'mobile' => ['label' => 'Mobile#', 'rules' => 'required|trim|regex_match[/^[0][3][0-9]{9}$/]'],
				'phone' => ['label' => 'Phone#', 'rules' => 'trim|regex_match[/^[0-9]{0,15}$/]'],
				'email' => ['label' => 'Email Address', 'rules' => 'required|trim|valid_email'],
				'passport' => ['label' => 'Passport#', 'rules' => 'trim|regex_match[/^[0-9]{0,15}$/]'],
				'city' => ['label' => 'City', 'rules' => 'trim|required'],
				'address' => ['label' => 'Home Address', 'rules' => 'trim|required'],
			]);
			if(!$validate){
				$error = $validation->listErrors();
			}
			//
			$customerModel = new Model_Customer();
			if(empty($error)){
				$emailCount=$customerModel->get_customer(null,null,null,$email)->countAllResults();
				if($emailCount > 0){
					$error = 'Email Address already exist';
				}
			} if(empty($error)){
				$nicCount=$customerModel->get_customer(null,null,null,null,$cnic)->countAllResults();
				if($nicCount > 0){
					$error = 'CNIC# already exist';
				}
			}
			//
			if(empty($error)){
				$this->db->transStart();
				//
				$data = array('firstname' => $fname, 'lastname' => $lname, 'email' => $email, 'nic' => $cnic, 'mobilephone' => $mobile, 'phone' => $phone, 'passport' => $passport, 'address' => $address, 'city' => $city, 'created_by' => $user_id);
				$this->db->table('bo_customer')->insert($data);
				//
				$cust_id = $this->db->insertID();
				$username = 'bo-'.$cust_id;
				//
				$permitted_chars = '123456789abcdefghijklmnopqrstuvwxyz';
				$pass = substr(str_shuffle($permitted_chars), 0, 6);
				//
				$data2 = array('username' => $username, 'password' => md5($pass), 'pass_string' => $pass);
				$this->db->table('bo_customer')->where('id',$cust_id)->update($data2);
				//
				$nicFront->move('./customer_nic',$username.'-front.jpg');
				$nicBack->move('./customer_nic',$username.'-back.jpg');
				//
				create_action_log('cust id '.$cust_id); 
				echo 'Success-'.$cust_id;
				//
				$customerModel->insert_status_info($username);
				///////////////////////// Radius Entry //////////////////////
				$radiusModel = new Model_Radius();
				$radiusModel->insert_radusergroup($username);
				$radiusModel->insert_radcheck($username,$pass);
				//
				$this->db->transComplete();
			}else{
				echo $error;
			}
		}else{
			echo 'Error : Some thing went wrong';
		}
	}
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	public function update_action(){

		if(isLoggedIn() && access_crud('Customer List','update')){
			$error = null;
			//
			$custID = $this->input->getPost('custID');
			$fname = $this->input->getPost('fname');
			$lname = $this->input->getPost('lname');
			$cnic = $this->input->getPost('cnic');
			$mobile = $this->input->getPost('mobile');
			$phone = $this->input->getPost('phone');
			$email = $this->input->getPost('email');
			$passport = $this->input->getPost('passport');
			$city = $this->input->getPost('city');
			$address = $this->input->getPost('address');
			$service = $this->input->getPost('service');
			//
			//
			//
			$nicFront = $this->input->getFile('nicFront');
			$nicBack = $this->input->getFile('nicBack');

			//
			$validation =  \Config\Services::validation();
			$validate = $this->validate([
				'fname' => ['label' => 'First Name', 'rules' => 'required|trim|regex_match[/^[a-zA-Z ]+$/]'],
				'lname' => ['label' => 'Last Name', 'rules' => 'required|trim|regex_match[/^[a-zA-Z ]+$/]'],
				'cnic' => ['label' => 'CNIC#', 'rules' => 'required|trim|regex_match[/^[0-9]{5}-[0-9]{7}-[0-9]$/]'],
				'mobile' => ['label' => 'Mobile#', 'rules' => 'required|trim|regex_match[/^[0][3][0-9]{9}$/]'],
				'phone' => ['label' => 'Phone#', 'rules' => 'trim|regex_match[/^[0-9]{0,15}$/]'],
				'email' => ['label' => 'Email Address', 'rules' => 'required|trim|valid_email'],
				'passport' => ['label' => 'Passport#', 'rules' => 'trim|regex_match[/^[0-9]{0,15}$/]'],
				'city' => ['label' => 'City', 'rules' => 'trim|required'],
				'address' => ['label' => 'Home Address', 'rules' => 'trim|required'],
			]);
			if(!$validate){
				$error = $validation->listErrors();
			}
			//
			if(empty($error) && !empty($email)){
				$customerModel = new Model_Customer();
				$emailCount=$customerModel->get_customer_except([$custID],$email)->countAllResults();
				if($emailCount > 0){
					$error = 'Email Address already exist';
				}
			}
			//
			if(empty($error)){
				$this->db->transStart();
				//
				$data = array('firstname' => $fname, 'lastname' => $lname, 'email' => $email, 'nic' => $cnic, 'mobilephone' => $mobile, 'phone' => $phone, 'passport' => $passport, 'address' => $address, 'city' => $city);
				$this->db->table('bo_customer')->where('id',$custID)->update($data);
				//
				if (!empty($_FILES['nicFront']['name'])) {
					if(file_exists('./customer_nic/bo-'.$custID.'-front.jpg')){
						unlink('./customer_nic/bo-'.$custID.'-front.jpg'); 
					}
					$nicFront->move('./customer_nic','bo-'.$custID.'-front.jpg'); 
				}
				//
				if (!empty($_FILES['nicBack']['name'])) {
					if(file_exists('./customer_nic/bo-'.$custID.'-back.jpg')){
						unlink('./customer_nic/bo-'.$custID.'-back.jpg'); 
					}
					$nicBack->move('./customer_nic','bo-'.$custID.'-back.jpg'); 
				}
				//
				create_action_log('cust id '.$custID); 
				echo 'Success : Customer Updated Successfuly';
				//
				$this->db->transComplete();
			}else{
				echo $error;
			}
		}else{
			echo 'Error : Some thing went wrong';
		}

	}
	// ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// public function panelEnableDisable(){
	// 	if(isLoggedIn() && access_crud('Customer List','update')){
	// 		echo $custID = $this->input->getPost('custID');
	// 		echo $block = $this->input->getPost('block');
	// 		//
	// 		// $data = array('block' => $block);
	// 		// $this->db->table('bo_customer')->where('id',$custID)->update($data);
	// 	}
	// }

	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////

	//////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////
	public function change_password(){
		if(isLoggedIn()){
			$error = null;
			$id= $this->input->getPost('id');
			$old= $this->input->getPost('old');
			$new= $this->input->getPost('new');
			$confirm= $this->input->getPost('confirm');
		//
			$validation =  \Config\Services::validation();
			//
			$validate = $this->validate([
				'old' => ['label' => 'Old Password', 'rules' => 'trim|required'],
				'new' => ['label' => 'New Password', 'rules' => 'trim|required|min_length[5]'],
				'confirm' => ['label' => 'Confirm Password', 'rules' => 'trim|required|matches[new]'],
			]);
			if(!$validate){
				$error = $validation->listErrors();
			}
			if(empty($error)){
				$modelCustomer = new Model_Customer();
				$oldpass = $modelCustomer->get_customer($id)->get()->getRow()->pass_string;
				if($oldpass != $old){
					$error = 'Error : Invalid Old Password';
				}
			}
			if(empty($error)){
				$this->db->transStart();
					//
				$this->db->table('bo_customer')->where('id',$id)->update(['password' => md5($new), 'pass_string' => $new]);
				echo 'Success : Password Changed Successfuly';
				create_action_log('id '.$id);  
				$this->db->transComplete();
			}else{
				echo $error;
			}
		}else {
			echo 'Error : Some thing went wrong';
		}
	}
	////////////////////////////////////////////////////////
	public function enableDisableCustomer(){
		if(isLoggedIn() && access_crud('Customer List','update')){
			$custID = $this->input->getPost('custID');
			$block = $this->input->getPost('block');
			//
			if(!empty($custID) && !empty($block)){
				$data = array('block' => $block);
				$this->db->table('bo_customer')->where('id',$custID)->update($data);
				//
				echo 'Update Successfuly';
				create_action_log('id '.$custID);  
			}
		}
	}
	/////////////////////////////////////////////////////////
	public function customer_detail(){
		if(isLoggedIn()){
			return view('customer/customer-detail');
		}else{
			return redirect()->to(base_url('login'));
		}	
	}
	/////////////////////////////////////////////////////////
	public function view_detail(){
		if(isLoggedIn()){
			$uri = new \CodeIgniter\HTTP\URI(current_url());
			$id = $uri->getSegment(3);
			//
			$data['modelGeneral'] = new Model_General();
			$data['customerModel'] = new Model_Customer();
			$data['modelTask'] = new Model_Task();
			$data['modelUser'] = new Model_Users();
			//
			$data['info'] = $data['customerModel']->get_customer_info($id)->get()->getRow();
			$data['get_task_detail'] = $data['modelTask']->get_task_detail(null,$id)->orderBy('id','ASC');
			//
			return view('cpanel/customerView',$data);
		}else{
			return redirect()->to(base_url('login'));
		}	
	}
	////////////////////////////////////////////////////////
	public function upload(){
		if(isLoggedIn() && access_crud('Assign Work Orders','view')){
			return view('cpanel/customer_upload');
		}else{
			return redirect()->to(base_url('login'));
		}	
	}
	///////////////////////////////////////////////////////
	public function upload_csv_action(){
		$error = null;
		$meterNoArray = array();
		$csv = $_FILES['file']['tmp_name'];
		if(!isLoggedIn()){
			$error = 'Error : Session expired';
		}
		if(isset($_FILES['file'])){
			$file_name = $_FILES['file']['name'];
			$handle = fopen($_FILES['file']['tmp_name'],"r");
			$ext = pathinfo($file_name, PATHINFO_EXTENSION);
			//
			if(count(fgetcsv($handle)) != "17"){
				$error = 'Error : Invalid file structure';
			}if($ext != 'csv'){
				$error = 'Error : Invalid file format';
			}
		}
		//
		if(empty($error)){
			$handle = fopen($csv,"r");
			$num = 0;
			while (($row = fgetcsv($handle, 10000, ",")) != FALSE) 
			{
				if($num > 0){
					//
					array_push($meterNoArray, trim($row[1]));
					//
					$meterNoExist = $this->db->table('bo_customer_info')->where('meter_number',$row[1])->countAllResults();
					if($meterNoExist > 0){
						$line = $num+1;
						$error = 'Error : Meter Number already exist at line#'.$line;
						break;
					}
					//
					if(empty($error)){
						if (count(array_diff_assoc($meterNoArray, array_unique($meterNoArray))) > 0) {
							$error = 'Error : Duplicate Meter Number in sheet';	
						}
					}
					//
				}
				$num++;
			}
			//
		}
		//
		//////////
		if(empty($error)){
			$remove = array("'","`","(",")",",",'"');
			$handle = fopen($csv,"r");
			$num = 0;
			while (($row = fgetcsv($handle, 10000, ",")) != FALSE) 
			{
				if($num > 0){

					$data = array(
						'un_number' => str_replace($remove,'',$row[0]),
						'meter_number' => str_replace($remove,'',$row[1]),
						'priority' => str_replace($remove,'',$row[2]),
						'scenario' => str_replace($remove,'',$row[3]),
						'latitude' => str_replace($remove,'',$row[4]),
						'longitude' => str_replace($remove,'',$row[5]),
						'protocol' => str_replace($remove,'',$row[6]),
						'mfg_cd' => str_replace($remove,'',$row[7]),
						'meter_model' => str_replace($remove,'',$row[8]),
						'prem_type' => str_replace($remove,'',$row[9]),
						'sector' => str_replace($remove,'',$row[10]),
						'plot' => str_replace($remove,'',$row[11]),
						'address' => str_replace($remove,'',$row[12]),
						'name' => str_replace($remove,'',$row[13]),
						'mobile' => str_replace($remove,'',$row[14]),
						'email' => str_replace($remove,'',$row[15]),
						'meter_type' => str_replace($remove,'',$row[16]),
					);
					//
					$this->db->table('bo_customer_info')->insert($data);
					//
				}
				$num++;
			}
			//
			create_action_log();
			return $this->response->setStatusCode(200)->setBody('Upload Successfully');
		}else{
			return $this->response->setStatusCode(401,$error);
		}
	}

	/////////////////////////////
	public function technician_list(){
		if(isLoggedIn()){
			// $assignid = $this->input->getPost('id');
			$userModel = new Model_Users();
			$query=$userModel->get_users(null,null,null,['engineer'])->where('block','no');
			?>
			<!-- <option <?= (empty($assignid)) ? 'selected' : '';?> >select technician</option> -->
			<option value="">select technician</option>
			<?php
			foreach ($query->get()->getResult() as $value) { ?>
				<option value="<?= $value->id;?>" ><?= $value->firstname.' '.$value->lastname;?></option>
			<?php }
		}else{
			return $this->response->setStatusCode(401,'Session Timeout');
		}
	}
	/////////////////////////////
	public function update_technician(){
		$error = null;
		$modelCustomer = new Model_Customer();
		$dataid = $this->input->getPost('dataid');
		$technician_id = $this->input->getPost('technician_id');
		$options = $this->input->getPost('options');
			//
		if(!isLoggedIn()){
			$error = 'Session Timeout';
		}
		if(empty($error)){
			$checkStatus = $modelCustomer->get_customer_info($dataid)->get()->getRow();
			if($checkStatus->status == 'commission'){
				if(session()->get('status') != 'admin'){
					$error = 'Access Denied';
				}
			}
		}
		//
		if(empty($error)){
			$modelTeam = new Model_Team();
			$checkTeamMember = $modelTeam->get_team_member(null,$technician_id)->countAllResults();
			if($checkTeamMember <= 0){
				$error = 'Error : Engineer is not a team member';
			}
		}
		//
		if(empty($error)){
			if($options == 'single'){
				//
				$this->db->table('bo_customer_info')->where('id',$dataid)->update(['assign_to' => $technician_id, 'status' => 'schedule' , 'assign_on' => date("Y-m-d H:i:s") ]);
				//
				create_action_log('task id '.$dataid);
			}else if($options == 'multiple'){
				//
				$un = $modelCustomer->get_customer_info($dataid)->get()->getRow()->un_number;
				$this->db->table('bo_customer_info')->where('un_number',$un)->where('status','unallocated')->update(['assign_to' => $technician_id, 'status' => 'schedule', 'assign_on' => date("Y-m-d H:i:s")]);
				//
				create_action_log('un# '.$un);
			}
			return $this->response->setStatusCode(200)->setBody('Updated Successfully');
		}else{
			return $this->response->setStatusCode(401,$error);
		}
	}
	////////////////////////////
	public function bulk_assign(){
		if(isLoggedIn()){
			$userModel = new Model_Users();
			$data['technicianList']=$userModel->get_users(null,null,null,['engineer']);
			return view('cpanel/bulk_assign',$data);
		}else{
			return redirect()->to(base_url('login'));
		}
	}
	/////////////////////////////
	public function assign_by_un(){
		if(isLoggedIn()){
			$error = null;
			$un_number = $this->input->getPost('un_number');
			$technician_id = $this->input->getPost('technician_id');
			//
			$validation =  \Config\Services::validation();
			$validate = $this->validate([
				'un_number' => ['label' => 'UN#', 'rules' => 'required|trim'],
			]);
			if(!$validate){
				$error = $validation->listErrors();
				$error = str_replace(array("\n", "\r"), '', $error);
				$error =  nl2br($error);
			}
			$customerModel = new Model_Customer();
			$unCount = $customerModel->get_customer_info(null,$un_number)->countAllResults();
			if($unCount <= 0){
				$error = 'Error : Invalid UN#';
			}
			//
			if(empty($error)){
				$modelTeam = new Model_Team();
				$checkTeamMember = $modelTeam->get_team_member(null,$technician_id)->countAllResults();
				if($checkTeamMember <= 0){
					$error = 'Error : Engineer is not a team member';
				}
			}
			//
			if(empty($error)){
				//
				$this->db->table('bo_customer_info')->where('un_number',$un_number)->update(['assign_to' => $technician_id, 'status' => 'schedule' , 'assign_on' => date("Y-m-d H:i:s")]);
				//
				create_action_log('un# '.$un_number);
				return $this->response->setStatusCode(200)->setBody('Updated Successfully');
			}else{
				return $this->response->setStatusCode(401,$error);
			}
			//
		}else{
			return $this->response->setStatusCode(401,'Session Timeout');
		}
	}
	/////////////////////////////////////
	public function assign_by_meter(){
		$error = null;
		$technician_id = $this->input->getPost('technician_id');
		$csv = $_FILES['file']['tmp_name'];
		if(!isLoggedIn()){
			$error = 'Error : Session expired';
		}
		if(isset($_FILES['file'])){
			$file_name = $_FILES['file']['name'];
			$handle = fopen($_FILES['file']['tmp_name'],"r");
			$ext = pathinfo($file_name, PATHINFO_EXTENSION);
			//
			if(count(fgetcsv($handle)) != "1"){
				$error = 'Error : Invalid file structure';
			}if($ext != 'csv'){
				$error = 'Error : Invalid file format';
			}
		}
		//
		if(empty($error)){
			$modelTeam = new Model_Team();
			$checkTeamMember = $modelTeam->get_team_member(null,$technician_id)->countAllResults();
			if($checkTeamMember <= 0){
				$error = 'Error : Engineer is not a team member';
			}
		}
		//////////
		if(empty($error)){
			$remove = array("'","`","(",")",",",'"');
			$handle = fopen($csv,"r");
			$num = 0;
			while (($row = fgetcsv($handle, 10000, ",")) != FALSE) 
			{
				if($num > 0){
					//echo $row[0];
					//
					$this->db->table('bo_customer_info')->where('meter_number',$row[0])->update(['assign_to' => $technician_id,'status' => 'schedule', 'assign_on' => date("Y-m-d H:i:s")]);
					//
				}
				$num++;
				create_action_log('meter# '.$row[0]);
			}
			//
			return $this->response->setStatusCode(200)->setBody('Upload Successfully');
		}else{
			return $this->response->setStatusCode(401,$error);
		}
	}
	/////////////////////////////////////////////////////////////////////////////////////
	public function count_meter_type(){
		$un = $this->input->getPost('data');
		$data['waterMeterCount'] = $this->db->table('bo_customer_info')->where('un_number',$un)->where(' 	meter_type','Water')->countAllResults();
		$data['electricMeterCount'] = $this->db->table('bo_customer_info')->where('un_number',$un)->where(' 	meter_type','Electric')->countAllResults();
		return json_encode($data);
	}
	////////////////////////////////////
	public function delete_task_action(){
		$error = null;
		$task_id = $this->input->getPost('id');
		if(!isLoggedIn() || !access_crud('All work Orders','delete')){
			$error = 'Access denied';
		}
		//
		$modelCustomer = new Model_Customer();
		// $checkStatus = $modelCustomer->get_customer_info($task_id,null,null,'unallocated')->countAllResults();
		$checkStatus = $this->db->table('bo_customer_info')->where('id',$task_id)->whereIn('status',['unallocated','schedule','travelling','on site'])->countAllResults();
		if($checkStatus <= 0){
			$error = 'Error : This can not be deleted';		
		}
		//
		if(empty($error)){
			//
			$this->db->table('bo_customer_info')->where('id',$task_id)->whereIn('status',['unallocated','schedule','travelling','on site'])->delete();
			//
			create_action_log('id#'.$task_id);
			return $this->response->setStatusCode(200)->setBody('Delete Successfully');
		}else{
			return $this->response->setStatusCode(401,$error);
		}
	}






}
