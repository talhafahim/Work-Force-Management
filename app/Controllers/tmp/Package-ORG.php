<?php
namespace App\Controllers;
use App\Models\Model_Tools;
use App\Models\Model_Package;
use App\Models\Model_Taxation;
//
class Package extends BaseController
{
	public function __construct(){

		parent::__construct();
		$this->db = \Config\Database::connect();
		$this->input = \Config\Services::request();
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function index()
	{
		if(access_crud('package','view')){
			return view('cpanel/packageList');
		}else{
			return redirect()->to(base_url('login'));
		}
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function show_list(){
		$pkg = new Model_Package();
		$query = $pkg->get_package();
		foreach($query->get()->getResult() as $key => $value){
			?>
			<tr>
				<td><?= $key+1;?></td>
				<td><?= $value->city;?></td>
				<td><?= $value->name;?></td>
				<td><?= $value->bandwidth;?> Mbps</td>
				<td><?= $value->int_rate;?></td>
				<td><?= $value->tv_rate;?></td>
				<td><?= $value->phone_rate;?></td>
				<td><span class="badge badge-soft-<?= (($value->status == 'enable') ? 'success' : 'danger'); ?>"><?= $value->status;?></span></td>
				<td>
					<a href="<?= base_url();?>/package/update/<?= $value->id;?>" class="mr-3 text-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" data-userid="<?php echo $value->id;?>"><i class="fa fa-edit"></i></a>
					<a href="javascript:void(0);" class="text-success infoBtn" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" data-userid="<?= $value->id;?>"><i class="fa fa-info"></i></a>
				</td>
			</tr>
			<?php
		}
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function create()
	{
		if(access_crud('package','create')){
			$modelTaxation = new Model_Taxation();
			$data['cities'] = $modelTaxation->get_taxation();
			return view('cpanel/packageCreate',$data);
		}else{
			return redirect()->to(base_url('login'));
		}
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function create_pkg()
	{
		$error = null;
		$pkgname = $this->input->getPost('pkgname');
		$bandwidth = $this->input->getPost('bandwidth');
		$groupname = $this->input->getPost('groupname');
		$city = $this->input->getPost('city');
		//
		$intRate = $this->input->getPost('int-rate');
		//
		$tvRate = $this->input->getPost('tv-rate');
		//
		$phRate = $this->input->getPost('ph-rate');
		//
		$validation =  \Config\Services::validation();
		$validate = $this->validate([
			'pkgname' => ['label' => 'Package Name', 'rules' => 'required|trim'],
			'bandwidth' => ['label' => 'Bandwidth', 'rules' => 'required|trim|integer'],
			'groupname' => ['label' => 'Package Groupname', 'rules' => 'required|trim'],

			'int-rate' => ['label' => 'Internet Rate', 'rules' => 'required|trim|decimal|greater_than_equal_to[0]'],
			'tv-rate' => ['label' => 'TV Rate', 'rules' => 'required|trim|decimal|greater_than_equal_to[0]'],
			'ph-rate' => ['label' => 'Phone Rate', 'rules' => 'required|trim|decimal|greater_than_equal_to[0]'],
		]);
		if(!access_crud('package','create')){
			$error = 'Sorry you don`t have access';
		}
		//
		if(!$validate){
			$error = $validation->listErrors();
		}
		//
		$pkg = new Model_Package();
		if($pkg->get_package(null,$pkgname,null,$city)->countAllResults() > 0){
			$error = 'Error : Package Name already Exist';
		}else if($pkg->get_package(null,null,$bandwidth,$city)->countAllResults() > 0){
			$error = 'Error : Bandwidth already Exist';
		}
		//
		if(empty($error)){
			$this->db->transStart();
			//
			$data = array(
				'name' => $pkgname, 
				'bandwidth' => $bandwidth,
				'int_rate' => $intRate, 
				'tv_rate' => $tvRate,
				'phone_rate' => $phRate,
				'city' => $city,
				'groupname' => $groupname
			);
			$this->db->table('bo_package')->insert($data);
			$pkgID = $this->db->insertID();
			create_action_log('pkg id '.$pkgID); 
			echo 'Success : Package Created Successfuly';
			//
			$this->db->transComplete();
		}else{
			echo $error;
		}
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function get_tax(){
		$city = $this->input->getPost('city');
		//
		$modelTaxation = new Model_Taxation();
		$data = $modelTaxation->get_taxation(null,$city)->get()->getRow();
		// 
		echo json_encode($data);
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function update()
	{
		if(access_crud('package','update')){
			$uri = new \CodeIgniter\HTTP\URI(current_url());
			$id = $uri->getSegment(3);
			//
			$modelTaxation = new Model_Taxation();
			$modelpkg = new Model_Package();
			//
			$data['cities'] = $modelTaxation->get_taxation();
			$data['pkg'] = $modelpkg->get_package($id)->get()->getRow();
			//
			return view('cpanel/package_Update',$data);
		}else{
			return redirect()->to(base_url('login'));
		}
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function update_action()
	{
		$error = null;
		$pkgid = $this->input->getPost('pkgid');
		$pkgname = $this->input->getPost('pkgname');
		$bandwidth = $this->input->getPost('bandwidth');
		$groupname = $this->input->getPost('groupname');
		$city = $this->input->getPost('city');
		//
		$intRate = $this->input->getPost('int-rate');
		$tvRate = $this->input->getPost('tv-rate');
		$phRate = $this->input->getPost('ph-rate');
		//
		$disable = $this->input->getPost('disable');
		//
		$validation =  \Config\Services::validation();
		$validate = $this->validate([
			'pkgname' => ['label' => 'Package Name', 'rules' => 'required|trim'],
			'bandwidth' => ['label' => 'Bandwidth', 'rules' => 'required|trim|integer'],
			'groupname' => ['label' => 'Package Groupname', 'rules' => 'required|trim'],
			'int-rate' => ['label' => 'Internet Rate', 'rules' => 'required|trim|decimal|greater_than_equal_to[0]'],
			'tv-rate' => ['label' => 'TV Rate', 'rules' => 'required|trim|decimal|greater_than_equal_to[0]'],
			'ph-rate' => ['label' => 'Phone Rate', 'rules' => 'required|trim|decimal|greater_than_equal_to[0]'],
		]);

		if(!$validate){
			$error = $validation->listErrors();
		}
		//
		if(!access_crud('package','update')){
			$error = 'Error : You don`t have rights';
		}
		//
		// $pkg = new Model_Package();
		// if($pkg->get_package(null,$pkgname,null,$city)->countAllResults() > 1){
		// 	$error = 'Error : Package Name already Exist';
		// }else if($pkg->get_package(null,null,$bandwidth,$city)->countAllResults() > 1){
		// 	$error = 'Error : Bandwidth already Exist';
		// }
		//
		if(empty($error)){
			$this->db->transStart();
			//
			$data = array(
				// 'name' => $pkgname, 
				// 'bandwidth' => $bandwidth,
				'int_rate' => $intRate, 
				'tv_rate' => $tvRate,
				'phone_rate' => $phRate,
				// 'city' => $city,
				'status' => $disable,
				'groupname' => $groupname
			);
			$this->db->table('bo_package')->where('id',$pkgid)->update($data);
			//
			create_action_log('pkg id '.$pkgid); 
			echo 'Success : Package Updated Successfuly';
			//
			$this->db->transComplete();
		}else{
			echo $error;
		}
	}
	////////////////////////////////////////////////////////////////////////////////////////////////
	public function get_PkgDetail(){ ///////////// for customer update page //////////////////
		$data['error'] = null;
		$package = $this->input->getPost('pkg');
		//
		if(empty($package)){
			$data['error'] = 'Error : Select Package First.';
		}
		// $service = $this->input->getPost('service');
		$data['intQty'] = $this->input->getPost('int-qty');
		$data['tvQty'] = $this->input->getPost('tv-qty');
		$data['phQty'] = $this->input->getPost('ph-qty');
		//
		$modelTaxation = new Model_Taxation();
		$modelpkg = new Model_Package();
		//
		$data['pkg'] = $modelpkg->get_package($package)->get()->getRow();
		$data['tax'] = $modelTaxation->get_taxation(null,$data['pkg']->city)->get()->getRow();
		//
		// if(empty($service)){
		// 	$data['pkg']->int_rate = 0;
		// 	$data['pkg']->tv_rate = 0;
		// 	$data['pkg']->phone_rate = 0;
		// }else{
		// 	if(!in_array('internet',$service)){
		// 		$data['pkg']->int_rate = 0;
		// 	}if(!in_array('tv',$service)){
		// 		$data['pkg']->tv_rate = 0;
		// 	}if(!in_array('phone',$service)){
		// 		$data['pkg']->phone_rate = 0;
		// 	}
		// }
		// 
		$data['total']['int'] = ($data['pkg']->int_rate + ($data['pkg']->int_rate * ($data['tax']->int_sst / 100)) + ($data['pkg']->int_rate * ($data['tax']->int_adv / 100))) * $data['intQty'];
		$data['total']['tv'] = ($data['pkg']->tv_rate + ($data['pkg']->tv_rate * ($data['tax']->tv_sst / 100)) + ($data['pkg']->tv_rate * ($data['tax']->tv_adv / 100))) * $data['tvQty'];
		$data['total']['ph'] = ($data['pkg']->phone_rate + ($data['pkg']->phone_rate * ($data['tax']->phone_sst / 100)) + ($data['pkg']->phone_rate * ($data['tax']->phone_adv / 100))) * $data['phQty'];
		//
		$data['gtotal'] = $data['total']['int'] + $data['total']['tv'] + $data['total']['ph'] ;
		//
		return json_encode($data);

	}


}
