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
	$user->confirm_password = isset($data['confirm_password']) ? trim($data['confirm_password']) : "";

	// IF REQUEST METHOD IS NOT POST
	if($_SERVER["REQUEST_METHOD"] != "POST"){
		$returnData = msg(false, 'Page Not Found!');
	}
	// CHECKING EMPTY FIELDS
	else if(!isset($data['email']) || !isset($data['password']) || !isset($data['confirm_password']) || empty(trim($data['email'])) || empty(trim($data['password'])) || empty(trim($data['confirm_password']))){
		$fields = ['fields' => ['email','password', 'confirm_password']];
		$returnData = msg(false, 'Please Fill in all Required Fields!', $fields);
	} 
	// IF THERE ARE NO EMPTY FIELDS THEN
	else{
		$email = isset($data['email']) ? trim($data['email']) : "";
		$password = isset($data['password']) ? trim($data['password']) : "";
		$confirm_password = isset($data['confirm_password']) ? trim($data['confirm_password']) : "";

		// CHECKING THE EMAIL FORMAT (IF INVALID FORMAT)
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			$returnData = msg(false, 'Invalid Email Address!');
		}
		// IF PASSWORD IS LESS THAN 8 THEN SHOW THE ERROR
		else if(strlen($password) < 8){
			$returnData = msg(false, 'Your password must be at least 8 characters long!');
		}
		// IF PASSWORD IS NOT SAME THEN SHOW THE ERROR
		else if($password != $confirm_password){
			$returnData = msg(false, 'Password and confirm password fields must be same!');
		}
		else{
			$check_email_query = "SELECT email FROM users WHERE email = '$email'";
			$result = $conn->query($check_email_query);

			if($result->num_rows > 0){
				// Update user's email and password
				if($user->change_password()){
					$returnData = msg(true, 'You have successfully update the password!');
				}
				else{
					$returnData = msg(false, 'There is an error to update the password!');
				}
			}
			else{
				$returnData = msg(false, 'This Email address does not found!');
			}
		}
	}
	echo json_encode($returnData);
?>