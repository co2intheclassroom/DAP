<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/dap/comps/authorise.php'); 
?>

<html lang="en">
  <head>
	<?php include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/header.php'); ?>
  </head>
  
<body>
    
	<?php 
	$pagenav = 5;
	include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/dap_page_top.php');
	?>

	<main class="container">
	  <div class="bg-light p-5 rounded">
		<div class="row mb-3">
			<h4>Introduction</h4>
			<p>Exposure to CO2 can produce a variety health effects. These may include headaches, dizziness, restlessness, a tingling or pins and needles feeling, difficulty breathing, sweating, tiredness, increased heart rate, elevated blood pressure, coma, asphyxia and convulsions. CO2 is produced by pupils and staff when they breathe out. The amount of CO2 in the air is measured in parts per million (ppm). Monitoring the CO2 concentration of a room is also a method of ensuring that the ventilation/fresh air supply of a room is adequate. Poorly ventilated rooms are known to significantly increase the risk of a virus spreading.</p>
			<h4>Purging a room</h4>
			<p>The most effective way to improve air quality is to carry out a purge of the air in the room. This achieved by opening all windows and doors for at least 10 minutes.</p>
			<h4>Room concentration</h4>
			<img src="comps/Table.png" class="rounded mx-auto d-block" style="width:800px">
			<p>A value of 950ppm or under indicates that the room is currently well ventilated and that no action is required, however the room should continiue to be monitored to ensure that levels remain at an acceptable level. The monitor will display a green light at this concentration and the analytics platform will also indicate this.</p>

			<p>A value between 950 and 1400ppm indicates that the air quality in the room is starting to diminish and should be monitored very closely. The monitor will show an amber light and the analytics platform will recommend that a purge of the rooms air is carried out soon.</p>

			<p>A value over 1400ppm indicates that the air quality is very low and it is likely that the pupils and staff are likely to start to show reduced cognitive function/fatigue. This has the potential to effect pupils ability to learn. The monitor will show a red light and then analytics platform will suggest that a purge of the classrooms air is carried out urgently.</p>
</p>
		</div>
			

	  </div>
	</main>

</body>
  
<footer>
	<?php include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/footer.php'); ?>
</footer>
</html>
