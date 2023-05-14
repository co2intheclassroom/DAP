<?php

	require_once($_SERVER['DOCUMENT_ROOT'].'/dap/comps/adminauthorise.php'); 
	
	$monitorid = $_GET['monitorid'];
	
	//does monitor have a locaiton?
	
	
	include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/connection.php');
	
	$statement = "SELECT `Current_Location` FROM `Monitors` WHERE `Mon_ID` = '$monitorid';";
	$result = mysqli_query($conn, $statement); //run sql query statement on the database.
	echo "</br>";		
	if($result){//if the result has been successful
		while ($r = mysqli_fetch_assoc($result)) { //for each row in the result
			$currentlocationid = $r['Current_Location'];
		}			
		
		$statement = "UPDATE Locations SET Current_Mon_ID=NULL WHERE ID =".$currentlocationid;		
		$result = mysqli_query($conn, $statement);
		echo "</br>";
		
		$statement = "INSERT INTO `User_Event_Log`(`User_ID`, `UEvent_Code`, `UEvent_Info`) VALUES ('".$_SESSION['userID']."','8','".$monitorid." unassigned from location ".$currentlocationid."')";
		$result = mysqli_query($conn, $statement);
	
		$statement = "UPDATE Monitors SET Current_Location=NULL WHERE Mon_ID ='".$monitorid."'";		
		$result = mysqli_query($conn, $statement);
		
		$statement = "INSERT INTO `Monitor_Event_Log`(`Mon_ID`, `MEvent_Code`, `MEvent_Info`) VALUES ('".$monitorid."','8','Monitor unassigned fom location ".$currentlocationid."')";
		$result = mysqli_query($conn, $statement);
		
		echo "</br>";
	}
			//if an error occurs a message is displayed on screen.
	else{
		echo "Database error";
		echo mysqli_error($conn);
	}
				 
	$statement = "DELETE FROM Monitors WHERE Mon_ID = '".$monitorid."'";

	$result = mysqli_query($conn, $statement);		



	$statement = "INSERT INTO `User_Event_Log`(`User_ID`, `UEvent_Code`, `UEvent_Info`) VALUES ('".$_SESSION['userID']."','14','Monitor removed from system - ".$monitorid."')";
	$result = mysqli_query($conn, $statement);
				
	$statement = "INSERT INTO `Monitor_Event_Log`(`Mon_ID`, `MEvent_Code`, `MEvent_Info`) VALUES ('".$monitorid."','14','Monitor removed from system.')";
	$result = mysqli_query($conn, $statement);			
	header("Location: monitors.php");
?>
