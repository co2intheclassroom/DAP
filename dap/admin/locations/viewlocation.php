<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/dap/comps/adminauthorise.php'); 
?>
<?php 
	if(!isset($_GET['locationID'])) { 
			header("Location: locations.php");
		}else{
			$viewlocation = $_GET['locationID'];
		};
include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/connection.php');
?>

<html lang="en">
  <head>
	<?php include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/header.php'); ?>
  </head>
  <body>
    
<?php include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/dap_page_top.php');?>
<?php
			
			
			$statement = "SELECT ID,Location_Name,Current_Mon_ID FROM Locations WHERE ID =".$viewlocation; //prepare sql statement

			$result = mysqli_query($conn, $statement); //run sql query statement on the database.
			
			if($result){//if the result has been successful
				while ($r = mysqli_fetch_assoc($result)) { //for each row in the result
					$location_id = $r['ID'];
					$location_name = $r['Location_Name'];
					$location_current_mon = $r['Current_Mon_ID'];
				}			
			}
			//if an error occurs a message is displayed on screen.
			else{
				echo "Database error";
				echo mysqli_error($conn);
			     }			
			
		
		
		?>
		
<main class="container">
  <div class="bg-light p-5 rounded">
		<div class="row align-items-center" align='center'>
			<h2> View location : <?php echo $location_name;?> </h2>
		</div>
		
		<div class="row align-items-center" align='center'>
			<?php 
			 if(isset($_GET['status'])) { 
				if ($_GET['status'] == 0) {
					echo "<p> An error has occured! - Please chcek the details and try again. </p>";
				};

				if ($_GET['status'] == 1) {
					echo "<p> SUCCESS - Location Updated </p>";
				};
				
			};

			?>
		</div>

		
		<div class="row align-items-center" align='center'>

			<form action="updatelocationprocess.php" method="POST">

				
				<div class="form-group">
					<label for="form_Location_Name">Update Location Name :</label>
					<input type="text" class="form-control" minlength = "3" maxlength = "30" id="form_Location_Name" name="form_Location_Name" value ="<?php echo $location_name; ?>" required>
					<input type="hidden" name="form_Location_ID" value="<?php echo $location_id; ?>" />
				</div>	
						
				
				
				<input type="submit" value="Update" />
		</form>
		</div>
		
		<div class="row align-items-center" align='center'>
			<h4> Last 10 readings </h4>
			<table class="table table-striped border"> <!-- Table is created -->
		<thead> <!-- Table header begins -->
			<tr>
				<th scope="col">TimeStamp</th>
				<th scope="col">Reading</th>
			</tr>
		</thead> <!-- Table header ends -->
			
			<?php			
			$statement = "SELECT TimeStamp, Value FROM Readings WHERE Location_ID = ".$location_id." ORDER BY TimeStamp DESC LIMIT 10"; //prepare sql statement

			$result = mysqli_query($conn, $statement); //run sql query statement on the database.
			
			if($result){//if the result has been successful
				while ($r = mysqli_fetch_assoc($result)) { //for each row in the result
					//for each result row create a row in the table.
					
					$timestamp = $r['TimeStamp'];
					$ukDate = date("d-m-Y - H:i:s", strtotime($timestamp));
					
					echo "<tr>";
					echo "<td>".$ukDate."</td>";
					echo "<td>".$r['Value']."</td>";					
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
		



		<div>
		<td><a class='btn btn-lg btn-danger' href='archiveprocess.php?locationID=<?php echo $location_id ?>' role='button'>Archive this location</a></td>
		</div>

	
  </div>

</main>
      
  </body>
  <footer>
	<?php include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/footer.php'); ?>
</footer>
</html>
