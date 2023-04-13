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
					<td><?php echo $fname;?></td>
					<td><?php echo $lname;?></td>
					<td><?php echo $email;?></td>
					<td><?php echo $mobilephone;?></td>
					<td><span class="badge badge-soft-primary"><?php echo $status;?></span></td>
					<td><span class="badge badge-soft-<?php echo $class;?>"><?php echo $activetxt;?></span></td>
					<td>
						<a href="javascript:void(0);" class="mr-3 text-primary updUserBtn" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" data-userid="<?php echo $id;?>"><i class="fa fa-edit"></i></a>
						<a href="javascript:void(0);" class="text-danger delUserBtn" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" data-userid="<?php echo $id;?>"><i class="fa fa-trash-alt"></i></a>
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
						<label for="exampleFormControlInput1">Firstname</label>
						<input type="text" class="form-control" name="f_name" id="exampleFormControlInput1" required="" value="<?= $fnames;?>" >
					</div>
				</div>
				<div class="col-md-6 col-xs-12">
					<div class="form-group">
						<label for="exampleFormControlInput1">Lastname</label>
						<input type="text" class="form-control" name="l_name" id="exampleFormControlInput1" required="" value="<?= $lnames;?>">
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
				
				<!-- <div class="col-md-6 col-xs-12">
					<div class="form-group">
						<label for="exampleFormControlInput1">Address</label>
						<input type="text" class="form-control" name="address" id="exampleFormControlInput1" required="" value="<?= $address;?>">
					</div>
				</div> -->
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
					'l_name' => 'trim|required',
					'email' => 'trim|required|valid_email',
					// 'nic' => 'trim|required',
					'username' => 'trim|required',
					'mobile' => 'trim|required|integer|min_length[10]|max_length[10]',
					// 'address' => 'trim|required'
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
							'staff_cost' => $staffCost
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
							'staff_cost' => $staffCost
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
				$extension= NULL;
		//
				$validation =  \Config\Services::validation();
			//
				$validate = $this->validate([
					'f_name' => 'trim|required',
					'l_name' => 'trim|required',
					'email' => 'trim|required|valid_email',
					// 'nic' => 'trim|required',
					'password' => 'trim|required|min_length[5]',
					'mobile' => 'trim|required|min_length[10]|max_length[10]',
					'username' => 'trim|required',
					// 'address' => 'trim|required',
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
						'staff_cost' => $staffCost
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
					'address' => 'trim|required',
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


	}
