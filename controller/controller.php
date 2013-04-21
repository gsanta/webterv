<?php

require 'user_database.php';
require 'topic_database.php';

class Controller {
	private $varArray;
	private $contentArray;
	private $user_database;
	private $topic_database;

	function __construct() {
		$this->user_database = new User_database();
		$this->topic_database = new Topic_database();
		$this->createContent();
	}

	public function loggedIn() {

	}

	private function createContent() {
		$page = isset($_GET['page']) ? $_GET['page'] : 'topics';
		$action = isset($_GET['action']) ? $_GET['action'] : null;
		
		if($page == 'login') {
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

						 header('Location: http://' . Constants::$BASE_URL . '?page=topics');

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
				"registration_label" => "Regisztráció",
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
					if(!$this->user_database->is_user_name_unique($user_name)) {
						$this->varArray["error_message"]["user_name_not_unique"] = "Ez a felhasználónév már foglalt!";
						$error = true;
					} else if(!$this->is_password_match($password,$password_repeat)) {
						$this->varArray["error_message"]["password_not_match"] = "A két jelszó nem egyezik!";
						$error = true;
					} else if(filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
						$this->varArray["error_message"]["email"] = "Hibás email cím!";
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
		} else if($page == "topics") {
			$this->varArray = array(
				'topic_rows' => array()
			);

			if(isset($_SESSION['user_data'])) {
				$this->varArray['topic_rows'] = $this->topic_database->get_topics_with_unread_marked($_SESSION['user_data']['id']);
			} else {
				$this->varArray['topic_rows'] = $this->topic_database->get_topics();
			}
			

			$this->contentArray = array('header','content_topics', 'footer');
			
		} else if($page == "topic") {
			$topic_id = isset($_GET['topic_id']) ? $_GET['topic_id'] : null;

			$this->varArray = array(
				'comment_rows' => array(),
				'topic_id' => $topic_id,
				'topic_title' => ""
			);

			$this->contentArray = array('header','content_topic', 'footer');
			$this->varArray['comment_rows'] = $this->topic_database->get_comments($topic_id);
			$this->varArray['topic_title'] = $this->topic_database->get_topic_title($topic_id);

			if(isset($_SESSION["user_data"])) {
				$this->topic_database->enter_topic_date($topic_id, $_SESSION["user_data"]["id"]);
			}
		} else if($page == "new_comment") {
			$topic_id = isset($_GET['topic_id']) ? $_GET['topic_id'] : null;

			$this->varArray = array(
				'topic_id' => $topic_id,
				'topic_title' => ""
			);

			$this->contentArray = array('header','content_comment_new', 'footer');
			$this->varArray['topic_title'] = $this->topic_database->get_topic_title($topic_id);

			$action = isset($_POST['action']) ? $_POST['action'] : null;
			if($action == "add_comment") {
				$topic_id = isset($_POST['topic_id']) ? $_POST['topic_id'] : null;
				$content = isset($_POST['content']) ? $_POST['content'] : null;

				if($this->topic_database->add_comment($_SESSION['user_data']['id'],$topic_id,$content) == 1) {
					header('Location: http://' . Constants::$BASE_URL . '?page=topic&topic_id=' . $topic_id);
				}
			}
		} else if($page == "logout") {
			unset($_SESSION['user_data']);

			header('Location: http://' . Constants::$BASE_URL . '?page=login');
		} else if($page == "like") {
			$topic_id = isset($_GET['topic_id']) ? $_GET['topic_id'] : null;
			$comment_id = isset($_GET['comment_id']) ? $_GET['comment_id'] : null;

			$this->topic_database->like_comment($comment_id);

			header('Location: http://' . Constants::$BASE_URL . '?page=topic&topic_id=' . $topic_id);
		} else if($page == "new_topic") {
			$this->varArray = array(
				'error_message' => ""
			);

			$this->contentArray = array('header','content_topic_new', 'footer');
			if(!isset($_SESSION['user_data'])) {
				return;
			}	

			$action = isset($_POST['action']) ? $_POST['action'] : null;
			if($action == "add_topic") {
				$topic_name = isset($_POST['title']) ? $_POST['title'] : null;
				$comment = isset($_POST['comment']) ? $_POST['comment'] : null;
				if($this->topic_database->add_topic($topic_name, $comment, $_SESSION['user_data']['id']) == 1) {
					header('Location: http://' . Constants::$BASE_URL . '?page=topics');
				} else {
					$this->varArray['error_message'] = 'Hiba történt!';
				}
			}
		} else if($page == "profile") {
			$this->varArray = array(
				'error_message' => ""
			);

			$this->contentArray = array('header','content_profile', 'footer');
			if(!isset($_SESSION['user_data'])) {
				return;
			}	

			$action = isset($_POST['action']) ? $_POST['action'] : null;
			if($action == "upload") {
				if ($_FILES["file"]["error"] > 0) {
				    $this->varArray['error_message'] = "Hiba történt!";
				} else {

					$allowedExts = array("gif", "jpeg", "jpg", "png");
					$extension = end(explode(".", $_FILES["file"]["name"]));
					if ((($_FILES["file"]["type"] == "image/gif")
							|| ($_FILES["file"]["type"] == "image/jpeg")
							|| ($_FILES["file"]["type"] == "image/jpg")
							|| ($_FILES["file"]["type"] == "image/pjpeg")
							|| ($_FILES["file"]["type"] == "image/x-png")
							|| ($_FILES["file"]["type"] == "image/png"))
							&& in_array($extension, $allowedExts)) {

						$image = "profile_" . $_SESSION['user_data']['id'] . '.' . $extension;
						$this->user_database->upload_profile($_SESSION['user_data']['id'],$image);
							move_uploaded_file($_FILES["file"]["tmp_name"],"upload/" . $image);
							header('Location: http://' . Constants::$BASE_URL . '?page=topics');
					}
					
				}

				

				/*if($this->topic_database->add_topic($topic_name, $comment, $_SESSION['user_data']['id']) == 1) {
					header('Location: http://' . Constants::$BASE_URL . '?page=topics');
				} else {
					$this->varArray['error_message'] = 'Hiba történt!';
				}*/
			}
		}
	}

	public function getContentArray() {
		return $this->contentArray;
		
	}

	public function getValue($param) {
		return $this->varArray[$param];
	}

	private function is_password_match($password1, $password2) {
		if($password1 != $password2) {
			return false;
		}

		return true;
	}


}