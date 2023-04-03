<?php

namespace App\Controllers;
use App\Models\Model_Users;
use App\Models\Model_Elastix;
use App\Models\Model_Customer;

class Elastix extends BaseController
{
	public function __construct(){

		parent::__construct();
		$this->db = \Config\Database::connect();
		$this->input = \Config\Services::request();
	}
	public function index(){
		$modelElastix = new Model_Elastix();
		$data = $modelElastix->get_active_calls();
		d($data);
	}
	//
	public function get_active_call()
	{
		$html = null;
		$callerID = '03093330061';
		$callerData = 'SIP/141,15,tr';
		$callerData = explode(',',$callerData);
		$callerData = explode('/',$callerData[0]);
		$callerData = $callerData[1];

		$modelCustomer = new Model_Customer();
		$custInfo = $modelCustomer->get_customer(null,null,null,null,null,$callerID)->get()->getRow();
		$callName = (!empty($custInfo->firstname)) ? ($custInfo->firstname.' '.$custInfo->lastname) : 'UNKNOWN';

		$html .= ' <li>
		<div class="d-flex call-wrapper">
		<div class="caller-pic">
		<i class="fa fa-user"></i>
		</div>
		<div class="caller-detail">
		<p class="mb-0">'.$callName.'</p>
		<p class="mb-0">'.$callerID.'</p>
		<p class="mb-0">'.$callerData.'</p>
		<p class="mb-0">Calling...</p>
		</div>
		<div class="calling-icon">
		<i class="fa fa-phone"></i>
		</div>
		</div>
		</li>';
		
		return $html;
	}
	public function get_active_calls()
	{
		$html = null;
		$modelElastix = new Model_Elastix();
		$data = $modelElastix->get_active_calls();	
		$data = json_decode($data);
		$countArr = count($data);
		$activeCalls = $data[$countArr-2];
		if($countArr > 3){
			for($i=0;$i<($countArr-3);$i++){
				$callerID = $data[$i]->CallerID;
				//
				if((strlen($callerID) > 5 )){
					//
					$callerData = $data[$i]->Data;
					$callerData = explode(',',$callerData);
					$callerData = explode('/',$callerData[0]);
					$callerData = $callerData[1];
					//
					if(session()->get('extension') == $callerData){
						//
						$modelCustomer = new Model_Customer();
						$custInfo = $modelCustomer->get_customer(null,null,null,null,null,substr($callerID,-7))->get()->getRow();
						$callName = (!empty($custInfo->firstname)) ? ($custInfo->firstname.' '.$custInfo->lastname) : 'UNKNOWN';
						//
						$html .= ' <li>
						<div class="d-flex call-wrapper">
						<div class="caller-pic">
						<i class="fa fa-user"></i>
						</div>
						<div class="caller-detail">
						<p class="mb-0">'.$callName.'</p>
						<p class="mb-0">'.$callerID.'</p>
						<p class="mb-0">Calling...</p>
						</div>
						<div class="calling-icon">
						<i class="fa fa-phone"></i>
						</div>
						</div>
						</li>';
					}
				}
				// echo '<br>';
				// echo 'working';
			}
		}
		return $html;
	}
	//
	

}
