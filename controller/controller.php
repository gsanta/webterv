<?php

class Controller {
	private $varArray;
	private $contentArray;

	function __construct() {
		$this->createContent();
	}

	public function loggedIn() {

	}

	private function createContent() {
		$page = isset($_GET['page']) ? $_GET['page'] : null;

		if($page == NULL) {
			$this->contentArray = array('header','content', 'footer');
		} else if($page == 'login') {

			$action = isset($_GET['action']) ? $_GET['action'] : null;

			$this->varArray = array(
				"user_name_label" => "Felhasználói azonosító: ",
				"password_label" => "Jelszó: ",
				"user_name" => "",
				"login_message" => "",
				"error_message" => ""
			);
			$this->contentArray = array('header','content_login', 'footer');

			if($action == "login") {
				$user_name = isset($_POST['user_name']) ? $_POST['user_name'] : null;
				$password = isset($_POST['password']) ? $_POST['password'] : null;

				if($this->authenticate($user_name, $password)) {
					$this->varArray["login_message"] = "sikerült!";
				} else {
					$this->varArray["user_name"] =  $user_name;
					$this->varArray["error_message"] = "hibás felhasználói név vagy jelszó";
				}
			}
			
		}
	}

	public function getContentArray() {
		return $this->contentArray;
		
	}

	public function getValue($param) {
		return $this->varArray[$param];
	}

	private function authenticate($user_name, $password) {
		if($user_name == "admin" && $password == "santag") {
			return true;
		} else {
			return false;
		}
	}
}