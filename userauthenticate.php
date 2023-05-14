<?php
//SQL Connection details
$servername = "localhost";
$username = "admin";
$password = "**********************************";
$database = "CITC";

$conn = mysqli_connect($servername, $username, $password, $database);

//Retrieve username and password details from POST
$submituser = $_POST['username'];
$submitpass = $_POST['password'];

//lookup and retrieve user details
$statement = "SELECT Username,Password,Def_Location,isAdmin,User_ID FROM Users WHERE Username='".$submituser."'";
$result = mysqli_query($conn, $statement);

//if there is a result
if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)) {
		$username = $row['Username'];
		$stored_password = $row['Password'];
		$Def_Location = $row['Def_Location'];
		$is_admin = $row['isAdmin'];
		$userid = $row['User_ID'];
		
		//verify the password entered is correct
		if (password_verify($submitpass, $stored_password)) {
				  // SUCCESS
			session_start();
			$_SESSION['id'] = session_id();
			$_SESSION['username'] = $username;
			$_SESSION['loggedin'] = true;
			$_SESSION['Def_Location'] = $Def_Location;
			$_SESSION['isAdmin'] = $is_admin;
			$_SESSION['userID'] = $userid;
			
			//add login to user event log
			$statement = "INSERT INTO `User_Event_Log`(`User_ID`, `UEvent_Code`, `UEvent_Info`) VALUES ('".$userid."','1','Logged in')";
			$result = mysqli_query($conn, $statement);

			$location = '/dap/facts/fact.php';

		}else{
			//If the password is incorrect
			$location = 'login.php?error=1';
		};
	
    };
}else{
          //If the user is not found in the database
	$location = 'login.php?error=2';
      
};

//close connection
$conn->close();

//redirect user to new location.
header("Location: $location");
?>