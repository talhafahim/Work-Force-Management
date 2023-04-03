<?php 
namespace App\Controllers;
use App\Models\Model_Customer;
use App\Models\Model_Taxation;
use App\Models\Model_Package;
use App\Models\Model_OTC;
use CodeIgniter\HTTP\Request;

class Billing extends BaseController
{
	public function __construct(){

		parent::__construct();
		$this->db = \Config\Database::connect();
		$this->input = \Config\Services::request();
	}
	//--------------------------------------------------------------------
	public function index() {
		return view('cpanel/billing');
	}
	//--------------------------------------------------------------------
	public function generate_bill($cust_id=null){
		$today = date('Y-m-d');
		$monthLastDay = date('Y-m-t');
		//
		$diff = strtotime($monthLastDay) - strtotime($today);
     	// 1 day = 24 hours
      	// 24 * 60 * 60 = 86400 seconds
		$bill_days = abs(round($diff / 86400)) + 1;
		//
		$modelCustomer = new Model_Customer();
		$activeCont = $modelCustomer->get_customer_contract(null,$cust_id,'Active');
		foreach($activeCont->get()->getResult() as $value){
			//
			$uniq = $value->cust_id.$value->id.date('Ym');
			//
			$modelCustomer->insert_bill($value->cust_id,$value->id,$today,date('Y-m'),$bill_days,$uniq);
		}
	}
	//
	public function invoice(){
		$uri = new \CodeIgniter\HTTP\URI(current_url());
		$bill_id = $uri->getSegment(3);
		$modelCustomer = new Model_Customer();
		$modelTaxation = new Model_Taxation();
		$modelpkg = new Model_Package();
		//
		$data['bill'] = $modelCustomer->get_customer_bill($bill_id)->get()->getRow();
		$data['cont'] = $modelCustomer->get_customer_contract($data['bill']->cont_id)->get()->getRow();
		$data['pkg'] = $modelpkg->get_package($data['cont']->pkg_id)->get()->getRow();
		$data['tax'] = $modelTaxation->get_taxation(null,$data['pkg']->city)->get()->getRow();
		//
		$data['intQty'] = $data['cont']->int_qty;
		$data['tvQty'] = $data['cont']->tv_qty;
		$data['phQty'] = $data['cont']->ph_qty;
		// 
		$data['total']['int'] = ($data['pkg']->int_rate + ($data['pkg']->int_rate * ($data['tax']->int_sst / 100)) + ($data['pkg']->int_rate * ($data['tax']->int_adv / 100))) * $data['intQty'];
		$data['total']['tv'] = ($data['pkg']->tv_rate + ($data['pkg']->tv_rate * ($data['tax']->tv_sst / 100)) + ($data['pkg']->tv_rate * ($data['tax']->tv_adv / 100))) * $data['tvQty'];
		$data['total']['ph'] = ($data['pkg']->phone_rate + ($data['pkg']->phone_rate * ($data['tax']->phone_sst / 100)) + ($data['pkg']->phone_rate * ($data['tax']->phone_adv / 100))) * $data['phQty'];
		//
		$contract_amount = $data['gtotal'] = $data['total']['int'] + $data['total']['tv'] + $data['total']['ph'];
		//
		$bill_amount = ($data['bill']->bill_days / cal_days_in_month(CAL_GREGORIAN,date('m',strtotime($data['bill']->bill_date)),date('Y',strtotime($data['bill']->bill_date)))) * $contract_amount;

		echo 'days = '.$data['bill']->bill_days;
		echo '<br>';
		echo 'Contract Amount = '.$contract_amount;
		echo '<br>';
		echo 'Bill Amount = '.$bill_amount;


	}
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function otc()
	{
		$uri = new \CodeIgniter\HTTP\URI(current_url());
		$data['custID'] = $uri->getSegment(3);
		$customerModel = new Model_Customer();
		$customerInfo = $customerModel->get_customer($data['custID']);
		//
		if(isLoggedIn() && access_crud('Customer Create','update') && $customerInfo->countAllResults() > 0){
			//
			$data['info'] = $customerModel->get_customer($data['custID'])->get()->getRow();
			//
			$modelOTC = new Model_OTC();
			$data['otc'] = $modelOTC->get_otc(null,$data['custID'])->get()->getRow();
			if(!empty($data['otc']->id)){
				$data['otc_detail'] = $modelOTC->get_otc_detail($data['otc']->id);
				$data['otc_bill'] = $modelOTC->get_otc_bill(null,$data['custID']);
			}
			//
			return view('cpanel/customer_OTC_Details',$data);
		}else{
			return redirect()->to(base_url('login'));
		}
	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function otc_save(){
		$error = null;
		$custID = $this->input->getPost('custID');
		$des = $this->input->getPost('des');
		$amount = $this->input->getPost('amount');
		$installAmt = $this->input->getPost('installAmt');
		//
		$validation =  \Config\Services::validation();
		$validate = $this->validate([

			'des*' => ['label' => 'Description', 'rules' => 'required|trim'],
			'amount*' => ['label' => 'Amount', 'rules' => 'required|trim|decimal|greater_than_equal_to[0]'],
			'installAmt' => ['label' => 'Installment Amountt', 'rules' => 'required|trim|decimal|greater_than_equal_to[0]'],
		]);

		if(!$validate){
			$error = $validation->listErrors();
		} if(($installAmt == 0) || ($installAmt > array_sum($amount))){
			$error = 'Error : Invalid Installment Amount';
		}

		if(empty($error)){
			$this->db->transStart();
			//
			$data1 = array('cust_id' => $custID, 'total_amount' => array_sum($amount), 'installment' => $installAmt , 'remaining_amount' => array_sum($amount));
			$this->db->table('bo_cust_otc')->insert($data1);
			$otcid = $this->db->insertID();
			//
			foreach($amount as $key => $amt){
				$data2 = array(
					'otc_id' => $otcid, 'description' => $des[$key], 'amount' => $amount[$key],
				);
				$this->db->table('bo_cust_otc_detail')->insert($data2);
			}
			create_action_log('cust id '.$custID); 
			//
			$this->db->transComplete();
			return $this->response->setStatusCode(200)->setBody('OTC Update Successfully');
		}else{
			return $this->response->setStatusCode(401,$error);
		}
	}
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function otc_generate_bill(){
		$error = null;
		$custID = $this->input->getPost('custID');
		//
		$validation =  \Config\Services::validation();
		$validate = $this->validate([

			'custID' => ['label' => 'Customer ID', 'rules' => 'required|trim'],
		]);
		if(!$validate){
			$error = $validation->listErrors();
		}
		$modelOTC = new Model_OTC();
		//
		if($modelOTC->get_otc(null,$custID)->countAllResults() <= 0){
			$error = 'Error : No OTC Detail Available';
		}else if($modelOTC->get_otc(null,$custID)->get()->getRow()->remaining_amount <= 0){
			$error = 'Zero Amount Remaining';
		}
		//
		if(empty($error)){
			$otc_bill = $modelOTC->get_otc_bill(null,$custID,'unpaid');
			if($otc_bill->countAllResults() > 0){
				$error = 'Error : Please pay previous bill amount first';
			}
		}
		//
		if(empty($error)){
			$this->db->transStart();
			$otcData = $modelOTC->get_otc(null,$custID)->get()->getRow();
			//
			$amount = ($otcData->remaining_amount > $otcData->installment) ? $otcData->installment : $otcData->remaining_amount;
			//
			$data = array( 'otc_id' => $otcData->id, 'cust_id' => $otcData->cust_id, 'amount' => $amount );
			$this->db->table('bo_cust_otc_bill')->insert($data);
			//
			create_action_log('cust id '.$otcData->id); 
			//
			$this->db->transComplete();
			return $this->response->setStatusCode(200)->setBody('Bill Generated Successfully');
		}else{
			return $this->response->setStatusCode(401,$error);
		}


	}



}
