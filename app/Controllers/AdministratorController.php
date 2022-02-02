<?php

namespace App\Controllers;
#use App\Models\ModeratorModel;
#use App\Models\MuscleModel;
#use App\Helpers\HelperTable;
#use App\Models\ExerciseModel;
#use App\Models\MusclesExercisedModel;
#use App\Models\WorkoutModel;
#use App\Models\ExercisesInWorkoutModel;
#use App\Models\PostModel;
#use App\Models\ClientModel;
use App\Models\ProductModel;
use App\Models\CustomerModel;
use App\Models\OrderModel;

class AdministratorController extends BaseController
{
    public function index(){
		$data = [];
		helper(['form']);
		$session = session();

		echo view('templates/administratorheader', $data);
		echo view('administratorhome');
		//echo view('moderator_3_panels');
		echo view('templates/footer');
	}
	//view products?
	public function viewproducts(){
		$data = [];
		$productsModel = new ProductModel();
		
		//Get every product in the database
		$data['product_data'] = $productsModel->listAll()->getResult();

		echo view('templates/administratorheader', $data);
		echo view('viewproducts',$data);
		echo view('templates/footer');
	}
	//edit existing product?
	public function editproduct($productID = null){
		$data = [];
		helper(['form']);
		$session = session();
		if($this->request->getMethod() == 'post')
		{
			$rules = [
				'produceCode' => 'required|max_length[15]',
				'category' => 'required',
				'description' => 'required|max_length[45]',
				'supplier' => 'required',
				'quantityInStock' => 'required',
				'bulkBuyPrice' => 'required',
				'bulkSalePrice' => 'required',
			];


			if(! $this->validate($rules)) {
				$data['validation'] = $this->validator;
				print_r($this->validator->listErrors());
			}
			else{
				$model = new ProductModel();
				$newData = [
					'produceCode' => $this->request->getpost('produceCode'),
					'category' => $this->request->getpost('category'),
					'description' => $this->request->getpost('description'),
					'supplier' => $this->request->getpost('supplier'),
					'quantityInStock' => $this->request->getpost('quantityInStock'),
					'bulkBuyPrice' => $this->request->getpost('bulkBuyPrice'),
					'bulkSalePrice' => $this->request->getpost('bulkSalePrice')
				];
				try{
					if(!empty($_FILES))
					{
						$x_file = $this->request->getFile('photo');
						if(!empty($x_file)){
						$image = \Config\Services::image()
								->withFile($x_file)
								->resize(345, 186, false, 'height')
								->save(FCPATH.'assets/images/products/thumbs/'.$x_file->getClientName());
		
						$fullSizeImage = \Config\Services::image()
						->withFile($x_file)
						->save(FCPATH.'assets/images/products/full/'.$x_file->getClientName());
						$x_file->move(WRITEPATH.'uploads');
						$newData['photo'] = $x_file->getClientName();
						}
					}
				}
				catch (\Exception $e){
					$session->setFlashdata('no-file-upload','no file was uploaded');
				}
				$model->save($newData);
				
				$session->setFlashdata('success','successfuly Updated');
				return redirect()->to('/viewproducts');
			}
		}
	else{
		$productsModel = new ProductModel();
		//Get the products details to populate the input fields for the form
		$data['product'] = $productsModel->getProduct($productID);
		echo view('templates/administratorheader', $data);
		echo view('editproduct',$data);
		echo view('templates/footer');
		}
	}
	//add new product?
	public function addproduct(){
		$data = [];
		helper(['form','url']);
		if($this->request->getMethod() == 'post')
		{
			print_r("I posted<br>");
			$rules = [
				'produceCode' => 'required|max_length[15]',
				'category' => 'required',
				'description' => 'required|max_length[45]',
				'supplier' => 'required',
				'quantityInStock' => 'required',
				'bulkBuyPrice' => 'required',
				'bulkSalePrice' => 'required',
				
			];

			if(! $this->validate($rules)){
				print_r($this->validator->listErrors()."<br>");
				$data['validation'] = $this->validator;
			}

			else{
				print_r("My data is valid");
				$x_file = $this->request->getFile('photo');
            	$image = \Config\Services::image()
						->withFile($x_file)
						->resize(345, 186, false, 'height')
						->save(FCPATH.'assets/images/products/thumbs/'.$x_file->getClientName());

				$fullSizeImage = \Config\Services::image()
				->withFile($x_file)
				->save(FCPATH.'assets/images/products/full/'.$x_file->getClientName());
            	$x_file->move(WRITEPATH.'uploads');
				$model = new ProductModel();
				//$x_file->store(FCPATH.'/assets/images/products/full/');
				$newData = [
					'produceCode' => $this->request->getpost('produceCode'),
					'category' => $this->request->getpost('category'),
					'description' => $this->request->getpost('description'),
					'supplier' => $this->request->getpost('supplier'),
					'quantityInStock' => $this->request->getpost('quantityInStock'),
					'bulkBuyPrice' => $this->request->getpost('bulkBuyPrice'),
					'bulkSalePrice' => $this->request->getpost('bulkSalePrice'),
					'photo' => $x_file->getClientName()
				];
				$model->save($newData);
				
				
				$session = session();
				$session->setFlashData('success','successfully added product');
				return redirect()->to('/viewproducts');
			}
		}

		print_r("I didn't post<br>");
		echo view('templates/administratorheader');
		echo view('addproduct');
		echo view('templates/footer');
	}
	//remove product
	public function removeproduct($produceCode){
		$model = new ProductModel();
		try{
		$model->removeProduct($produceCode);
		$session = session();
		$session->setFlashData('success','successfully removed product from database');
		}
		catch(\Exception $e){
		$session = session();
		$session->setFlashData('error','can\'t remove product on order');
		}
		return redirect()->to('/viewproducts');
	}

	//view all customers?
	public function allorders(){
		$customerModel = new CustomerModel();
		$orderModel = new OrderModel();
		$data['customers'] = $customerModel->getCustomers()->getResult();
		$orderlist = []; 
		$inProcessList = [];
		$shippedList = [];
		$disputedList = [];
		foreach($data['customers'] as $customer){
			$orderlist[$customer->customerNumber] = $orderModel->getOrderCount($customer->customerNumber);
			$inProcessList[$customer->customerNumber] = $orderModel->countForShippingType($customer->customerNumber, "In Process");
			$shippedList[$customer->customerNumber] = $orderModel->countForShippingType($customer->customerNumber, "Shipped");
			$disputedList[$customer->customerNumber] = $orderModel->countForShippingType($customer->customerNumber, "Disputed");
		}
		$data['orders'] = $orderlist;
		$data['inProcessList'] = $inProcessList;
		$data['shippedList'] = $shippedList;
		$data['disputedList'] = $disputedList;
		echo view('templates/administratorheader',$data);
		echo view('allorders');
		echo view('templates/footer');
	}

	public function customerorders($customerNumber){
		$data = [];
		$orderModel = new OrderModel();
		$customerModel = new CustomerModel();
		//Get all the orders the customer has made and add to data array
		$data['customer_orders'] = $orderModel->getAllCustomerOrders($customerNumber);
		$data['customer'] = $customerModel->getCustomerByID($customerNumber);

		echo view('templates/administratorheader' , $data);
		echo view('admincustomerorders');
		echo view('templates/footer');
	}
	//view customer orders?
	public function viewClientPosts($clientID){
		$postModel = new PostModel();
		$customerModel = new ClientModel();
		$data['client'] = $customerModel->getClientById($clientID);
		$data['posts'] = $postModel->getAllPosts($clientID);
		echo view('templates/moderatorheader',$data);
		echo view('viewclientposts');
		echo view('templates/footer');
	}
	//amend customer order?
	public function removePost($postID,$clientID){
		$postmodel = new PostModel();
		$postmodel->removePost($postID);
		return redirect()->to('/viewClientPosts/'.$clientID);
	}

}