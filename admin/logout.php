<?php
	//Start Session
	session_start();

	//Unset variables of session
	session_unset();

	//Destroy Session
	session_destroy();
	
	header('Location: index.php');
	exit();
?>