<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/dap/comps/adminauthorise.php'); 
?>

<?php
	$monitorid =$_POST['form_MonitorID'];
	$authcode = $_POST['form_AuthCode'];
	
	include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/connection.php');
	
	
	$statement = "INSERT INTO Monitors(Mon_ID, AuthCode) VALUES ('".$monitorid."','".$authcode."')";		
		
	$result = mysqli_query($conn, $statement);

	if(!$result){
		$location = 'monitors.php?status=0';
	}else{
		$statement = "INSERT INTO `User_Event_Log`(`User_ID`, `UEvent_Code`, `UEvent_Info`) VALUES ('".$_SESSION['userID']."','6','Added new monitor - ".$monitorid."')";
		$result = mysqli_query($conn, $statement);
		$statement = "INSERT INTO `Monitor_Event_Log`(`Mon_ID`, `MEvent_Code`, `MEvent_Info`) VALUES ('".$monitorid."','6','Monitor added to the system')";
		$result = mysqli_query($conn, $statement);
		$location = 'monitors.php?status=1';
	};
		
		header("Location: $location");
?>
