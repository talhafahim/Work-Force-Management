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
			}else{
				return view('cpanel/reports/excel/gateway_report_excel',$data);
			}
		}else {
			return redirect()->to(base_url('login'));
		}
	}
	//--------------------------------------------------------------------
	public function equipment_report(){
		$equipment = $this->input->getPost('equipment');
		$assignto = $this->input->getPost('assignto');
		$format = $this->input->getPost('format');
		//
		if(isLoggedIn() && access_crud('Equipment Report','view')){
			//
			$data['modelCustomer'] = new Model_Customer();
			$data['modelGeneral'] = new Model_General();
			$data['modelUsers'] = new Model_Users();
			$data['data'] = $data['modelGeneral']->get_users_misc_equipment($equipment,$assignto);
			//
			if($format == 'pdf'){
				return view('cpanel/reports/pdf/equipment_report_pdf',$data);
			}else{
				return view('cpanel/reports/excel/equipment_report_excel',$data);
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
		$format = $this->input->getPost('format');
		//
		if(isLoggedIn() && access_crud('Devices & Tools Report','view')){
			//
			$data['modelGeneral'] = new Model_General();
			$data['modelUsers'] = new Model_Users();
			$data['data'] = $data['modelGeneral']->get_users_devices_n_tools($assignto,$device,$serial);
			//
			if($format == 'pdf'){
				return view('cpanel/reports/pdf/device_tools_report_pdf',$data);
			}else{
				return view('cpanel/reports/excel/device_tools_report_excel',$data);
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
		$assignto = $this->input->getPost('assignto');
		$status = $this->input->getPost('status');
		$format = $this->input->getPost('format');
		//
		if(isLoggedIn() && access_crud('Task Report','view')){
			//
			$data['modelCustomer'] = new Model_Customer();
			$data['modelUsers'] = new Model_Users();
			$data['data'] = $data['modelCustomer']->get_customer_info(null,$un,$assignto,$status,$from,$to);
			//
			if($format == 'pdf'){
				return view('cpanel/reports/pdf/task_report_pdf',$data);
			}else{
				return view('cpanel/reports/excel/task_report_excel',$data);
			}
		}else {
			return redirect()->to(base_url('login'));
		}
	}


}