<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/dap/comps/adminauthorise.php'); 
?>

<?php
	$user_ID =$_GET['User_ID'];
	$admin_status = $_GET['Admin_Status'];
	
	echo $user_ID;
	echo "</br>";
	echo $admin_status;
	echo "</br>";
	
	include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/connection.php');
	
	$statement = "UPDATE `Users` SET isAdmin='".$admin_status."' WHERE User_ID = '".$user_ID."'";
	
	$result = mysqli_query($conn, $statement);

	if(!$result){
		echo mysqli_error($conn);
		$location = 'edituser.php?status=0&userID='.$user_ID;
		}else{
			echo "Admin Role succesfully updated";
			
			if ($admin_status == 1){
				$statement = "INSERT INTO `User_Event_Log`(`User_ID`, `UEvent_Code`, `UEvent_Info`) VALUES ('".$_SESSION['userID']."','13','Assigned admin privileges to ".$user_ID."')";	
			} else {
				$statement = "INSERT INTO `User_Event_Log`(`User_ID`, `UEvent_Code`, `UEvent_Info`) VALUES ('".$_SESSION['userID']."','13','Removed admin privileges for user ".$user_ID."')";
			};
			
			$result = mysqli_query($conn, $statement);
			$location = 'edituser.php?status=2&userID='.$user_ID;
		};
		
		header("Location: $location");
?>


