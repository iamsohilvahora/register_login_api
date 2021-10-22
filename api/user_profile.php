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

	// Get User ID
	$user->id = isset($_GET['user_id']) ? $_GET['user_id'] : '';

	// IF REQUEST METHOD IS NOT GET
	if($_SERVER["REQUEST_METHOD"] != "GET"){
		$returnData = msg(false, 'Page Not Found!');
	}
	//Get User Data
	else if($user->user_profile()){
		//Create User Array
		$user_arr = array(
			'id' => $user->id,
			'firstname' => $user->firstname,
			'lastname' => $user->lastname,
			'email' => $user->email,
		);
		$returnData = msg(true, 'User Profile Data', $user_arr);
	}
	else{
		$returnData = msg(false, 'User Profile Data Not Found');
	}
	echo json_encode($returnData);
?>