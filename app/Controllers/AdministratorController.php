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

class AdministratorController extends BaseController
{
    public function index(){
		$data = [];
		helper(['form']);
		$session = session();

		echo view('templates/administratorheader', $data);
		echo view('administratorhome');
		echo view('moderator_3_panels');
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
				//store the new Exercise information in our database
				$model = new ProductModel();
				$newData = [
					'produceCode' => $this->request->getpost('produceCode'),
					'category' => $this->request->getpost('category'),
					'description' => $this->request->getpost('description'),
					'supplier' => $this->request->getpost('supplier'),
					'quantity' => $this->request->getpost('quantity'),
					'bulkBuyPrice' => $this->request->getpost('bulkBuyPrice'),
					'bulkSalePrice' => $this->request->getpost('bulkSalePrice')
				];
				$model->save($newData);
				$session = session();
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
	//update existing product?
	public function updateExercise(){
		$data = [];
		helper(['form']);
		$model = new ExerciseModel();
		//If the update exercise form was submitted
		if($this->request->getMethod() == 'post')
		{
			$rules = [
				'exerciseName' => 'required|max_length[45]',
				'description' => 'required|max_length[500]',
			];


			if(! $this->validate($rules)) {
				$data['validation'] = $this->validator;
			}
			else{
				//store the new Exercise information in our database
				$model = new ExerciseModel();
				$newData = [
					'ExerciseID' => $this->request->getpost('exid'),
					'ExName' => $this->request->getpost('exerciseName'),
					'ExDescription' => $this->request->getPost('description'),
					'ExGifPath' => $this->request->getPost('gifpath'),
					'ExNeedsEquipment' => $this->request->getPost('equipment'),
				];
				$model->save($newData);
				$session = session();
				$session->setFlashdata('success','successfuly Updated');
			}
		}

		$data['exercise'] = $model->getExercise($this->request->getPost('exid'));

		echo view('templates/moderatorheader', $data);
		echo view('editexercise',$data);
		echo view('templates/footer');
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
				$model = new ProductModel();
				//$x_file->store(FCPATH.'/assets/images/products/full/');
				$newData = [
					'produceCode' => $this->request->getpost('produceCode'),
					'category' => $this->request->getpost('category'),
					'description' => $this->request->getpost('description'),
					'supplier' => $this->request->getpost('supplier'),
					'quantity' => $this->request->getpost('quantity'),
					'bulkBuyPrice' => $this->request->getpost('bulkBuyPrice'),
					'bulkSalePrice' => $this->request->getpost('bulkSalePrice'),
					'photo' => $x_file->getClientName()
				];
				$model->save($newData);
				
				$fullImage = \Config\Services::image()
						->withFile($x_file)
						->save(FCPATH .'/assets/images/products/full/'. $x_file->getFilename());
				$thumbImage = \Config\Services::image()
						->withFile($x_file)
						->resize(140, 75, false, 'height')
						->save(FCPATH .'/assets/images/products/thumbs/'. $x_file->getFilename());
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
	public function removeExercise($exerciseID = null){
		$model = new ExerciseModel();
		$model->removeExercise($exerciseID);
		$session = session();
		$session->setFlashData('success','successfully removed exercise from database');
		return redirect()->to('/exercises');
	}
	//view all customers?
	public function clients(){
		$clientModel = new ClientModel();
		$data['clients'] = $clientModel->getClients();
		echo view('templates/moderatorheader',$data);
		echo view('clients');
		echo view('templates/footer');
	}
	//view customer orders?
	public function viewClientPosts($clientID){
		$postModel = new PostModel();
		$clientModel = new ClientModel();
		$data['client'] = $clientModel->getClientById($clientID);
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