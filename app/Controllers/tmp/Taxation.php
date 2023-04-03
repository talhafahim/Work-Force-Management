<?php 
namespace App\Controllers;
use App\Models\Model_Setting;
use CodeIgniter\HTTP\Request;
use App\Models\Model_Tools;
use App\Models\Model_Taxation;


class Taxation extends BaseController
{
	public function __construct(){

		parent::__construct();
		$this->db = \Config\Database::connect();
		$this->input = \Config\Services::request();
	}
	//--------------------------------------------------------------------
	public function index()
	{
		if(access_crud('taxation','view')){
			return view('cpanel/taxation_List');
		}else{
			return redirect()->to(base_url('login'));
		}
	}
	//--------------------------------------------------------------------
	public function view()
	{
		$txtID = $this->input->getPost('txtID');
		$modelTaxation = new Model_Taxation();
		$data['info'] = $modelTaxation->get_taxation($txtID)->get()->getRow();
		//dd($data);
		return json_encode($data);
	}
	//--------------------------------------------------------------------
	public function show_list()
	{
		$modelTaxation = new Model_Taxation();
		$data['taxation_list'] = $modelTaxation->get_taxation();
		//
		foreach($data['taxation_list']->get()->getResult() as $key => $value){
			?>
			<tr>
				<td><?= $key+1;?></td>
				<td><?= $value->city;?></td>
				<td><?= $value->int_sst;?> %</td>
				<td><?= $value->int_adv;?> %</td>
				<td><?= $value->tv_sst;?> %</td>
				<td><?= $value->tv_adv;?> %</td>
				<td><?= $value->phone_sst;?> %</td>
				<td><?= $value->phone_adv;?> %</td>
				<td>
					<a href="<?= base_url();?>/taxation/update/<?= $value->serial;?>" class="mr-3 text-primary" title="edit"><i class="fa fa-edit"></i></a>

					<a href="javascript:void(0);" class="text-success infoBtn" data-userid="<?= $value->serial;?>" title="quick view"><i class="fa fa-info"></i></a>
					&nbsp;&nbsp;&nbsp;
					<a href="javascript:void(0);" class="text-danger delBtn" data-userid="<?= $value->serial;?>" title="delete"><i class="fa fa-trash-alt"></i></a>

				</td>
			</tr>
			<?php
		}
	}

	//--------------------------------------------------------------------
	public function create()
	{
		
		if(access_crud('taxation','create')){
			$tools = new Model_Tools();
			$data['cities'] = $tools->get_cities();
			return view('cpanel/taxation_Create', $data);
		}else{
			return redirect()->to(base_url('login'));
		}
	}
	////--------------------------------------------------------------------

	public function create_txt()
	{
		$error = null;
		$city = $this->input->getPost('city');
		//
		$intSST = $this->input->getPost('int-sst');
		$intADV = $this->input->getPost('int-adv');
		//
		$tvSST = $this->input->getPost('tv-sst');
		$tvADV = $this->input->getPost('tv-adv');
		//
		$phSST = $this->input->getPost('ph-sst');
		$phADV = $this->input->getPost('ph-adv');
		//
		$validation =  \Config\Services::validation();
		$validate = $this->validate([

			'int-sst' => ['label' => 'Internet SS Tax', 'rules' => 'required|trim|decimal|greater_than_equal_to[0]'],
			'int-adv' => ['label' => 'Internet ADV Tax', 'rules' => 'required|trim|decimal|greater_than_equal_to[0]'],

			'tv-sst' => ['label' => 'TV SS Tax', 'rules' => 'required|trim|decimal|greater_than_equal_to[0]'],
			'tv-adv' => ['label' => 'TV ADV Tax', 'rules' => 'required|trim|decimal|greater_than_equal_to[0]'],

			'ph-sst' => ['label' => 'Phone SS Tax', 'rules' => 'required|trim|decimal|greater_than_equal_to[0]'],
			'ph-adv' => ['label' => 'Phone ADV Tax', 'rules' => 'required|trim|decimal|greater_than_equal_to[0]'],
		]);

		if(!$validate){
			$error = $validation->listErrors();
		}
		//
		$txt = new Model_Taxation();
		if($txt->get_taxation2($city)->countAllResults() > 0){
			$error = 'Error : City already exist';
		}
		//
		if(!access_crud('taxation','create')){
			$error = 'Error : You don`t have rights';
		}
		//
		if(empty($error)){
			$this->db->transStart();
			
			$data = array(

				'int_sst' => $intSST, 'int_adv' => $intADV, 
				'tv_sst' => $tvSST, 'tv_adv' => $tvADV, 
				'phone_sst' => $phSST, 'phone_adv' => $phADV, 
				'city' => $city
			);
			$this->db->table('bo_taxation')->insert($data);
			$txtID = $this->db->insertID();
			create_action_log('txt id '.$txtID); 
			echo 'Success : Taxation Created Successfuly';
			//
			$this->db->transComplete();
		}else{
			echo $error;
		}
	}
	public function update(){
		$uri = new \CodeIgniter\HTTP\URI(current_url());
		$txtID = $uri->getSegment(3);
		$taxationModel = new Model_Taxation();
		$taxationInfo = $taxationModel->get_taxation($txtID);
		//
		if(access_crud('taxation','update') && $taxationInfo->countAllResults() > 0){
			$data['info'] = $taxationModel->get_taxation($txtID)->get()->getRow();
			$tools = new Model_Tools();
			$data['cities'] = $tools->get_cities();
			return view('cpanel/taxationUpdate', $data);
		}else{
			return redirect()->to(base_url('taxation'));
		}
	}

	public function update_action(){

		if(isLoggedIn() && access_crud('taxation','update')){
			//
			$error = null;
			$txtID = $this->input->getPost('txtID');

		//
			$intSST = $this->input->getPost('int-sst');
			$intADV = $this->input->getPost('int-adv');
		//
			$tvSST = $this->input->getPost('tv-sst');
			$tvADV = $this->input->getPost('tv-adv');
		//
			$phSST = $this->input->getPost('ph-sst');
			$phADV = $this->input->getPost('ph-adv');

			//
			$validation =  \Config\Services::validation();
			$validate = $this->validate([
				'int-sst' => ['label' => 'Internet SS Tax', 'rules' => 'required|trim|decimal|greater_than_equal_to[0]'],
				'int-adv' => ['label' => 'Internet ADV Tax', 'rules' => 'required|trim|decimal|greater_than_equal_to[0]'],

				'tv-sst' => ['label' => 'TV SS Tax', 'rules' => 'required|trim|decimal|greater_than_equal_to[0]'],
				'tv-adv' => ['label' => 'TV ADV Tax', 'rules' => 'required|trim|decimal|greater_than_equal_to[0]'],

				'ph-sst' => ['label' => 'Phone SS Tax', 'rules' => 'required|trim|decimal|greater_than_equal_to[0]'],
				'ph-adv' => ['label' => 'Phone ADV Tax', 'rules' => 'required|trim|decimal|greater_than_equal_to[0]'],
			]);
			if(!$validate){
				$error = $validation->listErrors();
			}

			//
			if(empty($error)){
				$this->db->transStart();
				//
				$data = array(

					'int_sst' => $intSST, 'int_adv' => $intADV, 
					'tv_sst' => $tvSST, 'tv_adv' => $tvADV, 
					'phone_sst' => $phSST, 'phone_adv' => $phADV, 
				);

				$this->db->table('bo_taxation')->where('serial',$txtID)->update($data);
				//
				create_action_log('txt id '.$txtID); 
				echo 'Success : Taxation Updated Successfuly';
				//
				$this->db->transComplete();
				//
				create_action_log('txt id '.$txtID); 
			}else{
				echo $error;
			}
		}else{
			echo 'Error : Some thing went wrong';
		}

	}
	//
	public function delete(){
		$error = null;
		$request = \Config\Services::request();
		$id = $request->getPost('id');
		//
		if(!access_crud('taxation','update')){
			$error = 'Error : You don`t have rights';
		}

		if(empty($error)){
			//
			$this->db->transStart();
			//
			$this->db->table('bo_taxation')->where('serial',$id)->delete();
			//
			$this->db->transComplete();
			//
			// create_action_log('serial '.$id);
			return $this->response->setStatusCode(200)->setBody('Deleted Successfuly');
		}else{
			return $this->response->setStatusCode(401,$error);
		}

	}
}
