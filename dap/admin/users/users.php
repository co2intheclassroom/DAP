<!doctype html>
<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/dap/comps/adminauthorise.php'); 
?>

<html lang="en">
    <head>
	<?php include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/header.php'); ?>
  </head>
  <body>
    
<?php 
$pagenav = '3';
include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/dap_page_top.php');?>

<main class="container">
  <div class="bg-light p-5 rounded">
		<div class="row align-items-center" align='center'>
			<?php 
			 if(isset($_GET['status'])) { 
				if ($_GET['status'] == 0) {
					echo "<p> An error has occured! - Please chcek the details and try again. </p>";
				};

				if ($_GET['status'] == 1) {
					echo "<p> SUCCESS - New User added successfully</p>";
				};
				
				if ($_GET['status'] == 2) {
					echo "<p> SUCCESS - User deleted successfully</p>";
				};
				
				if ($_GET['status'] == 3) {
					echo "<p> User is protected and cannot be deleted.</p>";
				};
				
				if ($_GET['status'] == 4) {
					echo "<p> A user already exists with this username. Please choose a different one.</p>";
				};
			};

			?>
		</div>
		<div class="row align-items-center" align='center'>
			<h2> User Management </h2>
		</div>
		<div class="row align-items-center" align='center'>
			<table class="table table-striped border"> <!-- Table is created -->
		<thead> <!-- Table header begins -->
			<tr>
				<th scope="col">User ID</th>
				<th scope="col">Username</th>
				<th scope="col">Default Location</th>
				<th scope="col">Administrator</th>
				<th scope="col">Edit</th>
				<th scope="col">Delete</th>
			</tr>
		</thead> <!-- Table header ends -->
			
			<?php
			
			include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/connection.php');
			
			//$statement = "SELECT User_ID, Username, Def_Location, isAdmin, Protected FROM Users"; //prepare sql statement


			$statement = "SELECT Users.User_ID, Users.Username, Users.Def_Location, IF(Users.isAdmin=1,'Yes','No') as isAdmin, Users.Protected, Locations.Location_Name 
			FROM Users
			LEFT JOIN Locations ON Users.Def_Location = Locations.ID"; //prepare sql statement

			
			$result = mysqli_query($conn, $statement); //run sql query statement on the database.
			
			if($result){//if the result has been successful
				while ($r = mysqli_fetch_assoc($result)) { //for each row in the result
					//for each result row create a row in the table.
					echo "<tr>";
					echo "<td>".$r['User_ID']."</td>";
					echo "<td>".$r['Username']."</td>";
					echo "<td>".$r['Location_Name']."</td>";
					echo "<td>".$r['isAdmin']."</td>";
					echo "<td><a class='btn btn-lg btn-primary' href='edituser.php?userID=".$r['User_ID']."' role='button'>Edit</a></td>";
					
					if ($r['Protected'] == 1) {	
						echo "<td><a class='btn btn-lg btn-danger disabled' href='#' role='button' >Delete</a></td>";
					} else {
						echo "<td><a class='btn btn-lg btn-danger' href='deleteuser.php?userID=".$r['User_ID']."&username=".$r['Username']."' role='button'>Delete</a></td>";
					};
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
		<div class="row" align='center'>
			<h3>Add new User</h3>
		</div>
		
		<div class="row">
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
			<form action="addnewuserprocess.php" method="POST">
				<div class="form-group">
					<label for="form_MonitorID">Username : </label>
					<input type="text" class="form-control" maxlength = "30" id="form_NewUsername" name="form_NewUsername" minlength="4" required>
				</div>
				<div class="form-group">
					<label for="form_eMail">eMail address : </label>
					<input type="email" class="form-control" maxlength = "30" id="form_eMail" name="form_eMail" minlength="4" required>
				</div>
				<div class="form-check">
					<input type="checkbox" class="form-check-input" id="form_isAdmin" name="form_isAdmin">
					<label class="form_isAdmin" for="form_isAdmin">Administrator?</label>
				</div>
				<div class="form-group">
					<label for="form_new_locationID">Default location : </label>
					<select class="form-control" id="form_new_locationID" name="form_new_locationID">
						<?php
		

							$statement = "SELECT * FROM Locations WHERE IsArchive=0 ORDER BY Location_Name";
							

							$result = mysqli_query($conn, $statement);

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
				<div class="form-group">
					<label for="form_MonitorID">Password : </label>
					<input type="password" class="form-control" maxlength = "30" id="form_NewPassword" name="form_NewPassword" onkeyup='checklength(),checkmatch(),checkboth();'>
				</div>
				<div class="form-group">
					<label for="form_MonitorID">Confirm Password : </label>
					<input type="password" class="form-control" maxlength = "30" id="form_NewPasswordConfirm" name="form_NewPasswordConfirm" onkeyup='checklength(),checkmatch(),checkboth();'>
				</div>	

				

				<div id="message"></div>
				<div id="message2"></div>
				<div id="message3"></div>
				<input type="submit" id="submitbutton" value="Add New User" disabled>
		</form>
		</div>



	
  </div>

</main>
      
  </body>
  
  <footer>
	<?php include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/footer.php'); ?>
</footer>
</html>
