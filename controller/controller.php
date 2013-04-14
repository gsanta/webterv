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
			$this->varArray = array(
				"valami" => "Név: ",
			);
			$this->contentArray = array('header','content_login', 'footer');
		}
	}

	public function getContentArray() {
		return $this->contentArray;
		
	}

	public function getValue($param) {
		return $this->varArray[$param];
	}
}