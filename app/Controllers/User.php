<?php

namespace App\Controllers;
use App\Models\Model_Users;
use App\Models\Model_General;

class User extends BaseController
{
	public function __construct(){

		parent::__construct();
		$this->db = \Config\Database::connect();
		$this->input = \Config\Services::request();
	}
	//
	public function index()
	{
		$sess_status = session()->get('status');
		if(isLoggedIn() && $sess_status == 'admin' && access_crud('User List','view')){
			return view('cpanel/userlist');
		}else{
			return redirect()->to(base_url('login'));
		}
	}
	//
	public function show_users(){
		$sess_status = session()->get('status');
		if(isLoggedIn() && $sess_status == 'admin'){

			$userModel = new Model_Users();
			$query=$userModel->get_users(null,null,null,['admin','manager','controller','technician','engineer','driver','technician','back office','trainee']);
		//
			$ser=0;
			foreach ($query->get()->getResult() as $value) {
				$user=$value->username;
				$fname=$value->firstname;
				$lname=$value->lastname;
				$password=$value->password;
				$email=$value->email;
				$mobilephone=$value->mobilephone;
				$status=$value->status;
				$id=$value->id;
                  //
				$ser++;
				$deletemodal="$('#deleteModel').modal('show');document.getElementById('duserid').value=";
				if($value->block == 'no'){
					$activetxt = 'Active'; $class = 'success';  
				}else{
					$activetxt = 'Block'; $class = 'danger';
				}
				?>
				<tr>
					<td><?php echo $ser;?></td>
					<td><?php echo $user;?></td>
					<td><?php echo $fname.' '.$lname;?></td>
					<!-- <td><?php echo $lname;?></td> -->
					<td><?php echo $email;?></td>
					<td><?php echo $mobilephone;?></td>
					<td><?php echo $value->unique_id;?></td>
					<td><span class="badge badge-soft-warning"><?php echo $status;?></span></td>
					<td><span class="badge badge-soft-<?php echo $class;?>"><?php echo $activetxt;?></span></td>
					<td>
						<div class="btn-group">
							<a type="button" class="btn btn-primary btn-sm updUserBtn" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" data-userid="<?php echo $id;?>"><i class="fa fa-edit"></i></a>
							<a type="button" class="btn btn-danger btn-sm delUserBtn" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" data-userid="<?php echo $id;?>"><i class="fa fa-trash-alt"></i></a>
							<a href="<?= base_url();?>/user/allow-access/<?= $id;?>" class="btn btn-secondary btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Allow Access"><i class="fa fa-lock"></i></a>
						</div>
					</td>
				</tr>
			<?php } 
		}
	}
	//
	public function update_form(){
		$request = \Config\Services::request();
		$userid=$request->getPost('userid');
		// 
		$userModel = new Model_Users();
		$value=$userModel->get_users($userid)->get()->getRow();
		// 
		$fnames= $value->firstname;
		$lnames=$value->lastname;
		$mails= $value->email;
		$nics= $value->nic;
		$password= $value->password;
		$password=md5($password);
		$mobiles= $value->mobilephone;
		$usernames= $value->username;
		$address= $value->address;
		$status= $value->status;
		$block = $value->block;
		$extension = $value->extension;
		?>
		<input type="hidden" name="userid" value="<?php echo $userid;?>">


		<div class="col-md-12">
			<div class="row">
				<div class="col-md-6 col-xs-12">
					<div class="form-group">
						<label for="exampleFormControlInput1">Full Name</label>
						<input type="text" class="form-control" name="f_name" id="exampleFormControlInput1" required="" value="<?= $fnames;?>" >
					</div>
				</div>
				<!-- <div class="col-md-6 col-xs-12">
					<div class="form-group">
						<label for="exampleFormControlInput1">Lastname</label>
						<input type="text" class="form-control" name="l_name" id="exampleFormControlInput1" required="" value="<?= $lnames;?>">
					</div>
				</div> -->
				<div class="col-md-6 col-xs-12">
					<div class="form-group">
						<label for="exampleFormControlInput1">Unique ID</label>
						<input type="text" class="form-control" name="uniq_id" id="exampleFormControlInput1" required="" value="<?= $value->unique_id;?>">
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-6 col-xs-12">
					<div class="form-group">
						<label for="exampleFormControlInput1">Email</label>
						<input type="email" class="form-control" name="email" id="exampleFormControlInput1" required="" value="<?= $mails;?>">
					</div>
				</div>
				<div class="col-md-6 col-xs-12">
					<div class="form-group">
						<label for="exampleFormControlInput1">Mobile#</label>
						<input type="text" class="form-control" name="mobile" id="exampleFormControlInput1" required="" value="<?= $mobiles;?>">
					</div>
				</div>
				<!-- <div class="col-md-6 col-xs-12">
					<div class="form-group">
						<label for="exampleFormControlInput1">CNIC</label>
						<input type="text" class="form-control" name="nic" id="exampleFormControlInput1" required="" value="<?= $nics;?>">
					</div>
				</div> -->
			</div>
		</div>
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-6 col-xs-12">
					<div class="form-group">
						<label for="exampleFormControlInput1">Username</label>
						<input type="text" class="form-control" name="username" id="exampleFormControlInput1" required="" value="<?= $usernames;?>">
					</div>
				</div>
				<div class="col-md-6 col-xs-12">
					<div class="form-group">
						<label for="exampleFormControlInput1">Password</label>
						<input type="password" class="form-control" name="password" id="exampleFormControlInput1"  >
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group"> 
						<label>Staff Cost</label>
						<input type="number" name="staffCost" class="form-control" value="<?= $value->staff_cost;?>">
					</div>
				</div>
				<div class="col-md-6">
					<!-- <div class="form-group"> -->
						<?php 
						if($block == 'yes'){
							$check = 'checked';
						}else{ $check = null; }
						?>
						<label for="exampleFormControlInput1">Block Account</label>
						<div>
							<input type="hidden" name="block" value="no">
							<input type="checkbox" name="block" class="switchBtn" id="switch8" switch="danger" value="yes" <?= $check;?>/>
							<label for="switch8" data-on-label="Yes" data-off-label="No"></label>
						</div>
						<!-- </div> -->
					</div>

				</div>
			</div>
			<!-- <div class="col-md-12">
				<div class="row">
					<div class="col-md-6 col-xs-12">
						<div class="form-group">
							<label for="exampleFormControlInput1">Unique ID</label>
							<input type="text" class="form-control" name="uniq_id" id="exampleFormControlInput1" required="" value="<?= $value->unique_id;?>">
						</div>
					</div>
				</div>
			</div> -->

			<?php

		}
		//
		public function update_user(){
			$sess_status = session()->get('status');
			$error = null;
			if(isLoggedIn() && $sess_status == 'admin'){
			//
				$request = \Config\Services::request();
				$validation =  \Config\Services::validation();

				$validate = $this->validate([
					'f_name' => 'trim|required',
					// 'l_name' => 'trim|required',
					'email' => 'trim|required|valid_email',
					// 'nic' => 'trim|required',
					'username' => 'trim|required',
					'mobile' => 'trim|required|integer|min_length[10]|max_length[10]',
					'uniq_id' => 'trim|required'
				]);
				$extension = $request->getPost('extension');
				if(!empty($extension)){
					$validate = $this->validate([
						'extension' => 'trim|integer',
					]);
				} 
				if(!$validate){
					$error = $validation->listErrors();
				}
				//
				$userdata = $this->db->table('bo_users')->where('username',$request->getPost('username'))->where('id !=',$request->getPost('userid'))->get()->getRow();
				if(!empty($userdata)){
					$error = "Error : Username already exist";
				}
				//
				$uniqIdExist = $this->db->table('bo_users')->where('unique_id',$request->getPost('uniq_id'))->where('id !=',$request->getPost('userid'))->get()->getRow();
				if(!empty($uniqIdExist)){
					$error = "Error : Unique ID already exist";
				}
				//
				if(empty($error)){
					$this->db->transStart();
					//
					$userid = $request->getPost('userid');
					$fname= $request->getPost('f_name');
					$lname= $request->getPost('l_name');
					$mail= $request->getPost('email');
					$nic= $request->getPost('nic');
					$access = $request->getPost('block');
					$extension = $request->getPost('extension');
					$staffCost = $request->getPost('staffCost');	
					$uniq_id = $request->getPost('uniq_id');	
					// 
					$new_pass= $request->getPost('password');
					if(!empty($new_pass)){
						$pass_md5=md5($new_pass);
					}
		// 
					$mobile= $request->getPost('mobile');
					$username= $request->getPost('username');
					$address= $request->getPost('address');

					if(!empty($new_pass)){
						$data= [
							'firstname'=> $fname,
							'lastname'=>$lname,
							'username'=>$username,
							'password'=>$pass_md5,
							'pass_string'=>$new_pass,
							'email'=>$mail,
							'nic'=>$nic,
							'mobilephone'=>$mobile,
							'address'=>$address,
							'block' => $access,
							'extension'=> $extension,
							'staff_cost' => $staffCost,
							'unique_id' => $uniq_id
						];
					}else{
						$data= [
							'firstname'=> $fname,
							'lastname'=>$lname,
							'username'=>$username,
							'email'=>$mail,
							'nic'=>$nic,
							'mobilephone'=>$mobile,
							'address'=>$address,
							'block' => $access,
							'extension'=> $extension,
							'staff_cost' => $staffCost,
							'unique_id' => $uniq_id
						];
					}
					$db = \Config\Database::connect();
		//
					$builder = $db->table('bo_users');
					$builder->where('id',$userid);
					$builder->update($data);
					//
					// from helper
					create_action_log('user id '.$userid); 
					echo 'Success : User Updated Successfuly';
					//
					$this->db->transComplete();
				}else{
					echo 'Error : '.$error;
				}
			}
		}
	//
		public function add_user(){
			$sess_status = session()->get('status');
			if(isLoggedIn() && $sess_status == 'admin'){
			//
				$request = \Config\Services::request();
				$db = \Config\Database::connect();
		//
				$error = null;
				$fname= $request->getPost('f_name');
				$lname= $request->getPost('l_name');
				$mail= $request->getPost('email');
				$nic= $request->getPost('nic');
				$password= $request->getPost('password');
				$pass=md5($password);
				$mobile= $request->getPost('mobile');
				$username= $request->getPost('username');
				$address= $request->getPost('address');
				$status= $request->getPost('status');
				$staffCost= $request->getPost('staffCost');
				$uniq_id= $request->getPost('uniq_id');
				$extension= NULL;
		//
				$validation =  \Config\Services::validation();
			//
				$validate = $this->validate([
					'f_name' => 'trim|required',
					// 'l_name' => 'trim|required',
					'email' => 'trim|required|valid_email',
					// 'nic' => 'trim|required',
					'password' => 'trim|required|min_length[5]',
					'mobile' => 'trim|required|min_length[10]|max_length[10]',
					'username' => 'trim|required',
					'uniq_id' => 'trim|required',
					'status' => 'trim|required',
				]);
				if(!empty($extension)){
					$validate = $this->validate([
						'extension' => 'trim|integer',
					]);
				} 
				if(!$validate){
					$error = $validation->listErrors();
				}
			//
				$userModel = new Model_Users();
				$userdata = $userModel->get_users(null,$username)->get()->getRow();
				if(!empty($userdata)){
					$error = "Error : Username already exist";
				}
				//
				$uniqIdExist = $userModel->get_users(null,null,null,null,null,null,$uniq_id)->get()->getRow();
				if(!empty($uniqIdExist)){
					$error = "Error : Unique ID already exist";
				}
				//
				if(empty($error)){
					$this->db->transStart();
					$data= array(
						'firstname'=> $fname,
						'lastname'=>$lname,
						'username'=>$username,
						'password'=>$pass,
						'pass_string'=>$password,
						'email'=>$mail,
						'nic'=> NULL,
						'mobilephone'=>$mobile,
						'address'=> NULL,
						'status'=> $status,
						'extension' => $extension,
						'staff_cost' => $staffCost,
						'unique_id' => $uniq_id,
					);
		//
					$builder = $db->table('bo_users');
					$builder->insert($data);
					//
					$insert_id = $this->db->insertID();
				//
					$modelUser = new Model_Users();
					$submenu_list = $modelUser->submenu_list();

					foreach ($submenu_list->get()->getResult() as $key => $value) {
						$data=['id' => $insert_id , 'menu_id' => $value->menu_id, 'sub_menu_id' => $value->id];
						$builder = $db->table('bo_crud_access');
						$builder->insert($data);
					}
					//
					// if($status == 'controller' || $status == 'admin'){
					// 	$allow = [41,40,36,34,9];
					// }elseif($status == 'engineer'){
					// 	$allow = [39];
					// }
					// //
					// $this->db->table('bo_crud_access')->whereIn('sub_menu_id',$allow)->where('id',$insert_id)->update(['view' => 1,'create' => 1,'update' => 1,'delete' => 1]);

		// 
					create_action_log('user id '.$insert_id); 
					echo "Success : User Added Successfuly";
					$this->db->transComplete();
				}else{
					echo $error;
				}
			}
		}
		//
		public function delete_user(){

			$sess_status = session()->get('status');
			if(isLoggedIn() && $sess_status == 'admin'){
			//
				$request = \Config\Services::request();
				$id = $request->getPost('id');
				if(!empty($id)){
			//
					$db = \Config\Database::connect();
			 //
					$userModel = new Model_Users();
			//
					$this->db->transStart();
				//
					$builder = $db->table('bo_users');
					$builder->where('id',$id);
					$builder->delete();
				//
					$builder = $db->table('bo_crud_access');
					$builder->where('id',$id);
					$builder->delete();
				//
					create_action_log('user id '.$id);
			//
					echo "User Deleted Successfuly";
					$this->db->transComplete();
				}
			}
		}
	//
		public function user_access(){
			//
			$sess_status = session()->get('status');
			if(isLoggedIn() && $sess_status == 'admin' && access_crud('User Access','view')){
				$data['modelUser'] = new Model_Users();
				$query=$data['modelUser']->get_users(null,null,null,['admin','manager','controller','technician','engineer','back office','trainee']);
				$data['data1']=$query;
				//
				// $data['data2']=$data['modelUser']->submenu_list();
				//
				return view('cpanel/user_access',$data);
			}else {
				return redirect()->to(base_url('login'));
			}

		}
		//
		public function user_allow_access(){
			//
			$sess_status = session()->get('status');
			$uri = new \CodeIgniter\HTTP\URI(current_url());
			$data['id'] = $uri->getSegment(3);
			$data['modelUser'] = new Model_Users();
			$userExist = $data['modelUser']->get_users($data['id'])->countAllResults();
			//
			if(isLoggedIn() && $sess_status == 'admin' && access_crud('User Access','view') && $userExist > 0){
				$data['userInfo'] = $data['modelUser']->get_users($data['id'])->get()->getRow();
				//
				$data['data2']=$data['modelUser']->submenu_list();
				//
				return view('cpanel/user_allow_access',$data);
			}else {
				return redirect()->to(base_url('login'));
			}

		}
	//
		public function crud_flip(){
			$request = \Config\Services::request();
		//
			$module = $request->getPost('module');
			$id = $request->getPost('user');
			$oper = $request->getPost('operation');
		// 
			$modelUser = new Model_Users();
			$row = $modelUser->crud_detail($module,$id)->getRow();
		//
			$value=$row->$oper;
		// 
			if($value==1){
				$access=0;
			}else{
				$access=1;
			}
		// 
			$data= [$oper => $access];
		//
			$db = \Config\Database::connect();
		//
			$builder = $db->table('bo_crud_access');
			$builder->where('sub_menu_id',$module);
			$builder->where('id',$id);
			$builder->update($data);
		//
			create_action_log('user id '.$id .' '.$module.' '.$access.' '.$oper);  
		}
	//
		public function user_profile(){
			if(isLoggedIn()){
				$id = session()->get('id');
				$modelUser = new Model_Users();
				$data['info']=$modelUser->get_users($id)->get()->getRow();
				return view('cpanel/user_profile',$data);
			}else {
				return redirect()->to(base_url('login'));
			}
		}
		//
		public function update_profile(){
				//
			$error = null;
			$id= $this->input->getPost('id');
			$mobile= $this->input->getPost('mobile');
			$address= $this->input->getPost('address');
		//
			$validation =  \Config\Services::validation();
			//
			$validate = $this->validate([
				'mobile' => 'trim|required|min_length[10]|max_length[11]',
				// 'address' => 'trim|required',
			]);
			if(!$validate){
				$error = $validation->listErrors();
				$error = str_replace(array("\n", "\r"), '', $error);
				$error =  nl2br($error);
			}
			if(!isLoggedIn()){
				$error = 'Session Timeout';
			}
				//
			if(empty($error)){
				$this->db->transStart();
				$this->db->table('bo_users')->where('id',$id)->update(['mobilephone' => $mobile, 'address' => $address]);
				return $this->response->setStatusCode(200)->setBody('Update Successfully');
				create_action_log('id '.$id);  
				$this->db->transComplete();
			}else{
				return $this->response->setStatusCode(401,$error);
			}
		}
		//
		public function change_password(){
			if(isLoggedIn()){
				$error = null;
				$id= $this->input->getPost('id');
				$old= $this->input->getPost('old');
				$new= $this->input->getPost('new');
				$confirm= $this->input->getPost('confirm');
		//
				$validation =  \Config\Services::validation();
			//
				$validate = $this->validate([
					'old' => ['label' => 'Old Password', 'rules' => 'trim|required'],
					'new' => ['label' => 'New Password', 'rules' => 'trim|required|min_length[5]'],
					'confirm' => ['label' => 'Confirm Password', 'rules' => 'trim|required|matches[new]'],
				]);
				if(!$validate){
					$error = $validation->listErrors();
				}
				if(empty($error)){
					$modelUser = new Model_Users();
					$oldpass=$modelUser->get_users($id)->get()->getRow()->pass_string;
					if($oldpass != $old){
						$error = 'Error : Invalid Old Password';
					}
				}
				if(empty($error)){
					$this->db->transStart();
					//
					$this->db->table('bo_users')->where('id',$id)->update(['password' => md5($new), 'pass_string' => $new]);
					echo 'Success : Password Changed Successfuly';
					create_action_log('id '.$id);  
					$this->db->transComplete();
				}else{
					echo $error;
				}
			}else {
				echo 'Error : Some thing went wrong';
			}
		}

		///////////////////////
		public function global_user_list(){
			$userModel = new Model_Users();
			$query = $userModel->get_users(null,null,null,['admin','controller','technician','engineer','driver']);
			return (json_encode($query->get()->getResult()));
		}
		//////////////////////
		public function user_upload_csv_action(){
			$error = null;
			$userModel = new Model_Users();
			$status = $this->input->getPost('status');
			$csv = $_FILES['file']['tmp_name'];
			if(!isLoggedIn()){
				$error = 'Error : Session expired';
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
				}if(empty($status)){
					$error = 'Please select status first';
				}
			}
		//
			if(empty($error)){
				$handle = fopen($csv,"r");
				$num = 0;
				while (($row = fgetcsv($handle, 10000, ",")) != FALSE) 
				{
					if($num > 0){
						//
						$userdata = $userModel->get_users(null,$row[0])->get()->getRow();
						if(!empty($userdata)){
							$error = "Error : Username already exist at line#".$num;
							break;
						}
						//
						$uniqIdExist = $userModel->get_users(null,null,null,null,null,null,$row[6])->get()->getRow();
						if(!empty($uniqIdExist)){
							$error = "Error : Unique ID already exist at line#".$num;
							break;
						}
						//
						if(empty($row[0]) || empty($row[1]) || empty($row[2]) || empty($row[3]) || empty($row[4]) || empty($row[5]) || empty($row[6])  ){
							$error = "Error : Cell can not be empty at line#".$num;
							break;
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
				while (($row = fgetcsv($handle, 10000, ",")) != FALSE) 
				{
					if($num > 0){
					//
						$this->db->transStart();
						$data= array(
							'firstname'=> str_replace($remove,'',$row[2]),
							// 'lastname'=> str_replace($remove,'',$row[3]),
							'username'=> str_replace($remove,'',$row[0]),
							'password'=> md5($row[1]),
							'pass_string'=> $row[1],
							'email'=> str_replace($remove,'',$row[3]),
							'mobilephone'=> str_replace($remove,'',$row[4]),
							'status'=> $status,
							'staff_cost' => str_replace($remove,'',$row[5]),
							'unique_id' => str_replace($remove,'',$row[6]),
						);
					//
						$builder = $this->db->table('bo_users');
						$builder->insert($data);
					//
						$insert_id = $this->db->insertID();
					//
						$submenu_list = $userModel->submenu_list();
					//
						foreach ($submenu_list->get()->getResult() as $key => $value) {
							$data=['id' => $insert_id , 'menu_id' => $value->menu_id, 'sub_menu_id' => $value->id];
							$builder = $this->db->table('bo_crud_access');
							$builder->insert($data);
						}
					//
						create_action_log('user id '.$insert_id);
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


	}
