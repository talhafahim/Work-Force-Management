<?php

namespace App\Controllers;
use App\Models\Model_Customer;
use App\Models\Model_Users;
use App\Models\Model_General;
use App\Models\Model_Task;
use App\Models\Model_Team;

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
		if(access_crud('Dashboard','view')){
			$status = session()->get('status');
			$modelUsers = new Model_Users();
			$modelCustomer = new Model_Customer();
			$modelGeneral = new Model_General();
			$id = session()->get('id');
			$today = date('Y-m-d');
			//
			$data['taskPieGraph'] = $data['taskStatusWise'] = $data['equipmentReport'] = $data['gatewayReport'] = $data['dailyStaffWise'] = $data['profit'] = null;
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
						$count = $modelCustomer->get_customer_info(null,null,$value->id,$taskstatus,date('Y-m-d'),date('Y-m-d'))->countAllResults();
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
				if(access_crud('All work Orders','view')){
					$data['dailyStaffWise'] = array();
					$statusArray = array('schedule','travelling','on site','complete','reject','commission');
					$engineerList = $modelUsers->get_users(null,null,null,['engineer'])->get();
			//
					foreach($statusArray as $taskstatus){
			//
						foreach($engineerList->getResult() as $key => $value){
							$count = $modelCustomer->get_customer_info(null,null,$value->id,$taskstatus,date('Y-m-d'),date('Y-m-d'))->countAllResults();
							$data['dailyStaffWise'][$taskstatus][$key]['username'] = $value->username; 
							$data['dailyStaffWise'][$taskstatus][$key]['count'] = $count; 	
						}
			//
					}
				////////////////////////////////////////////////////////
					$data['taskPieGraph'] = $this->task_pie_graph_data();
					$data['taskTotal'] = $this->db->table('bo_customer_info')->whereIn('status',['schedule','travelling','on site','complete','commission'])->where('assign_on >=',$today.' 00:00:00')->where('assign_on <=',$today.' 23:59:59')->countAllResults();	//// total gateway count
				}
				////////////////////////////////////////////////////////
				if(access_crud('Gateway','view')){ 
					$data['gatewayReport'] = array();
					$statusArray = array('free','assigned','used','return','faulty');
			//
					foreach($statusArray as $key => $taskstatus){
						$gatewayCount = $modelGeneral->get_gateway(null,null,null,$taskstatus)->countAllResults();
						$newtaskstatus = ($taskstatus == 'free') ? 'In Stock' : (($taskstatus == 'assigned') ? 'Assigned' : (($taskstatus == 'used') ? 'Utilized' : $taskstatus ));
						$data['gatewayReport'][$key]['status'] = $newtaskstatus;
						$data['gatewayReport'][$key]['count'] = $gatewayCount;
					}
					/////////////////////////////////////////////////
					$data['taskStatusWise'] = $this->gateway_taskStatusWise();
				}
				///////////////////////////////////////////////////////
				if(access_crud('Equipment','view')){
					$data['equipmentReport'] = $modelGeneral->get_misc_equipment()->get()->getResultArray();
				}
				////////////////////////////////////////////////////
				//
				if(access_crud('Profit & Loss Report','view')){
					$data['profit'] = $this->profit_graph_data();	
				}	
				///////////////////////////////////////////////////////
				$data['gatewayTotal'] = $this->db->table('gateway')->countAllResults();	//// total gateway count
				return view('cpanel/dashboard',$data);
			}
		}else{
			return redirect()->to(base_url('welcome'));
		}

	}
	//
	public function update_day_status()
	{
		$error = null;
		$status = $this->input->getPost('status');
		$latitude = $this->input->getPost('latitude');
		$longitude = $this->input->getPost('longitude');
		if(empty($latitude) || empty($longitude)){
			$latitude = null;
			$longitude = null;
		}
		$userID = session()->get('id');
		//
		if(!isLoggedIn()){
			$error = 'Session Timeout';
		}if(session()->get('status') != 'engineer'){
			$error = 'Access denied';
		}
		//
		$checkTask =  $this->db->table('bo_customer_info')->where('assign_to',$userID)->whereIn('status',['schedule','travelling','on site'])->countAllResults();
		if($checkTask > 0 && $status == 'end'){
			$error = 'You can not end your day.<br>Please check your task first';
		}
		//
		if(empty($error)){
			//
			$data = array('user_id' => $userID , 'status' => $status, 'date' => date('Y-m-d'), 'time' => date('H:i:s'), 'longitude' => $longitude, 'latitude' => $latitude);
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
	//
	public function welcome()
	{
		if(isLoggedIn() && !access_crud('Dashboard','view')){
			return view('cpanel/welcome');
		}else{
			return redirect()->to(base_url('login'));
		}
	}
	//
	public function profit_graph_data(){
		$data['profit'] = array();
		$modelTask = new Model_Task();

		for ($i = 6; $i >= 0; $i--) {
			$equipCost = $staffCost = $gatewayRev = $commissionRev = 0;
			$date = date('Y-m-d', strtotime("-$i days"));
			//
			$equipCost = $modelTask->get_total_equip_cost($date)->get()->getRow()->total_sum;
			$staffCost = $modelTask->get_total_team_cost($date)->get()->getRow()->total_sum;
			$gatewayRev = $modelTask->get_total_gateway_revenue($date)->get()->getRow()->total_sum;
			$commissionCount = $modelTask->get_total_commission($date)->countAllResults();
			$commissionRev = $commissionCount*18.62;
			//
			$totalRev = $gatewayRev + $commissionRev;
			$totalExp = $staffCost + $equipCost;
			//	
			// Staff cost + Equipment cost - (commissioning revenue + Gateway revenue)
			$profit = $totalRev - $totalExp;

			$data['profit'][$i]['date'] = date('M,d',strtotime($date));
			$data['profit'][$i]['profit'] = $profit;
		}
		//
		return ($data['profit']);
	}
	////////////////////////////////////////////////
	public function task_pie_graph_data(){
		$data['dailyTaskStatusWise'] = array();
		$statusArray = array('schedule','travelling','on site','complete','reject','commission');
		$modelCustomer = new Model_Customer();
			//
		foreach($statusArray as $key => $taskstatus){
				//
			$count = $modelCustomer->get_customer_info(null,null,null,$taskstatus,date('Y-m-d'),date('Y-m-d'))->countAllResults();
				//
			$status = ($taskstatus == 'complete') ? 'installed' : ( ($taskstatus == 'reject') ? 'return' : ($taskstatus) );
				//
			$data['dailyTaskStatusWise'][$key]['status'] = ucfirst($status); 
			$data['dailyTaskStatusWise'][$key]['count'] = $count; 	
			//
		}
		//
		return $data['dailyTaskStatusWise'];
	}
	////////////////////////////////////////////////
	public function gateway_taskStatusWise(){
		$modelGeneral = new Model_General();
		$modelUsers = new Model_Users();
		$data['taskStatusWise'] = array();
		$statusArray = array('complete','commission');
		$engineerList = $modelUsers->get_users(null,null,null,['engineer'])->get();
		//
		foreach($statusArray as $taskstatus){
			//
			foreach($engineerList->getResult() as $key => $value){
				$count = $modelGeneral->get_gateway_taskStatusWise($value->id,$taskstatus,date('Y-m-d'))->get()->getRow()->gatewayCount;
				$data['taskStatusWise'][$taskstatus][$key]['username'] = $value->username; 
				$data['taskStatusWise'][$taskstatus][$key]['count'] = $count; 	
			}
			//
		}
		//
		return $data['taskStatusWise'];
	}


}
