<?php

require 'user_database.php';

class Controller {
	private $varArray;
	private $contentArray;
	private $user_database;

	function __construct() {
		$this->user_database = new User_database();
		$this->createContent();	
	}

	public function loggedIn() {

	}

	private function createContent() {
		$page = isset($_GET['page']) ? $_GET['page'] : null;
		$action = isset($_GET['action']) ? $_GET['action'] : null;

		if($page == NULL) {
			$this->contentArray = array('header','content', 'footer');
		} else if($page == 'login') {
			$this->varArray = array(
				"user_name_label" => "Felhasználói azonosító: ",
				"password_label" => "Jelszó: ",
				"user_name" => "",
				"login_message" => "",
				"error_message" => array()
			);
			$this->contentArray = array('header','content_login', 'footer');

			if($action == "login") {
				$user_name = isset($_POST['user_name']) ? $_POST['user_name'] : null;
				$password = isset($_POST['password']) ? $_POST['password'] : null;

				$missing = false;

				if($user_name == null || $user_name == "") {	
					$this->varArray["error_message"][] = "Felhasználói név kitöltése kötelező!";
					$missing = true;
				} 

				if($password == null || $password == "") {
					$this->varArray["error_message"][] = "Jelszó kitöltése kötelező!";
					$missing = true;
				}

				if(!$missing) {
					$auth_info = $this->user_database->authenticate($user_name, $password);

					if($auth_info["success"] == true) {
						$_SESSION["user_data"] = $auth_info["user_data"];
						$this->varArray["login_message"] = "sikerült!";

					} else {
						$this->varArray["user_name"] =  $user_name;
						$this->varArray["error_message"][] = "hibás felhasználói név vagy jelszó";
					}
				}
			}
			
		} else if($page == "registration") {
			$this->varArray = array(
				"user_name_label" => "Felhasználói azonosító: ",
				"password_label" => "Jelszó: ",
				"password_repeat_label" => "Jelszó újra: ",
				"email_label" => "Email: ",
				"registration_label" => "Regisztráció: ",
				"user_name" => "",
				"password" => "",
				"password_repeat" => "",
				"email" => "",
				"message" => array(),
				"error_message" => array(
					"user_name" => "",
					"password" => "",
					"password_repeat" => "",
					"email" => "",
					"user_name_not_unique" => "",
					"password_not_match" => ""
				)
			);

			$this->contentArray = array('header','content_registration', 'footer');

			if($action == "registrate") {

				$user_name = isset($_POST['user_name']) ? $_POST['user_name'] : null;
				$password = isset($_POST['password']) ? $_POST['password'] : null;
				$password_repeat = isset($_POST['password_repeat']) ? $_POST['password_repeat'] : null;
				$email = isset($_POST['email']) ? $_POST['email'] : null;

				$error = false;

				if($user_name == null || $user_name == "") {	
					$this->varArray["error_message"]["user_name"] = "Felhasználói név kitöltése kötelező!";
					$error = true;
				} 

				if($password == null || $password == "") {
					$this->varArray["error_message"]["password"] = "Jelszó kitöltése kötelező!";
					$error = true;
				}

				if($password_repeat == null || $password_repeat == "") {
					$this->varArray["error_message"]["password_repeat"] = "Jelszó újra kitöltése kötelező!";
					$error = true;
				}

				if($email == null || $email == "") {
					$this->varArray["error_message"]["email"] = "Email kitöltése kötelező!";
					$error = true;
				}

				if(!$error) {
					if(!$this->is_user_name_unique($user_name)) {
						$this->varArray["error_message"]["user_name_not_unique"] = "Ez a felhasználónév már foglalt!";
						$error = true;
					} else if(!$this->is_password_match($password,$password_repeat)) {
						$this->varArray["error_message"]["password_not_match"] = "A két jelszó nem egyezik!";
						$error = true;
					} else {
						if(!$this->user_database->save_user($user_name,$password,$email)) {
							$error = true;
						} else {
							$this->varArray["message"][] = "Sikeres regisztráció!";
						}
					}
				}

				if($error) {
					$this->varArray["user_name"] = $user_name;
					$this->varArray["password"] = $password;
					$this->varArray["password_repeat"] = $password_repeat;
					$this->varArray["email"] = $email;
				}
			}
		} else if($page = "content_topics") {
			$this->varArray = array(

			);
			$this->contentArray = array('header','content_topics', 'footer');
		}
	}

	public function getContentArray() {
		return $this->contentArray;
		
	}

	public function getValue($param) {
		return $this->varArray[$param];
	}

	

	private function is_user_name_unique($user_name) {
		if($user_name == "santag") {
			return false;
		}
		return true;
	}

	private function is_password_match($password1, $password2) {
		if($password1 != $password2) {
			return false;
		}

		return true;
	}


}