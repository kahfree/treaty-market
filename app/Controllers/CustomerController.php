<?php

namespace App\Controllers;
#use App\Models\ClientModel;
#use App\Models\ExerciseModel;
#use App\Models\WorkoutModel;
#use App\Models\SavedWorkoutModel;
#use App\Models\PostModel;
#use App\Models\MuscleModel;
#use App\Models\MusclesExercisedModel;
#use App\Models\ExercisesInWorkoutModel;
#use App\Helpers\Filter;
class CustomerController extends BaseController
{

    public function index(){
		$data = [];
		helper(['form']);
		//Otherwise display the client dashboard
		echo view('templates/customerheader', $data);
		echo view('customerhome');
		echo view('client_3_panels');
		echo view('templates/footer');
	}
    //amend order details type function?
	public function editProfile(){
		$data = [];
		helper(['form']);
		$model = new ClientModel();
		$postModel = new PostModel();
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
		$postModel = new PostModel();
		$clientModel = new ClientModel();
		//Get all the posts the client has made and add to data array
		$data['client_posts'] = $postModel->getAllPosts(session()->get('clientID'));
		//Get the client's details and add to data array
		$data['client'] = $clientModel->getClientByID(session()->get('clientID'));
		echo view('templates/clientheader' , $data);
		echo view('clientprofile');
		echo view('templates/footer');
	}
    //add to cart type function?
	public function saveWorkout($workoutID = null){
		$workoutModel = new WorkoutModel();
		$savedWorkoutModel = new SavedWorkoutModel();
		$session = session();
		//Execute the add to savedd method in the savedWorkoutModel class
		$savedWorkoutModel = $savedWorkoutModel->addToSaved($workoutID,$session->get('clientID'));
		return redirect()->to('/workouts');
	}
    //remove from cart type function?
	public function removeFromSaved($workoutID = null){
		$data = [];

		$savedWorkoutModel = new SavedWorkoutModel();

		//If the workout exists in the client's saved workouts
		if(!$savedWorkoutModel->validateInsert($workoutID, session()->get('clientID')))
		{
			//Remove the workout from the client's saved workouts list
			$savedWorkoutModel->removeFromSaved($workoutID,session()->get('clientID'));
			//Let client know the workout has been removed
			session()->setFlashdata('success','The workout has been removed from your library');
		}
		//Otherwise, the workout cannot be removed as it is not contained in the client's saved workout list
		else
		{
			session()->setFlashdata('unsuccessful','There has been a problem performing this task.');
		}

		return redirect()->to('/savedWorkouts');
		
	}
    //view cart type function?
	public function savedWorkouts(){
		$data = [];
		$session = session();
		$workoutModel = new WorkoutModel();
		$savedWorkoutModel = new SavedWorkoutModel();
		//Get all workouts the client has in their saved workouts list
		$savedWorkouts = $savedWorkoutModel->allWorkoutsPerClient($session->get('clientID'));
		$workouts = [];
		//For every saved workout in the client's list
		foreach($savedWorkouts as $sw)
		{
			//Adding all the workout ID's to the workout model
			array_push($workouts,$workoutModel->getWorkout($sw)[0]);
		}
		$data['workout_data'] = $workouts;
		date_default_timezone_set('Europe/Dublin');
		echo view('templates/clientheader', $data);
		echo view('savedworkouts',$data);
		echo view('templates/footer');
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