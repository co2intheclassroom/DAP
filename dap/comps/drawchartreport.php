<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/dap/comps/authorise.php'); 
?>

<script type="text/javascript">
	google.charts.load('current', {'packages':['corechart','table','line','gauge']});
	google.charts.setOnLoadCallback(drawChart);
	  
	  
	  
	  
    function drawChart() {
		var data = new google.visualization.DataTable();
		data.addColumn('timeofday', 'Time of Day');
		data.addColumn('number', 'Low');
		data.addColumn('number', 'Medium');
		data.addColumn('number', 'High');
		data.addColumn('number', 'CO2 Reading');

		data.addRows([
		
		<?php 
			include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/connection.php');
			
			$query = "SELECT 
			CAST(`Timestamp` AS TIME) AS Time,
            HOUR(Timestamp) AS Hour,
            MINUTE(Timestamp) AS Minute,
            SECOND(Timestamp) AS Second,
			Value 
			FROM `Readings` 
			WHERE
			Location_ID = ".$querylocation."
			AND
			Timestamp BETWEEN '$queryday 08:00:00' AND '$queryday 18:00:00'";
			
			
			 $exec = mysqli_query($conn,$query);
			 			 
			 while($row = mysqli_fetch_array($exec)){
				
				$hour = (int)$row[Hour];
				$minute = (int)$row[Minute];
				$second = (int)$row[Second];
				$value = (int)$row[Value];
				
				echo '[['.$hour.','.$minute.','.$second.'],950,450,3500,'.$value.'],';
	
			 }
			 echo "]);";
			 
			$dayno = date("d");
			$dayno = date('d', strtotime($queryday));
			$chart_div_name = 'chart_div_'.$querylocation."_".$dayno;
			echo $chart_div_name;
			 ?> 
			 
		 
		
		var options = {
			chart: {
				
				subtitle: 'Estimated vs Actual',

			},
			//title: 'Class 5-2',
			lineWidth: 3,
			legend: { position: 'right' },
			seriesType: 'line',
            colors: ['green','orange','red','black'],
			isStacked: true,
			series: {

					0: {lineWidth: 0, areaOpacity: 0.3, type:'area', enableInteractivity:'false',visibleInLegend: false},
					1: {lineWidth: 0, areaOpacity: 0.3, type:'area', enableInteractivity:'false',visibleInLegend: false},
					2: {lineWidth: 0, areaOpacity: 0.3, type:'area', enableInteractivity:'false',visibleInLegend: false}
					
					},
			vAxis: {
				//title: 'Value',
				viewWindow: {max:3500},
				max: 3500,
				min: 0,
				ticks: [0, 500, 1000, 1500, 2000, 2500, 3000, 3500]

			},
			hAxis: {
				gridlines: { count: 8, color: '#CCC' },
				viewWindow: {max:[18,0,0],min:[8,0,0]},
				max: [18,0,0],
				min: [8,0,0],
				ticks: [[8,0,0],[9,0,0],[10,0,0],[11,0,0],[12,0,0],[13,0,0],[14,0,0],[15,0,0],[16,0,0],[17,0,0],[18,0,0]]
			},
		};
		
		var chart = new google.visualization.ComboChart(document.getElementById('<?php echo $chart_div_name; ?>'));
		chart.draw(data, options);
	  }
		
		
    </script>

    
	<div id="<?php echo $chart_div_name; ?>"></div>
	
	<div class="row justify-content-md-center">
		<div class="col col-lg-2">

		</div>
		
		<div class="col col-lg-2">
		
			<h3><?php echo $ukDate;?></h3>
		</div>

		<div class="col col-lg-2">

		</div>
		
	</div>
