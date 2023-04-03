<?php

namespace App\Controllers;
use App\Models\Model_Customer;
use App\Models\Model_Users;
use App\Models\Model_General;

class Dashboard extends BaseController
{
	public function __construct(){

		parent::__construct();
		$this->db = \Config\Database::connect();
		$this->input = \Config\Services::request();
	}
	//
	public function index()
	{
		$status = session()->get('status');
		$modelUsers = new Model_Users();
		$modelCustomer = new Model_Customer();
		$modelGeneral = new Model_General();
		$id = session()->get('id');
		$today = date('Y-m-d');
		//
		if($status == 'engineer'){	
			////////////////////////////////////////////////////////
			$data['dailyStaffWise'] = array();
			$statusArray = array('schedule','travelling','on site','complete','reject','commission');
			$engineerList = $modelUsers->get_users($id,null,null,['engineer'])->get();
			//
			foreach($statusArray as $taskstatus){
			//
				foreach($engineerList->getResult() as $key => $value){
					$count = $modelCustomer->get_customer_info(null,null,$value->id,$taskstatus,date('Y-m-d'))->countAllResults();
					$data['dailyStaffWise'][$taskstatus][$key]['username'] = $value->username; 
					$data['dailyStaffWise'][$taskstatus][$key]['count'] = $count; 	
				}
			//
			}
			////////////////////////////////////////////////////////
			$data['gatewayReport'] = array();
			$statusArray = array('free','assigned','used');
			//
			foreach($statusArray as $key => $taskstatus){
				$gatewayCount = $modelGeneral->get_gateway($id,null,null,$taskstatus)->countAllResults();
				$newtaskstatus = ($taskstatus == 'free') ? 'In Stock' : (($taskstatus == 'assigned') ? 'Assigned' : 'Utilized' );
				$data['gatewayReport'][$key]['status'] = $newtaskstatus;
				$data['gatewayReport'][$key]['count'] = $gatewayCount;
			}
			///////////////////////////////////////////////////////
			$data['day_start'] = $modelUsers->get_day_routine($id,'start',$today)->countAllResults();
			$data['break'] = $modelUsers->get_day_routine($id,'break',$today)->countAllResults();
			$data['day_end'] = $modelUsers->get_day_routine($id,'end',$today)->countAllResults();
			///////////////////////////////////////////////////////
			return view('customer/dashboard',$data);	
		}else{
			////////////////////////////////////////////////////////
			$data['dailyStaffWise'] = array();
			$statusArray = array('schedule','travelling','on site','complete','reject','commission');
			$engineerList = $modelUsers->get_users(null,null,null,['engineer'])->get();
			//
			foreach($statusArray as $taskstatus){
			//
				foreach($engineerList->getResult() as $key => $value){
					$count = $modelCustomer->get_customer_info(null,null,$value->id,$taskstatus,date('Y-m-d'))->countAllResults();
					$data['dailyStaffWise'][$taskstatus][$key]['username'] = $value->username; 
					$data['dailyStaffWise'][$taskstatus][$key]['count'] = $count; 	
				}
			//
			}
			////////////////////////////////////////////////////////
			$data['gatewayReport'] = array();
			$statusArray = array('free','assigned','used');
			//
			foreach($statusArray as $key => $taskstatus){
				$gatewayCount = $modelGeneral->get_gateway(null,null,null,$taskstatus)->countAllResults();
				$newtaskstatus = ($taskstatus == 'free') ? 'In Stock' : (($taskstatus == 'assigned') ? 'Assigned' : 'Utilized' );
				$data['gatewayReport'][$key]['status'] = $newtaskstatus;
				$data['gatewayReport'][$key]['count'] = $gatewayCount;
			}
			///////////////////////////////////////////////////////
			$data['equipmentReport'] = $modelGeneral->get_misc_equipment()->get()->getResultArray();
			///////////////////////////////////////////////////////
			return view('cpanel/dashboard',$data);
		}

	}
	//
	public function update_day_status()
	{
		$error = null;
		$status = $this->input->getPost('status');
		$userID = session()->get('id');
		//
		if(!isLoggedIn()){
			$error = 'Session Timeout';
		}if(session()->get('status') != 'engineer'){
			$error = 'Access denied';
		}
		//
		if(empty($error)){
			//
			$data = array('user_id' => $userID , 'status' => $status, 'date' => date('Y-m-d'), 'time' => date('H:i:s'));
			$this->db->table('day_routine')->insert($data);
			//
			$successMsg = ($status == 'start') ? 'Your day has started' : (($status == 'break') ? 'Lets take a break' : 'Your day has ended');
			return $this->response->setStatusCode(200)->setBody($successMsg);
		}else{
			return $this->response->setStatusCode(401,$error);
		}
	}
	/////////////////
	public function check_day_status(){
		$id = session()->get('id');
		$today = date('Y-m-d');
		$data['enableList'] = "";
		$data['disableList'] = "";
		$modelUsers = new Model_Users();
		//
		$data['day_start'] = $modelUsers->get_day_routine($id,'start',$today)->countAllResults();
		$data['break'] = $modelUsers->get_day_routine($id,'break',$today)->countAllResults();
		$data['resume'] = $modelUsers->get_day_routine($id,'resume',$today)->countAllResults();
		$data['day_end'] = $modelUsers->get_day_routine($id,'end',$today)->countAllResults();
		//
		if($data['day_start'] <= 0){
			$data['disableList'] = "break,end,resume";
			$data['enableList'] = "start";
			return json_encode($data);
		}elseif($data['day_end'] > 0){
				$data['enableList'] = "";
				$data['disableList'] = "start,break,end,resume";
				return json_encode($data);
		}elseif($data['day_start'] > 0 && $data['break'] <= 0){
				$data['enableList'] = "end,break";
				$data['disableList'] = "start,resume";
				return json_encode($data);
		}elseif($data['day_start'] > 0 && $data['break'] > 0 && $data['resume'] <= 0){
				$data['enableList'] = "end,resume";
				$data['disableList'] = "start,break";
				return json_encode($data);
		}elseif($data['day_start'] > 0 && $data['break'] > 0 && $data['resume'] > 0){
				$data['enableList'] = "end";
				$data['disableList'] = "start,break,resume";
				return json_encode($data);
		}
		//
		
	}
	

}
