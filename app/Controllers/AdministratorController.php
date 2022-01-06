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
	public function exercises(){
		$data = [];
		$musclesPerExercise = [];
		$musclesExercisedModel = new MusclesExercisedModel();
		$exercisemodel = new ExerciseModel();
		//Get every exercise in the database
		$data['exercise_data'] = $exercisemodel->listAll();
		//Get each muscle group for each exercise
		foreach($data['exercise_data']->getResult() as $row)
		{
			$musclesPerExercise[$row->ExName] = $musclesExercisedModel->MusclesInExercise($row->ExerciseID);
		}
		//Add these muscle groups to the data array
		$data['musclesExercised'] = $musclesPerExercise;
		echo view('templates/moderatorheader', $data);
		echo view('exercises',$data);
		echo view('templates/footer');
	}
	//edit existing product?
	public function editExercise($exerciseID = null){
		$data = [];
		helper(['form']);
		$exerciseModel = new ExerciseModel();
		//Get the exercise details to populate the input fields for the form
		$data['exercise'] = $exerciseModel->getExercise($exerciseID);
		echo view('templates/moderatorheader', $data);
		echo view('editexercise',$data);
		echo view('templates/footer');
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
	public function addExercise(){
		$data = [];

		if($this->request->getMethod() == 'post')
		{
			$rules = [
				'exerciseName' => 'required|max_length[45]',
				'equipment' => 'required',
				'description' => 'required|max_length[500]',
				'gifpath' => 'max_length[80]'
			];

			if(! $this->validate($rules)){
				$data['validation'] = $this->validator;
			}

			else{

				$model = new ExerciseModel();
				$newData = [
					'ExName' => $this->request->getpost('exerciseName'),
					'ExDescription' => $this->request->getPost('description'),
					'ExGifPath' => $this->request->getPost('gifpath'),
					'ExNeedsEquipment' => $this->request->getPost('equipment'),
				];
				$model->save($newData);
				$session = session();
				$session->setFlashData('success','successfully added exercise');
				return redirect()->to('/exercises');
			}
		}


		echo view('templates/moderatorheader');
		echo view('addexercise');
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