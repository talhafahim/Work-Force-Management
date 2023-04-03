<?php

namespace App\Controllers;
use App\Models\Model_Home;
class Site_Home extends BaseController
{
	public function __construct(){

		parent::__construct();
		$this->db = \Config\Database::connect();
		$this->input = \Config\Services::request();
		
		helper('form');
		helper('url');
		helper('file');
		// $this->load->helper('form');
    	// $this->load->helper('url');
	}
	public function index()
	{
		
		return view('site/index');
		// echo 'Welcome to Site';
	}
	public function packages()
	{
		return view('site/packages');
	}
	public function login()
	{
		return view('site/login');
	}
	public function register()
	{
		return view('site/signup');
	}
	//
	public function slider()
	{
		$sess_status = session()->get('status');
		if(isLoggedIn()){
			$sliderModel = new Model_Home();
			$query=$sliderModel->get_slider();
			$data['slider'] = $query->getResult();
			
			return view('cpanel/site_slider', $data);


		}else{
			return redirect()->to(base_url('login'));
		}
	}

	// ****** PAYMENT OPTION ON HOME PAGE ******* //
	public function payment()
	{
		$sess_status = session()->get('status');
		if(isLoggedIn()){
			$paymentModel = new Model_Home();
			$query=$paymentModel->get_payment_method();
			$data['method'] = $query->getResult();
			// var_dump($data['method']);
			return view('cpanel/site_payment', $data);


		}else{
			return redirect()->to(base_url('login'));
		}
	}
// ****** SERVICE REQUEST FORM ON HOME PAGE ******* //
	public function contact()
	{
		$sess_status = session()->get('status');
		if(isLoggedIn()){
			$homeModel = new Model_Home();
			$query=$homeModel->get_contact_detail();
			$data['contact'] = $query->getResult();
			// var_dump($data['method']);
			return view('cpanel/site_contact_form', $data);


		}else{
			return redirect()->to(base_url('login'));
		}
	}
// ****** USER QUERY FORM ON CONTACT PAGE ******* //
	public function query_form()
	{
		$sess_status = session()->get('status');
		if(isLoggedIn()){
			$homeModel = new Model_Home();
			$query=$homeModel->get_all_queries();
			$data['contact'] = $query->getResult();
			// var_dump($data['method']);
			return view('cpanel/site_query_form', $data);


		}else{
			return redirect()->to(base_url('login'));
		}
	}
	public function create_slider()
	{
		if(isLoggedIn()){
			$error = null;
			$title = $this->input->getPost('title');
			$slogan = $this->input->getPost('slogan');
			$image = $this->input->getFile('image');

			$validation =  \Config\Services::validation();
			$validate = $this->validate([
				'title' => ['label' => 'Title', 'rules' => 'required'],
				'slogan' => ['label' => 'Slogan', 'rules' => 'required'],
				// 'img' => ['uploaded[image]'],

			]);
			if (empty($_FILES['image']['name'])){
				$error = 'Please select the image';
			}
			if (!empty($_FILES['image']['name'])){
				$validate = $this->validate([
					'image' => [
						'uploaded[image]',
						'mime_in[image,image/jpg,image/jpeg,image/gif,image/png]',
						'max_size[image,4096]',
					],
				]);
			}
			if(!$validate){
				$error = $validation->listErrors();
			}
			if(empty($error)){
				
				// die();
				$this->db->transStart();
				$data= array(
					'title' => $title,
					'slogan' => $slogan
					// 'img' => $image
				);

				$this->db->table('bo_site_slider')->insert($data);
				$insert_id = $this->db->insertID();

				$image_name = 'slider'.$insert_id.'.png';
				$image_data= [
					'img'=>$image_name
				];
				$db = \Config\Database::connect();
				$builder = $db->table('bo_site_slider');
				$builder->where('id',$insert_id);
				$builder->update($image_data);

				$image->move('./uploads/','slider'.$insert_id.'.png');
				echo 'Success: Added Successfully';
				$this->db->transComplete();
			}else{
				echo $error;
			}


		}else{
			return redirect()->to(base_url('login'));
		}
	}

	public function show_slider(){
		$sess_status = session()->get('status');
		if(isLoggedIn() && $sess_status == 'admin'){

			$sliderModel = new Model_Home();
			$query=$sliderModel->get_slider();
			$data = $query->getResult();
			// echo json_encode($data); 
			// var_dump($data);

		}
	}

	 
	public function edit_form(){
		// $request = \Config\Services::request();
		$sliderid=$this->input->getPost('sliderid');
		//$this->input

		$sliderModel = new Model_Home();
		$value=$sliderModel->get_slider($sliderid)->getRow();

		echo json_encode($value);
		// $userModel = new Model_Home();
		// $value=$userModel->get_slider($sliderid)->getRow();
		// 
		$title= $value->title;
		$slogan=$value->slogan;
		$image= $value->img;
		$status= $value->status;


		?>
		
		<?php
	}


		public function update_slider(){
			$sess_status = session()->get('status');
			$error = null;
			if(isLoggedIn() && $sess_status == 'admin'){
			//
				$request = \Config\Services::request();
				$validation =  \Config\Services::validation();

				$validate = $this->validate([
					'title' => ['label' => 'Title', 'rules' => 'required'],
					'slogan' => ['label' => 'Slogan', 'rules' => 'required'],
				]);
				if (!empty($_FILES['image']['name'])){
					$validate = $this->validate([
						'image' => [
							'uploaded[image]',
							'mime_in[image,image/jpg,image/jpeg,image/gif,image/png]',
							'max_size[image,4096]',
						],
					]);
				}
				if(!$validate){
					$error = $validation->listErrors();
				}
		//
				if(empty($error)){
					$this->db->transStart();
					//
					$title = $this->input->getPost('title');
					$slogan = $this->input->getPost('slogan');
					// $slider_img = $this->input->getFile('image');
					 $sliderid=$this->input->getPost('sliderid');
					// die();
					$data= [
						'title'=> $title,
						'slogan'=>$slogan
						// 'img'=>$slider_img
					];
					if (!empty($_FILES['image']['name'])){
						$slider_img = $this->input->getFile('image');
						$data = ['img'=>$slider_img];
					}
					$db = \Config\Database::connect();
		//
					$builder = $db->table('bo_site_slider');
					$builder->where('id',$sliderid);
					$builder->update($data);

					if (!empty($_FILES['image']['name'])){
						if(file_exists('./uploads/slider'.$sliderid.'.png')){
							unlink('./uploads/slider'.$sliderid.'.png');
						}
						$slider_img->move('./uploads/','slider'.$sliderid.'.png');
					}
					
		// from helper
					create_action_log('slider id '.$sliderid); 
					echo 'Success : Slider Updated Successfuly';
					//
					$db->transComplete();
					// $this->db->transComplete();
				}else{
					echo 'Error : '.$error;
				}
			}
		}

		//
		public function delete_slider(){

			$sess_status = session()->get('status');
			if(isLoggedIn() && $sess_status == 'admin'){
			//
				$request = \Config\Services::request();
				$id = $request->getPost('id');
				if(!empty($id)){
			
					$db = \Config\Database::connect();
			 
					$sliderModel = new Model_Home();
			
					$this->db->transStart();
				
					$builder = $db->table('bo_site_slider');
					$builder->where('id',$id);
					$builder->delete();

					if(file_exists('./uploads/slider'.$id .'.png')){
						unlink('./uploads/slider'.$id .'.png');
					}
					create_action_log('slider id '.$id);
					echo "Slider Deleted Successfuly";
					$this->db->transComplete();
				}
			}
		}
	//

	// ********* PAYMENT METHOD **********

	public function create_payment()
	{
		if(isLoggedIn()){
			$error = null;
			$title = $this->input->getPost('title');
			$description = $this->input->getPost('description');
			$image = $this->input->getFile('image');

			$validation =  \Config\Services::validation();
			$validate = $this->validate([
				'title' => ['label' => 'Title', 'rules' => 'required'],
				'description' => ['label' => 'description', 'rules' => 'required'],

			]);
			if (empty($_FILES['image']['name'])){
				$error = 'Please select the image';
			}
			if (!empty($_FILES['image']['name'])){
				$validate = $this->validate([
					'image' => [
						'uploaded[image]',
						'mime_in[image,image/jpg,image/jpeg,image/gif,image/png]',
						'max_size[image,4096]',
					],
				]);
			}
			if(!$validate){
				$error = $validation->listErrors();
			}
			if(empty($error)){
				$this->db->transStart();
				$data= array(
					'title' => $title,
					'description' => $description
					// 'img' => $image
				);
				$this->db->table('bo_site_payment_method')->insert($data);
				$insert_id = $this->db->insertID();
				// upate image name
				$image_name = 'payment'.$insert_id.'.png';
				$image_data = [
					'img'=>$image_name
				];
				$db = \Config\Database::connect();
				$builder = $db->table('bo_site_payment_method');
				$builder->where('id',$insert_id);
				$builder->update($image_data);

				$image->move('./uploads/payment/','payment'.$insert_id.'.png');
				echo 'Success: Added Successfully';
				$this->db->transComplete();
			}else{
				echo $error;
			}


		}else{
			return redirect()->to(base_url('login'));
		}
	}

	public function show_payment(){
		$sess_status = session()->get('status');
		if(isLoggedIn() && $sess_status == 'admin'){
			$sliderModel = new Model_Home();
			$query=$sliderModel->get_payment_method();
			$data = $query->getResult();
			// echo json_encode($data); 
		}
	}

	//  ****** EDIT PAYMENT ******
	public function edit_payment(){
		$id = $this->input->getPost('paymentid');
		$homeModel = new Model_Home();
		$query=$homeModel->get_payment_method($id)->getRow();
		echo json_encode($query); 

	}
	// ****** UPDATE PAYMENT ******* 

	public function update_payment(){
		$sess_status = session()->get('status');
		$error = null;
		if(isLoggedIn() && $sess_status == 'admin'){
			$request = \Config\Services::request();
			$validation =  \Config\Services::validation();

			$validate = $this->validate([
				'title' => ['label' => 'Title', 'rules' => 'required'],
				'description' => ['label' => 'description', 'rules' => 'required'],
			]);
			if (!empty($_FILES['image']['name'])){
				$validate = $this->validate([
					'image' => [
						'uploaded[image]',
						'mime_in[image,image/jpg,image/jpeg,image/gif,image/png]',
						'max_size[image,4096]',
					],
				]);
			}
			if(!$validate){
				$error = $validation->listErrors();
			}
	//
			if(empty($error)){
				$this->db->transStart();
				//
				$title = $this->input->getPost('title');
				$description = $this->input->getPost('description');
				 $paymentid=$this->input->getPost('paymentid');
				$data= [
					'title'=> $title,
					'description'=>$description
				];
				if (!empty($_FILES['image']['name'])){
					$image = $this->input->getFile('image');
					$data = ['img'=>$image];
				}
				$db = \Config\Database::connect();
				$builder = $db->table('bo_site_payment_method');
				$builder->where('id',$paymentid);
				$builder->update($data);

				if (!empty($_FILES['image']['name'])){
					if(file_exists('./uploads/payment/payment'.$paymentid.'.png')){
						unlink('./uploads/payment/payment'.$paymentid.'.png');
					}
					$image->move('./uploads/payment/','payment'.$paymentid.'.png');
				}

				create_action_log('Payment id '.$paymentid); 
				echo 'Success : Payment Method Updated Successfuly';
				//
				$db->transComplete();
			}else{
				echo 'Error : '.$error;
			}
		}
	}
	//
	public function delete_payment(){

		$sess_status = session()->get('status');
		if(isLoggedIn() && $sess_status == 'admin'){
		//
			$request = \Config\Services::request();
			$id = $request->getPost('id');
			if(!empty($id)){
		
				$db = \Config\Database::connect();
		 
				$sliderModel = new Model_Home();
		
				$this->db->transStart();
			
				$builder = $db->table('bo_site_payment_method');
				$builder->where('id',$id);
				$builder->delete();

				if(file_exists('./uploads/payment/payment'.$id .'.png')){
					unlink('./uploads/payment/payment'.$id .'.png');
				}
				create_action_log('payment id '.$id);
				echo "Payment Method Deleted Successfuly";
				$this->db->transComplete();
			}
		}
	}
// ********* DELETE CONTACT FORM DETAIL ***************
	public function delete_form_detail(){

		$sess_status = session()->get('status');
		if(isLoggedIn() && $sess_status == 'admin'){
		//
			$request = \Config\Services::request();
			$id = $request->getPost('id');
			if(!empty($id)){
		
				$db = \Config\Database::connect();
		 		
				$this->db->transStart();
			
				$builder = $db->table('bo_site_contact_form');
				$builder->where('id',$id);
				$builder->delete();

				create_action_log('Contact form id '.$id);
				echo "Contact Detail Deleted Successfuly";
				$this->db->transComplete();
			}
		}
	}
	public function delete_query(){

		$sess_status = session()->get('status');
		if(isLoggedIn() && $sess_status == 'admin'){
		//
			$request = \Config\Services::request();
			$id = $request->getPost('id');
			if(!empty($id)){
		
				$db = \Config\Database::connect();
		 		
				$this->db->transStart();
			
				$builder = $db->table('bo_site_query_form');
				$builder->where('id',$id);
				$builder->delete();

				create_action_log('Query id '.$id);
				echo "Query Deleted Successfuly";
				$this->db->transComplete();
			}
		}
	}

	// ****** SWITCH BUTTON ******

	public function slider_flip(){
		$id = $this->input->getPost('id');

		$homeModel = new Model_Home();
		$query=$homeModel->get_slider($id)->getRow();
		$status = $query->status;

		if($status == 0){
			$status = 1;
		}
		else{
			$status = 0;
		}
		$data= [
			'status'=>$status
		];
		$db = \Config\Database::connect();
		$this->db->transStart();
		$builder = $db->table('bo_site_slider');
		$builder->where('id',$id);
		$builder->update($data);

		create_action_log('Status '.$id);
		echo "Status Updated Successfuly";
		$this->db->transComplete();
	}

	public function slider_flip_payment(){
		$id = $this->input->getPost('id');

		$homeModel = new Model_Home();
		$query=$homeModel->get_payment_method($id)->getRow();
		$status = $query->status;

		if($status == 0){
			$status = 1;
		}
		else{
			$status = 0;
		}
		$data= [
			'status'=>$status
		];
		$db = \Config\Database::connect();
		$this->db->transStart();
		$builder = $db->table('bo_site_payment_method');
		$builder->where('id',$id);
		$builder->update($data);

		create_action_log('Status '.$id);
		echo "Status Updated Successfuly";
		$this->db->transComplete();
	}
}