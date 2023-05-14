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
					echo "<p> SUCCESS - New monitor added </p>";
				};
			};

			?>
		</div>
		<div class="row align-items-center" align='center'>
			<h2> Monitor Management </h2>
		</div>
		<div class="row align-items-center" align='center'>
			<table class="table table-striped border"> <!-- Table is created -->
		<thead> <!-- Table header begins -->
			<tr>
				<th scope="col">Monitor ID</th>
				<th scope="col">IP Address</th>
				<th scope="col">Current Location</th>
				<th scope="col">Edit</th>
			</tr>
		</thead> <!-- Table header ends -->
			
			<?php
			
			include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/connection.php');
			
			$statement = "SELECT Monitors.Mon_ID, Monitors.Current_Location, Monitors.AuthCode, Monitors.MAC, Monitors.IP_ADDRESS, Locations.Location_Name
						  FROM Monitors
						LEFT JOIN Locations ON Monitors.Current_Location=Locations.ID"; //prepare sql statement

			$result = mysqli_query($conn, $statement); //run sql query statement on the database.
			
			if($result){//if the result has been successful
				while ($r = mysqli_fetch_assoc($result)) { //for each row in the result
					//for each result row create a row in the table.
					echo "<tr>";
					echo "<td>".$r['Mon_ID']."</td>";
					echo "<td>".$r['IP_ADDRESS']."</td>";
					echo "<td>".$r['Location_Name']."</td>";
					echo "<td><a class='btn btn-lg btn-primary' href='viewmonitor.php?monitorID=".$r['Mon_ID']."' role='button'>Edit</a></td>";
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
			<h3>Add new monitor </h3>
		</div>
		
		<div class="row align-items-center" align='center'>

			<form action="addmonitorprocess.php" method="POST">
				<div class="form-group">
					<label for="form_MonitorID">Monitor ID : </label>
					<input type="text" class="form-control" minlength="7" maxlength = "7" id="form_MonitorID" name="form_MonitorID" required>
				</div>
				
				<div class="form-group">
					<label for="form_AuthCode">Auth Code : </label>
					<input type="text" class="form-control" minlength="8" maxlength = "8" id="form_AuthCode" name="form_AuthCode" required>
				</div>
				
				<input type="submit" value="Add Monitor" />
		</form>
		</div>
	
  </div>

</main>
      
  </body>
  <footer>
	<?php include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/footer.php'); ?>
</footer>
</html>
