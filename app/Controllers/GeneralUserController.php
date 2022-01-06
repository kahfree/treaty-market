<?php

namespace App\Controllers;

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
				'firstname' => 'required|min_length[3]|max_length[20]',
				'lastname' => 'required|min_length[3]|max_length[20]',
				'email' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[customers.email]',
				'password' => 'required|min_length[8]|max_length[255]',
				'password_confirm' => 'matches[pass_word]',
			];
			//Check if validation specifications are met
			if(! $this->validate($rules)) {
				//if not, get the rules vialated and add them to the data array
				$data['validation'] = $this->validator;
			}
			else{
				//if rules are met, create user and store in database
				$model = new ClientModel();
				//Create new client row stored as elements in array
				$newData = [
					'FirstName' => $this->request->getVar('firstname'),
					'LastName' => $this->request->getVar('lastname'),
					'Email' => $this->request->getVar('email'),
					'ClientPassword' => hash('ripemd160',$this->request->getVar('password')),
				];
				//Add new client to database
				$model->save($newData);
				$session = session();
				//Set flash data to let user know registration was successful
				$session->setFlashdata('success','successful registration');
				//Redirect them to login now that registration was successful
				return redirect()->to('/login');
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
		$session = session();
		//Object of each usertype is created
		//This is to check what type the user loggin in is
		$ClientModel = new ClientModel();
		$moderatormodel = new ModeratorModel();

		//Check if post method was used
		if($this->request->getMethod() == 'post')
		{

			//Get the user's email and password 
				$baseuserEmail = $this->request->getVar('email');
				$baseuserPassword = $this->request->getVar('pass_word');


			//Check what type the user is
			$client = $ClientModel->getClientByEmail($baseuserEmail);
			$moderator = $moderatormodel->getModerator($baseuserEmail);

			//If the a client is found using the user's login details, sign them in as a user
			if($ClientModel->validateClientLogin($baseuserEmail,$baseuserPassword)){
				
				$session->setFlashdata('Client','email and password matches user in database');
			
				//Create all the client's session data
				$ses_data = [
					'clientID' => $client->ClientID,
					'firstname' => $client->FirstName,
					'lastname' => $client->LastName,
					'email' => $client->Email,
					'loggedIn' => TRUE,
					'userType' => 'Client'
				];
				//Set the client's session data
				$session->set($ses_data);

			}
			//If a moderator is found using the user's login details, sign them in as a moderator
			else if($moderatormodel->validateModeratorLogin($baseuserEmail,$baseuserPassword)){
				$session = session();
				$session->setFlashdata('Moderator','email and password matches moderator in database');
			
				//Create all the session data for moderator
				$ses_data = [
					'moderatorID' => $moderator->ModeratorID,
					'firstname' => $moderator->FirstName,
					'lastname' => $moderator->LastName,
					'email' => $moderator->Email,
					'loggedIn' => TRUE,
					'userType' => 'Moderator'
				];
				//Set moderator's session data
				$session->set($ses_data);

				
			}
			//If the user wasn't found in the client or moderator tables
			//Let user know their credentials were not found in the database
			else{
				$session->setFlashdata('unsuccessful', 'Email or password is incorrect');
				return redirect()->to('/login');
			}

			//Redirect the user to their respective controllers
			if($session->get('userType') === 'Client'){
					return redirect()->to('/Client');
			}
			else if($session->get('userType') === 'Moderator'){
					return redirect()->to('/Moderator');
			}
		}
		//If the form was not submitted, display login page
		else{
			echo view('templates/header', $data);
			echo view('login', $data);
			echo view('templates/footer');
		}

		
	}

	public function logout(){
		//Destroy the session of the user
		$session = session();
		$session->destroy();
		//Redirect the user to the login page
		return redirect()->to('/login');
	}

	

	public function workouts($workoutID = null){
		$data = [];
		$workoutModel = new WorkoutModel();
		$musclesExercisedModel = new MusclesExercisedModel();
		//Determine which header to use depending on the user type
		$whichHeader = strtolower('templates/'.session()->get('userType').'header');

		//If a workout ID was passed to the method, display the details of that workout
		if($workoutID)
			{
				$musclesWorked = [];
				$allMusclesInWorkout = [];
				//Create object to get each exercise in the workout
				$exercisesInWorkoutModel = new ExercisesInWorkoutModel();
				//For every exercise in the workout, Get the muscle groups worked by an exercise
				//Add muscle group to array '$musclesWorked'
				foreach($exercisesInWorkoutModel->exercisesInWorkoutStrArr($workoutID) as $exercise)
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
				//Now all data is gathered, populate the data array
				$data['musclesForWorkout'] = $allMusclesInWorkout;
				$data['workout_data'] = $workoutModel->getWorkout($workoutID);
				$data['exercise_data'] = $exercisesInWorkoutModel->WorkoutExercises($workoutID, $musclesWorked);
				$data['secondsExercised'] = $exercisesInWorkoutModel->totalSecondsExercising($workoutID);
				//Display the workout details to the user
				echo view($whichHeader, $data);
				echo view('viewworkout',$data);
				echo view('templates/footer');

			}
		//Otherwise display all the workouts for the user to choose from
		else
			{
				$data['workout_data'] = $workoutModel->listAll();
				//Display all workouts
				echo view($whichHeader, $data);
				echo view('workouts',$data);
				echo view('templates/footer');
			}
	}

	public function featured(){
		
		$data = [];
		$whichHeader = strtolower('templates/'.session()->get('userType').'header');

		$workoutModel = new WorkoutModel();
		//Get each workout that are featured, and store in data array
		$data['featured_workouts'] = $workoutModel->getFeatured();
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
