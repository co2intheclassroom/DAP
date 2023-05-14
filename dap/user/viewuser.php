<!doctype html>
<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/dap/comps/authorise.php'); 

  
	if(!isset($_GET['userID'])) { 
			$viewuser = $_SESSION['userID'];
			
		}else{
			$viewuser = $_GET['userID'];
		};
include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/connection.php');
?>

<html lang="en">

<head>
	<?php include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/header.php'); ?>
</head>
 
<body>
<?php 
$pagenav = '4';
include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/dap_page_top.php');?>

<?php
	$statement = "SELECT Users.Username, Users.Def_Location, Users.isAdmin, Locations.Location_Name, Users.GenReports, Users.eMail, Users.GenReports
				FROM Users 
				LEFT JOIN Locations ON Users.Def_Location = Locations.ID
				WHERE User_ID=".$viewuser;
							

	$result = mysqli_query($conn, $statement);

	if(!$result){
		echo mysqli_error($conn);
	}else{
		while($row = mysqli_fetch_assoc($result)) {
			$username = $row['Username'];
			$def_Location = $row['Def_Location'];
			$def_Location_Name = $row['Location_Name'];
			$user_email = $row['eMail'];
			$user_reports = $row['GenReports'];
			if ($row['isAdmin']==1) {
				$isadmin = "Yes";
			} else {
				$isadmin = "No";
			};
			if ($row['GenReports']==1) {
				$genreports = "Yes";
			} else {
				$genreports = "No";
			};
		};
	}							
?>

<main class="container">
  <div class="bg-light p-5 rounded">
		<div class="row align-items-center" align='center'>
			<p><b>Username : </b><?php echo $username; ?> </p>
			<p><b>Administrator? : </b><?php echo $isadmin?> </p>
		</div>

		
		<div class="row mb-3 text-center" align='center'>
			<form action="user_update_process.php" method="POST">						
				<div class="form-group">
					<label for="form_email_rep"><b>Receive eMail reports? : </b></label>
					<input type="checkbox" class="form_email_rep" id="form_email_rep" name="form_email_rep" value="1" <?php if($user_reports==1){echo "checked";}?>>
				</div>
				
				<div class="form-group">
					<label for="form_email"><b>eMail address : </b></label>
					<input type="text" class="form-control" maxlength = "100" id="form_email" name="form_email" value="<?php echo $user_email;?>">
				</div>
			
				<div class="form-group">
					<label for="form_new_locationID"><b>Default location : </b></label>
					<select class="form-control" id="form_new_locationID" name="form_new_locationID">
						<?php

							$statement = "SELECT ID, Location_Name FROM Locations WHERE IsArchive=0 ORDER BY Location_Name ";
							

							$result = mysqli_query($conn, $statement);
							
							
							echo "<option value ='".$def_Location."'>".$def_Location_Name." (Current)</option>";
							
							if(!$result){
								echo mysqli_error($conn);
							}else{
								while($row = mysqli_fetch_assoc($result)) {
									if ($row['ID'] == $def_Location) {
										//skip current one
									}else{
										echo "<option value ='".$row['ID']."'>".$row['Location_Name']."</option>";
										
									};
									
									
								};
							}
							
						?>
		
					</select>
					<input type="hidden" name="form_User_ID" value="<?php echo $viewuser; ?>" />
				</div>
				
				
				<input type="submit"  value="Update User Settings" />
			</form>
		</div>
		
		<div class="row mb-3 text-center" align='center'>
			
		</div>
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
		 <?php 
		 echo "<p><a href='usereventlog.php?userID=".$viewuser."'>Click here to view the full event log.</a></p>"; ?>
		 
		</div>

	
  </div>

</main>




      
  </body>
 <footer>
	<?php include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/footer.php'); ?>
</footer>

</html>
