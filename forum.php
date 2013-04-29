<?php
	session_start();
    require 'controller/controller.php';
    require 'utils/constants.php';
    require 'model/install.php';
    require 'model/user_database.php';
	require 'model/topic_database.php';
     

    Install::init_if_not_exists();
    
    $controller = new Controller();
    $contentArray = $controller->getContentArray();

    foreach ($contentArray as $item) {
            require 'includes/' . $item . '.php';
    }

    

