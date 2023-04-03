<?php 
namespace App\Controllers;
use App\Models\Model_Project;
use CodeIgniter\HTTP\Request;
use App\Models\Model_Field;
use App\Models\Model_Customer;

class Field extends BaseController
{
	public function __construct(){

		parent::__construct();
		$this->db = \Config\Database::connect();
		$this->input = \Config\Services::request();
	}
	//--------------------------------------------------------------------
	public function ndt()
	{
		if(access_crud('ndt','view')){
			$data['modelProject'] = new Model_Project();
			$data['modelField'] = new Model_Field();
			$data['project'] = $data['modelProject']->get_project();
			$data['ndt'] = $data['modelField']->get_ndt();
			return view('cpanel/ndt',$data);
		}else{
			return redirect()->to(base_url('login'));
		}
	}
	//------------------------------------------------------------------
	public function add_ndt(){
		$error = null;
		if(access_crud('ndt','create')){
			$project = $this->input->getPost('project');
			$coreColor = $this->input->getPost('coreColor');
			$distance = $this->input->getPost('distance');
			$power = $this->input->getPost('power');
			$splitter = $this->input->getPost('splitter');
			$splittertag = $this->input->getPost('splittertag');

			$validation =  \Config\Services::validation();
			$validate = $this->validate([
				'project' => ['label' => 'Project', 'rules' => 'required|trim'],
				'coreColor' => ['label' => 'Core Color', 'rules' => 'required|trim'],
				'distance' => ['label' => 'Distance', 'rules' => 'required|decimal|greater_than_equal_to[0]'],
				'power' => ['label' => 'Power', 'rules' => 'required|trim'],
				'splitter' => ['label' => 'Splitter', 'rules' => 'required|trim'],
				'splittertag' => ['label' => 'Splitter Tag', 'rules' => 'required|trim'],
			]);
			if(!$validate){
				$error = $validation->listErrors();
				$error = str_replace(array("\n", "\r"), '', $error);
				$error =  nl2br($error);
			}
			$modelField = new Model_Field();
			$checkAvail1 = $modelField->get_ndt(null,$project,$coreColor)->countAllResults();
			if($checkAvail1 > 0){
				$error = 'Error : Project already exist with same core color';
			}
			$checkAvail2 = $modelField->get_ndt(null,$project,null,$splitter)->countAllResults();
			if($checkAvail2 > 0){
				$error = 'Error : Project already exist with same splitter';
			}
			//
			if(empty($error)){
				$this->db->transStart();
				$data = array(
					'project_id' => $project, 'core_color' => $coreColor, 'distance' => $distance, 'power' => $power, 'splitter' => $splitter, 'splitter_tag' => $splittertag
				);
				$this->db->table('bo_ndt')->insert($data);
				$ndtid = $this->db->insertID(); 
				create_action_log($ndtid); 
				$this->db->transComplete();
				return 'Success : NDT Added Successfully';
			}else{
				return $error;
			}
		}else{
			return $error;
		}
	}
	//-----------------------------------------------------------------------------
	public function delete(){
		$ser = $this->input->getPost('ser');
		$des = $this->input->getPost('des');
		if(access_crud($des,'delete')){
			$this->db->transStart();
			$this->db->table('bo_'.$des)->where('id',$ser)->delete();
			create_action_log($des.' id#'.$ser); 
			$this->db->transComplete();
			return $this->response->setStatusCode(200)->setBody('Deleted Successfully');
		}else{
			return $this->response->setStatusCode(401,'Access Denied');
		}

	}
	//-------------------------------------------------------------------------------
	public function adt()
	{
		if(access_crud('ndt','view')){
			$data['modelProject'] = new Model_Project();
			$data['modelField'] = new Model_Field();
			$data['project'] = $data['modelProject']->get_project();
			$data['adt'] = $data['modelField']->get_adt();
			return view('cpanel/adt',$data);
		}else{
			return redirect()->to(base_url('login'));
		}
	}
	//--------------------------------------------------------------------
	//----------------------------------------------------------------------------------
	public function get_splitter(){
		$project = $this->input->getPost('project');
		$modelField = new Model_Field();
		$splitters = $modelField->get_ndt(null,$project)->get()->getResult();
		return json_encode($splitters);
	}
	//--------------------------------------------------------------------
	public function add_adt(){
		$error = null;
		if(access_crud('adt','create')){
			$project = $this->input->getPost('project');
			$customer = $this->input->getPost('customer');
			$distance = $this->input->getPost('distance');
			$splitter = $this->input->getPost('splitter');
			$splittertag = $this->input->getPost('splittertag');
			$power = $this->input->getPost('power');

			$validation =  \Config\Services::validation();
			$validate = $this->validate([
				'project' => ['label' => 'Project', 'rules' => 'required|trim'],
				'customer' => ['label' => 'Customer', 'rules' => 'required|trim'],
				'distance' => ['label' => 'Customer Distance', 'rules' => 'required|trim'],
				'splitter' => ['label' => 'Splitter', 'rules' => 'required|trim'],
				'splittertag' => ['label' => 'Splitter Tag', 'rules' => 'required|trim'],
				'power' => ['label' => 'Customer Power', 'rules' => 'required|trim'],
			]);
			if(!$validate){
				$error = $validation->listErrors();
				$error = str_replace(array("\n", "\r"), '', $error);
				$error =  nl2br($error);
			}
			$modelCustomer= new Model_Customer();
			$validCustomer = $modelCustomer->get_customer(null,$customer)->countAllResults();
			if($validCustomer <= 0){
				$error = 'Error : Invalid customer username';
			}
			$modelField = new Model_Field();
			$custAlreadyInAdt = $modelField->get_adt(null,$customer)->countAllResults();
			if($custAlreadyInAdt > 0){
				$error = 'Error : Customer already in list';
			}
			//
			if(empty($error)){
				$this->db->transStart();
				$data = array('project_id' => $project, 'splitter' => $splitter, 'splitter_tag' => $splittertag, 'distance' => $distance, 'customer' => $customer, 'power' => $power);
				$this->db->table('bo_adt')->insert($data);
				$adtid = $this->db->insertID(); 
				create_action_log($adtid); 
				$this->db->transComplete();
				return $this->response->setStatusCode(200)->setBody('ADT Added Successfully');
			}else{
				return $this->response->setStatusCode(401,$error);
			}
		}else{
			return $this->response->setStatusCode(401,'Access Denied');
		}
	}
	
}
