<!doctype html>
<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/dap/comps/adminauthorise.php'); 
?>

<html lang="en">
    <head>
	<?php include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/header.php'); ?>
	<meta http-equiv="refresh" content="60" >
  </head>
  <body>
    
<?php include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/dap_page_top.php');?>

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
			<h2> Archived Locations </h2>
		</div>
		<div class="row align-items-center" align='center'>
			<table class="table table-striped border"> <!-- Table is created -->
		<thead> <!-- Table header begins -->
			<tr>
				<th scope="col">Location Name</th>
				<th scope="col">Edit</th>
			</tr>
		</thead> <!-- Table header ends -->
			
			<?php
			
			include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/connection.php');
			
			
			$statement = "SELECT Locations.Location_Name, Locations.ID
			FROM Locations  
			WHERE IsArchive=1";
			$result = mysqli_query($conn, $statement); //run sql query statement on the database.
			
			if($result){//if the result has been successful
				while ($r = mysqli_fetch_assoc($result)) { //for each row in the result
					//for each result row create a row in the table.
					echo "<tr>";
					echo "<td>".$r['Location_Name']."</td>";
					echo "<td><a class='btn btn-lg btn-primary' href='unarchiveprocess.php?locationID=".$r['ID']."' role='button'>Unarchive</a></td>";
					
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
		


	
  </div>

</main>
      
  </body>
  
 <footer>
	<?php include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/footer.php'); ?>
</footer>

</html>
