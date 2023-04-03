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



}