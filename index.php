<?php

//Check to see if a session is already in progress. If it isn't then start one
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } ;

//Check the session details. If the user is not logged in then destroy the session and redirect the user to the login page.
if ($_SESSION['id'] != session_id() || !isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
	session_destroy(); //destroy the session
	$location = 'login.php';
	}else{
		//if the user is logged in redirect them to the DAP index page.
		$location = 'dap/index.php';
		
	};
	header("Location: $location");
	
?>

