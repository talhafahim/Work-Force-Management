<?php 
namespace App\Controllers;
use App\Models\Model_General;
use App\Models\Model_Task;
use App\Models\Model_Users;
use App\Models\Model_Notification;
use CodeIgniter\HTTP\Request;
use \Hermawan\DataTables\DataTable;

class General extends BaseController
{
	public function __construct(){

		parent::__construct();
		$this->db = \Config\Database::connect();
		$this->input = \Config\Services::request();
	}
	//--------------------------------------------------------------------
	public function return_reason()
	{
		if(access_crud('Return Reason','view')){
			$modelGeneral = new Model_General();
			$data['return_reason'] = $modelGeneral->get_return_reason();
			return view('cpanel/return_reason',$data);
		}else{
			return redirect()->to(base_url('login'));
		}
	}
	//------------------------------------------------------------------
	public function add_return_reason(){
		$error = null;
		if(access_crud('Return Reason','create')){
			$reason = $this->input->getPost('reason');
			$picReq = $this->input->getPost('picReq');
			$validation =  \Config\Services::validation();
			$validate = $this->validate([
				'reason' => ['label' => 'Reason', 'rules' => 'required|trim'],
			]);
			if(!$validate){
				$error = $validation->listErrors();
			}
			$modelGeneral = new Model_General();
			$cityalready = $modelGeneral->get_return_reason(null,$reason)->countAllResults();
			if($cityalready > 0){
				$error = 'Error : Reason already exist';
			}
			//
			if(empty($error)){
				$this->db->transStart();
				$this->db->table('return_reason')->insert(['reason' => $reason, 'pic_require' => $picReq]);
				create_action_log($reason); 
				$this->db->transComplete();
				return $this->response->setStatusCode(200)->setBody('Reason Added Successfully');
			}else{
				return $this->response->setStatusCode(401,$error);
			}
		}else{
			return $this->response->setStatusCode(401,'Access Denied');
		}
	}
	//-----------------------------------------------------------------------------
	public function delete_return_reason(){
		$ser = $this->input->getPost('ser');
		if(access_crud('Return Reason','delete')){
			// $this->db->transStart();
			$query = $this->db->table('return_reason')->where('id',$ser)->delete();
			if(empty($query)){
				return $this->response->setStatusCode(401,'You can not delete this.');
			}else{
				create_action_log(' ser#'.$ser); 
				return $this->response->setStatusCode(200)->setBody('Deleted Successfully');
			}
			// $this->db->transComplete();
		}else{
			return $this->response->setStatusCode(401,'Access Denied');
		}
	}
	//-----------------------------------------------------------------------------
	public function return_reason_pic_require_update(){
		if(access_crud('Return Reason','update')){
			$id = $this->input->getPost('id');
			$picReq = $this->input->getPost('picReq');
			//
			$this->db->table('return_reason')->where('id',$id)->update(['pic_require' => $picReq]);
			//	
			create_action_log('id '.$id);
		}else{
			return $this->response->setStatusCode(401,'Access Denied');
		}
	}
	//-----------------------------------------------------------------------------
	public function gateway(){
		if(access_crud('Gateway','view')){
			$modelUsers = new Model_Users();
			$data['users'] = $modelUsers->get_users(null,null,null,['engineer']);
			return view('cpanel/gateway',$data);
		}else{
			return redirect()->to(base_url('login'));
		}
	}
	//
	public function get_getway_list(){
		if(access_crud('Gateway','view')){
			$modelGeneral = new Model_General();
			$builder = $modelGeneral->get_gateway();
			//
			return DataTable::of($builder)->addNumbering('no')
			//
			->filter(function ($builder, $request) {
				if ($request->status)
					$builder->where('status', $request->status);
			})
			//
			->add('checkbox', function($row){
				//
				if($row->status == 'free'){
					return '<input type="checkbox" name="dataid[]" value="'.$row->id.'">';
				}else{
					$status = ($row->status == 'used') ? 'Utilized' : 'Assigned';
					return '<span class="badge badge-soft-info">'.ucfirst($status).'</span>';
				}
			})
			//
			->add('action', function($row){
				//
				if($row->status == 'free'){
					return '<button class="btn btn-primary btn-sm assignBtn" data-id="'.$row->id.'">Assign to</button>';
				}else if($row->status == 'assigned'){
					$modelUsers = new Model_Users();
					$userInfo = $modelUsers->get_users($row->assign_to)->get()->getRow();
					return $userInfo->firstname.' '.$userInfo->lastname;
				}else if($row->status == 'used'){
					$modelGeneral = new Model_General();
					$taskDetail = $modelGeneral->get_task_gateway(null,null,$row->serial)->get()->getRow();
					return '<a href="'.base_url().'/customer/view_detail/'.$taskDetail->task_id.'" class="btn btn-info btn-sm" title="View Detail"><i class="fa fa-info-circle"></i></a></div>';
				}
			})
			//
			->toJson(true);
		}
	}
	//
	public function gateway_upload_csv_action(){
		$error = null;
		$csv = $_FILES['file']['tmp_name'];
		if(!isLoggedIn()){
			$error = 'Error : Session expired';
		}
		if(isset($_FILES['file'])){
			$file_name = $_FILES['file']['name'];
			$handle = fopen($_FILES['file']['tmp_name'],"r");
			$ext = pathinfo($file_name, PATHINFO_EXTENSION);
			//
			if(count(fgetcsv($handle)) != "5"){
				$error = 'Error : Invalid file structure';
			}if($ext != 'csv'){
				$error = 'Error : Invalid file format';
			}
		}
		//////////
		if(empty($error)){
			$remove = array("'","`","(",")",",",'"');
			$handle = fopen($csv,"r");
			$num = 0;
			while (($row = fgetcsv($handle, 10000, ",")) != FALSE) 
			{
				if($num > 0){
					$data = array(
						'serial' => str_replace($remove,'',$row[0]),
						'vendor' => str_replace($remove,'',$row[1]),
						'model' => str_replace($remove,'',$row[2]),
						'scenario' => str_replace($remove,'',$row[3]),
						'cost' => str_replace($remove,'',$row[4]),
					);
					//
					$this->db->table('gateway')->insert($data);
					//
				}
				$num++;
			}

			return $this->response->setStatusCode(200)->setBody('Upload Successfully');
		}else{
			return $this->response->setStatusCode(401,$error);
		}
	}
	//
	public function assign_action(){
		if(isLoggedIn()){
			$dataid = $this->input->getPost('dataid');
			$technician_id = $this->input->getPost('technician_id');
			//
			$this->db->table('gateway')->where('id',$dataid)->update(['assign_to' => $technician_id, 'status' => 'assigned', 'assign_on' => date('Y-m-d H:i:s') ]);
			//
			$modelNoti = new Model_Notification();
			$modelNoti->set_notification('Gateway Assigned','One gateway has been assigned to you',[$technician_id]);
			//
			return $this->response->setStatusCode(200)->setBody('Updated Successfully');
		}else{
			return $this->response->setStatusCode(401,'Session Timeout');
		}
	}
	//
	public function assign_bulk_gateway(){
		$error = null;
		$gatewayIDList = $this->input->getPost('gatewayIDList');
		$gatewayIDList = explode(',',$gatewayIDList);
		$engineer_id = $this->input->getPost('engineer_id');
		if(!isLoggedIn()){
			$error = 'Session Timeout';
		}if(empty($gatewayIDList) || empty($engineer_id)){
			$error = 'Please select Gateway & Engineer';
		}
		//
		if(empty($error)){
			//
			foreach($gatewayIDList as $value){
				$this->db->table('gateway')->where('id',$value)->update(['assign_to' => $engineer_id, 'status' => 'assigned', 'assign_on' => date('Y-m-d H:i:s')]);	
			}
			// //
			$modelNoti = new Model_Notification();
			$modelNoti->set_notification('Gateway Assigned', count($gatewayIDList).' gateway has been assigned to you',[$engineer_id]);
			//
			return $this->response->setStatusCode(200)->setBody('Assigned Successfully');
		}else{
			return $this->response->setStatusCode(401,$error);
		}
	}
	//
	public function miscellaneous_equipment()
	{
		if(access_crud('Equipment','view')){
			//
			$data['modelGeneral'] = new Model_General();
			$status = session()->get('status');
			$id = session()->get('id');
			//
			if($status == 'engineer'){
				$data['misc_equipment'] = $data['modelGeneral']->get_users_misc_equipment(null,$id);
				return view('customer/misc_equipment',$data);
			}else{
				$data['misc_equipment'] = $data['modelGeneral']->get_misc_equipment();
				return view('cpanel/misc_equipment',$data);
			}
		}else{
			return redirect()->to(base_url('login'));
		}
	}
	//------------------------------------------------------------------
	public function add_misc_equipment(){
		$error = null;
		if(access_crud('Equipment','create')){
			$name = $this->input->getPost('name');
			$stock = $this->input->getPost('stock');
			$uom = $this->input->getPost('uom');
			$rate = $this->input->getPost('rate');
			$validation =  \Config\Services::validation();
			$validate = $this->validate([
				'name' => ['label' => 'Equipment Name', 'rules' => 'required|trim'],
				'stock' => ['label' => 'Stock', 'rules' => 'required|trim'],
				'uom' => ['label' => 'UOM', 'rules' => 'required|trim'],
				'rate' => ['label' => 'Rate', 'rules' => 'required|trim'],
			]);
			if(!$validate){
				$error = $validation->listErrors();
			}
			$modelGeneral = new Model_General();
			$cityalready = $modelGeneral->get_misc_equipment(null,$name)->countAllResults();
			if($cityalready > 0){
				$error = 'Error : Equipment Name already exist';
			}
			//
			if(empty($error)){
				$this->db->transStart();
				$this->db->table('miscellaneous_equipment')->insert(['name' => $name, 'stock' => $stock, 'uom' => $uom, 'rate' => $rate]);
				create_action_log($name); 
				$this->db->transComplete();
				return $this->response->setStatusCode(200)->setBody('Equipment Added Successfully');
			}else{
				return $this->response->setStatusCode(401,$error);
			}
		}else{
			return $this->response->setStatusCode(401,'Access Denied');
		}
	}
	//-----------------------------
	public function delet_misc_equipment(){
		$ser = $this->input->getPost('ser');
		if(access_crud('Equipment','delete')){
			// $this->db->transStart();
			$query = $this->db->table('miscellaneous_equipment')->where('id',$ser)->delete();
			if(empty($query)){
				return $this->response->setStatusCode(401,'You can not delete this.');
			}else{
				create_action_log(' ser#'.$ser); 
				return $this->response->setStatusCode(200)->setBody('Deleted Successfully');
			}
			// $this->db->transComplete();
		}else{
			return $this->response->setStatusCode(401,'Access Denied');
		}
	}
	//----------------------------------
	public function update_stock(){
		$ser = $this->input->getPost('ser');
		if(access_crud('Equipment','update')){
			//
			$modelGeneral = new Model_General();
			$data = $modelGeneral->get_misc_equipment($ser)->get()->getRow();
			return json_encode($data);
			//
		}else{
			return $this->response->setStatusCode(401,'Access Denied');
		}
	}
	//----------------------------------
	public function update_stock_action(){
		$id = $this->input->getPost('id');
		$stock = $this->input->getPost('stock');
		$uom = $this->input->getPost('uom');
		$rate = $this->input->getPost('rate');
		//
		if(access_crud('Equipment','update')){
			//
			if(!empty($id) &&  !empty($stock)){
				$this->db->table('miscellaneous_equipment')->where('id',$id)->update(['stock' => $stock,'uom' => $uom, 'rate' => $rate]);
				create_action_log('id# '.$id);
				return $this->response->setStatusCode(200)->setBody('Update Successfully');
			}else{
				return $this->response->setStatusCode(401,'Some thing went wrong');
			}
			//
		}else{
			return $this->response->setStatusCode(401,'Access Denied');
		}
	}
	//--------------------------------------------------------------------
	public function devices_n_tools()
	{
		if(access_crud('Devices & Tools','view')){
			$modelGeneral = new Model_General();
			$modelUsers = new Model_Users();
			$data['users'] = $modelUsers->get_users(null,null,null,['engineer','driver']);
			$data['devices_n_tools'] = $modelGeneral->get_devices_n_tools();
			return view('cpanel/devices_n_tools',$data);
		}else{
			return redirect()->to(base_url('login'));
		}
	}
	//------------------------------------------------------------------
	public function add_devices_n_tools(){
		$error = null;
		if(access_crud('Devices & Tools','create')){
			$name = $this->input->getPost('name');
			$validation =  \Config\Services::validation();
			$validate = $this->validate([
				'name' => ['label' => 'Name', 'rules' => 'required|trim'],
			]);
			if(!$validate){
				$error = $validation->listErrors();
			}
			$modelGeneral = new Model_General();
			$cityalready = $modelGeneral->get_devices_n_tools(null,$name)->countAllResults();
			if($cityalready > 0){
				$error = 'Error : Device or tool already exist';
			}
			//
			if(empty($error)){
				$this->db->transStart();
				$this->db->table('devices_and_tools')->insert(['name' => $name]);
				create_action_log($name); 
				$this->db->transComplete();
				return $this->response->setStatusCode(200)->setBody('Added Successfully');
			}else{
				return $this->response->setStatusCode(401,$error);
			}
		}else{
			return $this->response->setStatusCode(401,'Access Denied');
		}
	}
	//----------------------------------------------------------------
	public function equipment_assign_action(){
		$error = null;
		$otherEquipmentId = $this->input->getPost('otherEquipmentId');
		$equipQty = $this->input->getPost('equipQty');
		$technician_id = $this->input->getPost('technician_id');
		$modelGeneral = new Model_General();
		//
		if(!access_crud('Equipment','update')){
			$error = 'Access Denied';
		}if(empty($otherEquipmentId) || empty($technician_id)){
			$error = 'Please select equipment and engineer';
		}
		//
		$equipdata = $modelGeneral->get_misc_equipment($otherEquipmentId)->get()->getRow();
		if($equipdata->stock < $equipQty){
			$error = 'Error : '.$equipdata->name.' out of stock';
		}
		//
		if(empty($error)){
			//
			$count = $modelGeneral->get_users_misc_equipment($otherEquipmentId,$technician_id)->countAllResults();
			if($count > 0){
					//
				$this->db->query("UPDATE `users_misc_equipment` set `stock` = `stock` + '$equipQty', `rate` = '$equipdata->rate'  where `user_id` =  '$technician_id' and `equip_id` = '$otherEquipmentId' ");
					//
			}else{
				$this->db->table('users_misc_equipment')->insert(['user_id' => $technician_id, 'equip_id' => $otherEquipmentId, 'stock' => $equipQty, 'rate' => $equipdata->rate]);
			}
				//
			$this->db->query("UPDATE `miscellaneous_equipment` set `stock` = `stock` - '$equipQty'  where `id` =  '$otherEquipmentId' ");
				//

			$modelNoti = new Model_Notification();
			$modelNoti->set_notification('Equipment Assigned', $equipQty.$equipdata->uom.' '.$equipdata->name.' have been assigned to you',[$technician_id]);
			//
			create_action_log('id# '.$technician_id);
			return $this->response->setStatusCode(200)->setBody('Update Successfully');
		}else{
			return $this->response->setStatusCode(401,$error);
		}
	}


	//----------------------------------------------------------------
	public function device_assign_action(){
		$error = null;
		$deviceId = $this->input->getPost('deviceId');
		$serial = $this->input->getPost('serial');
		$technician_id = $this->input->getPost('technician_id');
		$modelGeneral = new Model_General();
		//
		if(!access_crud('Devices & Tools','update')){
			$error = 'Access Denied';
		}if(empty($deviceId) || empty($technician_id)){
			$error = 'Please select device and engineer';
		}
		//
		$alreadyAssigned = $modelGeneral->get_users_devices_n_tools($technician_id,$deviceId)->countAllResults();
		$deviceInfo = $modelGeneral->get_devices_n_tools($deviceId)->get()->getRow();
		if($alreadyAssigned > 0){
			$error = 'Error : '.$deviceInfo->name.' already assigned';
		}
		//
		if(empty($error)){
			//
			$this->db->table('users_devices_and_tools')->insert(['user_id' => $technician_id, 'tool_id' => $deviceId, 'serial' => $serial]);
			//
			$modelNoti = new Model_Notification();
			$modelNoti->set_notification('Device/Tools Assigned', $deviceInfo->name.' has been assigned to you',[$technician_id]);
			//
			create_action_log('id# '.$technician_id);
			return $this->response->setStatusCode(200)->setBody('Update Successfully');
		}else{
			return $this->response->setStatusCode(401,$error);
		}
	}
	////////////////////
	public function global_equipment_list(){
		$modelGeneral = new Model_General();
		$query = $modelGeneral->get_misc_equipment();
		return (json_encode($query->get()->getResult()));
	}
	////////////////////
	public function global_deviceTools_list(){
		$modelGeneral = new Model_General();
		$query = $modelGeneral->get_devices_n_tools();
		return (json_encode($query->get()->getResult()));
	}
	
}
