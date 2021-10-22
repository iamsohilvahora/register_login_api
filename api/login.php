<?php
	// header file
	header('Content-Type: application/json; charset=utf-8');

	// include database file 
	include_once '../config/db_connect.php';

	// include user model file
	include_once '../models/users.php';

	// Show message for api request
	function msg($status, $message, $data = []){
		return array(
		  'status' => $status,
		  'message' => $message,
		  'data' => $data
		);
	}

	// Instantiate user class object
	$user = new User($conn);

	// Get raw posted data
	$data = $_POST;

	// Set user properties
	$user->email = isset($data['email']) ? trim($data['email']) : "";
	$user->password = isset($data['password']) ? trim($data['password']) : "";

	// IF REQUEST METHOD IS NOT POST
	if($_SERVER["REQUEST_METHOD"] != "POST"){
		$returnData = msg(false, 'Page Not Found!');
	}
	// CHECKING EMPTY FIELDS
	else if(!isset($data['email']) || !isset($data['password']) || empty(trim($data['email'])) || empty(trim($data['password']))){
		$fields = ['fields' => ['email','password']];
		$returnData = msg(false, 'Please Fill in all Required Fields!', $fields);
	} 
	// IF THERE ARE NO EMPTY FIELDS
	else{	
		$email = isset($data['email']) ? trim($data['email']) : "";
		$password = isset($data['password']) ? trim($data['password']) : "";

		// CHECKING THE EMAIL FORMAT (IF INVALID FORMAT)
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			$returnData = msg(false, 'Invalid Email Address!');
		}
		// IF PASSWORD IS LESS THAN 8 THEN SHOW THE ERROR
		else if(strlen($password) < 8){
			$returnData = msg(false, 'Your password must be at least 8 characters long!');
		}
		// THE USER IS ABLE TO PERFORM THE LOGIN ACTION
		else{
			// Check user's email and password
			if($user->login()){
				$returnData = msg(true, 'You have successfully logged in.');
			}
			else{
				$returnData = msg(false, 'Invalid Email or Password!');
			}	
		}
	}
	echo json_encode($returnData);
?>