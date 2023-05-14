<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/dap/comps/adminauthorise.php'); 
?>

<?php
	$new_user_username =$_POST['form_NewUsername'];
	$new_user_password = $_POST['form_NewPassword'];
	$new_user_isAdmin = $_POST['form_isAdmin'];
	$new_user_default_location = $_POST['form_new_locationID'];
	$new_user_eMail = $_POST['form_eMail'];
	
	$hashedpassword = password_hash($new_user_password, PASSWORD_DEFAULT);
	
	if($_POST['form_isAdmin'] == 'on') { 
				$statement = "INSERT INTO Users (Username, Password, Def_Location, isAdmin,eMail) VALUES ('".$new_user_username."','".$hashedpassword."','".$new_user_default_location."',1,'".$new_user_eMail."')";
				$new_user_isAdmin = 'Yes';
				}else{
				$statement = "INSERT INTO Users (Username, Password, Def_Location, isAdmin,eMail) VALUES ('".$new_user_username."','".$hashedpassword."','".$new_user_default_location."',0,'".$new_user_eMail."')";
				$new_user_isAdmin = 'No';
				};
			
	include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/connection.php');
	
		$result = mysqli_query($conn, $statement);

		if(!$result){
			
			if(mysqli_errno($conn) == 1062) {
				$location = 'users.php?status=4';
			}else{
				echo mysqli_error($conn);
				$location = 'users.php?status=0';
			};

			
		}else{
			echo "New user added succesfully";
			$statement = "INSERT INTO `User_Event_Log`(`User_ID`, `UEvent_Code`, `UEvent_Info`) VALUES ('".$_SESSION['userID']."','9','Created new user-".$new_user_username." Admin-".$new_user_isAdmin."')";
			$result = mysqli_query($conn, $statement);
			$location = 'users.php?status=1';
		};
		
		header("Location: $location");
?>
