<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/dap/comps/adminauthorise.php'); 
?>

<?php
	$user_ID =$_POST['form_User_ID'];
	$new_user_password = $_POST['form_NewPassword'];
	
	include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/connection.php');
	
	$hashedpassword = password_hash($new_user_password, PASSWORD_DEFAULT);
	
	$statement = "UPDATE `Users` SET Password='".$hashedpassword."' WHERE User_ID = '".$user_ID."'";
	
	$result = mysqli_query($conn, $statement);

	if(!$result){
		echo mysqli_error($conn);
		$location = 'edituser.php?status=0&userID='.$user_ID;
		}else{
			echo "Password Updated succesfully";
			$statement = "INSERT INTO `User_Event_Log`(`User_ID`, `UEvent_Code`, `UEvent_Info`) VALUES ('".$_SESSION['userID']."','11','Changed password for user ".$user_ID."')";
			$result = mysqli_query($conn, $statement);
			
			$location = 'edituser.php?status=1&userID='.$user_ID;
		};
		
		header("Location: $location");
?>


