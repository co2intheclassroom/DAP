<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/dap/comps/adminauthorise.php'); 

  
	if(!isset($_GET['userID']) OR $_GET['userID']=='') { 
			$location = 'users.php';
			header("Location: $location");
			
		}else{
			$viewuser = $_GET['userID'];
		};

			 if(isset($_GET['status'])) { 
				if ($_GET['status'] == 0) {
					echo "<p> An error has occured! - Please chcek the details and try again. </p>";
				};

				if ($_GET['status'] == 1) {
					echo "<p> SUCCESS - Password Updated Successfully</p>";
				};
				
				if ($_GET['status'] == 2) {
					echo "<p> SUCCESS - Administrator Role Updated Successfully</p>";
				};
				
				
			};


?>

<html lang="en">
    <head>
	<?php include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/header.php'); ?>
  </head>
  <body>
    
<?php include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/dap_page_top.php');?>

<?php
							include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/connection.php');

							$statement = "SELECT Users.User_ID, Users.Username, Users.eMail, Users.Def_Location,Users.isAdmin,Users.Protected,Locations.Location_Name
							FROM Users 
							LEFT JOIN Locations ON Users.Def_Location = Locations.ID
							WHERE User_ID=".$viewuser;
						
			
			
							$result = mysqli_query($conn, $statement);

							if(!$result){
								echo mysqli_error($conn);
							}else{
								while($row = mysqli_fetch_assoc($result)) {
									$userid = $row['User_ID'];
									$username = $row['Username'];
									$def_Location = $row['Def_Location'];
									$def_Location_Name = $row['Location_Name'];
									$email = $row['eMail'];
									if ($row['isAdmin']==1) {
											$isadmin = "Yes";
									
									} else {
										$isadmin = "No";
									};
									if ($row['Protected']==1) {
											$protected = "Yes";
									
									} else {
										$protected = "No";
									};
								};
							}					
			
			
?>

<main class="container">
  <div class="bg-light p-5 rounded">
		<div class="row align-items-center" align='center'>
		<h3>Edit User</h3>
		</div>
		<div class="row align-items-center" align='center'>
			<p>Username : <?php echo $username; ?> </p>
			<p>Administrator? : <?php echo $isadmin?> </p?
		</div>
		<div class="row align-items-center" align='center'>
			<p>Current default location : <?php echo $def_Location_Name;?></p>
		</div>
		<div class="row align-items-center" align='center'>
			<p>eMail address : <?php echo $email;?></p>
		</div>
		<div class="row mb-3 text-center" align='center'>

		
				<div class="row align-items-center" align='center'>
		<h3>Change Password</h3>
		
						<script>
				var checkmatch = function() {
					
					if ((document.getElementById('form_NewPassword').value == document.getElementById('form_NewPasswordConfirm').value) && (document.getElementById('form_NewPassword').value.length >= 1)) {
							document.getElementById('message').style.color = 'green';
							document.getElementById('message').innerHTML = 'Passwords match';
							return 1;
					}; 
					if (document.getElementById('form_NewPassword').value != document.getElementById('form_NewPasswordConfirm').value){
							document.getElementById('message').style.color = 'red';
							document.getElementById('message').innerHTML = 'Passwords do not match!';
							document.getElementById('submitbutton').setAttribute("disabled", "");
							return 0;
							
					};
				};
				
				var checklength = function() {
					
					if ((document.getElementById('form_NewPassword').value.length >= 5)) {
							document.getElementById('message2').style.color = 'green';
							document.getElementById('message2').innerHTML = 'Pass length : OK';
							return 1;
							
					};
					
					if ((document.getElementById('form_NewPassword').value.length < 5)){
							document.getElementById('message2').style.color = 'red';
							document.getElementById('message2').innerHTML = 'Password must be at least 5 characters';
							document.getElementById('submitbutton').setAttribute("disabled", "");
							return 0;
							
					};
				};
				
				var checkboth = function() {
					
					if ((checkmatch()==1)&&(checklength()==1)){
						document.getElementById('submitbutton').removeAttribute("disabled", "");
					}else{
						document.getElementById('submitbutton').setAttribute("disabled", "");
					};
					
				};

				</script>
			<form action="pwdchangeprocess.php" method="POST">
				<div class="form-group">
					<label for="form_MonitorID">New Password : </label>
					<input type="password" class="form-control" maxlength = "30" id="form_NewPassword" name="form_NewPassword" onkeyup='checklength(),checkmatch(),checkboth();'>
				</div>
				<div class="form-group">
					<label for="form_MonitorID">Confirm New Password : </label>
					<input type="password" class="form-control" maxlength = "30" id="form_NewPasswordConfirm" name="form_NewPasswordConfirm" onkeyup='checklength(),checkmatch(),checkboth();'>
				</div>	
				<input type="hidden" name="form_User_ID" value="<?php echo $userid; ?>" />
				

				<div id="message"></div>
				<div id="message2"></div>
				<div id="message3"></div>
				<input type="submit" id="submitbutton" value="Change Password" disabled>
		</form>
		</div>
		
		
		
		
		</div>
		
		<div class="row mb-3 text-center" align='center'>
		 <?php 
		
		if ($protected == "No") {
			if ($isadmin == "Yes") {
			echo "<td><a class='btn btn-lg btn-primary' href='adminchangeprocess.php?Admin_Status=0&User_ID=".$userid."' role='button'>Remove Administrator Priviledges</a></td>";
		}else{
			echo "<td><a class='btn btn-lg btn-primary' href='adminchangeprocess.php?Admin_Status=1&User_ID=".$userid."' role='button'>Add Aministrator Priviledges</a></td>";
		};
		}
		
		
		
		 
		 ?>
			

				<div class="row align-items-center" align='center'>
			<h4> Event Log (Previous 10) </h4>
			<table class="table table-striped border"> <!-- Table is created -->
		<thead> <!-- Table header begins -->
			<tr>
				<th scope="col">TimeStamp</th>
				<th scope="col">Event Code</th>
				<th scope="col">Event Info</th>
			</tr>
		</thead> <!-- Table header ends -->
			
			<?php
			
			$statement = "SELECT TimeStamp,UEvent_Code,UEvent_Info FROM User_Event_Log WHERE User_ID = '".$viewuser."' ORDER BY TimeStamp DESC LIMIT 10"; //prepare sql statement

			$result = mysqli_query($conn, $statement); //run sql query statement on the database.
			
			if($result){//if the result has been successful
				while ($r = mysqli_fetch_assoc($result)) { //for each row in the result
					//for each result row create a row in the table.
					
					$timestamp = $r['TimeStamp'];
					$ukDate = date("d-m-Y @ H:i:s", strtotime($timestamp));
					
					echo "<tr>";
					echo "<td>".$ukDate."</td>";
					echo "<td>".$r['UEvent_Code']."</td>";			
					echo "<td>".$r['UEvent_Info']."</td>";						
					echo "</tr>";
				}			
			}
			//if an error occurs a message is displayed on screen.
			else{
				echo "Database error";
				echo mysqli_error($conn);
			     }
		
		 ?>
		 </table>
		 

		 
		</div>

			 <?php 
		 echo "<p><a href='../../../dap/user/usereventlog.php?userID=".$viewuser."'>Click here to view the full event log.</a></p>"; ?>
  </div>

</main>




      
  </body>
  
 <footer>
	<?php include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/footer.php'); ?>
</footer>
</html>
