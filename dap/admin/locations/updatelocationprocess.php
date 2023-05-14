<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/dap/comps/adminauthorise.php'); 
?>

<?php
	$location_ID = $_POST['form_Location_ID'];
	$new_location_name = $_POST['form_Location_Name'];
			
			
	include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/connection.php');

		$statement = "UPDATE Locations SET Location_Name='".$new_location_name."' WHERE ID = ".$location_ID." ";

		$result = mysqli_query($conn, $statement);

		if(!$result){
			$location = 'viewlocation.php?locationID='.$location_ID.'&status=0';
		}else{
			$statement = "INSERT INTO `User_Event_Log`(`User_ID`, `UEvent_Code`, `UEvent_Info`) VALUES ('".$_SESSION['userID']."','5','Renamed Location ".$location_ID." to ".$new_location_name."')";
			$result = mysqli_query($conn, $statement);
			$location = 'viewlocation.php?locationID='.$location_ID.'&status=1';
		};
		
		 header("Location: $location");
?>
