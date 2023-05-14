<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/dap/comps/adminauthorise.php'); 
?>

<?php
	$locationid =$_GET['locationid'];
	$monitorID =$_GET['monitorid'];

	
	include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/connection.php');

	
	$statement = "UPDATE Locations SET Current_Mon_ID=NULL WHERE ID =".$locationid;		
	$result = mysqli_query($conn, $statement);
	
	$statement = "UPDATE Monitors SET Current_Location=NULL WHERE Mon_ID ='".$monitorID."'";		
	$result = mysqli_query($conn, $statement);
	
	echo $statement;

		if(!$result){
			echo mysqli_error($conn);
			$location = 'viewmonitor.php?monitorID='.$monitorID.'&status=0';
		}else{
			echo "Assignment removed succesfully";
			$statement = "INSERT INTO `User_Event_Log`(`User_ID`, `UEvent_Code`, `UEvent_Info`) VALUES ('".$_SESSION['userID']."','8','".$monitorID." unassigned from location ".$locationid."')";
			$result = mysqli_query($conn, $statement);
			$statement = "INSERT INTO `Monitor_Event_Log`(`Mon_ID`, `MEvent_Code`, `MEvent_Info`) VALUES ('".$monitorID."','7','Monitor unassigned fom location ".$locationid."')";
			$result = mysqli_query($conn, $statement);
			$location = 'viewmonitor.php?monitorID='.$monitorID.'&status=1';
		};
		
		header("Location: $location");
?>
