<?php 
namespace App\Controllers;
use App\Models\Model_Project;
use CodeIgniter\HTTP\Request;
use App\Models\Model_Network;

class Project extends BaseController
{
	public function __construct(){

		parent::__construct();
		$this->db = \Config\Database::connect();
		$this->input = \Config\Services::request();
	}
	//--------------------------------------------------------------------
	public function city()
	{
		if(access_crud('city','view')){
			$modelProject = new Model_Project();
			$data['city'] = $modelProject->get_city();
			return view('cpanel/city',$data);
		}else{
			return redirect()->to(base_url('login'));
		}
	}
	//------------------------------------------------------------------
	public function add_city(){
		$error = null;
		if(access_crud('city','create')){
			$city = $this->input->getPost('city');
			$validation =  \Config\Services::validation();
			$validate = $this->validate([
				'city' => ['label' => 'City Name', 'rules' => 'required|trim'],
			]);
			if(!$validate){
				$error = $validation->listErrors();
			}
			$modelProject = new Model_Project();
			$cityalready = $modelProject->get_city(null,$city)->countAllResults();
			if($cityalready > 0){
				$error = 'Error : City already exist';
			}
			//
			if(empty($error)){
				$this->db->transStart();
				$this->db->table('bo_city')->insert(['city' => $city]);
				create_action_log($city); 
				$this->db->transComplete();
				return $this->response->setStatusCode(200)->setBody('City Added Successfully');
			}else{
				return $this->response->setStatusCode(401,$error);
			}
		}else{
			return $this->response->setStatusCode(401,'Access Denied');
		}
	}
	//--------------------------------------------------------------------
	public function area()
	{
		if(access_crud('area','view')){
			$modelProject = new Model_Project();
			$data['city'] = $modelProject->get_city();
			$data['area'] = $modelProject->get_area();
			return view('cpanel/area',$data);
		}else{
			return redirect()->to(base_url('login'));
		}
	}
	//------------------------------------------------------------------
	public function add_area(){
		$error = null;
		if(access_crud('area','create')){
			$area = $this->input->getPost('area');
			$city = $this->input->getPost('city');
			$validation =  \Config\Services::validation();
			$validate = $this->validate([
				'city' => ['label' => 'City', 'rules' => 'required|trim'],
				'area' => ['label' => 'Area', 'rules' => 'required|trim'],
			]);
			if(!$validate){
				$error = $validation->listErrors();
			}
			$modelProject = new Model_Project();
			$cityalready = $modelProject->get_area($area,$city)->countAllResults();
			if($cityalready > 0){
				$error = 'Error : Area already exist';
			}
			//
			if(empty($error)){
				$this->db->transStart();
				$this->db->table('bo_area')->insert(['city' => $city,'area' => $area]);
				create_action_log($area); 
				$this->db->transComplete();
				return $this->response->setStatusCode(200)->setBody('Area Added Successfully');
			}else{
				return $this->response->setStatusCode(401,$error);
			}
		}else{
			return $this->response->setStatusCode(401,'Access Denied');
		}
	}
	//--------------------------------------------------------------------
	public function project()
	{
		if(access_crud('project','view')){
			$modelProject = new Model_Project();
			$data['modelNetwork'] = new Model_Network();
			$data['olt'] = $data['modelNetwork']->get_olt();
			$data['city'] = $modelProject->get_city();
			$data['area'] = $modelProject->get_area();
			$data['project'] = $modelProject->get_project();
			return view('cpanel/project',$data);
		}else{
			return redirect()->to(base_url('login'));
		}
	}
	//
	public function get_area(){
		$city = $this->input->getPost('city');
		$modelProject = new Model_Project();
		$area = $modelProject->get_area(null,$city)->get()->getResult();
		return json_encode($area);
	}
	//
	//------------------------------------------------------------------
	public function add_project(){
		$error = null;
		if(access_crud('project','create')){
			$area = $this->input->getPost('area');
			$city = $this->input->getPost('city');
			$project = $this->input->getPost('project');
			//
			$olt = $this->input->getPost('olt');
			$oltPort = $this->input->getPost('oltPort');
			$coordinate = $this->input->getPost('coordinate');
			if(empty($olt)){
				$olt = NULL; $oltPort = NULL;
			}
			//
			$validation =  \Config\Services::validation();
			$validate = $this->validate([
				'city' => ['label' => 'City', 'rules' => 'required|trim'],
				'area' => ['label' => 'Area', 'rules' => 'required|trim'],
				'project' => ['label' => 'Project', 'rules' => 'required|trim'],
				'olt' => ['label' => 'OLT', 'rules' => 'trim'],
				'oltPort' => ['label' => 'OLT Port', 'rules' => 'trim'],
				'coordinate' => ['label' => 'Coordinate', 'rules' => 'trim'],
			]);
			if(!$validate){
				$error = $validation->listErrors();
			}
			$modelProject = new Model_Project();
			$projectalready = $modelProject->get_project(null,$city,$area,$project)->countAllResults();
			if($projectalready > 0){
				$error = 'Error : Project already exist';
			}
			//
			if(empty($error)){
				$this->db->transStart();
				$this->db->table('bo_project')->insert(['city' => $city,'area' => $area,'project' => $project,  'olt_id' => $olt, 'olt_port' => $oltPort, 'coordinates' => $coordinate]);
				create_action_log($project); 
				$this->db->transComplete();
				return $this->response->setStatusCode(200)->setBody('Project Added Successfully');
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
			// $this->db->transStart();
			$query = $this->db->table('bo_'.$des)->where('id',$ser)->delete();
			if(empty($query)){
				return $this->response->setStatusCode(401,'You can not delete this.');
			}else{
				create_action_log($des.' ser#'.$ser); 
				return $this->response->setStatusCode(200)->setBody('Deleted Successfully');
			}
			// $this->db->transComplete();
		}else{
			return $this->response->setStatusCode(401,'Access Denied');
		}

	}
	
}
