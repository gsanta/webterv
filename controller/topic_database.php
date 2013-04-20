<?php

class Topic_database {
	private $db;

	function __construct() {
		$this->db = new PDO(Constants::$DATABASE_URL, Constants::$DATABASE_USERNAME, Constants::$DATABASE_PASSWORD);
	}

	public function get_topics() {
		$stmt = $this->db->prepare(<<<STR
			SELECT topic.title AS title, topic.id AS id, date(c.last_comment_date) AS last_comment_date, count(c.comments) AS comments,
			user.name AS last_comment_by FROM topic
			LEFT JOIN (SELECT MAX(comment.modified_date) as last_comment_date, COUNT(comment.topic_id) as comments, comment.topic_id as c_topic_id,
			comment.user_id as c_user_id FROM comment GROUP BY comment.modified_date HAVING comment.topic_id = topic_id) as c ON topic.id = c_topic_id
			LEFT JOIN user ON user.id = c_user_id GROUP BY topic.id;
STR
		);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $rows;
	}

	public function get_topics_with_unread_marked($user_id) {
		$stmt = $this->db->prepare(<<<STR
			SELECT topic.title AS title, topic.id AS id, date(c.last_comment_date) AS last_comment_date, count(c.comments) AS comments,
			user.name AS last_comment_by, lr_date as last_read_date FROM topic
			LEFT JOIN (SELECT MAX(comment.modified_date) as last_comment_date, COUNT(comment.topic_id) as comments, comment.topic_id as c_topic_id,
			comment.user_id as c_user_id FROM comment GROUP BY comment.modified_date HAVING comment.topic_id = topic_id) as c ON topic.id = c_topic_id
			LEFT JOIN user ON user.id = c_user_id 
			LEFT JOIN (SELECT last_read.topic_id as topic_id, last_read.user_id as user_id, last_read.date as lr_date from last_read
			WHERE last_read.topic_id = topic_id and last_read.user_id = ?) as lr ON topic.id = lr.topic_id
			GROUP BY topic.id;
STR
		);

		$stmt->execute(array($user_id));
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

	public function enter_topic_date($topic_id, $user_id) {
		$stmt = $this->db->prepare("DELETE FROM last_read WHERE topic_id = ? and user_id = ?");
		$stmt = $stmt->execute(array($topic_id,$user_id));

		$stmt = $this->db->prepare("INSERT INTO last_read (topic_id,user_id,date) values(?,?,now());");
		$stmt = $stmt->execute(array($topic_id,$user_id));
	}
}