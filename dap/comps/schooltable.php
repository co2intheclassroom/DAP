<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/dap/comps/authorise.php'); 
?>


<script type="text/javascript">

	google.charts.load('current', {'packages':['table']});
	google.charts.setOnLoadCallback(drawTable);
	
	
		function drawTable() {
		var data2 = new google.visualization.DataTable();
		data2.addColumn('string', 'Location');
		data2.addColumn('number', 'Low');
		data2.addColumn('number', 'High');
		data2.addColumn('number', 'Average');
		
		data2.addRows([
		<?php 
			include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/connection.php');
			
			
			
			$query = "SELECT 
					  Readings.Location_ID, MAX(Readings.Value) AS Max, MIN(Readings.Value) AS Min, AVG(Readings.Value) AS Avg, Locations.Location_Name 
					  FROM Readings 
					  LEFT JOIN Locations ON Readings.Location_ID = Locations.ID 
					  WHERE Timestamp BETWEEN '$queryday 08:00:00' AND '$queryday 18:00:00'
					  AND isArchive = 0
					  GROUP BY Location_ID";
			
			 $exec = mysqli_query($conn,$query);		 
			 while($row = mysqli_fetch_array($exec)){
				
				$location = $row['Location_Name'];
				$minimum = (int)$row[Min];
				$maximum = (int)$row[Max];
				$average = (int)$row[Avg];
				
				echo "['".$location."',".$minimum.",".$maximum.",".$average."],";
				//echo '['.$hour.','.$minimum.','.$maximum.','.$average.'],';
				//echo '[['.$hour.','.$minute.','.$second.'],1000,500,1500,'.$value.'],';

				
				
			 }
			 echo "]);";
			 
			 $fulltable_div_name = 'fulltable_div_'.$querylocation;
			 
			 
			 ?> 
		
		
		var table = new google.visualization.Table(document.getElementById('<?php echo $fulltable_div_name; ?>'));
       
		table.draw(data2, {showRowNumber: false});
      }
</script>
	  
	  <div id="<?php echo $fulltable_div_name; ?>"></div>
	  