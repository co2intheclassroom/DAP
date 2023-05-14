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
			

	
		



		<div class="row mb-3 text-center" align='center'>
			<?php 
			include('comps/drawchartreport.php');?>
		</div>
		
		<div class="row mb-3 text-center" align='center'>
			<?php 
			$previousday = date('Y-m-d', strtotime("-1 day", strtotime($queryday)));
			$queryday = $previousday;
			$ukDate = date("d-m-Y", strtotime($queryday));
			include('comps/drawchartreport.php');?>
		</div>
		
		<div class="row mb-3 text-center" align='center'>
			<?php 
			$previousday = date('Y-m-d', strtotime("-1 day", strtotime($queryday)));
			$queryday = $previousday;
			$ukDate = date("d-m-Y", strtotime($queryday));
			include('comps/drawchartreport.php');?>
		</div>
			
		<div class="row mb-3 text-center" align='center'>
			<?php 
			$previousday = date('Y-m-d', strtotime("-1 day", strtotime($queryday)));
			$queryday = $previousday;
			$ukDate = date("d-m-Y", strtotime($queryday));
			include('comps/drawchartreport.php');?>
		</div>
				<div class="row mb-3 text-center" align='center'>
			<?php 
			$previousday = date('Y-m-d', strtotime("-1 day", strtotime($queryday)));
			$queryday = $previousday;
			$ukDate = date("d-m-Y", strtotime($queryday));
			include('comps/drawchartreport.php');?>
		</div>
	  </div>
	</main>

</body>
  
<footer>
	<?php include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/footer.php'); ?>
</footer>
</html>
