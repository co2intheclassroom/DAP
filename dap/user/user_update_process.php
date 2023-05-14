<?php
//Authorises user to view page. Access level - standard user
require_once($_SERVER['DOCUMENT_ROOT'].'/dap/comps/authorise.php'); 

//Summary
//User ID, Location ID, User eMail and a boolean value for whether or not the user recieves email alerts is brought in via $_POST from the form at dap/user/viewuser.php
//A connection is then made to the database and the relevant users details are updated.

//ser variable values from form via $_POST
$user_ID = $_POST['form_User_ID'];
$new_location_id = $_POST['form_new_locationID'];
$user_reports = $_POST['form_email_rep'];
$user_email = $_POST['form_email'];

//load database connection settings
include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/connection.php');

//set up the UPDATE statement, loading in the variables above
$statement = "UPDATE Users SET Def_Location=$new_location_id,GenReports=$user_reports,eMail='$user_email' WHERE User_ID = $user_ID";

//run the command on the database		
$result = mysqli_query($conn, $statement);

//if there is no result then redirect to viewuser page with an error status of 0. This will display a message at the top of the screen informing the user that something went front
if(!$result){
	$location = 'viewuser.php?userID='.$user_ID.'&status=0';
}
//if there is a result then add an event to the user event log, update the users $_SESSION variable which sets their default location for their home page and setup a redirect to take them to the sites homepage
else{
	$statement = "INSERT INTO `User_Event_Log`(`User_ID`, `UEvent_Code`, `UEvent_Info`) VALUES ('".$_SESSION['userID']."','12','Updated default location to location ".$new_location_id."')"; //statement for adding an event to the user event log
	
	$result = mysqli_query($conn, $statement); //run the command on the database
			
	$_SESSION['Def_Location'] = $new_location_id; //update users default location for their current session
	$location = 'https://co2intheclassroom.co.uk/'; //set redirection location
};

header("Location: $location");//carry out the redirection		
?>



