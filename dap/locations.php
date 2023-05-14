<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/dap/comps/authorise.php');  

?>

<html lang="en">
  <head>
	<?php include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/header.php'); ?>
	<meta http-equiv="refresh" content="60" >
  </head>
  
  <body>
    
<?php 
	$pagenav = '2'; //set pagenav for menu highlight
	include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/dap_page_top.php'); //include menu bar
?>

<main class="container">
  <div class="bg-light p-5 rounded">
		<div class="row align-items-center" align='center'>
			
			<?php
			
			//Gauges row STARTS
			echo "<div class='row align-items-center' align='center'><h2>Current Readings</h2>";
			
			include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/connection.php'); //read in sql connection settings
			
			//statement to lookup location name and current monitor based on location ID 
			$statement = "SELECT Locations.Location_Name, Locations.ID, Locations.Current_Mon_ID
			FROM Locations 
			WHERE IsArchive=0
			ORDER BY Locations.Location_Name";

			$result = mysqli_query($conn, $statement); //run sql query statement on the database.

			if($result){//Creates a latest reading gauge for each active location
				while ($r = mysqli_fetch_assoc($result)) {
					echo "<div class='col'>";
						$querylocation = $r['ID'];
						include('comps/gauge.php');

					echo "</div>";
				}			
			}else{ //if an error occurs a message is displayed on screen.
				echo "Database error";
				echo mysqli_error($conn);
			}
			echo "</div>";
			//Gauges row ENDS
			
			//Today overview row STARTS
			echo "<h1>Today</h1>";
			echo "<div class='row align-items-center' align='center'><h2>Overview (08:00 - 18:00)</h2>";
				$queryday = date('Y-m-d');
				include('comps/schooltable.php');
			echo "</div>";
			//Today overview row ENDS
			
			//Location graphs row STARTS
			echo "<div class='row align-items-center' align='center'>";
			//create graphs
			$statement = "SELECT Locations.Location_Name, Locations.ID, Locations.Current_Mon_ID
			FROM Locations 
			WHERE IsArchive=0
			ORDER BY Locations.Location_Name";
			
			$result = mysqli_query($conn, $statement); //run sql query statement on the database.
			
			if($result){//if the result has been successful
				while ($r = mysqli_fetch_assoc($result)) { //for each row in the result

					echo "<div class='row align-items-center p-4' align='center'><h3><a href='https://co2intheclassroom.co.uk/dap/index.php?LocationID=".$r['ID']."'>".$r['Location_Name']."</a></h3>";
						$querylocation = $r['ID'];
						$queryday = date('Y-m-d');
						include('comps/drawchart_nb.php');
						include('comps/drawtable.php');
						
					echo "</div>";
				}			
			}
			//if an error occurs a message is displayed on screen.
			else{
				echo "Database error";
				echo mysqli_error($conn);
			     }
		
			echo "</div>";
		//Location graphs row ENDS
		 ?>
		</div>
  </div>
</main>

</body>
 <footer>
	<?php include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/footer.php'); ?>
</footer>
</html>
