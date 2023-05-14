<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/dap/comps/adminauthorise.php'); 
	$monitorid = $_GET['monitorid'];
?>
<html lang="en">
    <head>
	<?php include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/header.php'); ?>
  </head>
  <body>
<?php include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/dap_page_top.php');?>

<main class="container">
  <div class="bg-light p-5 rounded">
    	<h1 class="text-center">Are you sure you want to remove <?php echo $monitorid ?> from the system?</h1>
		<div class="row align-items-center p-3" align='center'>
		
			<div class="col">
            <a class="btn btn-lg btn-danger" href="removemonitorprocess.php?monitorid=<?php echo $monitorid?>" role="button">Yes</a>
			</div>
		</div>
		
		<div class="row align-items-center p-3" align='center'>
			<div class="col">
			<a class="btn btn-lg btn-warning" href="viewmonitor.php?monitorID=<?php echo $monitorid?>" role="button">No</a>
			</div>
		</div>
		


	
  </div>

</main>
      
  </body>
  
  <footer>
	<?php include($_SERVER['DOCUMENT_ROOT'].'/dap/comps/footer.php'); ?>
</footer>
</html>
