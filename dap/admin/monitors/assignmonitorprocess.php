<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/dap/comps/adminauthorise.php'); 
?>

<?php
	$monitor_ID = $_POST['form_Monitor_ID'];
	$new_location_ID = $_POST['form_new_locationID'];
	$locationid = $_POST['form_CurrentLocation'];
			
	include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/connection.php');


	//remove assignments
	$statement = "UPDATE Locations SET Current_Mon_ID=NULL WHERE ID =".$locationid;		
	$result = mysqli_query($conn, $statement);
	
	$statement = "UPDATE Monitors SET Current_Location=NULL WHERE Mon_ID ='".$monitorID."'";		
	$result = mysqli_query($conn, $statement);


	//add assignments
	$statement = "UPDATE Locations SET Current_Mon_ID='".$monitor_ID."' WHERE ID =".$new_location_ID;		
	$result = mysqli_query($conn, $statement);
	
	$statement = "UPDATE Monitors SET Current_Location=".$new_location_ID." WHERE Mon_ID ='".$monitor_ID."'";		
	$result = mysqli_query($conn, $statement);
	

		if(!$result){
			$location = 'viewmonitor.php?monitorID='.$monitor_ID.'&status=0';
		}else{
			$statement = "INSERT INTO `User_Event_Log`(`User_ID`, `UEvent_Code`, `UEvent_Info`) VALUES ('".$_SESSION['userID']."','7','".$monitor_ID." assigned to location ".$new_location_ID."')";
			$result = mysqli_query($conn, $statement);
			$statement = "INSERT INTO `Monitor_Event_Log`(`Mon_ID`, `MEvent_Code`, `MEvent_Info`) VALUES ('".$monitor_ID."','7','Monitor assigned to location ".$new_location_ID."')";
			$result = mysqli_query($conn, $statement);
			$location = 'viewmonitor.php?monitorID='.$monitor_ID.'&status=2';
		};
		
		 header("Location: $location");
?>
