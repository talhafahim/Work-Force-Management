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
	public function internet_pkg_list()
	{
		if(access_crud('internet','view')){
			return view('cpanel/package_list_int');
		}else{
			return redirect()->to(base_url('login'));
		}
	}
	///////////////////////////////////////////////////////////////////
	public function tv_pkg_list()
	{
		if(access_crud('internet','view')){
			return view('cpanel/package_list_tv');
		}else{
			return redirect()->to(base_url('login'));
		}
	}
	///////////////////////////////////////////////////////////////////
	public function phone_pkg_list()
	{
		if(access_crud('internet','view')){
			return view('cpanel/package_list_phone');
		}else{
			return redirect()->to(base_url('login'));
		}
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function show_list_internet(){
		$pkg = new Model_Package();
		$query = $pkg->get_package_internet();
		foreach($query->get()->getResult() as $key => $value){
			?>
			<tr>
				<td><?= $key+1;?></td>
				<td><?= $value->city;?></td>
				<td><?= $value->name;?></td>
				<td><?= $value->bandwidth;?> Mbps</td>
				<td><?= $value->rate;?></td>
				<td><span class="badge badge-soft-<?= (($value->status == 'enable') ? 'success' : 'danger'); ?>"><?= $value->status;?></span></td>
				<td>
					<a href="<?= base_url();?>/package/update/<?= $value->id;?>" class="mr-3 text-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" data-userid="<?php echo $value->id;?>"><i class="fa fa-edit"></i></a>
					<a href="javascript:void(0);" class="text-success infoBtn" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" data-userid="<?= $value->id;?>"><i class="fa fa-info"></i></a>
				</td>
			</tr>
			<?php
		}
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////
	public function show_list_tv(){
		$pkg = new Model_Package();
		$query = $pkg->get_package_tv();
		foreach($query->get()->getResult() as $key => $value){
			?>
			<tr>
				<td><?= $key+1;?></td>
				<td><?= $value->city;?></td>
				<td><?= $value->name;?></td>
				<td><?= $value->qty;?></td>
				<td><?= $value->rate;?></td>
				<td><span class="badge badge-soft-<?= (($value->status == 'enable') ? 'success' : 'danger'); ?>"><?= $value->status;?></span></td>
				<td>
					<a href="<?= base_url();?>/package/update/<?= $value->id;?>" class="mr-3 text-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" data-userid="<?php echo $value->id;?>"><i class="fa fa-edit"></i></a>
					<a href="javascript:void(0);" class="text-success infoBtn" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" data-userid="<?= $value->id;?>"><i class="fa fa-info"></i></a>
				</td>
			</tr>
			<?php
		}
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////
	public function show_list_phone(){
		$pkg = new Model_Package();
		$query = $pkg->get_package_phone();
		foreach($query->get()->getResult() as $key => $value){
			?>
			<tr>
				<td><?= $key+1;?></td>
				<td><?= $value->city;?></td>
				<td><?= $value->name;?></td>
				<td><?= $value->minutes;?></td>
				<td><?= $value->rate;?></td>
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
	public function create_int_pkg()
	{
		if(access_crud('internet','create')){
			$modelTaxation = new Model_Taxation();
			$data['cities'] = $modelTaxation->get_taxation();
			return view('cpanel/package_create_int',$data);
		}else{
			return redirect()->to(base_url('login'));
		}
	}
	////////////////////////////////////////////////////
	public function create_phone_pkg()
	{
		if(access_crud('phone','create')){
			$modelTaxation = new Model_Taxation();
			$data['cities'] = $modelTaxation->get_taxation();
			return view('cpanel/package_create_phone',$data);
		}else{
			return redirect()->to(base_url('login'));
		}
	}
	////////////////////////////////////////////////////
	public function create_tv_pkg()
	{
		if(access_crud('tv','create')){
			$modelTaxation = new Model_Taxation();
			$data['cities'] = $modelTaxation->get_taxation();
			return view('cpanel/package_create_tv',$data);
		}else{
			return redirect()->to(base_url('login'));
		}
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function create_int_pkg_action()
	{
		$error = null;
		$pkgname = $this->input->getPost('pkgname');
		$bandwidth = $this->input->getPost('bandwidth');
		$groupname = $this->input->getPost('groupname');
		$city = $this->input->getPost('city');
		//
		$intRate = $this->input->getPost('int-rate');
		//
		$validation =  \Config\Services::validation();
		$validate = $this->validate([
			'city' => ['label' => 'City', 'rules' => 'required|trim'],
			'pkgname' => ['label' => 'Package Name', 'rules' => 'required|trim'],
			'bandwidth' => ['label' => 'Bandwidth', 'rules' => 'required|trim|integer'],
			'groupname' => ['label' => 'Package Groupname', 'rules' => 'required|trim'],
			'int-rate' => ['label' => 'Internet Rate', 'rules' => 'required|trim|decimal|greater_than_equal_to[0]'],
		]);
		if(!access_crud('internet','create')){
			$error = 'Sorry you don`t have access';
		}
		//
		if(!$validate){
			$error = $validation->listErrors();
		}
		//
		$pkg = new Model_Package();
		if($pkg->get_package_internet(null,$pkgname,null,$city)->countAllResults() > 0){
			$error = 'Error : Package Name already Exist';
		}else if($pkg->get_package_internet(null,null,$bandwidth,$city)->countAllResults() > 0){
			$error = 'Error : Bandwidth already Exist';
		}
		//
		if(empty($error)){
			$this->db->transStart();
			//
			$data = array(
				'name' => $pkgname, 
				'bandwidth' => $bandwidth,
				'rate' => $intRate,
				'city' => $city,
				'groupname' => $groupname
			);
			$this->db->table('bo_pkg_int')->insert($data);
			$pkgID = $this->db->insertID();
			create_action_log('id '.$pkgID); 
			echo 'Success : Package Created Successfuly';
			//
			$this->db->transComplete();
		}else{
			echo $error;
		}
	}
	//////////////////////
	public function create_phone_pkg_action()
	{
		$error = null;
		$pkgname = $this->input->getPost('pkgname');
		$minutes = $this->input->getPost('minutes');
		$city = $this->input->getPost('city');
		//
		$phRate = $this->input->getPost('ph-rate');
		//
		$validation =  \Config\Services::validation();
		$validate = $this->validate([
			'city' => ['label' => 'City', 'rules' => 'required|trim'],
			'pkgname' => ['label' => 'Package Name', 'rules' => 'required|trim'],
			'minutes' => ['label' => 'Minutes', 'rules' => 'required|trim|integer|greater_than_equal_to[1]'],
			'ph-rate' => ['label' => 'Internet Rate', 'rules' => 'required|trim|decimal|greater_than_equal_to[0]'],
		]);
		if(!access_crud('phone','create')){
			$error = 'Sorry you don`t have access';
		}
		//
		if(!$validate){
			$error = $validation->listErrors();
		}
		//
		$pkg = new Model_Package();
		if($pkg->get_package_phone(null,$pkgname,$city)->countAllResults() > 0){
			$error = 'Error : Package Name already Exist';
		}else if($pkg->get_package_phone(null,$pkgname,$city,$minutes)->countAllResults() > 0){
			$error = 'Error : Package already Exist';
		}
		//
		if(empty($error)){
			$this->db->transStart();
			//
			$data = array(
				'name' => $pkgname, 
				'minutes' => $minutes,
				'rate' => $phRate,
				'city' => $city
			);
			$this->db->table('bo_pkg_phone')->insert($data);
			$pkgID = $this->db->insertID();
			create_action_log('id '.$pkgID); 
			echo 'Success : Package Created Successfuly';
			//
			$this->db->transComplete();
		}else{
			echo $error;
		}
	}
	//////////////////////
	public function create_tv_pkg_action()
	{
		$error = null;
		$pkgname = $this->input->getPost('pkgname');
		$tvBox = $this->input->getPost('tvBox');
		$city = $this->input->getPost('city');
		//
		$tvRate = $this->input->getPost('tv-rate');
		//
		$validation =  \Config\Services::validation();
		$validate = $this->validate([
			'city' => ['label' => 'City', 'rules' => 'required|trim'],
			'pkgname' => ['label' => 'Package Name', 'rules' => 'required|trim'],
			'tvBox' => ['label' => 'Minutes', 'rules' => 'required|trim|integer|greater_than_equal_to[1]'],
			'tv-rate' => ['label' => 'Internet Rate', 'rules' => 'required|trim|decimal|greater_than_equal_to[0]'],
		]);
		if(!access_crud('phone','create')){
			$error = 'Sorry you don`t have access';
		}
		//
		if(!$validate){
			$error = $validation->listErrors();
		}
		//
		$pkg = new Model_Package();
		if($pkg->get_package_tv(null,$pkgname,$city)->countAllResults() > 0){
			$error = 'Error : Package Name already Exist';
		}else if($pkg->get_package_tv(null,$pkgname,$city,$tvBox)->countAllResults() > 0){
			$error = 'Error : Package already Exist';
		}
		//
		if(empty($error)){
			$this->db->transStart();
			//
			$data = array(
				'name' => $pkgname, 
				'qty' => $tvBox,
				'rate' => $tvRate,
				'city' => $city
			);
			$this->db->table('bo_pkg_tv')->insert($data);
			$pkgID = $this->db->insertID();
			create_action_log('id '.$pkgID); 
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
		$data['custID'] = $this->input->getPost('custID');
		//
		$data['intPkg'] = $this->input->getPost('intPkg');
		$data['phonePkg'] = $this->input->getPost('phonePkg');
		$data['tvPkg'] = $this->input->getPost('tvPkg');
		$data['discount'] = $this->input->getPost('discount');
		//
		$data['intPkgDetail'] = $data['phonePkgDetail'] = $data['tvPkgDetail'] = null;
		$data['gtotal'] = $data['total']['int'] = $data['total']['tv'] = $data['total']['ph'] = 0;
		//
		$modelTaxation = new Model_Taxation();
		$modelpkg = new Model_Package();
		//
		if(!empty($data['intPkg'])){
			$data['intPkgDetail'] = $modelpkg->get_package_internet($data['intPkg'])->get()->getRow();
			$data['intPkgTax'] = $modelTaxation->get_taxation(null,$data['intPkgDetail']->city)->get()->getRow();
			$data['total']['int'] = ($data['intPkgDetail']->rate + ($data['intPkgDetail']->rate * ($data['intPkgTax']->int_sst / 100)) + ($data['intPkgDetail']->rate * ($data['intPkgTax']->int_adv / 100)));
		}if(!empty($data['phonePkg'])){
			$data['phonePkgDetail'] = $modelpkg->get_package_phone($data['phonePkg'])->get()->getRow();
			$data['phonePkgTax'] = $modelTaxation->get_taxation(null,$data['phonePkgDetail']->city)->get()->getRow();
			$data['total']['ph'] = ($data['phonePkgDetail']->rate + ($data['phonePkgDetail']->rate * ($data['phonePkgTax']->phone_sst / 100)) + ($data['phonePkgDetail']->rate * ($data['phonePkgTax']->phone_adv / 100)));
		}if(!empty($data['tvPkg'])){
			$data['tvPkgDetail'] = $modelpkg->get_package_tv($data['tvPkg'])->get()->getRow();
			$data['tvPkgTax'] = $modelTaxation->get_taxation(null,$data['tvPkgDetail']->city)->get()->getRow();
			$data['total']['tv'] = ($data['tvPkgDetail']->rate + ($data['tvPkgDetail']->rate * ($data['tvPkgTax']->tv_sst / 100)) + ($data['tvPkgDetail']->rate * ($data['tvPkgTax']->tv_adv / 100)));
		}
		//
			$data['gtotal'] = ($data['total']['int'] + $data['total']['tv'] + $data['total']['ph']) - $data['discount'];
		//
		return json_encode($data);

	}


}
