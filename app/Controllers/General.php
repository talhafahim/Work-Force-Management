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
			$status = session()->get('status');
			if($status == 'engineer'){
				return view('customer/gateway');
			}else{
				$modelUsers = new Model_Users();
				$data['users'] = $modelUsers->get_users(null,null,null,['engineer']);
				return view('cpanel/gateway',$data);
			}
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
				if($row->status == 'free' || $row->status == 'return'){
					return '<input type="checkbox" name="dataid[]" value="'.$row->id.'">';
				}
			})
			//
			->add('assign_to', function($row){
				//
				if(!empty($row->assign_to)){
					$modelUsers = new Model_Users();
					$userInfo = $modelUsers->get_users($row->assign_to)->get()->getRow();
					return $userInfo->firstname.' '.$userInfo->lastname;
				}
			})
			//
			->add('action', function($row){
				//
				if($row->status == 'free' || $row->status == 'assigned'){
					$actionHtml = '<div class="btn-group">';
					$actionHtml .= '<button class="btn btn-primary btn-sm assignBtn" data-id="'.$row->id.'"><i class="fa fa-tasks"></i></button>';
					if($row->status == 'free'){
						$actionHtml .= '<a type="button" class="btn btn-danger btn-sm delete" data-serial="'.$row->id.'" title="Delete"><i class="fa fa-trash"></i></a>';
					}
					$actionHtml .= '</div>';
					return $actionHtml;

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
	public function get_engineer_getway_list(){
		if(access_crud('Gateway','view')){
			$modelGeneral = new Model_General();
			$id = session()->get('id');
			$builder = $modelGeneral->get_gateway(null,null,$id);
			//
			return DataTable::of($builder)->addNumbering('no')
			//
			->filter(function ($builder, $request) {
				if ($request->status)
					$builder->where('status', $request->status);
			})
			//
			->add('action', function($row){
				//
				if($row->status == 'assigned'){
					$actionHtml = '<div class="btn-group">';
					$actionHtml .= '<button class="btn btn-danger btn-sm return" data-id="'.$row->id.'">Return</button>';
					$actionHtml .= '</div>';
					return $actionHtml;

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
		$modelGeneral = new Model_General();
		$serialArray = array();
		$csv = $_FILES['file']['tmp_name'];
		if(!isLoggedIn()){
			$error = 'Error : Session expired';
		}if(!access_crud('Gateway','create')){
			$error = 'Access denied';
		}
		if(isset($_FILES['file'])){
			$file_name = $_FILES['file']['name'];
			$handle = fopen($_FILES['file']['tmp_name'],"r");
			$ext = pathinfo($file_name, PATHINFO_EXTENSION);
			//
			if(count(fgetcsv($handle)) != "7"){
				$error = 'Error : Invalid file structure';
			}if($ext != 'csv'){
				$error = 'Error : Invalid file format';
			}
		}
		///////////
		if(empty($error)){
			$remove = array("'","`","(",")",",",'"');
			$handle = fopen($csv,"r");
			$num = 0;
			// 
			while (($row = fgetcsv($handle, 10000, ",")) != FALSE) 
			{
				if($num > 0){
					//
					array_push($serialArray, trim($row[0]));
					//
					$serialExist = $modelGeneral->get_gateway(null,$row[0])->countAllResults();
					if($serialExist > 0){
						$line = $num+1;
						$error = 'Error : Serial already exist at line#'.$line;
						break;
					}
					//
					if(empty($error)){
						if (count(array_diff_assoc($serialArray, array_unique($serialArray))) > 0) {
							$error = 'Error : Duplicate Serial in sheet';	
						}
					}
					//
				}
				$num++;
			}
			
		}
		//////////
		if(empty($error)){
			$remove = array("'","`","(",")",",",'"');
			$handle = fopen($csv,"r");
			$num = 0;
			$this->db->transStart();
			while (($row = fgetcsv($handle, 10000, ",")) != FALSE) 
			{
				if($num > 0){
					$data = array(
						'serial' => str_replace($remove,'',$row[0]),
						'vendor' => str_replace($remove,'',$row[1]),
						'model' => str_replace($remove,'',$row[2]),
						'ctn' => str_replace($remove,'',$row[3]),
						'received_date' => str_replace($remove,'',$row[4]),
						'dn' => str_replace($remove,'',$row[5]),
						'cost' => str_replace($remove,'',$row[6]),
					);
					//
					$this->db->table('gateway')->insert($data);
					//
				}
				$num++;
			}
			$this->db->transComplete();

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
			$data['modelGeneral'] = new Model_General();
			$modelUsers = new Model_Users();
			$data['users'] = $modelUsers->get_users(null,null,null,['engineer','driver']);
			$data['devices_n_tools'] = $data['modelGeneral']->get_devices_n_tools();
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
		$alreadyAssigned = $modelGeneral->get_devices_detail($deviceId,$serial,'in stock')->countAllResults();
		// 
		if($alreadyAssigned <= 0){
			$error = 'Error : Invalid serial or not in stock';
		}
		//
		if(empty($error)){
			//
			$deviceInfo = $modelGeneral->get_devices_n_tools($deviceId)->get()->getRow();
			$deviceDetailInfo = $modelGeneral->get_devices_detail($deviceId,$serial,'in stock')->get()->getRow();
			//
			$this->db->transStart();
			//
			$this->db->table('device_detail')->where('id',$deviceDetailInfo->id)->update(['status' => 'assigned','user_id' => $technician_id]);
			$this->db->transComplete();
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
	////////////////////////////////////
	public function delete_gateway_action(){
		$error = null;
		$id = $this->input->getPost('id');
		if(!isLoggedIn() || !access_crud('Gateway','delete')){
			$error = 'Access denied';
		}
		//
		$modelGeneral = new Model_General();
		$checkStatus = $modelGeneral->get_gateway($id,null,null,'free')->countAllResults();
		if($checkStatus <= 0){
			$error = 'Error : This can not be deleted';		
		}
		//
		if(empty($error)){
			//
			$this->db->table('gateway')->where('id',$id)->where('status','free')->delete();
			//
			create_action_log('id#'.$id);
			return $this->response->setStatusCode(200)->setBody('Delete Successfully');
		}else{
			return $this->response->setStatusCode(401,$error);
		}
	}
	///////////////////////////////////
	public function delete_device_n_tool(){
		$id = $this->input->getPost('id');
		if(access_crud('Devices & Tools','delete')){
			// 
			$query = $this->db->table('devices_and_tools')->where('id',$id)->delete();
			if(empty($query)){
				return $this->response->setStatusCode(401,'You can not delete this.');
			}else{
				create_action_log('id#'.$id); 
				return $this->response->setStatusCode(200)->setBody('Deleted Successfully');
			}
			//
		}else{
			return $this->response->setStatusCode(401,'Access Denied');
		}
	}
	/////////////////////////////
	public function device_upload_action(){
		$error = null;
		$modelGeneral = new Model_General();
		$deviceId = $this->input->getPost('deviceId');
		$csv = $_FILES['file']['tmp_name'];
		if(!isLoggedIn()){
			$error = 'Error : Session expired';
		}if(!access_crud('Devices & Tools','create')){
			$error = 'Access denied';
		}
		//
		if(isset($_FILES['file'])){
			$file_name = $_FILES['file']['name'];
			$handle = fopen($_FILES['file']['tmp_name'],"r");
			$ext = pathinfo($file_name, PATHINFO_EXTENSION);
			//
			if(count(fgetcsv($handle)) != "2"){
				$error = 'Error : Invalid file structure';
			}if($ext != 'csv'){
				$error = 'Error : Invalid file format';
			}if(empty($deviceId)){
				$error = 'Please select device first';
			}
		}
		//
		if(empty($error)){
			$handle = fopen($csv,"r");
			$num = 0;
			$this->db->transStart();
			while (($row = fgetcsv($handle, 10000, ",")) != FALSE) 
			{
				if($num > 0){
						//
					$userdata = $modelGeneral->get_devices_detail(null,$row[0])->countAllResults();
					if($userdata > 0){
						$error = "Error : Serial already exist at line#".$num;
						break;
					}
						//
					if(empty($row[0])){
						$error = "Error : Serial can not be empty at line#".$num;
						break;
					}
					//
				}
				$num++;
			}
			$this->db->transComplete();
		}
		//////////
		if(empty($error)){
			$remove = array("'","`","(",")",",",'"');
			$handle = fopen($csv,"r");
			$num = 0;
			while (($row = fgetcsv($handle, 10000, ",")) != FALSE) 
			{
				if($num > 0){
					//
					$this->db->transStart();
					$data= array(
						'device_id'=> $deviceId,
						'serial'=> str_replace($remove,'',$row[0]),
						'model'=> str_replace($remove,'',$row[1]),
					);
					//
					$builder = $this->db->table('device_detail');
					$builder->insert($data);
					//
					$insert_id = $this->db->insertID();
					//
					create_action_log('id '.$insert_id);
					$this->db->transComplete();
					//
				}
				$num++;
			}

			return $this->response->setStatusCode(200)->setBody('Upload Successfully');
		}else{
			return $this->response->setStatusCode(401,$error);
		}
	}
		////////////////////////////////////////////
		//-----------------------------------------------------------------------------
	public function sim(){
		if(access_crud('SIM','view')){
			$status = session()->get('status');
			if($status == 'engineer'){
				return view('customer/sim');
			}else{
				$modelUsers = new Model_Users();
				$data['users'] = $modelUsers->get_users(null,null,null,['engineer']);
				return view('cpanel/sim',$data);
			}
		}else{
			return redirect()->to(base_url('login'));
		}
	}
	//------------------------------------------------------------------------------
	public function get_sim_list(){
		if(access_crud('SIM','view')){
			$modelGeneral = new Model_General();
			$builder = $modelGeneral->get_sim();
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
				if($row->status == 'in stock' || $row->status == 'return'){
					return '<input type="checkbox" name="dataid[]" value="'.$row->id.'">';
				}
			})
			//
			->add('assign_to', function($row){
				//
				if(!empty($row->user_id)){
					$modelUsers = new Model_Users();
					$userInfo = $modelUsers->get_users($row->user_id)->get()->getRow();
					return $userInfo->firstname.' '.$userInfo->lastname;
				}
			})
			//
			->add('action', function($row){
				//
				if($row->status == 'in stock' || $row->status == 'assigned'){
					$actionHtml = '<div class="btn-group">';
					$actionHtml .= '<button class="btn btn-primary btn-sm assignBtn" data-id="'.$row->id.'"><i class="fa fa-tasks"></i></button>';
					if($row->status == 'in stock'){
						$actionHtml .= '<a type="button" class="btn btn-danger btn-sm delete" data-serial="'.$row->id.'" title="Delete"><i class="fa fa-trash"></i></a>';
					}
					$actionHtml .= '</div>';
					return $actionHtml;

				}else if($row->status == 'utilized'){
					$modelGeneral = new Model_General();
					$taskDetail = $modelGeneral->get_task_sim(null,null,$row->icc_id)->get()->getRow();
					return '<a href="'.base_url().'/task/view_detail/'.$taskDetail->task_id.'" class="btn btn-info btn-sm" title="View Detail"><i class="fa fa-info-circle"></i></a></div>';
				}
			})
			//
			->toJson(true);
		}
	}
	//------------------------------------------------------------------------------
	public function get_engineer_sim_list(){
		if(access_crud('SIM','view')){
			$modelGeneral = new Model_General();
			$id = session()->get('id');
			$builder = $modelGeneral->get_sim(null,null,$id);
			//
			return DataTable::of($builder)->addNumbering('no')
			//
			->filter(function ($builder, $request) {
				if ($request->status)
					$builder->where('status', $request->status);
			})
			//
			->add('action', function($row){
				//
				if($row->status == 'in stock' || $row->status == 'assigned'){
					$actionHtml = '<div class="btn-group">';
					$actionHtml .= '<button class="btn btn-danger btn-sm return" data-id="'.$row->id.'">Return</button>';
					$actionHtml .= '</div>';
					return $actionHtml;

				}else if($row->status == 'utilized'){
					$modelGeneral = new Model_General();
					$taskDetail = $modelGeneral->get_task_sim(null,null,$row->icc_id)->get()->getRow();
					return '<a href="'.base_url().'/task/view_detail/'.$taskDetail->task_id.'" class="btn btn-info btn-sm" title="View Detail"><i class="fa fa-info-circle"></i></a></div>';
				}
			})
			//
			->toJson(true);
		}
	}
	//-------------------------------------------------------------------------
	public function sim_upload_csv_action(){
		
		$error = null;
		$iccArray =  array();
		$modelGeneral = new Model_General();
		$csv = $_FILES['file']['tmp_name'];
		if(!isLoggedIn()){
			$error = 'Error : Session expired';
		}
		if(!access_crud('SIM','create')){
			$error = 'Access denied';
		}
		//
		if(isset($_FILES['file'])){
			$file_name = $_FILES['file']['name'];
			$handle = fopen($_FILES['file']['tmp_name'],"r");
			$ext = pathinfo($file_name, PATHINFO_EXTENSION);
			//
			if(count(fgetcsv($handle)) != "1"){
				$error = 'Error : Invalid file structure';
			}if($ext != 'csv'){
				$error = 'Error : Invalid file format';
			}
		}
		///////////
		if(empty($error)){
			$remove = array("'","`","(",")",",",'"');
			$handle = fopen($csv,"r");
			$num = 0;
			// 
			while (($row = fgetcsv($handle, 10000, ",")) != FALSE) 
			{
				if($num > 0){
					//
					array_push($iccArray, trim($row[0]));
					//
					$serialExist = $modelGeneral->get_sim(null,$row[0])->countAllResults();
					if($serialExist > 0){
						$line = $num+1;
						$error = 'Error : ICC ID already exist at line#'.$line;
						break;
					}
					//
					if(empty($error)){
						if (count(array_diff_assoc($iccArray, array_unique($iccArray))) > 0) {
							$error = 'Error : Duplicate ICC ID in sheet';	
						}
					}
					//
				}
				$num++;
			}
			
		}
		//////////
		//////////
		if(empty($error)){
			$remove = array("'","`","(",")",",",'"');
			$handle = fopen($csv,"r");
			$num = 0;
			$this->db->transStart();
			while (($row = fgetcsv($handle, 10000, ",")) != FALSE) 
			{
				if($num > 0){
					$data = array(
						'icc_id' => str_replace($remove,'',$row[0]),
					);
					//
					$this->db->table('sim')->insert($data);
					//
				}
				$num++;
			}
			$this->db->transComplete();

			return $this->response->setStatusCode(200)->setBody('Upload Successfully');
		}else{
			return $this->response->setStatusCode(401,$error);
		}
	
	}
	//-------------------------------------------------------------
	public function sim_assign_action(){
		$dataid = $this->input->getPost('dataid');
		$technician_id = $this->input->getPost('technician_id');
		//
		if(!isLoggedIn()){
			$error = 'Session Timeout';
		}if(empty($dataid) || empty($technician_id)){
			$error = 'Please select SIM & Engineer';
		}
		if(!access_crud('SIM','update')){
			$error = 'Access denied';
		}	
		//
		if(empty($error)){
			$this->db->table('sim')->where('id',$dataid)->update(['user_id' => $technician_id, 'status' => 'assigned', 'assign_on' => date('Y-m-d H:i:s') ]);
			//
			$modelNoti = new Model_Notification();
			$modelNoti->set_notification('SIM Assigned','One SIM has been assigned to you',[$technician_id]);
			//
			return $this->response->setStatusCode(200)->setBody('Updated Successfully');
		}else{
			return $this->response->setStatusCode(401,$error);
		}
	}
	//--------------------------------------------------------------
	public function assign_bulk_sim(){
		$error = null;
		$simIDList = $this->input->getPost('simIDList');
		$simIDList = explode(',',$simIDList);
		$engineer_id = $this->input->getPost('engineer_id');
		if(!isLoggedIn()){
			$error = 'Session Timeout';
		}if(empty($simIDList) || empty($engineer_id)){
			$error = 'Please select SIM & Engineer';
		}
		if(!access_crud('SIM','update')){
			$error = 'Access denied';
		}
		//
		if(empty($error)){
			//
			foreach($simIDList as $value){
				$this->db->table('sim')->where('id',$value)->update(['user_id' => $engineer_id, 'status' => 'assigned', 'assign_on' => date('Y-m-d H:i:s')]);	
			}
			// //
			$modelNoti = new Model_Notification();
			$modelNoti->set_notification('SIM Assigned', count($simIDList).' SIM have been assigned to you',[$engineer_id]);
			//
			return $this->response->setStatusCode(200)->setBody('Assigned Successfully');
		}else{
			return $this->response->setStatusCode(401,$error);
		}
	}
	//---------------------------------------------------------
	public function delete_sim_action(){
		$error = null;
		$id = $this->input->getPost('id');
		if(!isLoggedIn()){
			$error = 'Session Timeout';
		}if(empty($id)){
			$error = 'Please select SIM';
		}
		if(!access_crud('SIM','delete')){
			$error = 'Access denied';
		}
		//
		$modelGeneral = new Model_General();
		$checkStatus = $modelGeneral->get_sim($id,null,null,'in stock')->countAllResults();
		if($checkStatus <= 0){
			$error = 'Error : This can not be deleted';		
		}
		//
		if(empty($error)){
			//
			$this->db->table('sim')->where('id',$id)->where('status','in stock')->delete();
			//
			create_action_log('id#'.$id);
			return $this->response->setStatusCode(200)->setBody('Delete Successfully');
		}else{
			return $this->response->setStatusCode(401,$error);
		}
	}

	//
	public function gateway_return_action(){
		$error = null;
		$id = session()->get('id');
		$gateway_id = $this->input->getPost('gateway_id');
		if(!isLoggedIn()){
			$error = 'Session Timeout';
		}if(!access_crud('Gateway','update')){
			$error = 'Access denied';
		}
		if(empty($error)){
			$modelGeneral = new Model_General();
			$checkStatus = $modelGeneral->get_gateway($gateway_id,null,$id,'assigned')->countAllResults();
			if($checkStatus <= 0){
				$error = 'Error : This can not be returned';
			}
		}
		//
		if(empty($error)){
			//
			$this->db->table('gateway')->where('id',$gateway_id)->where('assign_to',$id)->where('status','assigned')->update(['status' => 'return']);
			// //
			create_action_log('id#'.$gateway_id);
			return $this->response->setStatusCode(200)->setBody('Returned Successfully');
		}else{
			return $this->response->setStatusCode(401,$error);
		}
	}
	//
	public function bulk_gateway_changeStatus(){
		$error = null;
		$gatewayIDList = $this->input->getPost('gatewayIDList');
		$gatewayIDList = explode(',',$gatewayIDList);
		$status = $this->input->getPost('status');
		if(!isLoggedIn()){
			$error = 'Session Timeout';
		}if(!access_crud('Gateway','update')){
			$error = 'Access denied';
		}if(empty($gatewayIDList) || empty($status)){
			$error = 'Please select Gateway & Status';
		}
		//
		if(empty($error)){
			//
			foreach($gatewayIDList as $value){
				$this->db->table('gateway')->where('id',$value)->update(['status' => $status]);	
			}
			//
			return $this->response->setStatusCode(200)->setBody('Changed Successfully');
		}else{
			return $this->response->setStatusCode(401,$error);
		}
	}
	/////

	//
	public function sim_return_action(){
		$error = null;
		$id = session()->get('id');
		$sim_id = $this->input->getPost('sim_id');
		if(!isLoggedIn()){
			$error = 'Session Timeout';
		}if(!access_crud('SIM','update')){
			$error = 'Access denied';
		}
		if(empty($error)){
			$modelGeneral = new Model_General();
			$checkStatus = $modelGeneral->get_sim($sim_id,null,$id,'assigned')->countAllResults();

			if($checkStatus <= 0){
				$error = 'Error : This can not be returned';
			}
		}
		//
		if(empty($error)){
			//
			$this->db->table('sim')->where('id',$sim_id)->where('user_id',$id)->where('status','assigned')->update(['status' => 'return']);
			// //
			create_action_log('id#'.$sim_id);
			return $this->response->setStatusCode(200)->setBody('Returned Successfully');
		}else{
			return $this->response->setStatusCode(401,$error);
		}
	}
	//
	//
	public function bulk_sim_changeStatus(){
		$error = null;
		$simIDList = $this->input->getPost('simIDList');
		$simIDList = explode(',',$simIDList);
		$status = $this->input->getPost('status');
		if(!isLoggedIn()){
			$error = 'Session Timeout';
		}if(!access_crud('SIM','update')){
			$error = 'Access denied';
		}if(empty($simIDList) || empty($status)){
			$error = 'Please select SIM & Status';
		}
		//
		if(empty($error)){
			//
			foreach($simIDList as $value){
			$this->db->table('sim')->where('id',$value)->update(['status' => $status,'user_id' => null]);	
			}
			//
			return $this->response->setStatusCode(200)->setBody('Changed Successfully');
		}else{
			return $this->response->setStatusCode(401,$error);
		}
	}


	
}
