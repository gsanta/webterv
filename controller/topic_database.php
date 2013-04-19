<?php

class Topic_database {
	private $db;

	function __construct() {
		$this->db = new PDO(Constants::$DATABASE_URL, Constants::$DATABASE_USERNAME, Constants::$DATABASE_PASSWORD);
	}

	public function get_topics() {
		$stmt = $this->db->prepare("SELECT topic.title AS title, topic.id AS id, topic.create_date AS create_date, count(comment.topic_id) AS comments," . 
									" max(comment.id) as last_comment_by FROM topic  LEFT JOIN comment ON topic.id = comment.topic_id GROUP BY topic.id;");
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $rows;
	}

	public function get_comments($topic_id) {
		$stmt = $this->db->prepare("SELECT user.name AS user_name, comment.content AS content, comment.create_date AS create_date " .
									" FROM comment, user WHERE comment.user_id = user.id and comment.topic_id = " . $topic_id);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $rows;
	}

	public function add_comment($user_id,$topic_id,$content) {
		$stmt = $this->db->prepare("INSERT INTO comment (topic_id,user_id,contednt,create_date,modified_date) VALUES(?,?,?,now(),now())");
		$rows = $stmt->execute(array($topic_id,$user_id,$content));

		return $rows;
	}

}