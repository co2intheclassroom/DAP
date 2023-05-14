<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/dap/comps/authorise.php'); 

$today = date('Y-m-d H:i:s');	
 
 if(isset($_GET['LocationID'])) { 
    $querylocation = $_GET['LocationID'];
  } else {
	  $querylocation = $_SESSION['Def_Location'];
	  
  };
  
  if(isset($_GET['day'])) { 
    $queryday = $_GET['day'];
	$nextday = date('Y-m-d', strtotime("+1 day", strtotime($queryday)));
	$previousday = date('Y-m-d', strtotime("-1 day", strtotime($queryday)));
  } else {
	  $queryday = date('Y-m-d');
	  //$queryday = date('d-m-Y');
	  $nextday = date('Y-m-d', strtotime("+1 day", strtotime($queryday)));
	  $previousday = date('Y-m-d', strtotime("-1 day", strtotime($queryday)));
  }
  
  $ukDate = date("d-m-Y", strtotime($queryday));
  

?>

<html lang="en">
  <head>
	<?php include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/header.php'); ?>
	<meta http-equiv="refresh" content="60" >
  </head>
  
<body>
    
	<?php 
	$pagenav = 1;
	include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/dap_page_top.php');
	?>

	<main class="container">
	  <div class="bg-light p-5 rounded text-center">
		<h1><?php include('comps/lookupmonid.php')?></h1>
			
		<div class="row align-items-center" align='center'>
			<?php include('comps/gauge.php');?>
		</div>

		<?php
		
		if ($value <= 950){
			$table_colour = "success";
			$table_text = "No action required. Continue monitoring";
		};
		if ($value >950) {
			if ($value <= 1400){
				$table_colour = "warning";
				$warning_array =array( "Consider purging the room at the end of the lesson by opening all doors and windows for at least 10 minutes.",
									 "Limit learner numbers where possible.",
									 "Consider moving high energy level activities (e.g. dance, music, physical) to a more ventilated space.",
									 "Monitor CO2 closely."
									 );
				$random = rand(0,3);
				$table_text = "Increase ventilation by opening doors/windows. " . $warning_array[$random];
									 
			};
			if ($value >1400) {
				$table_colour = "danger";
				$table_text = "The CO2 concentration of the room is VERY HIGH. Continue to monitor. Purge the rooms ventilation ASAP by opening all doors and windows for at least 10 minutes. Consistently high readings should be reported.";
			};
		};
		?>		

		<table class="table table-<?php echo $table_colour;?>" style="text-align: center">
		  <tbody>
			<tr>
			  <td><h2><?php echo $value?> ppm</h2></td>
			</tr>
			<tr>
			  <td><h6><?php echo $table_text;?></h6></td>
			</tr>
		  </tbody>
		</table>
		



		<div class="row mb-3 text-center" align='center'>
			<h4>Graphical Summary</h4>
			<?php include('comps/drawchart.php');?>
		</div>
			
		<div class="row mb-3 text-center" align='center'>
			<?php include('comps/drawtable.php');?>
		</div>
			
		<div class="row mb-3 text-center" align='center'>
			<h2>Last 7 days</h2>
			<?php include('comps/last7chart.php');?>
		</div>
	  </div>
	</main>

</body>
  
<footer>
	<?php include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/footer.php'); ?>
</footer>
</html>
