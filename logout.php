<?php

	// start session
	session_start();

	// destroy session
	session_destroy();

	// redirect to login page
	header('location: login.php');
	exit;
?>
