<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/dap/comps/authorise.php'); 
?>


<script type="text/javascript">
	google.charts.load('current', {'packages':['gauge']});
	  
	google.charts.setOnLoadCallback(drawgauge);
	  
    function drawgauge() {

		var data3 = google.visualization.arrayToDataTable([
		  ['Label', 'Value'],
          ['CO2', 
		  <?php

			include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/connection.php');
			
			$query = "SELECT TimeStamp,Value FROM Readings WHERE Location_ID = ".$querylocation." ORDER BY TimeStamp DESC LIMIT 1";
		
			
			
			$exec = mysqli_query($conn,$query);
			while($row = mysqli_fetch_array($exec)){
				$count = $count+1;
				$value = $row[Value];
				$timestamp = $row[TimeStamp];
			
				$valueukDate = date("d/m/Y @ H:i:s", strtotime($timestamp));
			
				//echo $value;
				echo "{v: $value, f:'$value ppm'}";

			 }		
			
			$gauge_div_name = 'gauge_div_'.$querylocation;
			
		?> 
		],
        ]);

        var options = {
          width: 600, height: 180,
		  min: 0, max : 2000,
          redFrom: 1401, redTo: 2000,
          yellowFrom:951, yellowTo: 1400,
		  greenFrom:0, greenTo: 950,
          minorTicks: 25,
		  majorTicks: ['0', '2000'],
		  animation:{
			duration : 1000,
			easing : 'in',
		  }
        };

        var chart = new google.visualization.Gauge(document.getElementById('<?php echo $gauge_div_name; ?>'));

        chart.draw(data3, options);

      }
    </script>
	

		<div id="<?php echo $gauge_div_name; ?>"></div>
		<div class="row mb-3 text-center" align='center'>
		
			<h6><a href='https://co2intheclassroom.co.uk/dap/index.php?LocationID=<?php echo $r['ID']?>'><?php echo $r['Location_Name']?></a></h6>
		
			<h6><?php echo "Updated : ".$valueukDate;?></h6>
		</div>
