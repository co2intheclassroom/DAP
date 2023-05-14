<?php

//connection details
$servername = "localhost";
$username = "admin";
$password = "784f7022496a94134eea4850a84d38f7186c27bb55b3169f";
$database = "CITC";

$conn = new mysqli($servername, $username, $password, $database);

//monitor submission information retrieved via GET
$authcode = $_GET['auth'];
$monitorid = $_GET['monid'];
$value = $_GET['val'];


//Query database to confirm that auth code submitted from monitor matches the one stored in the database. Stored auth code is not revealed.
$authcheckstmnt = "SELECT IF((SELECT AuthCode FROM Monitors WHERE MON_ID = '".$monitorid."')='".$authcode."', 'PASS', 'FAIL') AS AUTH_CHECK";
$result = mysqli_query($conn, $authcheckstmnt);

while ($r = mysqli_fetch_assoc($result)) { //for each row in the result
		$authcheck = $r['AUTH_CHECK'];
};

//If auth code check has passed  
if ($authcheck == "PASS") {
	//retrieve the registered current location of the Monitor
	$locationstatement = "SELECT Current_Location FROM Monitors WHERE Mon_ID = '".$monitorid."'";
	$result = mysqli_query($conn, $locationstatement);
	
	while ($r = mysqli_fetch_assoc($result)) { //for each row in the result
		$Current_Location_ID = $r['Current_Location'];
	};
	
	//If the value being submitted is less than 3000 then statement will add the result to the readings table
	if ($value < 4000) {
		$submit_statement = "INSERT INTO `Readings` (`Location_ID`,`Mon_ID`,`Value`) VALUES ('".$Current_Location_ID."','".$monitorid."','".$value."')";
		
	} else { //if the result is not less than 3000 then statement will add an event to the event log and send an HTTP response code of 999 to the monitor. Which will trigger it to perform a hardware reset
		$submit_statement = "INSERT INTO `Monitor_Event_Log` (`Mon_ID`,`MEvent_Code`,`MEvent_Info`) VALUES ('".$monitorid."','4','Reading Error : ".$value."')";
		http_response_code(999);
	};
	
	//carry out the statement action as set above
	$result = mysqli_query($conn, $submit_statement);

};

//close the connection
$conn->close();


?>

<p><a href='https://co2intheclassroom.co.uk/'>CO2 in the Classroom</a></p>