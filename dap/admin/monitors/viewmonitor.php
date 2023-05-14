<!doctype html>
<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/dap/comps/adminauthorise.php'); 
	
	if(!isset($_GET['monitorID'])) { 
			header("Location: monitors.php");
		}else{
			$viewmonitor = $_GET['monitorID'];
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
			
			$statement = "SELECT Mon_ID,Current_Location,AuthCode,MAC, IP_ADDRESS, Locations.Location_Name
			FROM Monitors
			LEFT JOIN Locations ON Monitors.Current_Location=Locations.ID
			WHERE Mon_ID = '".$viewmonitor."'"; //prepare sql statement
				

			$result = mysqli_query($conn, $statement); //run sql query statement on the database.
			
			if($result){//if the result has been successful
				while ($r = mysqli_fetch_assoc($result)) { //for each row in the result
					$monitor_id = $r['Mon_ID'];
					$monitor_Current_Location = $r['Current_Location'];
					$monitor_Current_Location_Name = $r['Location_Name'] ;
					$monitor_Authcode = $r['AuthCode'];
					$monitor_MAC = $r['MAC'];
					$monitor_IP_ADD = $r['IP_ADDRESS'];
				}			
			}
			//if an error occurs a message is displayed on screen.
			else{
				echo "Database error";
				echo mysqli_error($conn);
			     }			
			
		
		
	
?>

<?php
			
			
			$statement = "SELECT MEvent_TimeStamp FROM Monitor_Event_Log WHERE Mon_ID = '".$monitor_id."' AND MEvent_Code=1 ORDER BY MEvent_TimeStamp DESC LIMIT 1"; //prepare sql statement

			$result = mysqli_query($conn, $statement); //run sql query statement on the database.
			
			if($result){//if the result has been successful
				while ($r = mysqli_fetch_assoc($result)) { //for each row in the result
					//for each result row create a row in the table.
					
					$timestamp = $r['MEvent_TimeStamp'];
					$ukDate = date("d-m-Y @ H:i:s", strtotime($timestamp));
					
					$lastbootup = $ukDate;
					}			
			}
			//if an error occurs a message is displayed on screen.
			else{
				echo "Database error";
				echo mysqli_error($conn);
			     };
		
		 ?>
		 
<?php
			
			
			$statement = "SELECT TimeStamp,Value FROM Readings WHERE Mon_ID = '".$monitor_id."' ORDER BY TimeStamp DESC LIMIT 1"; //prepare sql statement
			$result = mysqli_query($conn, $statement); //run sql query statement on the database.
			
			if($result){//if the result has been successful
				while ($r = mysqli_fetch_assoc($result)) { //for each row in the result
					//for each result row create a row in the table.
					
					$timestamp = $r['TimeStamp'];
					$ukDate = date("d-m-Y @ H:i:s", strtotime($timestamp));
					
					$lastreading = $ukDate;
					}			
			}
			//if an error occurs a message is displayed on screen.
			else{
				echo "Database error";
				echo mysqli_error($conn);
			     };
		
		 ?>
		
<main class="container">
  <div class="bg-light p-5 rounded">
		<div class="row align-items-center" align='center'>
			<h2> View Monitor : <?php echo $monitor_id;?> </h2>
		</div>
		
		<div class="row align-items-center" align='center'>
			<?php 
			 if(isset($_GET['status'])) { 
				if ($_GET['status'] == 0) {
					echo "<p> An error has occured! - Please chcek the details and try again. </p>";
				};

				if ($_GET['status'] == 1) {
					echo "<p> SUCCESS - Assignment removed successfully </p>";
				};
				
				if ($_GET['status'] == 2) {
					echo "<p> SUCCESS - Assignment added successfully </p>";
				};
				
			};

			?>
		</div>
		
		<div class="row align-items-center" align='center'>
			<p> Monitor ID : <?php echo $monitor_id; ?></P>
			<p> Authcode : <?php echo $monitor_Authcode; ?></p>
			<p> MAC Address : <?php echo $monitor_MAC; ?></p>
			<p> Current IP Address: <?php echo $monitor_IP_ADD; ?></P>
			<p> Last boot up : <?php echo $lastbootup ;?></p>
			<p> Last reading report : <?php echo $lastreading ;?></p>
			
			
		</div>
		
		<div class="row align-items-center" align='center'>
			<h4>Location Assignment</h4>
			<p>Currently Assigned to : <?php echo $monitor_Current_Location_Name ?><p>
			
			
			<form action="assignmonitorprocess.php" method="POST">						
				<div class="form-group">
					<label for="form_new_locationID">Choose a NEW location : </label>
					<select class="form-control" id="form_new_locationID" name="form_new_locationID">
						<?php

							$statement = "SELECT ID,Location_Name FROM Locations 
							WHERE Current_Mon_ID IS NULL AND IsArchive=0
							ORDER BY Location_Name";
							

							$result = mysqli_query($conn, $statement);

							if(!$result){
								echo mysqli_error($conn);
							}else{
								while($row = mysqli_fetch_assoc($result)) {
									if ($row['ID'] == $monitor_Current_Location) {
										//skip current one
									}else{
										echo "<option value ='".$row['ID']."'>".$row['Location_Name']."</option>";
										
									};
									
									
								};
							}
							
						?>
		
					</select>
					<input type="hidden" name="form_Monitor_ID" value="<?php echo $monitor_id; ?>" />
					<input type="hidden" name="form_CurrentLocation" value="<?php echo $monitor_Current_Location; ?>" />
					<p> Tip : If you can't see the location you want to assign the monitor to. Please unassign the existing monitor first.</p>
				</div>
				
				
				<input type="submit"  value="Update" />
		</form>
		<p><a class="btn btn-lg btn-danger" href="removeassignmentprocess.php?monitorid=<?php echo $monitor_id?>&locationid=<?php echo $monitor_Current_Location ?>" role="button">Remove current assignment</a></p>
		</div>
		
		<div class="row align-items-center" align='center'>
			<h4> Recent events </h4>
			<table class="table table-striped border"> <!-- Table is created -->
		<thead> <!-- Table header begins -->
			<tr>
				<th scope="col">TimeStamp</th>
				<th scope="col">Event Code</th>
				<th scope="col">Event Info</th>
			</tr>
		</thead> <!-- Table header ends -->
			
			<?php
			
			
			$statement = "SELECT MEvent_TimeStamp,MEvent_Code,MEvent_Info FROM Monitor_Event_Log WHERE Mon_ID = '".$monitor_id."' ORDER BY MEvent_TimeStamp DESC LIMIT 10"; //prepare sql statement

			$result = mysqli_query($conn, $statement); //run sql query statement on the database.
			
			if($result){//if the result has been successful
				while ($r = mysqli_fetch_assoc($result)) { //for each row in the result
					//for each result row create a row in the table.
					
					$timestamp = $r['MEvent_TimeStamp'];
					$ukDate = date("d-m-Y @ H:i:s", strtotime($timestamp));
					
					echo "<tr>";
					echo "<td>".$ukDate."</td>";
					echo "<td>".$r['MEvent_Code']."</td>";			
					echo "<td>".$r['MEvent_Info']."</td>";						
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
		 <?php echo "<p><a href='monitoreventlog.php?monitorID=".$viewmonitor."'>Click here to view the full event log.</a></p>"; ?>
		 
		</div>
		



		<div>
				<p><a class="btn btn-lg btn-danger" href="removemonitor.php?monitorid=<?php echo $monitor_id?>&locationid=<?php echo $monitor_Current_Location ?>" role="button">Remove monitor from system</a></p>
		</div

	
  </div>

</main>
      
  </body>
 <footer>
	<?php include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/footer.php'); ?>
</footer>
</html>
