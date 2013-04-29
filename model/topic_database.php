<?php

class Topic_database {
	private $db;

	function __construct() {
		$this->db = new PDO(Constants::$DATABASE_URL, Constants::$DATABASE_USERNAME, Constants::$DATABASE_PASSWORD);
	}

	public function get_topics() {
		$stmt = $this->db->prepare(<<<STR
			SELECT topic.title AS title, topic.id AS id, MAX(comment.modified_date) AS last_comment_date, count(comment.id) AS comments FROM topic
			LEFT JOIN comment ON comment.topic_id = topic.id
			GROUP BY topic.id
STR
		);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$ret = array();

		foreach($rows as $row) {
			$stmt = $this->db->prepare("SELECT user.name AS name, DATE(comment.modified_date) as date2 FROM user,comment 
										WHERE user.id = comment.user_id AND comment.modified_date = ? and comment.topic_id = ?");
			$stmt->execute(array($row["last_comment_date"],$row["id"]));

			$ret[] = array(
				'title' => $row["title"],
				'id' => $row["id"],
				'comments' => $row["comments"],
				'last_comment_date' => "",
				'last_comment_by' => "",
				'unread' => 0
			);

			if($stmt->rowCount() > 0) {
				$count = count($ret) - 1;
				$rows2 = $stmt->fetchAll(PDO::FETCH_ASSOC);

				$ret[$count]['last_comment_date'] = $rows2[0]["date2"];
				$ret[$count]['last_comment_by'] = $rows2[0]["name"];
			}
		}
		return $ret;
	}

	public function get_topics_with_unread_marked($user_id) {
		$topics = $this->get_topics();

		$new_topics = array();

		foreach($topics as $topic) {

			$is_row = $this->db->prepare("SELECT * FROM last_read WHERE last_read.topic_id = ? and last_read.user_id = ?");
			$is_row->execute(array($topic["id"],$user_id));
			if($is_row->rowCount() > 0) {
				$stmt = $this->db->prepare("SELECT COUNT(comment.id) as unread FROM comment, last_read WHERE comment.modified_date > last_read.date AND
											 comment.topic_id = ? AND last_read.user_id = ? AND comment.topic_id = last_read.topic_id");
				$stmt->execute(array($topic["id"], $user_id));
			} else {
				$stmt = $this->db->prepare("SELECT COUNT(comment.id) as unread FROM comment WHERE comment.topic_id = ?");
				$stmt->execute(array($topic["id"]));
			}

			$tmp_row = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			$new_topics[] = array(
				'title' => $topic["title"],
				'id' => $topic["id"],
				'comments' => $topic["comments"],
				'last_comment_date' => $topic["last_comment_date"],
				'last_comment_by' => $topic['last_comment_by'],
				'unread' => isset($tmp_row[0]["unread"]) ? $tmp_row[0]["unread"] : 0
			);
		}

		return $new_topics;
	}

	public function get_topic_title($topic_id) {
		$stmt = $this->db->prepare("SELECT title FROM topic WHERE topic.id = ?");
		$stmt->execute(array($topic_id));
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $rows[0]['title'];
	}

	public function get_comments($topic_id) {
		$stmt = $this->db->prepare("SELECT user.name AS user_name, user.id AS user_id, user.image_name as image_name, comment.content AS content, comment.create_date AS create_date,
								 	comment.id AS id, comment.like AS liked FROM comment, user WHERE comment.user_id = user.id and comment.topic_id = ? ORDER BY comment.create_date DESC");
		$stmt->execute(array($topic_id));
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $rows;
	}

	public function get_comment_by_id($comment_id) {
		$stmt = $this->db->prepare("SELECT * FROM comment WHERE id = ?");
		$stmt->execute(array($comment_id));
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $rows;
	}

	public function delete_comment($comment_id) {
		$stmt = $this->db->prepare("DELETE FROM comment WHERE id = ?");
		$stmt->execute(array($comment_id));
	}

	public function add_comment($user_id,$topic_id,$content,$comment_id) {

		if($comment_id != -1) {
			$stmt = $this->db->prepare("UPDATE comment SET content = ?, modified_date = now() WHERE id = ?");
			$rows = $stmt->execute(array(trim($content),$comment_id));
		} else {
			$stmt = $this->db->prepare("INSERT INTO comment (topic_id,user_id,content,create_date,modified_date) VALUES(?,?,?,now(),now())");
			$rows = $stmt->execute(array($topic_id,$user_id,trim($content)));
		}
		

		return $rows;
	}

	public function enter_topic_date($topic_id, $user_id) {
		$stmt = $this->db->prepare("DELETE FROM last_read WHERE topic_id = ? and user_id = ?");
		$stmt = $stmt->execute(array($topic_id,$user_id));

		$stmt = $this->db->prepare("INSERT INTO last_read (topic_id,user_id,date) values(?,?,now());");
		$stmt = $stmt->execute(array($topic_id,$user_id));
	}

	public function like_comment($comment_id) {
		$stmt = $this->db->prepare("SELECT comment.like as liked FROM comment WHERE comment.id = ?");
		$stmt->execute(array($comment_id));

		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$like = $rows[0]["liked"];

		$stmt = $this->db->prepare("UPDATE comment SET comment.like = ? WHERE comment.id = ?");
		$stmt = $stmt->execute(array($like + 1,$comment_id));
	}

	public function add_topic($title,$comment, $user_id) {
		$stmt = $this->db->prepare("INSERT INTO topic (title,create_date) VALUES(?,now())");
		$stmt->execute(array($title));

		$id = $this->db->lastInsertId();

		$this->add_comment($user_id, $id, $comment);

		if($stmt->rowCount() == 1) {
			return true;
		}

		return false;
	} 
}