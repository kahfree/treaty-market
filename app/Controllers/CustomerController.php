<?php

namespace App\Controllers;
use App\Helpers\HelperTable;
use App\Models\ProductModel;
use App\Models\CustomerModel;
use App\Models\WishlistModel;
use App\Models\OrderModel;
use App\Models\OrderDetailsModel;
class CustomerController extends BaseController
{

    public function index(){
		$data = [];
		helper(['form']);
		//Otherwise display the client dashboard
		echo view('templates/customerheader', $data);
		echo view('customerhome');
		//echo view('client_3_panels');
		echo view('templates/footer');
	}
    //amend order details type function?
	public function editProfile(){
		$data = [];
		helper(['form']);
		$model = new ClientModel();
		$orderModel = new PostModel();
		//If the edit user details form was submitted
		if($this->request->getMethod() == 'post')
		{
			$rules = [];
			//If the user hasn't changed their email
			if(session()->get('email') === $this->request->getPost('email'))
			{
				//Don't check for unique email, as it's already known to be unique
				$rules = [
					'firstname' => 'required|min_length[3]|max_length[20]',
					'lastname' => 'required|min_length[3]|max_length[20]',
					'email' => 'required|min_length[6]|max_length[50]|valid_email'
				];
			}
			//Otherwise, if the client changed their email, check if it's unique in the database
			else
			{
				$rules = [
					'firstname' => 'required|min_length[3]|max_length[20]',
					'lastname' => 'required|min_length[3]|max_length[20]',
					'email' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[client.Email]'
				];
			}

			//If the client requests to change their password, validate their input
			if($this->request->getPost('pass_word') != ''){
				$rules['pass_word'] = 'required|min_length[8]|max_length[255]';
				$rules['password_confirm'] = 'matches[pass_word]';
			}

			//If some validation rules are broken
			if(! $this->validate($rules)) {
				//Add to validation in data array to display to user
				$data['validation'] = $this->validator;
			}
			//Otherwise, update the client's details with the new ones
			else{
				$model = new ClientModel();
				//create new row to update with
				$newData = [
					'ClientID' => session()->get('clientID'),
					'Email' => $this->request->getPost('email'),
					'FirstName' => $this->request->getPost('firstname'),
					'LastName' => $this->request->getPost('lastname'),
				];
				//If the client requests a password change, add this to the new client row
				if($this->request->getPost('pass_word') != ''){
					$newData['ClientPassword'] = hash('ripemd160',$this->request->getPost('pass_word'));
				}
				//Update the client's details in the database
				$model->save($newData);
				$session = session();
				//Set flash data to let user know their details have been updated
				$session->setFlashdata('success','successfuly Updated');
				//Reset the client's session email, incase they changed it in the form
				$session->set('email', $this->request->getPost('email'));
				return redirect()->to('/profile');
			}
		}
		//Get all client details to populate the input fields
		$data['client'] = $model->getClientByID(session()->get('clientID'));
		echo view('templates/clientheader', $data);
		echo view('editprofile');
		echo view('templates/footer');
	}
    //view order details type function?
	public function profile(){
		$data = [];
		$orderModel = new PostModel();
		$customerModel = new ClientModel();
		//Get all the posts the client has made and add to data array
		$data['client_posts'] = $orderModel->getAllPosts(session()->get('clientID'));
		//Get the client's details and add to data array
		$data['client'] = $customerModel->getClientByID(session()->get('clientID'));
		echo view('templates/clientheader' , $data);
		echo view('clientprofile');
		echo view('templates/footer');
	}
	public function orders(){
		$data = [];
		$orderModel = new OrderModel();
		$customerModel = new CustomerModel();
		//Get all the orders the customer has made and add to data array
		$data['customer_orders'] = $orderModel->getAllCustomerOrders($customerModel->getCustomerByEmail(session()->get('email'))->customerNumber);

		echo view('templates/customerheader' , $data);
		echo view('customerorders');
		echo view('templates/footer');
	}

	public function orderdetails($orderNumber) {
		$data = [];
		$orderDetailsModel = new OrderDetailsModel();
		$productModel = new ProductModel();
		$orderModel = new OrderModel();
		$products = [];
		$orderdetails = $orderDetailsModel->getAllProductsOnOrder($orderNumber);
		foreach($orderdetails as $row) {
			array_push($products,$productModel->getProduct($row->produceCode));
		}
		$order = $orderModel->getOrder($orderNumber);
		$data['order'] = $order;
		$data['products'] = $products;
		$data['order_details'] = $orderdetails;
		$whichHeader = 'templates/'.session()->get('userType').'header';
		echo view($whichHeader, $data);
		echo view('vieworderdetails');
		echo view('templates/footer');

	}

	public function amendorderdetails($orderNumber) {
		$data = [];
		helper(['form']);
		$orderDetailsModel = new OrderDetailsModel();
		$productModel = new ProductModel();
		$orderModel = new OrderModel();
		$products = [];
		$order = $orderModel->getOrder($orderNumber);
		$orderdetails = $orderDetailsModel->getAllProductsOnOrder($orderNumber);
		if($this->request->getMethod() == 'post')
		{
			foreach($orderdetails as $row)
			{
				$quantity = $this->request->getPost('product_'.$row->produceCode.'_quantity');
				if($row->quantityOrdered != $quantity)
				{
					$newData = [
						'orderNumber' => $orderNumber,
						'produceCode' => $row->produceCode,
						'quantityOrdered' => $quantity,
						'priceEach' => $row->priceEach
					];
					$orderDetailsModel->replace($newData);
				}

				$newOrderData = [
					'orderNumber' => $orderNumber,
					'comments' => $this->request->getPost('comment')
				];

				$orderModel->save($newOrderData);
			}
			return redirect()->to('/orderdetails/'.$orderNumber);
		}
		
		foreach($orderdetails as $row) {
			array_push($products,$productModel->getProduct($row->produceCode));
		}
		
		$data['order'] = $order;
		$data['products'] = $products;
		$data['order_details'] = $orderdetails;

		$whichHeader = 'templates/'.session()->get('userType').'header';
		echo view($whichHeader, $data);
		echo view('amendorderdetails');
		echo view('templates/footer');

	}

	public function addProductToOrder($orderNumber, $produceCode = null){
		$data = [];
		helper(['form']);
		$productModel = new ProductModel();
		$orderDetailsModel = new OrderDetailsModel();
		
		//Determine which header to use depending on the user type
		if(session()->get('userType'))
			$whichHeader = strtolower('templates/'.session()->get('userType').'header');
		else
			$whichHeader = 'templates/header';

		if($this->request->getMethod() == 'post')
		{
			$priceEach = $productModel->getProduct($produceCode)->bulkSalePrice;
			$quantity = $this->request->getPost('quantity');
			if(!$quantity)
				$quantity = 1;
			$newData = [
				'orderNumber' => $orderNumber,
				'produceCode' => $produceCode,
				'quantityOrdered' => $quantity,
				'priceEach' => $priceEach
			];
			$orderDetailsModel->save($newData);
			return redirect()->to('/amendorderdetails/'.$orderNumber);
		}
		else{
			$produceCodeList = $orderDetailsModel->getProduceCodeArray($orderNumber);
			$products = $productModel->listAll()->getResult();
			$productsFiltered = [];
			//Filter products out that are currently on the order
			foreach($products as $product) 
				foreach($produceCodeList as $p)
					if(!(in_array($product->produceCode,$produceCodeList)))
						if(!in_array($product,$productsFiltered))
							array_push($productsFiltered,$product);

			$data['product_data'] = $productsFiltered;
			$data['orderNumber'] = $orderNumber;
		//Display all products
		echo view($whichHeader, $data);
		echo view('addproductstoorder',$data);
		echo view('templates/footer');
		}
		

	}

	public function removeProductFromOrder($orderNumber, $produceCode){
		$data = [];
		helper(['form']);
		$productModel = new ProductModel();
		$orderDetailsModel = new OrderDetailsModel();
		
		//Determine which header to use depending on the user type
		if(session()->get('userType'))
			$whichHeader = strtolower('templates/'.session()->get('userType').'header');
		else
			$whichHeader = 'templates/header';

		$orderDetailsModel->removeProductFromOrder($orderNumber, $produceCode);
		return redirect()->to('/amendorderdetails/'.$orderNumber);
	}

    //add to cart type function?
	public function addToCart($produceCode = null){
		helper(['form']);
		if(session()->get('userType')){
			if (isset($_GET['submit']))
			{
				if($_GET['quantity'])
					$_SESSION['cart'][$produceCode] = $_GET['quantity'];
				else
					$_SESSION['cart'][$produceCode] = 1;
			}
		return redirect()->to('/browseproducts');
		}
		else{
			return redirect()->to('/login');
		}
	}
    //remove from cart type function?
	public function removeFromCart($produceCode = null){
		$data = [];

		$session = session();
		$cart = $session->cart;
		unset($cart[$produceCode]);
		$session->cart = $cart;

		return redirect()->to('/viewCart');
		
	}
    //view cart type function?
	public function viewCart(){
		$data = [];
		$session = session();
		$productModel = new ProductModel();
		$products = [];
		$quantities = [];
		if($_SESSION['cart'])
		{
			foreach($_SESSION['cart'] as $productID => $quantity)
			{
				$product = $productModel->getProduct($productID);
				array_push($products,$product);
				array_push($quantities,$quantity);
			}
		}
			$data['products'] = $products;
			$data['quantities'] = $quantities;
		
		echo view('templates/customerheader', $data);
		//HelperTable::productsToTable($products, $quantities);
		echo view('viewcart',$data);
		echo view('templates/footer');
	}

	public function checkout(){
		$data = [];
		helper(['form']);
		$orderDetailsModel = new OrderDetailsModel();
		if($this->request->getMethod() == 'post')
		{
			$session = session();
			$produceCodeList = [];
			$updatedCart = [];
			foreach(session()->get('cart') as $produceCode => $quantity)
			{
					$updatedCart[$produceCode] = $this->request->getPost('quantity_'.$produceCode);
			}

			$session->remove('cart');
			foreach($updatedCart as $produceCode=>$quantity)
			{
				$_SESSION['cart'][$produceCode] = $quantity;
			}
		}

		echo view('templates/customerheader',$data);
		echo view('confirmorder');
		echo view('templates/footer');
	}
	//View wishlist?
	public function viewWishlist(){
		$data = [];
		$session = session();
		$productModel = new ProductModel();
		$wishlistModel = new WishlistModel();
		$customerModel = new CustomerModel();
		$customer = $customerModel->getCustomerByEmail(session()->get('email'));
		$wishlists = $wishlistModel->getWishList($customer->customerNumber);
		$products = [];
		foreach($wishlists as $wishlist){
			array_push($products, $productModel->getProduct($wishlist->produceCode));
		}
		
		$data['products'] = $products;
		$data['wishlist'] = $wishlists;
		
		echo view('templates/customerheader', $data);
		//HelperTable::productsToTable($products, $quantities);
		echo view('wishlist',$data);
		echo view('templates/footer');
	}

	public function addToWishlist($produceCode = null){
		helper(['form']);
		if(session()->get('userType')){
			$model = new WishlistModel();
			$customerModel = new CustomerModel();
			$customer = $customerModel->getCustomerByEmail(session()->get('email'));
			$newData = [
				'customerNumber' => $customer->customerNumber,
				'produceCode' => $produceCode,
				'comment' => NULL,
				'priority' => NULL,
				'quantity' => 1
			];
			print_r($newData);
			$model->save($newData);
		return redirect()->to('/browseproducts');
		}
		else{
			return redirect()->to('/login');
		}
	}

	public function removeFromWishlist($produceCode = null){
		$data = [];
		$customerModel = new CustomerModel();
		$wishlistModel = new WishlistModel();
		$customer = $customerModel->getCustomerByEmail(session()->get('email'));

		$wishlistModel->removeWishlistItem($produceCode,$customer->customerNumber);
		

		return redirect()->to('/wishlist');
		
	}

	public function completeWorkout($workoutID = null){
		$data = [];
		$workoutModel = new WorkoutModel();
		//Get workout details to populate input fields 
		$data['workout_data'] = $workoutModel->getWorkout($workoutID)[0];
		helper(['form']);
		echo view('templates/clientheader', $data);
		echo view('completeworkout', $data);
		echo view('templates/footer');	
	}

	public function post($workoutID = null){
		$data = [];
		helper(['form']);
		$model = new PostModel();
		//If the post form was submitted
		if($this->request->getMethod() == 'post')
		{
			$rules = [
				'workoutName' => 'required|min_length[5]|max_length[45]',
				'posttext' => 'required|min_length[5]|max_length[255]',
				'email' => 'required',
			];
			//If any rules were vialated, add to data array
			if(! $this->validate($rules)){
				$data['validation'] = $this->validator;
			}
			//Otherwise, create new post and add to database
			else{
				$newData = [
					'ClientID' => session()->get('clientID'),
					'DateTime' => $this->request->getPost('DateTime'),
					'Title' => $this->request->getPost('workoutName'),
					'PostText' => $this->request->getPost('posttext'),
					'WorkoutID' => $workoutID,
					];

				$model->save($newData);
				$session = session();
				$session->setFlashdata('Postsuccess','Workout has been successfully completed!');
				return redirect()->to('/savedWorkouts');
			}
		}

		$workoutModel = new WorkoutModel();
		$data['workout_data'] = $workoutModel->getWorkout($workoutID)[0];
		echo view('templates/clientheader', $data);
		echo view('completeworkout', $data);
		echo view('templates/footer');
	}

	public function generateWorkout(){

		$data = [];
		if($this->request->getMethod() == 'post')
		{
			$muscleModel = new MuscleModel();
			$allMuscles = $muscleModel->getAllMuscleNames();
			$musclesSelected = [];
			foreach($allMuscles as $m)
			{
				if($m['Name'] == $this->request->getPost($m['Name']))
				{
					//echo $m['Name'];
					//print_r ($muscleModel->getMuscleFromName($m['Name']));
					array_push($musclesSelected, $muscleModel->getMuscleFromName($m['Name']));
				}
				

			}
			//print_r($musclesSelected);
			$musclesExercisedModel = new MusclesExercisedModel();
			$exerciseModel = new ExerciseModel();
			//Check if there are at least 3 exercises in the database with the muscle groups selected
			if($musclesExercisedModel->validateMuscleSelection($musclesSelected)){

				$muscleSet = [];
				foreach($musclesSelected as $m)
				{
					foreach($musclesExercisedModel->getExercisesByMuscle($m[0]['MuscleID']) as $muscles)
					{
						array_push($muscleSet, $muscles);
					}
					
				}
				$data['muscleSetbefore'] = $muscleSet;
				$listOfExerciseIDs = [];
				
				for($i = 0; $i < 6; $i++)
				{
					$randomExercise = rand(0,count($muscleSet)-1);
					if(!$muscleSet)
						break;
					array_push($listOfExerciseIDs, $muscleSet[$randomExercise]->ExerciseID);
					unset($muscleSet[$randomExercise]);
					$muscleSet = array_values($muscleSet);
				}
				$data['ExerciseList'] = $listOfExerciseIDs;

				$musclesWorked = [];
				$allMusclesInWorkout = [];
				//Create object to get each exercise in the workout
				//For every exercise in the workout, Get the muscle groups worked by an exercise
				//Add muscle group to array '$musclesWorked'
				foreach($listOfExerciseIDs as $exercise)
				{
					array_push($musclesWorked,$musclesExercisedModel->MusclesInExercise($exercise));
				}
				
				foreach($musclesWorked as $muscle)
				{
					$temp = explode(",",rtrim($muscle,", "));
					// '$temp' is an array that takes the musclesWorked string and stores individual elements
					// separated by a comma
					foreach($temp as $element)
					{
						//if the element in temp is a valid muscle, add it to the array
						//This is checked because elements that are just whitespace must be filtered out
						if(! in_array($element,$allMusclesInWorkout) && strlen($element) >= 3)
							array_push($allMusclesInWorkout,$element);
							
					}
					
				}
				$data['musclesForWorkout'] = $allMusclesInWorkout;
				$durationList = array(15,30,45,60,75,90);
				$exerciseDuration = [];
				$totalDuration = 0;
				for($i = 0; $i < count($data['ExerciseList']); $i++)
				{
					$randNum = rand(0,count($durationList)-1);
					array_push($exerciseDuration, $durationList[$randNum]);
					$totalDuration += $durationList[$randNum];
				}
				$data['the_fuck'] = $exerciseDuration;
				$data['exercise_data'] = $exerciseModel->ExercisesFromSet($listOfExerciseIDs,$musclesWorked,$exerciseDuration);
				$data['total_workout_duration'] = $this->request->getPost('duration');
				$data['secondsExercised'] = $totalDuration;
				$data['exerciseDuration'] = $exerciseDuration;

				echo view('templates/clientheader',$data);
				echo view('viewcustomworkout');
				echo view('templates/footer');

			}
			else
			{
				session()->setFlashdata('error','There are not enough exercises in the database to create a workout with these muscle groups, please choose more muscle groups');
				echo view('templates/clientheader',$data);
				echo view('generateworkout');
				echo view('templates/footer');
			}

		}
		else{
				echo view('templates/clientheader',$data);
				echo view('generateworkout');
				echo view('templates/footer');
		}


		
	}
	
	

	
}