<?php
	class User{
		// DB Stuff
		private $conn;
		private $table = 'users';

		// User Properties
		public $id;
		public $firstname;
		public $lastname;
		public $email;
		public $password;

		// Set connection variable
		public function __construct($db){
			$this->conn = $db;
		}

		// Register User
		public function register(){
			$hash_password = password_hash($this->password, PASSWORD_DEFAULT);
			$insert_query = "INSERT INTO $this->table (firstname, lastname, email, password) VALUES ('$this->firstname', '$this->lastname', '$this->email', '$hash_password')";
			$result = $this->conn->query($insert_query);

			if($result){
				return true;
			} 
			else{
				return false;
			}
		}

		// Login User
		public function login(){
			$check_email_query = "SELECT * FROM $this->table WHERE email = '$this->email'";
			$result = $this->conn->query($check_email_query);

			if($result->num_rows > 0){
				$row = $result->fetch_assoc();
				$check_password = password_verify($this->password, $row['password']);

				// VERIFYING THE PASSWORD
				if($check_password){
					return true;
				} 
				// IF INVALID PASSWORD
				else{
					return false;
				}
			}
			// IF INVALID EMAIL
			else{
				return false;
			}
		}

		// Get User Profile Data
		public function user_profile(){
			$user_profile_query = "SELECT * FROM $this->table WHERE id = '$this->id'";
			$result = $this->conn->query($user_profile_query);

			if($result->num_rows > 0){
				$row = $result->fetch_assoc();
				extract($row);

				// Set User Properties
				$this->id = $id; 
				$this->firstname = $firstname; 
				$this->lastname = $lastname; 
				$this->email = $email;

				return true;
			}
			else{
				return false;
			}
		}

		// Update User Profile Data
		public function update(){
			if($this->id){
				$get_user_query = "SELECT * FROM $this->table WHERE id = '$this->id'";
				$result = $this->conn->query($get_user_query);

				if($result->num_rows > 0){
					$row = $result->fetch_assoc();
					$id = $row['id'];

					$update_user_profile_query = "UPDATE $this->table SET firstname = '$this->firstname', lastname = '$this->lastname', email = '$this->email' WHERE id = $id";
					$result = $this->conn->query($update_user_profile_query);

					if($result){
						return true;
					} 
					else{
						return false;
					}
				}
				else{
					return false;
				}
			}
			else{
				return false;
			}
		}

		// Update User Password
		public function change_password(){
			$hash_password = password_hash($this->password, PASSWORD_DEFAULT);

			$update_password_query = "UPDATE $this->table SET password = '$hash_password' WHERE email = '$this->email'";
			$result = $this->conn->query($update_password_query);

			if($result){
				return true;
			} 
			else{
				return false;
			}
		}
	}
?>