<?php
	session_start();
    require 'controller/controller.php';
     
    $controller = new Controller();
    $contentArray = $controller->getContentArray();

    foreach ($contentArray as $item) {
            require 'includes/' . $item . '.php';
    }