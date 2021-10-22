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
	$user->id = isset($data['user_id']) ? trim($data['user_id']) : "";
	$user->firstname = isset($data['firstname']) ? trim($data['firstname']) : "";
	$user->lastname = isset($data['lastname']) ? trim($data['lastname']) : "";
	$user->email = isset($data['email']) ? trim($data['email']) : "";	  
	  
	// Update User Data
	if($user->update()){
		$returnData = msg(true, 'User Data Updated Succesfully');
	} 
	else{
		$returnData = msg(false, 'User Data Not Updated or Pass the user id');
	}
	echo json_encode($returnData);
?>