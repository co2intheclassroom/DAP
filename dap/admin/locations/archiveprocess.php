<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/dap/comps/adminauthorise.php'); 
	
	$location_ID = $_GET['locationID'];			
			
	include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/connection.php');

		$statement = "UPDATE Locations SET IsArchive=1 WHERE ID = ".$location_ID." ";
		
		

		$result = mysqli_query($conn, $statement);

		if(!$result){
			echo mysqli_error($conn);
			$location = 'locations.php';
		}else{
			$statement = "INSERT INTO `User_Event_Log`(`User_ID`, `UEvent_Code`, `UEvent_Info`) VALUES ('".$_SESSION['userID']."','3','Archived location - ".$location_ID."')";
			$result = mysqli_query($conn, $statement);
			$location = 'locations.php';
		};
		
		 header("Location: $location");
?>
