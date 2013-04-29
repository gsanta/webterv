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

	public function refresh_time($user_id) {
		$stmt = $this->db->prepare("UPDATE user SET last_interact_date = now() WHERE id = ?");
		$row = $stmt->execute(array($user_id));
	}

	public function get_active_users() {
		$stmt = $this->db->prepare("SELECT * FROM user WHERE DATE_SUB(NOW(), INTERVAL 1 MINUTE) < last_interact_date");
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $rows;
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
			$auth_info["user_data"]["image_name"] = $row["image_name"];
		}
		return $auth_info;
	}

	public function is_user_name_unique($user_name) {
		$stmt = $this->db->prepare("SELECT * FROM user WHERE name=?");
		$stmt->execute(array($user_name));

		if($stmt->rowCount() > 0) {
			return false;
		}
		return true;
	}

	public function upload_profile($user_id,$image_name) {
		$stmt = $this->db->prepare("UPDATE user SET image_name = ? WHERE id = ?");
		$stmt->execute(array($image_name, $user_id));

		if($stmt->rowCount() > 0) {
			return true;
		}
		return false;
	}

}