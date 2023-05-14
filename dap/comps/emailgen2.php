<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);


//LOOKUP USERS
$servername = "localhost";
$username = "admin";
$password = "784f7022496a94134eea4850a84d38f7186c27bb55b3169f";
$dbname = "CITC";
$conn = mysqli_connect($servername, $username, $password, $dbname);


$statement = "SELECT Users.Username, Users.Def_Location, Users.eMail, Users.GenReports, Locations.Location_Name 
			FROM Users
			LEFT JOIN Locations ON Users.Def_Location = Locations.ID"; //prepare sql statement

			
$result = mysqli_query($conn, $statement); //run sql query statement on the database.

if($result){//if the result has been successful
	while ($r = mysqli_fetch_assoc($result)) { //for each row in the result
					//for each result row .........
		
		$Rep_Username = $r['Username'];
		$Rep_Location = $r['Def_Location'];
		$Rep_Email = $r['eMail'];
		$Rep_Location_Name = $r['Location_Name'];
					
		if ($r['GenReports'] == 1) {	
			Gen_Rep_Email($Rep_Username,$Rep_Location,$Rep_Email,$Rep_Location_Name);
		}
	}			
};
			
			

function Gen_Rep_Email($Rep_Username,$Rep_Location,$Rep_Email,$Rep_Location_Name) {
	$servername = "localhost";
	$username = "admin";
	$password = "784f7022496a94134eea4850a84d38f7186c27bb55b3169f";
	$dbname = "CITC";
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	
	//email settings
	$FROMEMAIL  = '"CO2 in the Classroom" <citcdap@gmail.com>';
	$RANDOMHASH = "anyrandomhash";
	$FICTIONALSERVER = "@email.co2intheclassroom.co.uk";
	$ORGANIZATION = "CITC";

	// Basic headers
	$headers = "From: ".$FROMEMAIL."\n";
	$headers .= "Reply-To: ".$FROMEMAIL."\n";
	$headers .= "Return-path: ".$FROMEMAIL."\n";
	$headers .= "Message-ID: <".$RANDOMHASH.$FICTIONALSERVER.">\n";
	$headers .= "X-Mailer: Your Website\n";
	$headers .= "Organization: $ORGANIZATION\n";
	$headers .= "MIME-Version: 1.0\n";

	// Add content type (plain text encoded in quoted printable, in this example)
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	
	//set date
	$queryday = date('Y-m-d');
	$ukDate = date("d-m-Y", strtotime($queryday));
	$previousday = date('Y-m-d', strtotime("-1 day", strtotime($queryday)));
	
	//generate subject
	$subject = "Daily CO2 Report : $Rep_Location_Name";
	
	//generate message
	$message = '<html><style>
	table {
	  border-collapse: collapse;
	  width: 100%;
	}

	th, td {
	  padding: 8px;
	  text-align: left;
	  border-bottom: 1px solid #DDD;
	}
	tr:hover {background-color: #D6EEEE;}
	</style><body>';
	$message .= "<h1>$Rep_Location_Name</h1>";
	$message .= "<p>Date of report : $ukDate</p>";
	$message .= "<p>Username : $Rep_Username</p>";
	$message .= '<br></br>';
	
	//QUERY Days Highest and average
	$query = "SELECT 
				MAX(Value) AS Max ,AVG(Value) AS Avg
				FROM `Readings`  
				WHERE 
				Location_ID = ".$Rep_Location."
				AND
				Timestamp BETWEEN '$queryday 08:00:00' AND '$queryday 18:00:00'";
				
	$exec = mysqli_query($conn,$query);
	
	while($row = mysqli_fetch_array($exec)){
	
		$today_maximum = (int)$row['Max'];
		$today_average = (int)$row['Avg'];
		
		//$message .= "<p>Today's high : $today_maximum ppm</p>";
		//$message .= "<p>Today's average : $today_average ppm</p>";
				
	};
	
	
	//QUERY Yesterdays Days Highest and average
	$query = "SELECT 
				MAX(Value) AS Max ,AVG(Value) AS Avg
				FROM `Readings`  
				WHERE 
				Location_ID = ".$Rep_Location."
				AND
				Timestamp BETWEEN '$previousday 08:00:00' AND '$previousday 18:00:00'";
				
	$exec = mysqli_query($conn,$query);
	
	while($row = mysqli_fetch_array($exec)){
	
		$yesterday_maximum = (int)$row['Max'];
		$yesterday_average = (int)$row['Avg'];
		
		$message .= "<p>Today's high : <b>$today_maximum ppm</b> (Yesterday's high : $yesterday_maximum ppm)</p>";
		$message .= "<p>Today's average : <b>$today_average ppm</b> (Yesterday's average : $yesterday_average ppm)</p>";
				
	};
	
	$message .= "<br></br>";
	
	//table header
	$message .= '<table><tr><th>Time Range</h><th>High (ppm)</th><th>Average (ppm)</th>';

	//create table row for each hourly readings

	$query = "SELECT 
				HOUR(Timestamp) AS Hour,MIN(Value) AS Min,MAX(Value) AS Max ,AVG(Value) AS Avg
				FROM `Readings`  
				WHERE 
				Location_ID = ".$Rep_Location."
				AND
				Timestamp BETWEEN '$queryday 08:00:00' AND '$queryday 18:00:00'
				GROUP BY 
				HOUR(Timestamp)
				ORDER BY 
				AVG DESC";
				
				
	$exec = mysqli_query($conn,$query);
				 
	while($row = mysqli_fetch_array($exec)){
					
		$hour = (int)$row['Hour'];
		$between = strval($hour).":00-".strval($hour+1).":00";
		$between = strval($between);
					
		$minimum = (int)$row['Min'];
		$maximum = (int)$row['Max'];
		$average = (int)$row['Avg'];
					
		$message .= "<tr><td>$between</td><td>$maximum</td><td>$average</td></tr>";
				
	};

	$message .= '</table>
				 </body></html>';


	// Send email
	//mail($Rep_Email, $subject, $message, $headers, "-f".$FROMEMAIL);
	echo $message;
	sleep(2);
};





?>