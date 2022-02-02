<?php

namespace App\Controllers;
use App\Models\CustomerModel;
use App\Models\AdministratorModel;
use App\Models\ProductModel;
use App\Models\WishlistModel;

class GeneralUserController extends BaseController
{
	public function index()
	{
		//The home page for a non logged in user
		$data = [];
		helper(['form']);


		echo view('templates/header.php');
        echo view('index.php');
        echo view('templates/footer.php');
	}

	public function register(){
		$data = [];
		helper(['form']);
		//Check if the method used was post
		if($this->request->getMethod() == 'post')
		{
			//Specify validation rules
			$rules = [
				'companyName' => 'required|min_length[3]|max_length[50]',
				'firstname' => 'required|min_length[3]|max_length[50]',
				'lastname' => 'required|min_length[3]|max_length[50]',
				'phoneNumber' => 'required|regex_match[/^[0-9]{10}$/]',
				'address1' => 'required|min_length[3]|max_length[50]',
				'address2' => 'max_length[50]',
				'city' => 'required',
				'postalCode' => 'max_length[15]',
				'country' => 'required|min_length[3]|max_length[50]',
				'address1' => 'required|min_length[3]|max_length[50]',
				'email' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[customers.email]',
				'password' => 'required|min_length[3]|max_length[255]',
				'password_confirm' => 'matches[password]',
			];

			if($this->request->getVar('creditLimit')) {
				$rules['creditLimit'] = 'regex_match[/^\d+$/]';
			}
			//Check if validation specifications are met
			if(! $this->validate($rules)) {
				//if not, get the rules vialated and add them to the data array
				$data['validation'] = $this->validator;
			}
			else{
				//if rules are met, create user and store in database
				$model = new CustomerModel();
				//Create new customer$customer row stored as elements in array
				$newData = [
					'customerName' => $this->request->getVar('companyName'),
					'contactFirstName' => $this->request->getVar('firstname'),
					'contactLastName' => $this->request->getVar('lastname'),
					'phone' => $this->request->getVar('phoneNumber'),
					'addressLine1' => $this->request->getVar('address1'),
					'addressLine2' => $this->request->getVar('address2'),
					'city' => $this->request->getVar('city'),
					'postalCode' => $this->request->getVar('postalCode'),
					'country' => $this->request->getVar('country'),
					'creditLimit' => $this->request->getVar('creditLimit'),
					'email' => $this->request->getVar('email'),
					'password' => hash('md5',$this->request->getVar('password')),
				];
				//Add new customer$customer to database
				$model->save($newData);
				$session = session();
				//Set flash data to let user know registration was successful
				$session->setFlashdata('success','successful registration');
				//Redirect them to login now that registration was successful
				print_r($newData);
				//return redirect()->to('/login');
			}
		}
		//If the post method wasn't used, reload the page.
		echo view('templates/header', $data);
		echo view('register');
		echo view('templates/footer');
	}

	public function login(){
		$data = [];
		helper(['form']);
		helper(['cookie']);
		$session = session();
		//Object of each usertype is created
		//This is to check what type the user loggin in is
		$customerModel = new CustomerModel();
		$administratorModel = new AdministratorModel();

		//Check if post method was used
		if($this->request->getMethod() == 'post')
		{

			//Get the user's email and password 
				$baseuserEmail = $this->request->getVar('email');
				$baseuserPassword = $this->request->getVar('pass_word');


			//Check what type the user is
			$customer = $customerModel->getCustomerByEmail($baseuserEmail);
			$administrator = $administratorModel->getAdministratorByEmail($baseuserEmail);

			//If the a customer$customer is found using the user's login details, sign them in as a user
			if($customerModel->validateCustomerLogin($baseuserEmail,$baseuserPassword)){
				
				$session->setFlashdata('Customer','email and password matches customer in database');
			
				//Create all the customer's session data
				$ses_data = [
					'customerNumber' => $customer->customerNumber,
					'firstname' => $customer->contactFirstName,
					'lastname' => $customer->contactLastName,
					'email' => $customer->email,
					'loggedIn' => TRUE,
					'userType' => 'Customer',
					'cart' => array('empty' => 'yeah')
				];

				//Set the customer's session data
				$session->set($ses_data);

			}
			//If a administrator is found using the user's login details, sign them in as a administrator
			else if($administratorModel->validateAdminLogin($baseuserEmail,$baseuserPassword)){
				$session = session();
				$session->setFlashdata('Administrator','email and password matches administrator in database');
			
				//Create all the session data for administrator
				$ses_data = [
					'adminNumber' => $administrator->adminNumber,
					'firstname' => $administrator->firstName,
					'lastname' => $administrator->lastName,
					'email' => $administrator->email,
					'loggedIn' => TRUE,
					'userType' => 'Administrator'
				];
				//Set administrator's session data
				$session->set($ses_data);

				
			}
			//If the user wasn't found in the customer or administrator tables
			//Let user know their credentials were not found in the database
			else{
				$session->setFlashdata('unsuccessful', 'Email or password is incorrect');
				return redirect()->to('/login');
			}

			//Check if user wants to save cookies
			if(isset($_POST['rememberMe'])){
				if($customer)
					setcookie("rememberMe",$customer->customerNumber);
				else if($administrator)
					setcookie("rememberMe",$administrator);
			}
			//Redirect the user to their respective controllers
			if($session->get('userType') === 'Customer'){
					return redirect()->to('/Customer');
			}
			else if($session->get('userType') === 'Administrator'){
					return redirect()->to('/Administrator');
			}
		}
		//If the form was not submitted, display login page
		else{
			//Check if cookie is set, to auto login user
			if(isset($_COOKIE['rememberMe'])){
				$customer = $customerModel->getCustomerByID($_COOKIE['rememberMe']);
				$administrator = $administratorModel->getAdministratorByID($_COOKIE['rememberMe']);

				//If the a customer$customer is found using the user's login details, sign them in as a user
				if($customer){
					
					$session->setFlashdata('Customer','email and password matches customer in database');
				
					//Create all the customer's session data
					$ses_data = [
						'customerNumber' => $customer->customerNumber,
						'firstname' => $customer->contactFirstName,
						'lastname' => $customer->contactLastName,
						'email' => $customer->email,
						'loggedIn' => TRUE,
						'userType' => 'Customer',
						'cart' => array('empty' => 'yeah'),
					];

					//Set the customer's session data
					$session->set($ses_data);
					return redirect()->to('/Customer');

				}
				else if($administrator){
					$session = session();
					$session->setFlashdata('Administrator','email and password matches administrator in database');
				
					//Create all the session data for administrator
					$ses_data = [
						'adminNumber' => $administrator->adminNumber,
						'firstname' => $administrator->firstName,
						'lastname' => $administrator->lastName,
						'email' => $administrator->email,
						'loggedIn' => TRUE,
						'userType' => 'Administrator'
					];
					//Set administrator's session data
					$session->set($ses_data);
					return redirect()->to('/Administrator');
					
				}
				else{
					$session->setFlashdata('unsuccessful', 'Email or password is incorrect');
				}
			}
			echo view('templates/header', $data);
			echo view('login', $data);
			echo view('templates/footer');
		}

		
	}

	public function logout(){
		//Destroy the session of the user
		$session = session();
		$session->destroy();
		setcookie("rememberMe","", time()-3600);
		//Redirect the user to the login page
		return redirect()->to('/login');
	}

	
	//Browse products
	public function browseproducts($produceCode = null){
		$data = [];
		helper(['form']);
		$productModel = new ProductModel();
		$wishlistModel = new WishlistModel();
		$customerModel = new CustomerModel();
		//Determine which header to use depending on the user type
		if(session()->get('userType'))
			$whichHeader = strtolower('templates/'.session()->get('userType').'header');
		else
			$whichHeader = 'templates/header';

		//If a produce code was passed to the method, display the details of that product
		if($produceCode)
			{
				$data['selected_product'] = $productModel->getProduct($produceCode);
				//Display the product details to the user
				echo view($whichHeader, $data);
				echo view('viewproduct',$data);
				echo view('templates/footer');

			}
		//Otherwise display all the products for the user to choose from
		else
			{
				$customerNumber = $customerModel->getCustomerByEmail(session()->get('email'))->customerNumber;
				$wishlist = $wishlistModel->getWishlist($customerNumber);
				$productsOnWishlist = [];
				foreach($wishlist as $product){
					array_push($productsOnWishlist,$product->produceCode);
				}
				$data['productsOnWishlist'] = $productsOnWishlist;
				if($this->request->getMethod() == 'post'){

					$result = $productModel->searchProducts($this->request->getPost('key'));
					$data['product_data'] = $result;
					$data['key'] = $this->request->getPost('key');
				}
				else{
					$data['key'] = "";
					$data['product_data'] = $productModel->listAll();
				}
				//Display all products
				echo view($whichHeader, $data);
				echo view('products',$data);
				echo view('templates/footer');
			}
	}

	public function featured(){
		
		$data = [];
		$whichHeader = strtolower('templates/'.session()->get('userType').'header');

		$productModel = new productModel();
		//Get each workout that are featured, and store in data array
		$data['featured_workouts'] = $productModel->getFeatured();
		echo view($whichHeader, $data);
		echo view('featured', $data);
		echo view('templates/footer');
	}

	public function search(){
		$data = [];
		$header = 'templates/'.session()->get('userType').'header';
		helper(['form']);
		$model = new ExerciseModel();
		if($this->request->getMethod() == 'post'){

			$result = $model->liveSearchExercise($this->request->getPost('key'));
			$data['result'] = $result;
			$data['key'] = $this->request->getPost('key');
		}
		else{
		$data['result'] = $model->listAll()->getResult();
		$data['key'] = "";
		}
		echo view($header, $data);
		echo view('search.php');
		echo view('templates/footer');
	}
}
