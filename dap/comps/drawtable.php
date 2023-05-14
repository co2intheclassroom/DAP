<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/dap/comps/authorise.php'); 
?>

<script type="text/javascript">

	google.charts.load('current', {'packages':['table']});
	google.charts.setOnLoadCallback(drawTable);
	
	
		function drawTable() {
		var data2 = new google.visualization.DataTable();
		data2.addColumn('string', 'Time of Day');
		data2.addColumn('number', 'Low');
		data2.addColumn('number', 'High');
		data2.addColumn('number', 'Average');
		
		data2.addRows([
		<?php 
			include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/connection.php');
			
			
			$count = 0;
			$query = "SELECT 
					  HOUR(Timestamp) AS Hour,MIN(Value) AS Min,MAX(Value) AS Max ,AVG(Value) AS Avg
					  FROM `Readings`  
					  WHERE 
					  Location_ID = ".$querylocation."
					  AND
					  Timestamp BETWEEN '$queryday 08:00:00' AND '$queryday 18:00:00'
					  GROUP BY 
					  HOUR(Timestamp)";
			
			
			 $exec = mysqli_query($conn,$query);
			 
			 while($row = mysqli_fetch_array($exec)){
				$count = $count+1;
				
				$hour = (int)$row[Hour];
				$between = "(".$count.") ".strval($hour).":00-".strval($hour+1).":00";
				$between = strval($between);
				console.log($between);
				
				$minimum = (int)$row[Min];
				$maximum = (int)$row[Max];
				$average = (int)$row[Avg];
				
				echo "['".$between."',".$minimum.",".$maximum.",".$average."],";
				//echo '['.$hour.','.$minimum.','.$maximum.','.$average.'],';
				//echo '[['.$hour.','.$minute.','.$second.'],1000,500,1500,'.$value.'],';

				
				
			 }
			 echo "]);";
			 
			 $table_div_name = 'table_div_'.$querylocation;
			 
			 
			 ?> 
		
		
		var table = new google.visualization.Table(document.getElementById('<?php echo $table_div_name; ?>'));
       
		table.draw(data2, {showRowNumber: false});
      }
</script>
	  
	  <div id="<?php echo $table_div_name; ?>">
	  <script>console.log('Debug Objects: <?php echo $query; ?>' );</script>
	  
	  </div>
	  