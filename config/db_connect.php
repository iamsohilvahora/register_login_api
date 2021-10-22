<?php   
	// Database configuration  
	define('DB_HOST', 'localhost'); 
	define('DB_USERNAME', 'root'); 
	define('DB_PASSWORD', 'Admin@123'); 
	define('DB_NAME', 'register_login_api');

	// Connect with the database  
	$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);  
	  
	// Display error if failed to connect  
	if($conn->connect_errno){  
	    printf("Connect failed: %s\n", $conn->connect_error);  
	    exit(); 
	}
?>