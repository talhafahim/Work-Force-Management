<?php 
namespace App\Controllers;
use App\Models\Model_Project;
use CodeIgniter\HTTP\Request;
use App\Models\Model_Network;

class Network extends BaseController
{
	public function __construct(){

		parent::__construct();
		$this->db = \Config\Database::connect();
		$this->input = \Config\Services::request();
	}
	//--------------------------------------------------------------------
	public function olt()
	{
		if(access_crud('olt','view')){
			$modelNetwork = new Model_Network();
			$data['olt'] = $modelNetwork->get_olt();
			$data['pop'] = $modelNetwork->get_pop();
			return view('cpanel/olt',$data);
		}else{
			return redirect()->to(base_url('login'));
		}
	}
	//------------------------------------------------------------------
	public function add_olt(){
		$error = null;
		if(access_crud('olt','create')){
			$name = $this->input->getPost('name');
			$version = $this->input->getPost('version');
			$ip = $this->input->getPost('ip');
			$model = $this->input->getPost('model');
			$port = $this->input->getPost('port');
			$pop = $this->input->getPost('pop');
			$connectedto = $this->input->getPost('connectedto');

			$validation =  \Config\Services::validation();
			$validate = $this->validate([
				'name' => ['label' => 'OLT Name', 'rules' => 'required|trim'],
				'version' => ['label' => 'Version', 'rules' => 'required|trim'],
				'ip' => ['label' => 'Ip', 'rules' => 'required|trim'],
				'model' => ['label' => 'Model', 'rules' => 'required|trim'],
				'port' => ['label' => 'Port', 'rules' => 'required|trim'],
				'pop' => ['label' => 'Pop', 'rules' => 'required|trim'],
				'connectedto' => ['label' => 'Connected To', 'rules' => 'required|trim'],
			]);
			if(!$validate){
				$error = $validation->listErrors();
				$error = str_replace(array("\n", "\r"), '', $error);
				$error =  nl2br($error);
			}
			$modelNetwork = new Model_Network();
			$oltalready = $modelNetwork->get_olt(null,$name)->countAllResults();
			if($oltalready > 0){
				$error = 'Error : OLT Name already exist';
			}
			//
			if(empty($error)){
				$this->db->transStart();
				$data = array('name' => $name, 'version' => $version, 'ip' => $ip, 'model' => $model, 'port' => $port, 'pop' => $pop, 'connected_to' => $connectedto);
				$this->db->table('bo_olt')->insert($data);
				create_action_log($name); 
				$this->db->transComplete();
				return $this->response->setStatusCode(200)->setBody('OLT Added Successfully');
			}else{
				return $this->response->setStatusCode(401,$error);
			}
		}else{
			return $this->response->setStatusCode(401,'Access Denied');
		}
	}
	//-----------------------------------------------------------------------------
	public function delete(){
		$ser = $this->input->getPost('ser');
		$des = $this->input->getPost('des');
		if(access_crud($des,'delete')){
			$this->db->transStart();
			$this->db->table('bo_'.$des)->where('id',$ser)->delete();
			create_action_log($des.' ser#'.$ser); 
			$this->db->transComplete();
			return $this->response->setStatusCode(200)->setBody('Deleted Successfully');
		}else{
			return $this->response->setStatusCode(401,'Access Denied');
		}

	}
	//
	
}
