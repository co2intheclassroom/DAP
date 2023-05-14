<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/dap/comps/adminauthorise.php'); 
?>

<?php
	$new_location_name =$_POST['form_LocationName'];
				
	include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/connection.php');

		$statement = "INSERT INTO Locations (Location_Name) VALUES ('".$new_location_name."')";
		$result = mysqli_query($conn, $statement);

		if(!$result){
			$location = 'locations.php?status=0';
		}else{
			$location = 'locations.php?status=1';
		};
		
		$statement = "INSERT INTO `User_Event_Log`(`User_ID`, `UEvent_Code`, `UEvent_Info`) VALUES ('".$_SESSION['userID']."','2','Added new location - ".$new_location_name."')";
		$result = mysqli_query($conn, $statement);
		
		header("Location: $location");
?>
