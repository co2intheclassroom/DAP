<?php

//connection details
$servername = "localhost";
$username = "admin";
$password = "784f7022496a94134eea4850a84d38f7186c27bb55b3169f";
$database = 'CITC';

$conn = new mysqli($servername, $username, $password, $database);


//monitor submission information retrieved via GET
$authcode = $_GET['auth'];

$monitorid = $_GET['monid'];
$eventid = $_GET['eventid'];
$eventinfo = $_GET['eventinfo'];


//Query database to confirm that auth code submitted from monitor matches the one stored in the database. Stored auth code is not revealed.
$authcheckstmnt = "SELECT IF((SELECT AuthCode FROM Monitors WHERE MON_ID = '".$monitorid."')='".$authcode."', 'PASS', 'FAIL') AS AUTH_CHECK";
$result = mysqli_query($conn, $authcheckstmnt);

while ($r = mysqli_fetch_assoc($result)) { //for each row in the result
		$authcheck = $r['AUTH_CHECK'];
};


//if the auth check has passed then set the relevant statement based on the eventid.
if ($authcheck == "PASS") {
	//eventid = 1. Update IP address in monitor table.
	if ($eventid == '1') { 
		$eventstatement = "UPDATE Monitors SET IP_ADDRESS='".$eventinfo."' WHERE Mon_ID = '".$monitorid."'";
	};
	
	//eventid = 2.Update MAC address in monitor table.
	if ($eventid == '2') {
		$eventstatement = "UPDATE Monitors SET MAC='".$eventinfo."' WHERE Mon_ID = '".$monitorid."'";
	};
	
	//eventid = 3.Add a boot up event to the monitor event log table
	if ($eventid == '3') { 
		$eventstatement = "INSERT INTO `Monitor_Event_Log`(`Mon_ID`, `MEvent_Code`, `MEvent_Info`) VALUES ('".$monitorid."','3','Boot UP')";
	};
	
	//execute the statement set above
	$result = mysqli_query($conn, $eventstatement);
};


//close connection
$conn->close();

?>

<p><a href='https://co2intheclassroom.co.uk/'>CO2 in the Classroom</a></p>