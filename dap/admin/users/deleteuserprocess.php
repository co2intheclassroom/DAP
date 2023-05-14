<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/dap/comps/adminauthorise.php'); 
?>

<?php
	$user_ID = $_GET['userID'];

	
	include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/connection.php');
	
	//if($locationID == 'X') {
	//			$statement = "INSERT INTO Monitors(Mon_ID, AuthCode) VALUES ('".$monitorid."','".$authcode."')";
	//		}else{
	//			$statement = "INSERT INTO Monitors(Mon_ID, Current_Location, AuthCode) VALUES ('".$monitorid."','".$locationID."','".$authcode."')";
	//		};
	
	$statement = "SELECT Protected FROM Users WHERE User_ID =".$user_ID." "; //prepare sql statement

	$result = mysqli_query($conn, $statement); //run sql query statement on the database.
			
	if($result){//if the result has been successful
		while ($r = mysqli_fetch_assoc($result)) { //for each row in the result
					$protected = $r['Protected'];
		
			};			
	};	


		//$statement = "INSERT INTO Locations (Location_Name, Location_Type_ID) VALUES ('".$new_location_name."','".$new_location_type."')";
	
	if ($protected != 1){
		
		$statement2 = "DELETE FROM Users WHERE User_ID = ".$user_ID." ";
		$result2 = mysqli_query($conn, $statement2);
			if(!$result2){
				echo mysqli_error($conn);
				$location = 'users.php?status=0';
			}else{
				echo "Deleted succesfully";
				$statement = "INSERT INTO `User_Event_Log`(`User_ID`, `UEvent_Code`, `UEvent_Info`) VALUES ('".$_SESSION['userID']."','10','Deleted user - ".$user_ID."')";
				$result = mysqli_query($conn, $statement);
				$location = 'users.php?status=2';
			};
	
	header("Location: $location");
	}else{
		echo "User is protected and cannot be deleted";
		$location = 'users.php?status=3';
		
	};
		
	header("Location: $location");
?>
