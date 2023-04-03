<?php 
namespace App\Controllers;
use App\Models\Model_Setting;
use CodeIgniter\HTTP\Request;

class Settings extends BaseController
{
	public function __construct(){

		parent::__construct();
		$this->db = \Config\Database::connect();
		$this->input = \Config\Services::request();
	}
	//--------------------------------------------------------------------
	public function index()
	{
		if(session()->get('status') == 'admin'){
			$modelSetting = new Model_Setting();
			$data['loginOTP'] = $modelSetting->setting('Login OTP')->get()->getRow();
			$data['mMode'] = $modelSetting->setting('Maintenance Mode')->get()->getRow();
			$data['appTitle'] = $modelSetting->setting('App Title')->get()->getRow();
			$data['footerText'] = $modelSetting->setting('Footer Text')->get()->getRow();
			return view('cpanel/settings',$data);
		}else{
			return redirect()->to(base_url('403'));
		}
	}
	//--------------------------------------------------------------------
	public function page_403()
	{
		return view('errors/html/error_403');
	}
	//--------------------------------------------------------------------
	public function page_503()
	{
		///// Cheching Maintanance Mode
		$modelSetting = new Model_Setting();
		$checkOTP = $modelSetting->setting('Maintenance Mode')->get()->getRow();

		$myIP = $this->request->getIPAddress();

		if ($checkOTP->value == 'enable' && (strpos($checkOTP->parameter, $myIP) === false )  ) {
			return view('errors/html/error_503');
		}else{
			return redirect()->to(base_url('login'));
		}

	}
	////--------------------------------------------------------------------
	public function update(){
		$loginOTP = $this->input->getPost('loginOTP');
		$mMode = $this->input->getPost('mMode');
		$mModeIPs = $this->input->getPost('mModeIPs');
		$appTitle = $this->input->getPost('appTitle');
		$footerText = $this->input->getPost('footerText');
		$appLogo = $this->input->getFile('appLogo');
		$backImage = $this->input->getFile('backImage');
		$smLogo = $this->input->getFile('smLogo');
		//
		$error = null;
		if(!isLoggedIn()){
			$errors = 'Error : Please Login';
		}
		//
		if(empty($error)){
			$modelSetting = new Model_Setting();
			$modelSetting->settingUpdate('Login OTP',$loginOTP);
			$modelSetting->settingUpdate('Maintenance Mode',$mMode,$mModeIPs);
			$modelSetting->settingUpdate('App Title',null,$appTitle);
			$modelSetting->settingUpdate('Footer Text',null,$footerText);
			//
			if(!empty($_FILES['appLogo']['name'])){
				unlink('./assets/images/logo.png');// delete old if exist
				$appLogo->move('./assets/images','logo.png');
			}
			//
			if(!empty($_FILES['backImage']['name'])){
				unlink('./assets/images/bank/loginBackground.jpg');// delete old if exist
				$backImage->move('./assets/images/bank','loginBackground.jpg');
			}
			//
			if(!empty($_FILES['smLogo']['name'])){
				unlink('./assets/images/logo-sm.png');// delete old if exist
				$smLogo->move('./assets/images','logo-sm.png');
			}
			//
			return $this->response->setStatusCode(200)->setBody('Changes Update Successfully');
		}else{
			return $this->response->setStatusCode(401,$error);
		}
	}
	//---------------------------------------------------------------------------------------------
	public function search(){
		$error = null;
		$html = null;
		if(!isLoggedIn()){
			$error = 'Oops!';
		}
		if(empty($error)){
			$text = $this->input->getPost('text');
			// $text = 'kashif';
			$modelSetting = new Model_Setting();
			$data = $modelSetting->general_search($text);
// d($data);
			// if($data->countAllResults() > 0){
			foreach($data->get()->getResult() as $value){
				$html .= '<a href="'.base_url('/customer/update').'/'.$value->id.'" class="dropdown-item notify-item active">
				<div class="notify-icon"><i class="fa fa-search"></i></div>
				<p class="notify-details">'.$value->username.'<span class="text-muted">'.$value->firstname.' '.$value->lastname.'</span></p>
				</a> ';
			}
			//
			return $html;
		}else{
			$html = '<a href="javascript:void(0);" class="dropdown-item notify-item active">
			<center>No record found</center>
			</a> ';
			return $html;
		}
		
	}
}
