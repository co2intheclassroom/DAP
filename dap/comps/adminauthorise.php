<!--Authorise is the lowest access level on the site. This will be used where access is for posters and readers -->

<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

	if ($_SESSION['isAdmin'] != 1){
				session_destroy(); //destroy the session
				header("Location: https://co2intheclassroom.co.uk/dap/badauth.php"); //redirect the user to badauth.php
					exit; //exit function
			};
			
//if stored session id doesnt match the session id or the session is not marked as loggedin or the session login value is not set at all.
if ($_SESSION['id'] != session_id() || !isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
	session_destroy(); //destroy the session
	header("Location: https://co2intheclassroom.co.uk/dap/badauth.php"); //redirect the user to badauth.php
    exit; //exit function
	}

?>