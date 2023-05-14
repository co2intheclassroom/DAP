<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/dap/comps/authorise.php'); 

$today = date('Y-m-d H:i:s');	
 
 if(isset($_GET['LocationID'])) { 
    $querylocation = $_GET['LocationID'];
  } else {
	  $querylocation = $_SESSION['Def_Location'];
	  
  };
  
?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CO2 in the Classroom</title>
	
	<meta http-equiv="refresh" content="60"> 
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<body>

<!-- Last 30 Table Code starts -->
<script type="text/javascript">

	google.charts.load('current', {'packages':['table','bar','corechart']});
	google.charts.setOnLoadCallback(last30);
	
		function last30() {
		var data2 = new google.visualization.DataTable();
		//data2.addColumn('number', 'Day');
		data2.addColumn('number', 'Date');
		data2.addColumn('number', 'Low');
		data2.addColumn('number', 'Medium');
		data2.addColumn('number', 'High');
		data2.addColumn('number', 'High');
		data2.addColumn('number', 'Average');
		
		data2.addRows([
		<?php 
			include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/connection.php');
			
			//echo "['23-02-2023',1000,500,3500,0,0],";
			$count = 0;
			
			$todaydate = date('Y-m-d');
			$startday = date('Y-m-d', strtotime("-7 day", strtotime($todaydate)));
			
			//echo "['$queryday',1000,500,3500,0,0],";
			$queryday = $startday;
			$ticks = [];
			while($count < 7){
				
				
				$query = "SELECT 
					  MIN(Value) AS Min,MAX(Value) AS Max ,AVG(Value) AS Avg
					  FROM `Readings`  
					  WHERE 
					  Location_ID = ".$querylocation."
					  AND
					  Timestamp BETWEEN '$queryday 09:00:00' AND '$queryday 15:00:00'";
			
			
			 $exec = mysqli_query($conn,$query);		 
			 
			 while($row = mysqli_fetch_array($exec)){
				
				$date = date("d-m-Y", strtotime($queryday));
				$maximum = (int)$row[Max];
				$average = (int)$row[Avg];
				if ($average > 0){
					//echo "[".$count.",'".$date."',1000,500,3500,".$maximum.",".$average."],";
					//echo "['".$date."',1000,500,3500,".$maximum.",".$average."],";
					echo "[{v:$count, f:'$date'},950,450,3500,$maximum,$average],";
					
					$arraystring = "{v:".$count.",f:'".$date."'}";
					array_push($ticks,$arraystring);
				};
			 };
				$count = $count+1;
				$queryday = date('Y-m-d', strtotime("+1 day", strtotime($queryday)));
			};
			
			 echo "]);";
			 
			 $table30_div_name = 'table30day_div_'.$querylocation;
			 
			 ?> 
		
		var options = {
			chart: {
				
				subtitle: 'Estimated vs Actual',

			},
			//title: 'Class 5-2',
			lineWidth: 3,
			legend: { position: 'right' },
			//seriesType: 'line',
            colors: ['green','orange','red','red','blue'],
			isStacked: true,
			//bar: { groupWidth: "100%" },
			series: {

					0: {lineWidth: 0, areaOpacity: 0.3, type:'area', enableInteractivity:'false',visibleInLegend: false},
					1: {lineWidth: 0, areaOpacity: 0.3, type:'area', enableInteractivity:'false',visibleInLegend: false},
					2: {lineWidth: 0, areaOpacity: 0.3, type:'area', enableInteractivity:'false', visibleInLegend: false},
					//4: {type:'ScatterChart'}
					},
			vAxis: {
				//title: 'Value',
				viewWindow: {max:3000},
				max: 3000,
				min: 0,
				ticks: [0, 500, 1000, 1500, 2000, 2500, 3000, 4000,5000],
				gridlines : {
              count : 3
            }

			},
			hAxis: {
				ticks: [<?php echo implode(",", $ticks)?>]
			},
		};
		
		var chart7 = new google.visualization.ComboChart(document.getElementById('chart7'));

        chart7.draw(data2,options);
		
		
		
		
		
	
      }
</script>
<!-- Last 30 Table Code ends -->

	  
	  <div id="chart7"></div>
	  
</body>
</html>