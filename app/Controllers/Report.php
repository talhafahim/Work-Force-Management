<?php 
namespace App\Controllers;
use App\Models\Model_Customer;
use App\Models\Model_Tools;
use App\Models\Model_Users;
use App\Models\Model_Task;
use App\Models\Model_General;

class Report extends BaseController
{
	public function __construct(){

		parent::__construct();
		$this->db = \Config\Database::connect();
		$this->input = \Config\Services::request();
	}
	//--------------------------------------------------------------------
	public function gateway_report(){
		$from = $this->input->getPost('from');
		$to = $this->input->getPost('to');
		$serial = $this->input->getPost('serial');
		$assignto = $this->input->getPost('assignto');
		$status = $this->input->getPost('status');
		$format = $this->input->getPost('format');
		//
		if(isLoggedIn() && access_crud('Gateway Report','view')){
			//
			$data['modelCustomer'] = new Model_Customer();
			$data['modelGeneral'] = new Model_General();
			$data['modelUsers'] = new Model_Users();
			$data['data'] = $data['modelGeneral']->get_gateway(null,$serial,$assignto,$status,$from,$to);
			//
			if($format == 'pdf'){
				return view('cpanel/reports/pdf/gateway_report_pdf',$data);
			}else if($format == 'csv'){
				return view('cpanel/reports/csv/gateway_report_excel',$data);
			}else{
				return view('cpanel/reports/excel/gateway_report_excel',$data);
			}
		}else {
			return redirect()->to(base_url('login'));
		}
	}
	//--------------------------------------------------------------------
	public function equipment_report(){
		$from = $this->input->getPost('from');
		$to = $this->input->getPost('to');
		$equip_id = $this->input->getPost('equipment');
		$user_id = $this->input->getPost('assignto');
		$format = $this->input->getPost('format');
		//
		if(isLoggedIn() && access_crud('Equipment Report','view')){
			//
			$data['modelCustomer'] = new Model_Customer();
			$data['modelGeneral'] = new Model_General();
			$data['modelUsers'] = new Model_Users();
			$data['data'] = $data['modelGeneral']->get_task_equip_count($from,$to,$user_id,null,$equip_id);
			//
			if($format == 'pdf'){
				return view('cpanel/reports/pdf/equipment_report_pdf',$data);
			}else if($format == 'excel'){
				return view('cpanel/reports/excel/equipment_report_excel',$data);
			}else{
				return view('cpanel/reports/csv/equipment_report_excel',$data);
			}
		}else {
			return redirect()->to(base_url('login'));
		}
	}
	//--------------------------------------------------------------------
	public function device_tools_report(){
		$device = $this->input->getPost('device');
		$assignto = $this->input->getPost('assignto');
		$serial = $this->input->getPost('serial');
		$status = $this->input->getPost('status');
		$format = $this->input->getPost('format');
		//
		if(isLoggedIn() && access_crud('Devices & Tools Report','view')){
			//
			$data['modelGeneral'] = new Model_General();
			$data['modelUsers'] = new Model_Users();
			$data['data'] = $data['modelGeneral']->get_devices_detail($device,$serial,$status,$assignto);
			//
			if($format == 'pdf'){
				return view('cpanel/reports/pdf/device_tools_report_pdf',$data);
			}else if($format == 'excel'){
				return view('cpanel/reports/excel/device_tools_report_excel',$data);
			}else{
				return view('cpanel/reports/csv/device_tools_report_excel',$data);
			}
		}else {
			return redirect()->to(base_url('login'));
		}
	}
	//--------------------------------------------------------------------
	public function task_report(){
		$from = $this->input->getPost('from');
		$to = $this->input->getPost('to');
		$un = $this->input->getPost('un');
		$user_id = $this->input->getPost('assignto');
		$status = $this->input->getPost('status');
		$format = $this->input->getPost('format');
		//
		if(isLoggedIn() && access_crud('Task Report','view')){
			//
			$data['modelTask'] = new Model_Task();
			$data['modelUsers'] = new Model_Users();
			$data['modelGeneral'] = new Model_General();
			// $data['data'] = $data['modelTask']->get_task_detail_report($user_id,$status,$un,$from,$to);
			$data['data'] = $data['modelTask']->get_task(null,$un,$user_id,$status,$from,$to);
			//
			if($format == 'pdf'){
				return view('cpanel/reports/pdf/task_report_pdf',$data);
			}else if($format == 'excel'){
				return view('cpanel/reports/excel/task_report_excel',$data);
			}else{
				return view('cpanel/reports/csv/task_report_excel',$data);
			}
		}else {
			return redirect()->to(base_url('login'));
		}
	}
	//-----------------------------------------------------------------
	public function users_report(){
		$from = $this->input->getPost('from');
		$to = $this->input->getPost('to');
		$id = $this->input->getPost('user');
		$status = $this->input->getPost('status');
		$format = $this->input->getPost('format');
		//
		if(isLoggedIn() && access_crud('Users Detail Report','view')){
			//
			$array = (empty($status)) ? null : array($status);
			//
			$data['modelUsers'] = new Model_Users();
			$data['data'] = $data['modelUsers']->get_users($id,null,null,$array,$from,$to);
			//
			if($format == 'pdf'){
				return view('cpanel/reports/pdf/users_report_pdf',$data);
			}else if($format == 'excel'){
				return view('cpanel/reports/excel/users_report_excel',$data);
			}else{
				return view('cpanel/reports/csv/users_report_excel',$data);
			}
		}else {
			return redirect()->to(base_url('login'));
		}
	}
	//--------------------------------------------------------------------
	public function sim_report(){
		$from = $this->input->getPost('from');
		$to = $this->input->getPost('to');
		$serial = $this->input->getPost('serial');
		$assignto = $this->input->getPost('assignto');
		$status = $this->input->getPost('status');
		$format = $this->input->getPost('format');
		//
		if(isLoggedIn() && access_crud('SIM Report','view')){
			//
			$data['modelCustomer'] = new Model_Customer();
			$data['modelGeneral'] = new Model_General();
			$data['modelUsers'] = new Model_Users();
			$data['data'] = $data['modelGeneral']->get_sim(null,$serial,$assignto,$status,$from,$to);
			//
			if($format == 'pdf'){
				return view('cpanel/reports/pdf/sim_report_pdf',$data);
			}else if($format == 'excel'){
				return view('cpanel/reports/excel/sim_report_excel',$data);
			}else{
				return view('cpanel/reports/csv/sim_report_excel',$data);
			}
		}else {
			return redirect()->to(base_url('login'));
		}
	}
	//--------------------------------------------------------------------
	public function profit_loss_report(){
		
		$start_date = $this->input->getPost('from');
		$end_date = $this->input->getPost('to');
		$user_id = $this->input->getPost('user_id');
		$format = $this->input->getPost('format');
		//
		if(empty($user_id)){
			$user_id = null;
		}
		//
		$data['modelTask'] = new Model_Task();
		//
		if(isLoggedIn() && access_crud('Profit & Loss Report','view')){
			//
			$current_date = strtotime($start_date);
			$i = 0;
			while ($current_date <= strtotime($end_date)) {
				// echo date('Y-m-d', $current_date) . "<br>";
				$date =  date('Y-m-d', $current_date);
				//
				$equipCost = $data['modelTask']->get_total_equip_cost($date,$user_id)->get()->getRow()->total_sum;
				$staffCost = $data['modelTask']->get_total_team_cost($date,$user_id)->get()->getRow()->total_sum;
				$gatewayRev = $data['modelTask']->get_total_gateway_revenue($date,$user_id)->get()->getRow()->total_sum;
				$commissionCount = $data['modelTask']->get_total_commission($date,$user_id)->countAllResults();
				$commissionRev = $commissionCount*18.62;
				//
				$totalRev = $gatewayRev + $commissionRev;
				$totalExp = $staffCost + $equipCost;
				//	
				// Staff cost + Equipment cost - (commissioning revenue + Gateway revenue)
				$profitLoss = $totalRev - $totalExp;
				//
				$profit = $loss = 0;
				if($profitLoss > 0){
					$profit = $profitLoss;
				}else{
					$loss = $profitLoss;
				}
				//
				$data['profit'][$i]['date'] = $date;
				$data['profit'][$i]['profit'] = $profit;
				$data['profit'][$i]['loss'] = $loss;
				//
				$current_date = strtotime('+1 day', $current_date);
				$i++;
			}
			//
			if($format == 'pdf'){
				return view('cpanel/reports/pdf/profit_loss_report_pdf',$data);
			}else if($format == 'excel'){
				return view('cpanel/reports/excel/profit_loss_report_excel',$data);
			}else{
				return view('cpanel/reports/csv/profit_loss_report_excel',$data);
			}
		}else {
			return redirect()->to(base_url('login'));
		}

	}

	//-----------------------------------------------------------------
	public function users_day_routine_report(){
		$from = $this->input->getPost('from');
		$to = $this->input->getPost('to');
		$user_id = $this->input->getPost('user_id');
		$status = $this->input->getPost('status');
		$format = $this->input->getPost('format');
		//
		if(isLoggedIn() && access_crud('Day Routine Report','view')){
			//
			$builder = $this->db->table('day_routine');
			if(!empty($user_id)){
				$builder->where('user_id',$user_id);
			}if(!empty($status)){
				$builder->where('status',$status);
			}if(!empty($from)){
				$builder->where('date >=',$from);
			}if(!empty($to)){
				$builder->where('date <=',$to);
			}
			$data['data'] = $builder;
			$data['modelUsers'] = new Model_Users();
			//
			if($format == 'pdf'){
				return view('cpanel/reports/pdf/day_routine_report_pdf',$data);
			}else if($format == 'excel'){
				return view('cpanel/reports/excel/day_routine_report_excel',$data);
			}else{
				return view('cpanel/reports/csv/day_routine_report_excel',$data);
			}
		}else {
			return redirect()->to(base_url('login'));
		}
	}
//

	
	public function map(){
		if(isLoggedIn()){
			$uri = new \CodeIgniter\HTTP\URI(current_url());
			$latitude = $uri->getSegment(3);
			$longitude = $uri->getSegment(4);
			echo $cord = $latitude.','.$longitude;
			echo '<iframe style="width: 100%;height: 500px;" src = "https://maps.google.com/maps?q='.$cord.'&hl=es;z=14&amp;output=embed"></iframe>';
		}else {
			return redirect()->to(base_url('login'));
		}

	}

}