<?php

class User_database {
	private $db;

	function __construct() {
		$this->db = new PDO(Constants::$DATABASE_URL, Constants::$DATABASE_USERNAME, Constants::$DATABASE_PASSWORD);
	}

	public function get_db() {
		return $this->db;
	}

	public function save_user($user_name,$password,$email) {
		$stmt = $this->db->prepare("INSERT INTO user (name,password,email) values(?,?,?)");
		$row = $stmt->execute(array($user_name, md5($password),$email));
		if($row == 1) {
			return true;
		} else {
			return false;
		}
	}

	public function authenticate($user_name, $password) {
		$auth_info = array(
			"success" => false,
			"user_data" => array()
		);

		$stmt = $this->db->prepare("SELECT * FROM user WHERE name=? AND password=?");
		$stmt->execute(array($user_name, md5($password)));
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($rows as $row){
			$auth_info["success"] = true;
			$auth_info["user_data"]["name"] = $row["name"];
			$auth_info["user_data"]["id"] = $row["id"];
		}
		return $auth_info;
	}

}