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
					echo "<p> SUCCESS - New location added </p>";
				};
				
				if ($_GET['status'] == 2) {
					echo "<p> SUCCESS - New location type added </p>";
				};
			};

			?>
		</div>
		<div class="row align-items-center" align='center'>
			<h2> Location Management </h2>
		</div>
		<div class="row align-items-center" align='center'>
			<table class="table table-striped border"> <!-- Table is created -->
		<thead> <!-- Table header begins -->
			<tr>
				<th scope="col">Location Name</th>
				<th scope="col">Current Monitor</th>
				<th scope="col">Edit</th>
			</tr>
		</thead> <!-- Table header ends -->
			
			<?php
			
			include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/connection.php');
			
			$statement = "SELECT Locations.Location_Name,Locations.ID, Locations.Current_Mon_ID
			FROM Locations 
			WHERE IsArchive=0";

			$result = mysqli_query($conn, $statement); //run sql query statement on the database.
			
			if($result){//if the result has been successful
				while ($r = mysqli_fetch_assoc($result)) { //for each row in the result
					//for each result row create a row in the table.
					echo "<tr>";
					echo "<td>".$r['Location_Name']."</td>";
					echo "<td>".$r['Current_Mon_ID']."</td>";
					echo "<td><a class='btn btn-lg btn-primary' href='viewlocation.php?locationID=".$r['ID']."' role='button'>Edit</a></td>";
					
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
			<p><a href='archivedlocations.php'>Click here to view archived locations.</a></p>
		</div>
		<div class="row" align='center'>
			<h3>Add new Location</h3>
		</div>
		
		<div class="row align-items-center" align='center'>

			<form action="addlocationprocess.php" method="POST">
				<div class="form-group">
					<label for="form_MonitorID">New Location Name </label>
					<input type="text" class="form-control" maxlength = "30" id="form_LocationName" name="form_LocationName">
				</div>

				
				<input type="submit" value="Add Location" />
		</form>
		</div>

		

	
  </div>

</main>
      
  </body>
  
  <footer>
	<?php include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/footer.php'); ?>
</footer>
</html>
